<?php

namespace App\Models;

use App\Conex\Conexion;
use PDO;


class Devoluciones extends Conexion {
    public $id;
    public $codigo;
    public $fecha;
    public $motivo;
    public $total_devuelto_bolivar;
    public $total_devuelto_dolar;

    private $table = "devolucion";

    public function __construct() {
        parent::__construct();
    }

    public function mostrarDevoluciones() {
        $sql = "SELECT d.*, c.nombre , c.apellido
                FROM detalles_devolucion dv
                JOIN devolucion d ON dv.id_devoluciones = d.id 
                JOIN  detalles_factura df ON dv.id_detalle_factura = df.id
                JOIN factura f ON df.id_factura = f.id
                JOIN clientes c ON f.id_cliente = c.id
                GROUP BY d.id, c.nombre, c.apellido
                ORDER BY d.id DESC";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (\Exception $e) {
            error_log("Error al mostrar devoluciones: " . $e->getMessage());
            return false;
        }
    }

    public function guardarDevolucion(Devoluciones $devoluciones) {
        $sql = "INSERT INTO {$this->table} (codigo, fecha, motivo, total_devuelto_bolivar, total_devuelto_dolar) VALUES (:codigo, :fecha, :motivo, :total_devuelto_bolivar, :total_devuelto_dolar)";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':codigo', $devoluciones->codigo);
            $stmt->bindParam(':fecha', $devoluciones->fecha);
            $stmt->bindParam(':motivo', $devoluciones->motivo);
            $stmt->bindParam(':total_devuelto_bolivar', $devoluciones->total_devuelto_bolivar);
            $stmt->bindParam(':total_devuelto_dolar', $devoluciones->total_devuelto_dolar);
            if ($stmt->execute()) {
                return $this->conn->lastInsertId();
            }
            return false;
        } catch (\Exception $e) {
            error_log("Error al guardar devolucion: " . $e->getMessage());
            return false;
        }
    }

    public function obtenerPorId($id) {
        $sql = "SELECT d.*, c.nombre, c.apellido 
                FROM {$this->table} d
                LEFT JOIN detalles_devolucion dd ON d.id = dd.id_devoluciones
                LEFT JOIN detalles_factura df ON dd.id_detalle_factura = df.id
                LEFT JOIN factura f ON df.id_factura = f.id
                LEFT JOIN clientes c ON f.id_cliente = c.id
                WHERE d.id = :id
                LIMIT 1";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetchObject(Devoluciones::class);
        } catch (\Exception $e) {
            error_log("Error al obtener devolucion: " . $e->getMessage());
            return false;
        }
    }

    public function obtenerDevolucionesConCantidad() {
        $sql = "SELECT d.*, SUM(dd.cantidad) as total_items 
                FROM {$this->table} d 
                LEFT JOIN detalles_devolucion dd ON d.id = dd.id_devolucion 
                GROUP BY d.id 
                ORDER BY d.id DESC";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS, Devoluciones::class);
        } catch (\Exception $e) {
            error_log("Error al obtener devoluciones con cantidad: " . $e->getMessage());
            return false;
        }
    }

    public function obtenerVentasDisponibles() {
        $sql = "SELECT v.*, c.nombre as cliente_nombre 
                FROM ventas v 
                LEFT JOIN clientes c ON v.cliente_id = c.id 
                WHERE v.estado = 'finalizada' 
                ORDER BY v.id DESC";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            error_log("Error al obtener ventas disponibles: " . $e->getMessage());
            return [];
        }
    }
}
