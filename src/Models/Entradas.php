<?php

namespace App\Models;

use App\Conex\Conexion;
use PDO;

class Entradas extends Conexion {
    public $id;
    public $codigo;
    public $fecha;
    public $local;

    private $table = "entradas";

    public function __construct() {
        parent::__construct();
    }

    public function mostrarEntradas() {
        $sql = "SELECT * FROM {$this->table}";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS, Entradas::class);
        } catch (\Exception $e) {
            error_log("Error al mostrar entradas: " . $e->getMessage());
            return false;
        }
    }

    public function guardarEntrada(Entradas $entradas) {
        $sql = "INSERT INTO {$this->table} (codigo, fecha, local) VALUES (:codigo, :fecha, :local)";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':codigo', $this->codigo);
            $stmt->bindParam(':fecha', $this->fecha);
            $stmt->bindParam(':local', $this->local);
            if ($stmt->execute()) {
                return $this->conn->lastInsertId();
            }
            return false;
        } catch (\Exception $e) {
            error_log("Error al guardar entrada: " . $e->getMessage());
            return false;
        }
    }

    public function obtenerPorId($id) {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetchObject(Entradas::class);
        } catch (\Exception $e) {
            error_log("Error al obtener entrada: " . $e->getMessage());
            return false;
        }
    }
}
