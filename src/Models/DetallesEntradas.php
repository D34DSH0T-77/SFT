<?php

namespace App\Models;

use App\Conex\Conexion;
use PDO;

class DetallesEntradas extends Conexion {
    public $id;
    public $id_entrada;
    public $id_torta;
    public $cantidad;

    private $table = "detalles_entrada";

    public function __construct() {
        return parent::__construct();
    }

    public function MostrarDetalles() {
        $sql = "SELECT * FROM {$this->table}";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS, DetallesEntradas::class);
        } catch (\Exception $e) {
            error_log("error al mostrar el detalle" . $e->getMessage());
            return false;
        }
    }
    public function AgregarDetalles(DetallesEntradas $detalles) {
        $sql = "INSERT INTO {$this->table} (id_entrada, id_torta, cantidad) VALUES(:id_entrada, :id_torta, :cantidad)";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id_entrada', $detalles->id_entrada);
            $stmt->bindParam(':id_torta', $detalles->id_torta);
            $stmt->bindParam(':cantidad', $detalles->cantidad);
            $stmt->execute();
        } catch (\Exception $e) {
            error_log("error al agreagar el detalle para la entrada" . $e->getMessage());
            return false;
        }
    }

    public function obtenerPorEntradaId($id_entrada) {
        $sql = "SELECT d.*, t.nombre as nombre_torta 
                FROM {$this->table} d 
                INNER JOIN tortas t ON d.id_torta = t.id 
                WHERE d.id_entrada = :id_entrada";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id_entrada', $id_entrada);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (\Exception $e) {
            error_log("Error al obtener detalles de entrada: " . $e->getMessage());
            return [];
        }
    }
}
