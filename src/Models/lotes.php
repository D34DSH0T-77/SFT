<?php

namespace App\Models;

use App\Conex\Conexion;
use PDO;

class lotes extends Conexion {

    public $id;
    public $id_torta;
    public $cantidad;
    public $stock;
    private $tabla = 'lotes';
    public function __construct() {
        parent::__construct();
    }
    public function guardarLote(lotes $lotes) {
        $sql = "INSERT INTO {$this->tabla} (id_torta, cantidad) VALUES (:id_torta, :cantidad)";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id_torta', $lotes->id_torta);
            $stmt->bindParam(':cantidad', $lotes->cantidad);
            return $stmt->execute();
        } catch (\Throwable $e) {
            error_log("Error al guardar el lote: " . $e->getMessage());
            return false;
        }
    }
    public function inventario() {
        $sql = "SELECT id_torta, SUM(cantidad) AS stock
        FROM {$this->tabla}
        GROUP BY id_torta";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
        } catch (\Throwable $e) {
            error_log("Error al mostrar en el inventario: " . $e->getMessage());
            return [];
        }
    }

    public function contar() {
        $sql = "SELECT SUM(cantidad) FROM {$this->tabla}";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (\Throwable $e) {
            error_log("Error al contar los lotes: " . $e->getMessage());
            return 0;
        }
    }
    public function ajustar(lotes $lotes) {
        $sql = "UPDATE {$this->tabla} SET cantidad= :cantidad WHERE id = :id ";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":cantidad", $lotes->cantidad);
            $stmt->bindParam(":id", $lotes->id);
            return $stmt->execute();
        } catch (\Throwable $e) {
            error_log("error al ajustar la entrada" . $e->getMessage());
        }
    }
    public function buscarlote($id) {
        $sql = "SELECT * FROM {$this->tabla} WHERE id_torta = :id_torta AND cantidad > 0";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":id_torta", $id);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Throwable $e) {
            error_log("error al buscar el lote" . $e->getMessage());
        }
    }

    public function obtenerInventarioDetallado() {
        $sql = "SELECT t.id, t.nombre, t.precio, 
                COALESCE(SUM(l.cantidad), 0) as total_stock
                FROM tortas t
                LEFT JOIN lotes l ON t.id = l.id_torta
                GROUP BY t.id
                ORDER BY total_stock DESC";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (\Throwable $e) {
            error_log("Error al obtener inventario detallado: " . $e->getMessage());
            return [];
        }
    }

    public function obtenerBajoStock($limit = 5) {
        $sql = "SELECT t.id, t.nombre, t.precio, 
                COALESCE(SUM(l.cantidad), 0) as total_stock
                FROM tortas t
                LEFT JOIN lotes l ON t.id = l.id_torta
                GROUP BY t.id
                HAVING total_stock <= 3
                ORDER BY total_stock ASC
                LIMIT :limit";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (\Throwable $e) {
            error_log("Error al obtener productos bajo stock: " . $e->getMessage());
            return [];
        }
    }
}
