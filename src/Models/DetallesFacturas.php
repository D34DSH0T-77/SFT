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
}
