<?php

namespace App\Models;

use App\Conex\Conexion;
use PDO;

class Clientes extends Conexion {
    public $id;
    public $nombre;
    public $apellido;
    public $estado;

    private $tabla = 'clientes';

    public function agregar(Clientes $clientes) {
        $sql = "INSERT INTO {$this->tabla} (nombre, apellido, estado) VALUES (:nombre, :apellido, :estado)";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":nombre", $clientes->nombre);
            $stmt->bindParam(":apellido", $clientes->apellido);
            $stmt->bindParam(":estado", $clientes->estado);
            return $stmt->execute();
        } catch (\Throwable $th) {
            error_log("fallo al agregar" . $th->getMessage());
            return false;
        }
    }

    public function editar(Clientes $clientes) {
        $sql = "UPDATE {$this->tabla} SET nombre=:nombre, apellido=:apellido, estado=:estado WHERE id=:id";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":id", $clientes->id);
            $stmt->bindParam(":nombre", $clientes->nombre);
            $stmt->bindParam(":apellido", $clientes->apellido);
            $stmt->bindParam(":estado", $clientes->estado);
            return $stmt->execute();
        } catch (\Throwable $th) {
            error_log("fallo al editar" . $th->getMessage());
            return false;
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
            return false;
        }
    }

    public function buscarPorid($id) {
        $sql = "SELECT * FROM {$this->tabla} WHERE id=:id";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS, Clientes::class);
            return $stmt->fetch();
        } catch (\Throwable $th) {
            error_log("fallo al buscar por id" . $th->getMessage());
            return null;
        }
    }

    public function mostrar() {
        $sql = "SELECT * FROM {$this->tabla}";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS, Clientes::class);
        } catch (\Throwable $th) {
            error_log("fallo total" . $th->getMessage());
            return null;
        }
    }

    public function contar() {
        $sql = "SELECT COUNT(*) FROM {$this->tabla} WHERE estado = 'Activo'";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return (int)$stmt->fetchColumn();
        } catch (\Throwable $th) {
            error_log("fallo al contar" . $th->getMessage());
            return 0;
        }
    }
}
