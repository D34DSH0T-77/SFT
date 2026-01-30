<?php

namespace App\Controllers;

use App\Models\Factura;
use App\Models\DetallesFacturas;
use App\Models\Devoluciones;
use App\Models\DetallesDevoluciones;

class DevolucionesController {
    private $facturaModel;
    private $detallesModel;
    private Devoluciones $devolucionesModel;
    private DetallesDevoluciones $detallesDevolucionesModel;

    public function __construct() {
        $this->facturaModel = new Factura();
        $this->detallesModel = new DetallesFacturas();
        $this->devolucionesModel = new Devoluciones();
    }

    public function index() {
        verificarLogin();
        $ventas = $this->facturaModel->mostrar();
        $devoluciones = $this->devolucionesModel->mostrarDevoluciones();


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
    public function guardarDevolucion() {
        verificarLogin();


        $devoluciones = $this->devolucionesModel;
        $devoluciones->codigo = $_POST['codigo'] ?? '';
        $devoluciones->fecha = $_POST['fecha'] ?? '';
        $devoluciones->motivo = $_POST['motivo'] ?? '';
        $devoluciones->total_devuelto_bolivar = $_POST['total_devuelto_bolivar'] ?? '';
        $devoluciones->total_devuelto_dolar = $_POST['total_devuelto_dolar'] ?? '';
        $id = $this->devolucionesModel->guardarDevolucion($devoluciones);

        // Guardar detalles
        if ($id && isset($_POST['detalles']) && is_array($_POST['detalles'])) {
            $this->detallesDevolucionesModel = new DetallesDevoluciones();
            foreach ($_POST['detalles'] as $id_detalle_factura => $cantidad) {
                if ($cantidad > 0) {
                    $detalle = $this->detallesDevolucionesModel;
                    $detalle->id_devoluciones = $id;
                    $detalle->id_detalle_factura = $id_detalle_factura;
                    $detalle->cantidad_devuelta = $cantidad;
                    $this->detallesDevolucionesModel->guardarDetallesDevoluciones($detalle);
                }
            }
        }

        if ($id) {
            header('Location: ' . RUTA_BASE . 'devoluciones');
            $_SESSION['mensaje'] = [
                'tipo' => 'success',
                'texto' => 'Devolucion registrada correctamente'
            ];
            exit;
        } else {
            $_SESSION['mensaje'] = [
                'tipo' => 'error',
                'texto' => 'Error al registrar devolucion'
            ];
            header('Location: ' . RUTA_BASE . 'devoluciones');
            exit;
        }
    }

    public function ver($id) {
        verificarLogin();

        $devolucion = $this->devolucionesModel->obtenerPorId($id);

        // Populate missing properties for the view if they don't exist in the main fetch
        // (Assuming obtenerPorId returns the basic object specific to 'devolucion' table)
        // Retrieve client name if possible. Since current 'obtenerPorId' is simple select *,
        // we might need a better query or just accept missing client for now or fetch it manually.
        // For now, consistent with index, we won't crash but client might be missing.

        $this->detallesDevolucionesModel = new DetallesDevoluciones();
        $detalles = $this->detallesDevolucionesModel->obtenerPorDevolucionId($id);

        if (!$devolucion) {
            header('Location: ' . RUTA_BASE . 'devoluciones');
            exit;
        }

        $data = [
            'title' => 'Ver Devolución',
            'moduloActivo' => 'devoluciones',
            'devolucion' => $devolucion,
            'detalles' => $detalles
        ];
        render_view('devoluciones_ver', $data);
    }
}
