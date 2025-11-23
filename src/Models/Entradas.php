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
        }
    }

    public function guardarEntrada() {
        $sql = "INSERT INTO {$this->table} (codigo, fecha, local) VALUES (:codigo, :fecha, :local)";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':codigo', $this->codigo);
            $stmt->bindParam(':fecha', $this->fecha);
            $stmt->bindParam(':local', $this->local);
            return $stmt->execute();
        } catch (\Exception $e) {
            error_log("Error al guardar entrada: " . $e->getMessage());
            return false;
        }
    }
}
