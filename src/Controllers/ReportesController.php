<?php

namespace App\Controllers;

use App\Models\Clientes;
use App\Models\Entradas;
use App\Models\DetallesEntradas;
use App\Models\Factura;
use App\Models\Lotes;
use Dompdf\Dompdf;
use Dompdf\Options;

class ReportesController {
    private $clientesModel;
    private $entradasModel;
    private $facturaModel;
    private $lotesModel;
    private $detallesEntradasModel;

    public function __construct() {
        $this->clientesModel = new Clientes();
        $this->entradasModel = new Entradas();
        $this->facturaModel = new Factura();
        $this->lotesModel = new Lotes();
        $this->detallesEntradasModel = new DetallesEntradas();
    }

    public function entradas() {
        verificarLogin();
        $entradas = $this->entradasModel->mostrarEntradas();

        // Extract unique locales for the filter dropdown
        // Extract unique locales for the filter dropdown
        $locales = [];
        $totalEntradas = 0;
        $totalUsd = 0;
        $totalBs = 0;

        if (!empty($entradas)) {
            $locales = array_unique(array_column($entradas, 'local'));
            sort($locales); // Optional: sort alphabetically

            $totalEntradas = count($entradas);
            foreach ($entradas as $entrada) {
                $totalUsd += $entrada->precio_usd;
                $totalBs += $entrada->precio_bs;
            }
        }

        $data = [
            'title' => 'Reporte de Entradas',
            'moduloActivo' => 'reportesEntradas',
            'entradas' => $entradas,
            'locales' => $locales,
            'totalEntradas' => $totalEntradas,
            'totalUsd' => $totalUsd,
            'totalBs' => $totalBs
        ];
        render_view('reportesEntradas', $data);
    }

    public function ventas() {
        verificarLogin();
        $ventas = $this->facturaModel->mostrar();

        $totalVentas = 0;
        $totalUsd = 0;
        $totalBs = 0;

        if (!empty($ventas)) {
            foreach ($ventas as $venta) {
                if ($venta->estado != 'Anulado') {
                    $totalVentas++;
                    $totalUsd += $venta->total_usd;
                    $totalBs += $venta->total_bs;
                }
            }
        }

        $data = [
            'title' => 'Reporte de Ventas',
            'moduloActivo' => 'reportesVentas', // Assuming a route or sidebar ID
            'ventas' => $ventas,
            'totalVentas' => $totalVentas,
            'totalUsd' => $totalUsd,
            'totalBs' => $totalBs
        ];
        render_view('reportesVentas', $data);
    }

    public function inventario() {
        verificarLogin();
        $inventario = $this->lotesModel->obtenerInventarioDetallado();

        $totalUnidades = 0;
        $totalValorUsd = 0;
        $itemsBajoStock = 0;
        $umbralBajo = 5; // Alert threshold

        $productos = []; // For the filter dropdown

        foreach ($inventario as $item) {
            $totalUnidades += $item->total_stock;
            $valorItem = $item->total_stock * $item->precio;
            $totalValorUsd += $valorItem;

            // Add calculated fields to item object for display
            $item->total_valor_usd = $valorItem;

            if ($item->total_stock <= $umbralBajo) {
                $itemsBajoStock++;
            }

            // Collect product Name ID/Name for dropdown
            // Assuming item has 'id' and 'nombre'. Using ID as value if available, else name.
            // Checking previous view, item has 'nombre'. We likely want to filter by ID if possible, but let's check what 'obtenerInventarioDetallado' returns.
            // For now collecting objects or arrays to keep ID and Name.
            // If ID is not readily available in the object for the *product* (this might be a lot), we'll use name.
            // View uses $item->nombre. Let's assume name is unique enough for this report or just use name as value.
            $productos[] = $item->nombre;
        }

        $productos = array_unique($productos);
        sort($productos);

        $data = [
            'moduloActivo' => 'reportes/inventario',
            'title' => 'Reporte de Inventario',
            'inventario' => $inventario,
            'totalUnidades' => $totalUnidades,
            'totalValorUsd' => $totalValorUsd,
            'itemsBajoStock' => $itemsBajoStock,
            'productos' => $productos
        ];
        render_view('reportesInventario', $data);
    }

    public function clientes() {
        verificarLogin();
        $clientesStats = $this->clientesModel->obtenerClientesConVentas();

        $totalClientes = count($clientesStats);
        $clienteTop = null;
        if (!empty($clientesStats)) {
            $clienteTop = $clientesStats[0]; // Ordered by USD DESC
        }

        $data = [
            'moduloActivo' => 'reportes/clientes',
            'title' => 'Reporte de Clientes',
            'clientes' => $clientesStats,
            'totalClientes' => $totalClientes,
            'clienteTop' => $clienteTop
        ];
        render_view('reportesClientes', $data);
    }

    public function tiposdereporte() {
        $reportes = trim($_POST['reportes']);
        error_log("ReportesController::tiposdereporte POST: " . print_r($_POST, true));
        if ($reportes == 'detallado') {
            header('location: ' . RUTA_BASE . 'reportes/generarreporte');
            exit();
        } else if ($reportes == 'multiple') {
            $_SESSION['reporte_cliente_id'] = $_POST['cliente_id'];
            $_SESSION['reporte_fecha_inicio'] = $_POST['fecha_inicio'];
            $_SESSION['reporte_fecha_final'] = $_POST['fecha_final'];
            header('location: ' . RUTA_BASE . 'reportes/generarMultiple');
            exit();
        } else if ($reportes == 'entradas_general') {
            $_SESSION['reporte_fecha_inicio'] = $_POST['fecha_inicio'];
            $_SESSION['reporte_fecha_final'] = $_POST['fecha_final'];
            header('location: ' . RUTA_BASE . 'reportes/generarReporteEntradas');
            exit();
        } else if ($reportes == 'multiple_local') {
            $_SESSION['reporte_local'] = $_POST['local'];
            $_SESSION['reporte_fecha_inicio'] = $_POST['fecha_inicio'];
            $_SESSION['reporte_fecha_final'] = $_POST['fecha_final'];
            header('location: ' . RUTA_BASE . 'reportes/generarMultipleentrada');
            exit();
        } else if ($reportes == 'inventario_general') {
            header('location: ' . RUTA_BASE . 'reportes/generarReporteInventario');
            exit();
        } else if ($reportes == 'por_producto') {
            $_SESSION['reporte_producto'] = $_POST['producto'];
            header('location: ' . RUTA_BASE . 'reportes/generarReporteInventarioProducto');
            exit();
        } else if ($reportes == 'inventario_bajo_stock') {
            header('location: ' . RUTA_BASE . 'reportes/generarReporteInventarioBajoStock');
            exit();
        } else if ($reportes == 'ventas_general') {
            $_SESSION['reporte_fecha_inicio'] = $_POST['fecha_inicio'];
            $_SESSION['reporte_fecha_final'] = $_POST['fecha_final'];
            header('location: ' . RUTA_BASE . 'reportes/generarReporteVenta');
            exit();
        } else if ($reportes == 'ventas_estado') {
            $_SESSION['reporte_estado'] = $_POST['estado'];
            $_SESSION['reporte_fecha_inicio'] = $_POST['fecha_inicio'];
            $_SESSION['reporte_fecha_final'] = $_POST['fecha_final'];
            header('location: ' . RUTA_BASE . 'reportes/generarReporteVentaEstado');
            exit();
        } else if ($reportes == 'mas_vendidas' || $reportes == 'menos_vendidas') {
            $_SESSION['reporte_ranking_tipo'] = $reportes;
            $_SESSION['reporte_fecha_inicio'] = $_POST['fecha_inicio'];
            $_SESSION['reporte_fecha_final'] = $_POST['fecha_final'];
            header('location: ' . RUTA_BASE . 'reportes/generarReporteRankingVentas');
            exit();
        }
    }

    public function generarReporteVenta() {
        verificarLogin();
        $fechaInicio = (!empty($_SESSION['reporte_fecha_inicio'])) ? $_SESSION['reporte_fecha_inicio'] : '';
        $fechaFinal = (!empty($_SESSION['reporte_fecha_final'])) ? $_SESSION['reporte_fecha_final'] : '';

        $ventas = $this->facturaModel->mostrar();

        if (!empty($fechaInicio) && !empty($fechaFinal)) {
            $ventas = array_filter($ventas, function ($v) use ($fechaInicio, $fechaFinal) {
                $fechaVenta = date('Y-m-d', strtotime($v->fecha));
                return $fechaVenta >= $fechaInicio && $fechaVenta <= $fechaFinal;
            });
        }

        ob_start();
        require 'src/Views/reportegenerarventa.php';
        $html = ob_get_clean();
        $dompdf = new Dompdf();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');

        $dompdf->render();
        $dompdf->stream("reporte_ventas_general.pdf", array("Attachment" => false));
    }

    public function generarReporteVentaEstado() {
        verificarLogin();
        $estado = isset($_SESSION['reporte_estado']) ? trim($_SESSION['reporte_estado']) : '';
        $fechaInicio = (!empty($_SESSION['reporte_fecha_inicio'])) ? $_SESSION['reporte_fecha_inicio'] : '';
        $fechaFinal = (!empty($_SESSION['reporte_fecha_final'])) ? $_SESSION['reporte_fecha_final'] : '';

        $ventas = $this->facturaModel->mostrar();

        // Filter by date
        if (!empty($fechaInicio) && !empty($fechaFinal)) {
            $ventas = array_filter($ventas, function ($v) use ($fechaInicio, $fechaFinal) {
                $fechaVenta = date('Y-m-d', strtotime($v->fecha));
                return $fechaVenta >= $fechaInicio && $fechaVenta <= $fechaFinal;
            });
        }

        // Filter by state (Case insensitive and trimmed)
        if (!empty($estado)) {
            $ventas = array_filter($ventas, function ($v) use ($estado) {
                return strcasecmp(trim($v->estado), $estado) === 0;
            });
        }

        // Pass the specific title
        $tituloReporte = "Reporte de Ventas (" . ucfirst(strtolower($estado)) . ")";

        ob_start();

        // Select specific template based on status
        if (strcasecmp($estado, 'Pendiente') === 0 || strcasecmp($estado, 'En proceso') === 0) {
            require 'src/Views/reportegenerarventapendiente.php';
        } else if (strcasecmp($estado, 'Completado') === 0) {
            require 'src/Views/reportegenerarventacompletado.php';
        } else {
            // Default or generic
            require 'src/Views/reportegenerarventa.php';
        }

        $html = ob_get_clean();
        $dompdf = new Dompdf();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');

        $dompdf->render();
        $dompdf->stream("reporte_ventas_" . strtolower($estado) . ".pdf", array("Attachment" => false));
    }

    public function generarreporte() {
        verificarLogin();
        $clientes = $this->clientesModel->mostrar();
        ob_start();
        require 'src/Views/reportegenerarcliente.php';
        $html = ob_get_clean();
        $dompdf = new Dompdf();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');

        // 8. Renderizar el HTML como PDF
        $dompdf->render();

        // 9. Enviarlo al navegador (Stream)
        $dompdf->stream("reporte_clientes_general.pdf", array("Attachment" => false));
    }

    public function generarReporteEntradas() {
        verificarLogin();
        $fechaInicio = (!empty($_SESSION['reporte_fecha_inicio'])) ? $_SESSION['reporte_fecha_inicio'] : '';
        $fechaFinal = (!empty($_SESSION['reporte_fecha_final'])) ? $_SESSION['reporte_fecha_final'] : '';
        error_log("ReportesController::generarReporteEntradas SESSION dates: Start=$fechaInicio, End=$fechaFinal");

        // Use new method to get Entradas with 'total_items' (quantity)
        $entradas = $this->entradasModel->obtenerEntradasConCantidad();

        if (!empty($fechaInicio) && !empty($fechaFinal)) {
            $entradas = array_filter($entradas, function ($e) use ($fechaInicio, $fechaFinal) {
                $fechaEntrada = date('Y-m-d', strtotime($e->fecha));
                $keep = $fechaEntrada >= $fechaInicio && $fechaEntrada <= $fechaFinal;
                error_log("Filtering entry: ID={$e->id}, Date={$fechaEntrada} vs Range {$fechaInicio}-{$fechaFinal} => " . ($keep ? 'Keep' : 'Discard'));
                return $keep;
            });
            error_log("After filtering: " . count($entradas) . " entries remain.");
        }

        // Fetch details for each entry
        foreach ($entradas as $entrada) {
            $entrada->detalles = $this->detallesEntradasModel->obtenerPorEntradaId($entrada->id);
            $entrada->precio_usd = floatval($entrada->precio_usd);
            $entrada->precio_bs = floatval($entrada->precio_bs);
        }

        ob_start();
        require 'src/Views/reportegenerarentrada.php';
        $html = ob_get_clean();
        $dompdf = new Dompdf();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');

        $dompdf->render();
        $dompdf->stream("reporte_entradas_general.pdf", array("Attachment" => false));
    }

    public function generarMultipleentrada() {
        verificarLogin();

        $localSeleccionado = isset($_SESSION['reporte_local']) ? trim($_SESSION['reporte_local']) : '';
        $fechaInicio = (!empty($_SESSION['reporte_fecha_inicio'])) ? $_SESSION['reporte_fecha_inicio'] : '';
        $fechaFinal = (!empty($_SESSION['reporte_fecha_final'])) ? $_SESSION['reporte_fecha_final'] : '';

        // isset($_SESSION['reporte_local']) ? unset($_SESSION['reporte_local']) : '';

        $entradas = $this->entradasModel->obtenerEntradasConCantidad();

        // Filter by date
        if (!empty($fechaInicio) && !empty($fechaFinal)) {
            $entradas = array_filter($entradas, function ($e) use ($fechaInicio, $fechaFinal) {
                $fechaEntrada = date('Y-m-d', strtotime($e->fecha));
                return $fechaEntrada >= $fechaInicio && $fechaEntrada <= $fechaFinal;
            });
        }

        // Filter by local
        if (!empty($localSeleccionado)) {
            $entradas = array_filter($entradas, function ($entrada) use ($localSeleccionado) {
                return $entrada->local === $localSeleccionado;
            });
        }

        // Fetch details for each entry
        foreach ($entradas as $entrada) {
            $entrada->detalles = $this->detallesEntradasModel->obtenerPorEntradaId($entrada->id);
            $entrada->precio_usd = floatval($entrada->precio_usd);
            $entrada->precio_bs = floatval($entrada->precio_bs);
        }

        ob_start();
        require 'src/Views/reportegenerarentrada.php';
        $html = ob_get_clean();
        $dompdf = new Dompdf();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');

        $dompdf->render();
        $dompdf->stream("reporte_entradas_local.pdf", array("Attachment" => false));
    }


    public function generarMultiple() {
        verificarLogin();

        $clienteId = isset($_SESSION['reporte_cliente_id']) ? $_SESSION['reporte_cliente_id'] : '';
        $fechaInicio = isset($_SESSION['reporte_fecha_inicio']) ? $_SESSION['reporte_fecha_inicio'] : '';
        $fechaFinal = isset($_SESSION['reporte_fecha_final']) ? $_SESSION['reporte_fecha_final'] : '';

        // Fetch all sales
        $ventas = $this->facturaModel->mostrar();

        // 1. Filter by Client
        if (!empty($clienteId)) {
            $ventas = array_filter($ventas, function ($v) use ($clienteId) {
                return $v->id_cliente == $clienteId;
            });
        }

        // 2. Filter by Dates
        if (!empty($fechaInicio) && !empty($fechaFinal)) {
            $ventas = array_filter($ventas, function ($v) use ($fechaInicio, $fechaFinal) {
                $fechaVenta = date('Y-m-d', strtotime($v->fecha));
                return $fechaVenta >= $fechaInicio && $fechaVenta <= $fechaFinal;
            });
        }

        // Set dynamic title
        $tituloReporte = "Reporte de Ventas por Cliente";
        if (!empty($ventas)) {
            // Try to get client name from first record if filtered
            // Or we could fetch client name using client model, but we have invoice objects with client name attached
            $first = reset($ventas); // Get first element
            if (isset($first->cliente)) {
                $tituloReporte .= " - " . $first->cliente;
            }
        }

        ob_start();
        // Reuse general sales template
        require 'src/Views/reportegenerarventa.php';
        $html = ob_get_clean();
        $dompdf = new Dompdf();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');

        $dompdf->render();
        $dompdf->stream("reporte_ventas_cliente.pdf", array("Attachment" => false));
    }

    public function generarReporteInventario() {
        verificarLogin();
        $inventario = $this->lotesModel->obtenerInventarioDetallado();

        // Calculate totals for the report
        foreach ($inventario as $item) {
            $item->total_valor_usd = $item->total_stock * $item->precio;
        }

        ob_start();
        require 'src/Views/reportegenerarinventario.php';
        $html = ob_get_clean();
        $dompdf = new Dompdf();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');

        $dompdf->render();
        $dompdf->stream("reporte_inventario_general.pdf", array("Attachment" => false));
    }

    public function generarReporteInventarioProducto() {
        verificarLogin();

        $productoSeleccionado = isset($_SESSION['reporte_producto']) ? trim($_SESSION['reporte_producto']) : '';
        // Clear session after use to prevent stuck filters? Or keep it?
        // Let's keep it simple for now. 
        // unset($_SESSION['reporte_producto']); 

        $inventario = $this->lotesModel->obtenerInventarioDetallado();

        // Filter by selected product if provided
        if (!empty($productoSeleccionado)) {
            $inventario = array_filter($inventario, function ($item) use ($productoSeleccionado) {
                return $item->nombre === $productoSeleccionado;
            });
        }

        foreach ($inventario as $item) {
            $item->total_valor_usd = $item->total_stock * $item->precio;
        }

        ob_start();
        require 'src/Views/reportegenerarinventario.php';
        $html = ob_get_clean();
        $dompdf = new Dompdf();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');

        $dompdf->render();
        $dompdf->stream("reporte_inventario_producto.pdf", array("Attachment" => false));
    }

    public function generarReporteInventarioBajoStock() {
        verificarLogin();
        $inventario = $this->lotesModel->obtenerInventarioDetallado();
        $umbralBajo = 5;

        // Filter by low stock
        $inventario = array_filter($inventario, function ($item) use ($umbralBajo) {
            return $item->total_stock <= $umbralBajo;
        });

        foreach ($inventario as $item) {
            $item->total_valor_usd = $item->total_stock * $item->precio;
        }

        ob_start();
        require 'src/Views/reportegenerarinventariobajostock.php';
        $html = ob_get_clean();
        $dompdf = new Dompdf();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');

        $dompdf->render();
        $dompdf->stream("reporte_inventario_bajo_stock.pdf", array("Attachment" => false));
    }

    public function generarReporteRankingVentas() {
        verificarLogin();

        $tipo = isset($_SESSION['reporte_ranking_tipo']) ? $_SESSION['reporte_ranking_tipo'] : 'mas_vendidas';
        $fechaInicio = (!empty($_SESSION['reporte_fecha_inicio'])) ? $_SESSION['reporte_fecha_inicio'] : date('Y-m-01');
        $fechaFinal = (!empty($_SESSION['reporte_fecha_final'])) ? $_SESSION['reporte_fecha_final'] : date('Y-m-t');

        $orden = ($tipo == 'mas_vendidas') ? 'DESC' : 'ASC';
        $titulo = ($tipo == 'mas_vendidas') ? 'Tortas Más Vendidas' : 'Tortas Menos Vendidas';

        // Use a generic details model or load it if not property
        // Assuming $this->facturaModel connects to invoices, but we need Detail model for products
        // We can create an instance on the fly or add it to constructor. 
        // Best practice: add to constructor, but for quick fix:
        $detallesModel = new \App\Models\DetallesFacturas();
        $datos = $detallesModel->obtenerVentasPorProducto($fechaInicio, $fechaFinal, $orden);

        // Filter for "Tortas Menos Vendidas" threshold (<= 3)
        if ($tipo == 'menos_vendidas') {
            $datos = array_filter($datos, function ($item) {
                return $item->total_vendido <= 3;
            });
        }

        ob_start();
        require 'src/Views/reportegenerarrankingventas.php';
        $html = ob_get_clean();
        $dompdf = new Dompdf();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');

        $dompdf->render();
        $dompdf->stream("reporte_sales_ranking.pdf", array("Attachment" => false));
    }

    public function capital() {
        verificarLogin();
        $facturas = $this->facturaModel->mostrar();
        $entradas = $this->entradasModel->mostrarEntradas();

        // 1. Calculate Grand Totals & Daily Transactions
        $totalIngresosUsd = 0;
        $totalIngresosBs = 0;
        $transactions = [];

        if ($facturas) {
            foreach ($facturas as $f) {
                if ($f->estado != 'Anulado') {
                    $totalIngresosUsd += floatval($f->total_usd);
                    $totalIngresosBs += floatval($f->total_bs);

                    // Add to timeline
                    $date = date('Y-m-d', strtotime($f->fecha));
                    if (!isset($transactions[$date])) {
                        $transactions[$date] = ['income_usd' => 0, 'expense_usd' => 0, 'income_bs' => 0, 'expense_bs' => 0];
                    }
                    $transactions[$date]['income_usd'] += floatval($f->total_usd);
                    $transactions[$date]['income_bs'] += floatval($f->total_bs);
                }
            }
        }

        $totalEgresosUsd = 0;
        $totalEgresosBs = 0;

        if ($entradas) {
            foreach ($entradas as $e) {
                $totalEgresosUsd += floatval($e->precio_usd);
                $totalEgresosBs += floatval($e->precio_bs);

                // Add to timeline
                $date = date('Y-m-d', strtotime($e->fecha));
                if (!isset($transactions[$date])) {
                    $transactions[$date] = ['income_usd' => 0, 'expense_usd' => 0, 'income_bs' => 0, 'expense_bs' => 0];
                }
                $transactions[$date]['expense_usd'] += floatval($e->precio_usd);
                $transactions[$date]['expense_bs'] += floatval($e->precio_bs);
            }
        }

        // 2. Process for Candlestick Chart (OHLC)
        ksort($transactions); // Sort by date

        $chartData = [];
        $chartDataBs = [];

        $runningCapital = 0; // USD
        $runningCapitalBs = 0; // BS

        foreach ($transactions as $date => $dayData) {
            // USD
            $open = $runningCapital;
            $close = $open + $dayData['income_usd'] - $dayData['expense_usd'];
            $high = max($open, $close, $open + $dayData['income_usd']);
            $low = min($open, $close, $open - $dayData['expense_usd']);
            $chartData[] = ['x' => $date, 'y' => [$open, $high, $low, $close]];
            $runningCapital = $close;

            // BS
            $openBs = $runningCapitalBs;
            $closeBs = $openBs + $dayData['income_bs'] - $dayData['expense_bs'];
            $highBs = max($openBs, $closeBs, $openBs + $dayData['income_bs']);
            $lowBs = min($openBs, $closeBs, $openBs - $dayData['expense_bs']);
            $chartDataBs[] = ['x' => $date, 'y' => [$openBs, $highBs, $lowBs, $closeBs]];
            $runningCapitalBs = $closeBs;
        }

        $capitalNetoUsd = $totalIngresosUsd - $totalEgresosUsd;
        $capitalNetoBs = $totalIngresosBs - $totalEgresosBs;

        $data = [
            'moduloActivo' => 'reportes/capital',
            'title' => 'Reporte de Capital',
            'totalIngresosUsd' => $totalIngresosUsd,
            'totalIngresosBs' => $totalIngresosBs,
            'totalEgresosUsd' => $totalEgresosUsd,
            'totalEgresosBs' => $totalEgresosBs,
            'capitalNetoUsd' => $capitalNetoUsd,
            'capitalNetoBs' => $capitalNetoBs,
            'chartData' => json_encode($chartData),
            'chartDataBs' => json_encode($chartDataBs)
        ];
        render_view('reportesCapital', $data);
    }
}
