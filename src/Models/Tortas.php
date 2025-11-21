<?php

namespace App\Models;

use App\Conex\Conexion;

class Tortas extends Conexion {
    public $id;
    public $nombre;
    public $precio;
    public $img;
    public $estado;


    public function mostrar() {

        $sql = "SELECT * FROM tortas";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (\Throwable $th) {
            error_log("fallo total" . $th->getMessage());
        }
    }

    public function agregar(Tortas $tortas) {
        $sql = "INSERT INTO tortas (nombre,precio,img,estado) VALUES (:nombre, :precio, :img,:estado)";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":nombre", $tortas->nombre);
            $stmt->bindParam(":precio", $tortas->precio);
            $stmt->bindParam(":img", $tortas->img);
            $stmt->bindParam(":estado", $tortas->estado);
            $stmt->execute();
        } catch (\Throwable $th) {
            error_log("fallo en agregar torta " . $th->getMessage());
        }
    }
    public function editar(Tortas $tortas) {
        $sql = "UPDATE SET tortas (nombre,precio,img,estado) VALUES(:nombre, :precio, :img,:estado)";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":nombre", $tortas->nombre);
            $stmt->bindParam(":precio", $tortas->precio);
            $stmt->bindParam(":img", $tortas->img);
            $stmt->bindParam(":estado", $tortas->estado);
            $stmt->execute();
        } catch (\Throwable $th) {
            error_log("fallo al editar" . $th->getMessage());
        }
    }

    public function eliminar($id) {
        $sql = "DELETE FROM tortas WHERE id=:id";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
        } catch (\Throwable $th) {
            error_log("fallo al eliminar" . $th->getMessage());
        }
    }

    public function buscarPorid($id) {
        $sql = "SELECT FROM tortas WHERE id=:id";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
        } catch (\Throwable $th) {
            error_log("fallo al buscar por el id" . $th->getMessage());
        }
    }
}
