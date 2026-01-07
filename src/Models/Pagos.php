<?php

namespace App\Models;

use App\Conex\Conexion;
use PDO;

class Pagos extends Conexion {
    public $id;
    public $id_factura;
    public $metodo;
    public $monto;
    public $fecha;

    private $tabla = 'pago';

    public function __construct() {
        parent::__construct();
    }

    public function guardarPago($id_factura, $metodo, $monto) {
        $sql = "INSERT INTO {$this->tabla} (id_factura, metodo, monto, fecha) VALUES (:id_factura, :metodo, :monto, :fecha)";
        // try {
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_factura', $id_factura);
        $stmt->bindParam(':metodo', $metodo);
        $stmt->bindParam(':monto', $monto);
        $fecha = date('Y-m-d H:i:s');
        $stmt->bindParam(':fecha', $fecha);
        return $stmt->execute();
        // } catch (\Exception $e) {
        //     error_log("Error al guardar pago: " . $e->getMessage());
        //     return false;
        // }
    }
    public function obtenerPorFacturaId($id_factura) {
        $sql = "SELECT * FROM {$this->tabla} WHERE id_factura = :id_factura";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id_factura', $id_factura);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            error_log("Error al obtener pagos factura: " . $e->getMessage());
            return [];
        }
    }
    public function obtenerTodos() {
        $sql = "SELECT * FROM {$this->tabla}";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            error_log("Error al obtener todos los pagos: " . $e->getMessage());
            return [];
        }
    }
}
