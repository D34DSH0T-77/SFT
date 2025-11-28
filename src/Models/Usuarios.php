<?php

namespace App\Models;

use App\Conex\Conexion;
use PDO;

class Usuarios extends Conexion {
    public $id;
    public $nombre;
    public $apellido;
    public $usuario;
    public $cedula;
    public $rol;
    public $estado;

    private $tabla = "usuarios";

    public function agregar(Usuarios $usuarios) {
        $sql = "INSERT INTO {$this->tabla} (nombre, apellido, usuario, cedula, rol, estado) VALUES (:nombre, :apellido, :usuario, :cedula, :rol, :estado)";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":nombre", $usuarios->nombre);
            $stmt->bindParam(":apellido", $usuarios->apellido);
            $stmt->bindParam(":usuario", $usuarios->usuario);
            $stmt->bindParam(":cedula", $usuarios->cedula);
            $stmt->bindParam(":rol", $usuarios->rol);
            $stmt->bindParam(":estado", $usuarios->estado);
            return $stmt->execute();
        } catch (\Throwable $th) {
            error_log("fallo al agregar" . $th->getMessage());
        }
    }
    public function editar(Usuarios $usuarios) {
        $sql = "UPDATE {$this->tabla} SET nombre=:nombre, apellido=:apellido, usuario=:usuario, cedula=:cedula, rol=:rol, estado=:estado WHERE id=:id";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":id", $usuarios->id);
            $stmt->bindParam(":nombre", $usuarios->nombre);
            $stmt->bindParam(":apellido", $usuarios->apellido);
            $stmt->bindParam(":usuario", $usuarios->usuario);
            $stmt->bindParam(":cedula", $usuarios->cedula);
            $stmt->bindParam(":rol", $usuarios->rol);
            $stmt->bindParam(":estado", $usuarios->estado);

            return $stmt->execute();
        } catch (\Throwable $th) {
            error_log("fallo al editar" . $th->getMessage());
        }
    }
    public function eliminar($id) {
        $sql = "DELETE FROM {$this->tabla} WHERE id = :id";
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
            $stmt->setFetchMode(PDO::FETCH_CLASS, Usuarios::class);
            return $stmt->fetch();
        } catch (\Throwable $th) {
            error_log("fallo al buscar por id" . $th->getMessage());
            return null;
        }
    }

    public function buscarPorUsuario($usuario) {
        $sql = "SELECT * FROM {$this->tabla} WHERE usuario = :usuario LIMIT 1";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":usuario", $usuario);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (\Throwable $th) {
            error_log("fallo al buscar por usuario" . $th->getMessage());
            return null;
        }
    }

    public function mostrar() {
        $sql = "SELECT * FROM {$this->tabla}";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS, Usuarios::class);
        } catch (\Throwable $th) {
            error_log("fallo total" . $th->getMessage());
        }
    }
}
