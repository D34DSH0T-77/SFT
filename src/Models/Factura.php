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
    public $codigo;

    public $productos;

    private $tabla = 'factura';
    public function __construct() {
        parent::__construct();
    }

    public function mostrar() {
        $sql = "SELECT f.*, c.nombre as cliente FROM {$this->tabla} f LEFT JOIN clientes c ON f.id_cliente = c.id WHERE f.estado != 'Devuelto completamente' ORDER BY f.id DESC ";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS, Factura::class);
        } catch (\Exception $e) {
            error_log("Error al mostrar facturas: " . $e->getMessage());
            return false;
        }
    }

    public function obtenerRecientes($limit = 5) {
        $sql = "SELECT f.*, c.nombre as cliente, 
                GROUP_CONCAT(t.nombre SEPARATOR ', ') as productos
                FROM {$this->tabla} f 
                JOIN clientes c ON f.id_cliente = c.id
                LEFT JOIN detalles_factura df ON f.id = df.id_factura
                LEFT JOIN tortas t ON df.id_torta = t.id
                WHERE f.estado IN ('Completado', 'Entregado')
                GROUP BY f.id
                ORDER BY f.fecha DESC, f.id DESC
                LIMIT :limit";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS, Factura::class);
        } catch (\Exception $e) {
            error_log("Error al obtener facturas recientes: " . $e->getMessage());
            return [];
        }
    }

    public function guardarFactura(Factura $factura) {
        $sql = "INSERT INTO {$this->tabla} (id_cliente,total_bs,total_usd,fecha,estado,codigo) VALUES (:id_cliente,:total_bs,:total_usd,:fecha,:estado,:codigo)";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id_cliente', $factura->id_cliente);
            $stmt->bindParam(':total_bs', $factura->total_bs);
            $stmt->bindParam(':total_usd', $factura->total_usd);
            $stmt->bindParam(':fecha', $factura->fecha);
            $stmt->bindParam(':estado', $factura->estado);
            $stmt->bindParam(':codigo', $factura->codigo);
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

    public function obtenerPendientes() {
        $sql = "SELECT f.*, c.nombre as cliente 
                FROM {$this->tabla} f 
                JOIN clientes c ON f.id_cliente = c.id 
                WHERE f.estado = 'En proceso' 
                ORDER BY f.fecha DESC";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS, Factura::class);
        } catch (\Exception $e) {
            error_log("Error al obtener facturas pendientes: " . $e->getMessage());
            return [];
        }
    }
    public function obtenerCompletadasMes($mes, $anio) {
        $sql = "SELECT * FROM {$this->tabla} WHERE (estado = 'Completado' OR estado = 'Entregado') AND MONTH(fecha) = :mes AND YEAR(fecha) = :anio";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':mes', $mes, PDO::PARAM_INT);
            $stmt->bindParam(':anio', $anio, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS, Factura::class);
        } catch (\Exception $e) {
            error_log("Error al obtener facturas completadas del mes: " . $e->getMessage());
            return [];
        }
    }

    public function restarTotales($id, $resta_bs, $resta_usd) {
        $sql = "UPDATE {$this->tabla} SET total_bs = total_bs - :resta_bs, total_usd = total_usd - :resta_usd WHERE id = :id";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':resta_bs', $resta_bs);
            $stmt->bindParam(':resta_usd', $resta_usd);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (\Exception $e) {
            error_log("Error al restar totales factura: " . $e->getMessage());
            return false;
        }
    }

    public function obtenerFacturasParaDevolucion() {
        $sql = "SELECT f.*, c.nombre as cliente 
                FROM {$this->tabla} f 
                LEFT JOIN clientes c ON f.id_cliente = c.id 
                WHERE f.estado != 'Devuelto completamente' 
                AND f.estado != 'Anulado'
                ORDER BY f.id DESC";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS, Factura::class);
        } catch (\Exception $e) {
            error_log("Error al obtener facturas para devolucion: " . $e->getMessage());
            return false;
        }
    }
    public function mostrarDevoluciones() {
        $sql = "SELECT f.*, c.nombre as cliente FROM {$this->tabla} f LEFT JOIN clientes c ON f.id_cliente = c.id ORDER BY f.id DESC ";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS, Factura::class);
        } catch (\Exception $e) {
            error_log("Error al mostrar facturas: " . $e->getMessage());
            return false;
        }
    }
}
