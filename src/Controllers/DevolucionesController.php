<?php

namespace App\Controllers;

use App\Models\Factura;
use App\Models\DetallesFacturas;
use App\Models\Devoluciones;
use App\Models\DetallesDevoluciones;
use App\Models\lotes;
use App\Models\Pagos;

class DevolucionesController {
    private $facturaModel;
    private $detallesModel;
    private Devoluciones $devolucionesModel;
    private DetallesDevoluciones $detallesDevolucionesModel;
    private lotes $lotesModel;
    private Pagos $pagosModel;

    public function __construct() {
        $this->facturaModel = new Factura();
        $this->detallesModel = new DetallesFacturas();
        $this->devolucionesModel = new Devoluciones();
    }

    public function index() {
        verificarLogin();
        $ventas = $this->facturaModel->obtenerFacturasParaDevolucion();
        $devoluciones = $this->devolucionesModel->mostrarDevoluciones();


        $data = [
            'title' => 'Devoluciones',
            'moduloActivo' => 'devoluciones',
            'mensaje' => $_SESSION['mensaje'] ?? null,
            'ventas' => $ventas,
            'devoluciones' => $devoluciones
        ];
        render_view('devoluciones', $data);
        unset($_SESSION['mensaje']);
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

        // Guardar detalles y actualizar inventario/factura
        if ($id && isset($_POST['detalles']) && is_array($_POST['detalles'])) {
            $this->detallesDevolucionesModel = new DetallesDevoluciones();
            $this->lotesModel = new lotes();

            $total_restar_bs = 0;
            $total_restar_usd = 0;
            $id_factura = null;
            $regresarInventario = isset($_POST['motivo']) && $_POST['motivo'] === 'Otro' && isset($_POST['regresar_inventario']);

            foreach ($_POST['detalles'] as $id_detalle_factura => $cantidad) {
                if ($cantidad > 0) {
                    // Obtener detalle original para precios
                    $detalleOriginal = $this->detallesModel->obtenerDetalle($id_detalle_factura);

                    if ($detalleOriginal) {
                        $id_factura = $detalleOriginal['id_factura'];

                        // Guardar detalle devolución
                        $detalle = $this->detallesDevolucionesModel;
                        $detalle->id_devoluciones = $id;
                        $detalle->id_detalle_factura = $id_detalle_factura;
                        $detalle->cantidad_devuelta = $cantidad;
                        $this->detallesDevolucionesModel->guardarDetallesDevoluciones($detalle);

                        // Actualizar cantidad en detalle factura
                        $this->detallesModel->actualizarCantidad($id_detalle_factura, $cantidad);

                        // Regresar al inventario si corresponde
                        if ($regresarInventario) {
                            $this->lotesModel->incrementarStock($detalleOriginal['id_torta'], $cantidad);
                        }

                        // Calcular montos a restar
                        $total_restar_bs += $detalleOriginal['precio_bs'] * $cantidad;
                        $total_restar_usd += $detalleOriginal['precio_usd'] * $cantidad;
                    }
                }
            }

            // Actualizar totales de la factura
            if ($id_factura) {
                $this->facturaModel->restarTotales($id_factura, $total_restar_bs, $total_restar_usd);

                // Verificar nuevo total para actualizar estado
                // Lógica de estado:
                // 1. Si total <= 0 -> 'Devuelto completamente'
                // 2. Si total > 0 pero pagos >= total -> 'Completado'
                // 3. Si no -> 'Parcialmente devuelto'

                $facturaActualizada = $this->facturaModel->buscarPorId($id_factura);
                if ($facturaActualizada) {
                    $nuevoEstado = 'Parcialmente devuelto';

                    if ($facturaActualizada->total_usd <= 0.01) {
                        $nuevoEstado = 'Devuelto completamente';
                    } else {
                        // Verificar pagos
                        $this->pagosModel = new Pagos();
                        $pagos = $this->pagosModel->obtenerPorFacturaId($id_factura);
                        $totalPagado = 0;
                        if ($pagos) {
                            foreach ($pagos as $p) {
                                $totalPagado += floatval($p['monto']);
                            }
                        }

                        if ($totalPagado >= ($facturaActualizada->total_usd - 0.01)) {
                            $nuevoEstado = 'Completado';
                        }
                    }

                    $this->facturaModel->actualizarEstado($id_factura, $nuevoEstado);
                }
            }
        }

        if ($id) {
            $_SESSION['mensaje'] = [
                'tipo' => 'success',
                'texto' => 'Devolucion registrada correctamente'
            ];
            header('Location: ' . RUTA_BASE . 'devoluciones');
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
