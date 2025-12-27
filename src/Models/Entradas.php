<?php

namespace App\Models;

use App\Conex\Conexion;
use PDO;

class Entradas extends Conexion {
    public $id;
    public $codigo;
    public $fecha;
    public $local;
    public $precio_bs;
    public $precio_usd;

    private $table = "entradas";

    public function __construct() {
        parent::__construct();
    }

    public function mostrarEntradas() {
        $sql = "SELECT * FROM {$this->table} ORDER BY id DESC";
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
        $sql = "INSERT INTO {$this->table} (codigo, fecha, local, precio_bs, precio_usd) VALUES (:codigo, :fecha, :local, :precio_bs, :precio_usd)";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':codigo', $entradas->codigo);
            $stmt->bindParam(':fecha', $entradas->fecha);
            $stmt->bindParam(':local', $entradas->local);
            $stmt->bindParam(':precio_bs', $entradas->precio_bs);
            $stmt->bindParam(':precio_usd', $entradas->precio_usd);
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

    public function obtenerEntradasConCantidad() {
        $sql = "SELECT e.*, SUM(d.cantidad) as total_items 
                FROM {$this->table} e 
                LEFT JOIN detalles_entrada d ON e.id = d.id_entrada 
                GROUP BY e.id 
                ORDER BY e.id DESC";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS, Entradas::class);
        } catch (\Exception $e) {
            error_log("Error al obtener entradas con cantidad: " . $e->getMessage());
            return false;
        }
    }
}
