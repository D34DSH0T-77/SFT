<?php

namespace App\Models;

use App\Conex\Conexion;
use PDO;

class DetallesFacturas extends Conexion {
    public $id;
    public $id_factura;
    public $id_torta;
    public $cantidad;
    public $precio;

    private $table = "detalles_factura";

    public function __construct() {
        return parent::__construct();
    }

    public function MostrarDetalles() {
        $sql = "SELECT * FROM {$this->table}";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS, DetallesFacturas::class);
        } catch (\Exception $e) {
            error_log("error al mostrar el detalle" . $e->getMessage());
            return false;
        }
    }

    public function AgregarDetalles(DetallesFacturas $detalles) {
        $sql = "INSERT INTO {$this->table} (id_factura, id_torta, cantidad, precio) VALUES(:id_factura, :id_torta, :cantidad, :precio)";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id_factura', $detalles->id_factura);
            $stmt->bindParam(':id_torta', $detalles->id_torta);
            $stmt->bindParam(':cantidad', $detalles->cantidad);
            $stmt->bindParam(':precio', $detalles->precio);
            $stmt->execute();
        } catch (\Exception $e) {
            error_log("error al agregar el detalle para la factura" . $e->getMessage());
            return false;
        }
    }

    public function obtenerPorFacturaId($id_factura) {
        $sql = "SELECT d.*, t.nombre as nombre_torta 
                FROM {$this->table} d 
                INNER JOIN tortas t ON d.id_torta = t.id 
                WHERE d.id_factura = :id_factura";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id_factura', $id_factura);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (\Exception $e) {
            error_log("Error al obtener detalles de factura: " . $e->getMessage());
            return [];
        }
    }
}
