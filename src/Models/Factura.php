<?php

namespace App\Models;

use App\Conex\Conexion;
use PDO;

class Factura extends Conexion {
    public $id;
    public $id_cliente;
    public $total_bs;
    public $total_usd;
    public $fecha;
    public $estado;
    public $cliente;


    private $tabla = 'factura';
    public function __construct() {
        parent::__construct();
    }

    public function mostrar() {
        $sql = "SELECT f.*, c.nombre as cliente FROM {$this->tabla} f JOIN clientes c ON f.id_cliente = c.id";
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
        $sql = "INSERT INTO {$this->tabla} (id_cliente,total_bs,total_usd,fecha,estado) VALUES (:id_cliente,:total_bs,:total_usd,:fecha,:estado)";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id_cliente', $factura->id_cliente);
            $stmt->bindParam(':total_bs', $factura->total_bs);
            $stmt->bindParam(':total_usd', $factura->total_usd);
            $stmt->bindParam(':fecha', $factura->fecha);
            $stmt->bindParam(':estado', $factura->estado);
            if ($stmt->execute()) {
                return $this->conn->lastInsertId();
            }
            return false;
        } catch (\Exception $e) {
            error_log("Error al guardar factura env: " . $e->getMessage());
            return false;
        }
    }
    public function buscarPorId($id) {
        $sql = "SELECT f.*, c.nombre as cliente FROM {$this->tabla} f JOIN clientes c ON f.id_cliente = c.id WHERE f.id=:id";
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

    public function actualizarEstado($id, $estado) {
        $sql = "UPDATE {$this->tabla} SET estado = :estado WHERE id = :id";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':estado', $estado);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (\Exception $e) {
            error_log("Error al actualizar estado factura: " . $e->getMessage());
            return false;
        }
    }
}
