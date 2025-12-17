<?php

namespace App\Controllers;

use App\Models\Factura;
use App\Models\DetallesFacturas;
use App\Models\Tortas;
use App\Models\Clientes;
use App\Models\Lotes;

class VentasController {
    private factura $facturaModel;
    private  $detallesfacturasModel;
    private  $tortasModel;
    private  $clientesModel;
    private  $lotesModel;

    public function __construct() {
        $this->facturaModel = new factura();
        $this->detallesfacturasModel = new DetallesFacturas();
        $this->tortasModel = new Tortas();
        $this->clientesModel = new Clientes();
        $this->lotesModel = new Lotes();
    }

    public function index() {
        verificarLogin();
        $clientes = $this->clientesModel->mostrar();
        $tortas = $this->tortasModel->mostrar();
        $data = [
            'title' => 'Ventas',
            'moduloActivo' => 'ventas',
            'clientes' => $clientes,
            'tortas' => $tortas
        ];
        render_view('ventas', $data);
    }
    public function ver($id) {
        verificarLogin();
        $factura = $this->facturaModel->buscarPorId($id);
        $detalles = $this->detallesfacturasModel->obtenerPorFacturaId($id);
        if (!$factura) {
            header('Location: ' . RUTA_BASE . 'ventas');
            exit;
        }
        $data = [
            'title' => 'Ventas',
            'moduloActivo' => 'ventas',
            'factura' => $factura,
            'detalles' => $detalles
        ];
        render_view('ventas', $data);
    }

    public function agregar() {
        verificarLogin();
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Método no permitido']);
            exit;
        }

        $factura = $this->facturaModel;
        $factura->id_cliente = $_POST['id_cliente'] ?? '';
        $factura->total = $_POST['total'] ?? '';
        $factura->fecha = $_POST['fecha'] ?? '';
        $factura->estado = $_POST['estado'] ?? '';

        $id_factura = $this->facturaModel->guardarFactura($factura);

        if ($id_factura) {
            echo json_encode(['success' => true, 'id' => $id_factura]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al guardar factura']);
        }
        exit;
    }

    public function agregarDetalle() {
        verificarLogin();
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Método no permitido']);
            exit;
        }

        $detalle = $this->detallesfacturasModel;
        $detalle->id_factura = $_POST['id_factura'] ?? '';
        $detalle->id_torta = $_POST['id_torta'] ?? '';
        $detalle->cantidad = $_POST['cantidad'] ?? '';
        $detalle->precio = $_POST['precio'] ?? '';

        if ($this->detallesfacturasModel->AgregarDetalles($detalle)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al guardar detalle']);
        }
        exit;
    }

    public function restarLote() {
        verificarLogin();
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Método no permitido']);
            exit;
        }

        $id_torta = $_POST['id'] ?? ''; // JS sends Torta ID here
        $cantidadRestar = intval($_POST['cantidad'] ?? 0);

        if (!$id_torta || $cantidadRestar <= 0) {
            echo json_encode(['success' => false, 'message' => 'Datos inválidos']);
            exit;
        }

        // 1. Get available lots for this product (FIFO)
        $lotes = $this->lotesModel->buscarlote($id_torta);

        if (!$lotes) {
            echo json_encode(['success' => false, 'message' => 'No hay stock disponible']);
            exit;
        }

        $restante = $cantidadRestar;
        $errores = [];

        foreach ($lotes as $lote) {
            if ($restante <= 0) break;

            $stockLote = intval($lote['cantidad']);
            $idLote = $lote['id'];

            $cantidadDescontar = min($restante, $stockLote);

            // Update local object for model method
            $loteObj = $this->lotesModel;
            $loteObj->id = $idLote;
            $loteObj->cantidad = $cantidadDescontar; // The method "restarlote" now subtracts this amount

            if ($this->lotesModel->restarlote($loteObj)) {
                $restante -= $cantidadDescontar;
            } else {
                $errores[] = "Error restando del lote $idLote";
            }
        }

        if ($restante > 0) {
            // Partial success or not enough stock found in loop logic (race condition?)
            echo json_encode(['success' => true, 'message' => 'Procesado con advertencias (Stock insuficiente)', 'restante' => $restante]);
        } else {
            echo json_encode(['success' => true]);
        }
        exit;
    }

    public function buscarTortas() {
        verificarLogin();
        header('Content-Type: application/json');

        // 1. Try GET (standard)
        $termino = $_GET['q'] ?? '';

        error_log("DEBUG SEARCH: Received term '{$termino}'");

        // 2. Fallback to JSON POST (if user implemented tutorial exactly)
        if (trim($termino) === '') {
            $input = json_decode(file_get_contents('php://input'), true);
            $termino = $input['busqueda'] ?? '';
            error_log("DEBUG SEARCH: Term from JSON input '{$termino}'");
        }

        // If still empty, usually we return nothing, but for DEBUG we will continue
        /*
        if (trim($termino) === '') {
            error_log("DEBUG SEARCH: Term is empty, returning []");
            echo json_encode([]);
            exit;
        }
        */

        try {
            // Optimized search (Model does JOIN/Subquery + Stock)
            $resultados = $this->tortasModel->buscar($termino);

            error_log("DEBUG SEARCH: Found " . count($resultados) . " results for '{$termino}'");

            // Log for debugging if empty
            if (empty($resultados)) {
                error_log("Search term '$termino' returned no results.");
            }
            echo json_encode($resultados);
        } catch (\Throwable $th) {
            error_log("Controller Error in buscarTortas: " . $th->getMessage());
            echo json_encode([
                [
                    'id' => 0,
                    'nombre' => 'ERROR SISTEMA: ' . $th->getMessage(),
                    'precio' => 0,
                    'stock' => 0,
                    'img' => ''
                ]
            ]);
        }
        exit;
    }
}
