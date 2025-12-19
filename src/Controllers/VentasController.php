<?php

namespace App\Controllers;

use App\Models\Factura;
use App\Models\DetallesFacturas;
use App\Models\Tortas;
use App\Models\Lotes;
use App\Models\Clientes;

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

        $stock = $this->lotesModel->inventario();
        foreach ($tortas as $torta) {
            $torta->stock = $stock[$torta->id] ?? 0;
        }

        $facturas = $this->facturaModel->mostrar();
        $data = [
            'title' => 'Ventas',
            'moduloActivo' => 'ventas',
            'clientes' => $clientes,
            'tortas' => $tortas,
            'ventas' => $facturas,
            'mensaje' => $_SESSION['mensaje'] ?? []
        ];
        render_view('ventas', $data);
        unset($_SESSION['mensaje']);
    }
    public function registrar() {
        verificarLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . RUTA_BASE . 'ventas');
            exit;
        }

        // 1. Recoger datos del formulario
        $id_cliente = $_POST['id_cliente'] ?? null;
        $id_tortas = $_POST['id_torta'] ?? [];
        $cantidades = $_POST['cantidad'] ?? [];
        $precios = $_POST['precio'] ?? [];
        $tasa = floatval($_POST['tasa'] ?? 0);

        // Pagos (opcionales)
        $metodos_pago = $_POST['pago_metodo'] ?? [];
        $montos_pago = $_POST['pago_monto'] ?? [];

        // Validaciones básicas
        if (empty($id_cliente) || empty($id_tortas)) {
            $_SESSION['mensaje'] = ['tipo' => 'danger', 'texto' => 'Datos incompletos para la venta.'];
            header('Location: ' . RUTA_BASE . 'ventas');
            exit;
        }

        // Calcular total USD
        $totalUsd = 0;
        for ($i = 0; $i < count($id_tortas); $i++) {
            $cant = floatval($cantidades[$i]);
            $prec = floatval($precios[$i]);
            $totalUsd += ($cant * $prec);
        }

        // Calcular total BS
        $totalBs = $totalUsd * ($tasa > 0 ? $tasa : 1);
        // 2. Guardar Factura

        $factura = $this->facturaModel;
        $factura->id_cliente = $id_cliente;
        $factura->total_usd = $totalUsd;
        $factura->total_bs = $totalBs;
        $factura->fecha = date('Y-m-d H:i:s');
        $factura->estado = 'En proceso';

        $id_factura = $this->facturaModel->guardarFactura($factura);

        if (!$id_factura) {
            $_SESSION['mensaje'] = ['tipo' => 'danger', 'texto' => 'Error al crear la factura.'];
            header('Location: ' . RUTA_BASE . 'ventas');
            exit;
        }


        // 3. Procesar Detalles y Lotes
        $lotes = $this->lotesModel;
        $detalles = $this->detallesfacturasModel;

        for ($i = 0; $i < count($id_tortas); $i++) {
            $id_torta = $id_tortas[$i];
            $cantidad_necesaria = floatval($cantidades[$i]);
            $precio_unitario = floatval($precios[$i]); // Precio de venta

            // Guardar Detalle
            $detalles->id_factura = $id_factura;
            $detalles->id_torta = $id_torta;
            $detalles->cantidad = $cantidad_necesaria;
            $detalles->precio_usd = $precio_unitario;
            $detalles->precio_bs = $precio_unitario * ($tasa > 0 ? $tasa : 1);
            $detalles->guardarDetalle($detalles);

            // Descontar de Lotes (FIFO / Disponibles)
            // Buscar lotes con stock > 0 para este producto
            $lotes_disponibles = $lotes->buscarlote($id_torta);

            if ($lotes_disponibles) {
                foreach ($lotes_disponibles as $lote) {
                    if ($cantidad_necesaria <= 0) break;

                    $stock_lote = floatval($lote['cantidad']);
                    $a_descontar = 0;

                    if ($stock_lote >= $cantidad_necesaria) {
                        $a_descontar = $cantidad_necesaria;
                        $cantidad_necesaria = 0;
                    } else {
                        $a_descontar = $stock_lote;
                        $cantidad_necesaria -= $stock_lote;
                    }

                    // Actualizar lote
                    $nueva_cantidad = $stock_lote - $a_descontar;
                    $lotes->id = $lote['id'];
                    $lotes->cantidad = $nueva_cantidad;
                    $lotes->ajustar($lotes);
                }
            }
        }


        // 4. Procesar Pagos (Opcional)
        // Se recorren los pagos enviados, si vienen vacíos se ignora o se guarda 0 según lógica
        if (!empty($metodos_pago)) {
            $pagosModel = new \App\Models\Pagos();

            for ($j = 0; $j < count($metodos_pago); $j++) {
                $metodo = $metodos_pago[$j];
                $monto = isset($montos_pago[$j]) && $montos_pago[$j] !== '' ? floatval($montos_pago[$j]) : 0;

                // Si el usuario quiere guardar registro aunque el monto sea 0, lo permitimos
                // Si preferimos no guardar pagos vacíos: if ($monto > 0) ...
                $pagosModel->guardarPago($id_factura, $metodo, $monto);
            }
        }

        $_SESSION['mensaje'] = ['tipo' => 'success', 'texto' => 'Venta registrada con éxito.'];
        header('Location: ' . RUTA_BASE . 'ventas');
        exit;
    }

    public function agregarPago() {
        // Soportar JSON (fetch) o POST normal
        $data = [];
        if ($_SERVER['CONTENT_TYPE'] === 'application/json') {
            $data = json_decode(file_get_contents('php://input'), true);
        } else {
            $data = $_POST;
        }

        $id_factura = $data['id_factura'] ?? null;
        $metodo = $data['metodo'] ?? '';
        $monto = $data['monto'] ?? 0;

        if ($id_factura && $metodo) {
            $pagosModel = new \App\Models\Pagos();
            if ($pagosModel->guardarPago($id_factura, $metodo, $monto)) {
                echo json_encode(['status' => true, 'message' => 'Pago registrado']);
            } else {
                echo json_encode(['status' => false, 'message' => 'Error al guardar pago']);
            }
        } else {
            echo json_encode(['status' => false, 'message' => 'Datos inválidos']);
        }
        exit;
    }

    public function ver($id) {
        verificarLogin();

        $factura = $this->facturaModel->buscarPorId($id);
        if (!$factura) {
            header('Location: ' . RUTA_BASE . 'ventas');
            exit;
        }

        $detalles = $this->detallesfacturasModel->obtenerPorFacturaId($id);

        $pagosModel = new \App\Models\Pagos();
        $pagos = $pagosModel->obtenerPorFacturaId($id);

        $data = [
            'title' => 'Detalle de Venta',
            'moduloActivo' => 'ventas',
            'factura' => $factura,
            'detalles' => $detalles,
            'pagos' => $pagos
        ];
        render_view('ventas_ver', $data);
    }
}
