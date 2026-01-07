<?php

namespace App\Controllers;

use App\Models\Factura;
use App\Models\DetallesFacturas;

class DevolucionesController {
    private $facturaModel;
    private $detallesModel;

    public function __construct() {
        $this->facturaModel = new Factura();
        $this->detallesModel = new DetallesFacturas();
    }

    public function index() {
        verificarLogin();
        $ventas = $this->facturaModel->mostrar();

        $devoluciones = []; // Agregar el metodo pa cuando alla modelo y tabla en la BD :V

        $data = [
            'title' => 'Devoluciones',
            'moduloActivo' => 'devoluciones',
            'ventas' => $ventas,
            'devoluciones' => $devoluciones
        ];
        render_view('devoluciones', $data);
    }

    public function getDetallesVenta($id_venta) {
        header('Content-Type: application/json');

        if (!$id_venta) {
            echo json_encode(['status' => false, 'message' => 'ID de venta no proporcionado']);
            return;
        }

        $detalles = $this->detallesModel->obtenerPorFacturaId($id_venta);

        if ($detalles) {
            echo json_encode(['status' => true, 'detalles' => $detalles]);
        } else {
            echo json_encode(['status' => false, 'message' => 'No se encontraron detalles para esta venta']);
        }
        exit;
    }
}
