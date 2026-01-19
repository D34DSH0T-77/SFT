<?php

namespace App\Controllers;

use App\Models\Factura;
use App\Models\DetallesFacturas;
use App\Models\Tortas;
use App\Models\Lotes;
use App\Models\Clientes;
use App\Models\Pagos;

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
        $tortas = $this->lotesModel->obtenerstock();

        $facturas = $this->facturaModel->mostrar();

        // Calcular Ingresos (Pagos Reales)
        $pagosModel = new Pagos();
        $todosPagos = $pagosModel->obtenerTodos();

        $totalGananciasUsd = 0;
        $totalGananciasBs = 0;

        foreach ($todosPagos as $p) {
            $monto = floatval($p['monto']);
            $metodo = $p['metodo'];

            // Logica simple de clasificacion
            if ($metodo === 'Divisa' || $metodo === 'Efectivo USD') {
                $totalGananciasUsd += $monto;
            } else {
                $totalGananciasBs += $monto;
            }
        }

        $totalVentas = 0;
        $totalUsd = 0;
        $totalBs = 0;
        if (!empty($facturas)) {
            foreach ($facturas as $venta) {
                if ($venta->estado != 'Anulado') {
                    $totalVentas++;
                    $totalUsd += $venta->total_usd;
                    $totalBs += $venta->total_bs;
                }
            }
        }

        $data = [
            'title' => 'Ventas',
            'moduloActivo' => 'ventas',
            'clientes' => $clientes,
            'tortas' => $tortas,
            'ventas' => $facturas,
            'totalVentas' => $totalVentas,
            'totalUsd' => $totalUsd,
            'totalBs' => $totalBs,
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
        $codigo = $_POST['codigo'] ?? '';

        // Pagos (opcionales)
        $metodos_pago = $_POST['pago_metodo'] ?? [];
        $montos_pago = $_POST['pago_monto'] ?? [];

        // Validaciones básicas
        if (empty($id_cliente) || empty($id_tortas)) {
            $_SESSION['mensaje'] = ['tipo' => 'error', 'texto' => 'Datos incompletos para la venta.'];
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
        $factura->fecha = date('Y-m-d');
        $factura->estado = 'En proceso';
        $factura->codigo = $codigo;

        $id_factura = $this->facturaModel->guardarFactura($factura);

        if (!$id_factura) {
            $_SESSION['mensaje'] = ['tipo' => 'error', 'texto' => 'Error al crear la factura.'];
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
        $totalPagadoInicial = 0;
        if (!empty($metodos_pago)) {
            $pagosModel = new \App\Models\Pagos();

            for ($j = 0; $j < count($metodos_pago); $j++) {
                $metodo = $metodos_pago[$j];
                $monto = isset($montos_pago[$j]) && $montos_pago[$j] !== '' ? floatval($montos_pago[$j]) : 0;

                // Si el método NO es Divisa ni Efectivo USD, asumimos que es en Bolivares
                // y debemos convertirlo a USD para guardarlo en la DB
                $monto_original = 0.00;
                if ($metodo !== 'Divisa' && $metodo !== 'Efectivo USD' && $tasa > 0) {
                    $monto_original = $monto; // Guardamos lo que se ingresó (ej: 500)
                    $monto = $monto / $tasa;
                } else {
                    $monto_original = $monto; // Si es USD, el original es el mismo
                }

                if ($monto > 0) {
                    $totalPagadoInicial += $monto;
                    $pagosModel->guardarPago($id_factura, $metodo, $monto, $tasa, $monto_original);
                }
            }

            // Validar si completó el pago
            if ($totalPagadoInicial >= ($totalUsd - 0.01)) {
                $this->facturaModel->actualizarEstado($id_factura, 'Completado');
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
        $monto = floatval($data['monto'] ?? 0);

        if ($id_factura && $metodo && $monto > 0) {
            $facturaModel = new \App\Models\Factura();
            $pagosModel = new \App\Models\Pagos();

            // 1. Obtener Factura Actual
            $factura = $facturaModel->buscarPorId($id_factura);
            if (!$factura) {
                echo json_encode(['status' => false, 'message' => 'Factura no encontrada']);
                exit;
            }

            // 2. Calcular Deuda Pendiente
            $todosPagos = $pagosModel->obtenerPorFacturaId($id_factura);
            $totalPagado = 0;
            foreach ($todosPagos as $p) {
                $totalPagado += floatval($p['monto']);
            }
            $restante = $factura->total_usd - $totalPagado;

            // 3. Validar Monto (con pequeño margen para float)
            if ($monto > ($restante + 0.01)) {
                echo json_encode([
                    'status' => false,
                    'message' => 'El monto excede la deuda pendiente ($' . number_format($restante, 2) . ')'
                ]);
                exit;
            }

            // 4. Guardar Pago
            // Recalcular tasa si es BS para guardarla
            $tasaGuardar = 1.00;
            if ($metodo !== 'Divisa' && $metodo !== 'Efectivo USD') {
                // Si el monto en USD es X y el pago original era Y, Tasa = Y / X
                // Pero aquí ya recibimos el monto convertido (o no?)
                // REVISAR: El frontend envia 'monto' ya convertido a USD si es 'agregarPago'?
                // Mirando ventas.js: procesarPagoExistente envia `monto: pagoReal`. Donde pagoReal = monto / TASA_CAMBIO.
                // Entonces el backend recibe USD.
                // Necesitamos 'tasa' del frontend o estimarla.
                // ventas.js NO envia la tasa en 'agregarPago'.
                // Debemos asumir la tasa actual del momento para guardar referencia? 
                // O mejor, modificar ventas.js para enviar la tasa.
                // Por ahora, usaremos una logica inversa simple si tuvieramos el monto original, pero no lo tenemos.
                // VAMOS A MODIFICAR ventas.js para enviar la tasa también.
                // Mientras tanto, usaremos 1.00 si es divisa, o calcularemos si podemos.
                // Como no tenemos la tasa, asumiremos guardar 1.00 hasta actualizar JS, pero el plan dice actualizar controller. 
                // Voy a leer de $_POST['tasa'] si existe.
            }

            $tasa = floatval($data['tasa'] ?? 1.00);
            $monto_exacto = floatval($data['monto_exacto'] ?? 0.00);

            // Si no nos mandan el monto exacto (versiones viejas de JS?), tratar de inferirlo o usar 0
            if ($monto_exacto <= 0) {
                // Heurística simple: Si tasa > 1 y no es divisa, quizás $monto es ya convertido? 
                // Pero `agregarPago` recibe `monto` ya convertido desde JS.
                // Sin embargo el JS nuevo mandará `monto_exacto` con lo que el usuario escribió.
                // Si es Divisa, monto_exacto debería ser igual a monto (en USD).
                if ($metodo === 'Divisa' || $metodo === 'Efectivo USD') {
                    $monto_exacto = $monto;
                } else {
                    // Si es BS, y no vino, quizas tasa * monto?
                    if ($tasa > 1) {
                        $monto_exacto = $monto * $tasa;
                    }
                }
            }

            if ($pagosModel->guardarPago($id_factura, $metodo, $monto, $tasa, $monto_exacto)) {

                // Verificar si la factura está pagada por completo
                // Recalculamos con el nuevo pago
                $totalPagado += $monto;

                if ($totalPagado >= ($factura->total_usd - 0.01)) {
                    $facturaModel->actualizarEstado($id_factura, 'Completado');
                }

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

        $pagosModel = new Pagos();
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

    public function getSaldo($id) {
        $factura = $this->facturaModel->buscarPorId($id);
        if (!$factura) {
            echo json_encode(['error' => 'Factura no encontrada']);
            return;
        }

        $pagosModel = new \App\Models\Pagos();
        $pagos = $pagosModel->obtenerPorFacturaId($id);

        $totalPagado = 0;
        foreach ($pagos as $p) {
            $totalPagado += floatval($p['monto']);
        }

        $restanteUsd = $factura->total_usd - $totalPagado;

        header('Content-Type: application/json');
        echo json_encode([
            'status' => true,
            'total_usd' => $factura->total_usd,
            'pagado_usd' => $totalPagado,
            'restante_usd' => max(0, $restanteUsd)
        ]);
        exit;
    }
}
