<?php

namespace App\Models;

use App\Conex\Conexion;
use PDO;

class Factura extends Conexion {
    public $id;
    public $id_cliente;
    public $total;
    public $fecha;
    public $estado;

    private $tabla = 'facturas';
    public function __construct() {
        parent::__construct();
    }

    public function mostrar() {
        $sql = "SELECT * FROM {$this->tabla}";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS, Factura::class);
        } catch (\Exception $e) {
            error_log("Error al mostrar facturas: " . $e->getMessage());
            return false;
        }
    }
    public function guardarFactura(Factura $factura) {
        $sql = "INSERT INTO {$this->tabla} (id_cliente,total,fecha,estado) VALUES (:id_cliente,:total,:fecha,:estado)";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id_cliente', $factura->id_cliente);
            $stmt->bindParam(':total', $factura->total);
            $stmt->bindParam(':fecha', $factura->fecha);
            $stmt->bindParam(':estado', $factura->estado);
            return $stmt->execute();
        } catch (\Exception $e) {
            error_log("Error al guardar factura: " . $e->getMessage());
            return false;
        }
    }
    public function buscarPorId($id) {
        $sql = "SELECT * FROM {$this->tabla} WHERE id=:id";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetchObject(Factura::class);
        } catch (\Exception $e) {
            error_log("Error al buscar factura por id: " . $e->getMessage());
            return false;
        }
    }
}
