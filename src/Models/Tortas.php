<?php

namespace App\Models;

use App\Conex\Conexion;
use PDO;

class Tortas extends Conexion {
    public $id;
    public $nombre;
    public $precio;
    public $img;
    public $estado;
    public $stock;


    private $tabla = 'tortas';

    public function mostrar() {

        $sql = "SELECT * FROM {$this->tabla}";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS, Tortas::class);
        } catch (\Throwable $th) {
            error_log("fallo total" . $th->getMessage());
        }
    }

    public function agregar(Tortas $tortas) {
        $sql = "INSERT INTO {$this->tabla} (nombre,precio,img,estado) VALUES (:nombre, :precio, :img,:estado)";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":nombre", $tortas->nombre);
            $stmt->bindParam(":precio", $tortas->precio);
            $stmt->bindParam(":img", $tortas->img);
            $stmt->bindParam(":estado", $tortas->estado);
            return $stmt->execute();
        } catch (\Throwable $th) {
            error_log("fallo en agregar torta " . $th->getMessage());
        }
    }
    public function editar(Tortas $tortas) {
        $sql = "UPDATE {$this->tabla} SET nombre = :nombre, precio = :precio, img = :img, estado = :estado WHERE id = :id";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":id", $tortas->id);
            $stmt->bindParam(":nombre", $tortas->nombre);
            $stmt->bindParam(":precio", $tortas->precio);
            $stmt->bindParam(":img", $tortas->img);
            $stmt->bindParam(":estado", $tortas->estado);
            return $stmt->execute();
        } catch (\Throwable $th) {
            error_log("fallo al editar" . $th->getMessage());
        }
    }

    public function eliminar($id) {
        $sql = "DELETE FROM {$this->tabla} WHERE id=:id";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":id", $id);
            return $stmt->execute();
        } catch (\Throwable $th) {
            error_log("fallo al eliminar" . $th->getMessage());
        }
    }

    public function buscarPorid($id) {
        $sql = "SELECT * FROM {$this->tabla} WHERE id = :id";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS, Tortas::class);
            return $stmt->fetch();
        } catch (\Throwable $th) {
            error_log("fallo al buscar por el id" . $th->getMessage());
        }
    }

    public function contar() {
        $sql = "SELECT COUNT(*) FROM {$this->tabla}";
        try {
            $stmt = $this->conn->query($sql);
            return $stmt->fetchColumn();
        } catch (\Throwable $th) {
            error_log("Error contando tortas: " . $th->getMessage());
            return 0;
        }
    }

    public function mostrarPaginado($limit, $offset) {
        $sql = "SELECT * FROM {$this->tabla} LIMIT :limit OFFSET :offset";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(":limit", $limit, PDO::PARAM_INT);
            $stmt->bindValue(":offset", $offset, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS, Tortas::class);
        } catch (\Throwable $th) {
            error_log("Error en paginación: " . $th->getMessage());
            return [];
        }
    }

    public function buscar($termino) {
        // Safer query using subquery to avoid ONLY_FULL_GROUP_BY issues
        // Optimized search (Model does JOIN/Subquery + Stock)
        $sql = "SELECT t.*, 
                IFNULL((SELECT SUM(cantidad) FROM lotes WHERE id_torta = t.id), 0) as stock
                FROM {$this->tabla} t
                WHERE t.nombre LIKE :termino
                LIMIT 10";
        try {
            $stmt = $this->conn->prepare($sql);
            $termino = "%" . $termino . "%";
            $stmt->bindParam(":termino", $termino);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS, Tortas::class);
        } catch (\Throwable $th) {
            // Log error and return it as a fake product for debugging frontend
            error_log("Error buscando tortas: " . $th->getMessage());
            return [
                (object)[
                    'id' => 0,
                    'nombre' => 'SQL ERROR: ' . $th->getMessage(),
                    'precio' => 0,
                    'stock' => 0,
                    'img' => ''
                ]
            ];
        }
    }
}
