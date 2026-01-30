<?php

namespace App\Models;

use App\Conex\Conexion;
use PDO;

class DetallesDevoluciones extends Conexion {
    public $id;
    public $id_devoluciones;
    public $id_detalle_factura;
    public $cantidad_devuelta;

    private $table = "detalles_devolucion";

    public function __construct() {
        parent::__construct();
    }

    public function guardarDetallesDevoluciones(DetallesDevoluciones $detallesDevoluciones) {
        $sql = "INSERT INTO {$this->table} (id_devoluciones, id_detalle_factura, cantidad_devuelta) VALUES (:id_devoluciones, :id_detalle_factura, :cantidad_devuelta)";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id_devoluciones', $detallesDevoluciones->id_devoluciones);
            $stmt->bindParam(':id_detalle_factura', $detallesDevoluciones->id_detalle_factura);
            $stmt->bindParam(':cantidad_devuelta', $detallesDevoluciones->cantidad_devuelta);
            if ($stmt->execute()) {
                return $this->conn->lastInsertId();
            }
            return false;
        } catch (\Exception $e) {
            error_log("Error al guardar detalles de devolucion: " . $e->getMessage());
            return false;
        }
    }

    public function obtenerPorDevolucionId($id) {
        $sql = "SELECT dd.*, t.nombre as nombre_torta 
                FROM {$this->table} dd
                JOIN detalles_factura df ON dd.id_detalle_factura = df.id
                JOIN tortas t ON df.id_torta = t.id
                WHERE dd.id_devoluciones = :id";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (\Exception $e) {
            error_log("Error al obtener detalles de devolucion: " . $e->getMessage());
            return [];
        }
    }
}
