<?php

namespace App\Models;

use App\Conex\Conexion;
use PDO;

class DetallesFacturas extends Conexion {
    public $id;
    public $id_torta;
    public $precio_bs;
    public $precio_usd;
    public $cantidad;
    public $id_factura;
    public $tortas;

    private $tabla = 'detalles_factura';

    public function __construct() {
        parent::__construct();
    }

    public function guardarDetalle(DetallesFacturas $detallesfacturas) {
        $sql = "INSERT INTO {$this->tabla} (id_factura, id_torta, cantidad, precio_bs,precio_usd) VALUES (:id_factura, :id_torta, :cantidad, :precio_bs,:precio_usd)";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id_factura', $detallesfacturas->id_factura);
            $stmt->bindParam(':id_torta', $detallesfacturas->id_torta);
            $stmt->bindParam(':cantidad', $detallesfacturas->cantidad);
            $stmt->bindParam(':precio_bs', $detallesfacturas->precio_bs);
            $stmt->bindParam(':precio_usd', $detallesfacturas->precio_usd);
            return $stmt->execute();
        } catch (\Exception $e) {
            error_log("Error al guardar detalle factura: " . $e->getMessage());
            return false;
        }
    }
    public function obtenerPorFacturaId($id_factura) {
        $sql = "SELECT d.*, t.nombre as tortas
                FROM {$this->tabla} d 
                JOIN tortas t ON d.id_torta = t.id 
                WHERE d.id_factura = :id_factura";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id_factura', $id_factura);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            error_log("Error al obtener detalles factura: " . $e->getMessage());
            return [];
        }
    }

    public function getProductosMasVendidos($limit = 5) {
        $sql = "SELECT t.nombre, SUM(d.cantidad) as total_vendido
                FROM {$this->tabla} d
                JOIN tortas t ON d.id_torta = t.id
                GROUP BY d.id_torta
                ORDER BY total_vendido DESC
                LIMIT :limit";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            error_log("Error al obtener productos más vendidos: " . $e->getMessage());
            return [];
        }
    }

    public function obtenerVentasPorProducto($fechaInicio, $fechaFinal, $orden = 'DESC') {
        $orden = strtoupper($orden) === 'ASC' ? 'ASC' : 'DESC';
        $sql = "SELECT t.nombre, SUM(d.cantidad) as total_vendido, SUM(d.cantidad * d.precio_usd) as total_ingreso_usd
                FROM {$this->tabla} d
                JOIN factura f ON d.id_factura = f.id
                JOIN tortas t ON d.id_torta = t.id
                WHERE f.estado != 'Anulado'
                AND DATE(f.fecha) BETWEEN :fechaInicio AND :fechaFinal
                GROUP BY d.id_torta
                ORDER BY total_vendido $orden";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':fechaInicio', $fechaInicio);
            $stmt->bindParam(':fechaFinal', $fechaFinal);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (\Exception $e) {
            error_log("Error al obtener ventas por producto: " . $e->getMessage());
            return [];
        }
    }

    public function obtenerDetalle($id) {
        $sql = "SELECT d.*, t.nombre as tortas 
            FROM {$this->tabla} d 
            JOIN tortas t ON d.id_torta = t.id 
            WHERE d.id = :id";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            error_log("Error al obtener detalle factura: " . $e->getMessage());
            return false;
        }
    }
}
