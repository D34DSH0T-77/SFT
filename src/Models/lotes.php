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
}
