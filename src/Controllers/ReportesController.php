<?php

namespace App\Controllers;

use App\Models\Clientes;
use App\Models\Entradas;
use App\Models\Factura;

use App\Models\Lotes;

class ReportesController {
    public function entradas() {
        verificarLogin();
        $entradasModel = new Entradas();
        $entradas = $entradasModel->mostrarEntradas();

        $totalBs = 0;
        $totalUsd = 0;
        $totalEntradas = count($entradas);

        foreach ($entradas as $e) {
            $totalBs += floatval($e->precio_bs);
            $totalUsd += floatval($e->precio_usd);
        }

        $data = [
            'moduloActivo' => 'reportes/entradas',
            'title' => 'Reporte de Entradas',
            'entradas' => $entradas,
            'totalBs' => $totalBs,
            'totalUsd' => $totalUsd,
            'totalEntradas' => $totalEntradas
        ];
        render_view('reportesEntradas', $data);
    }

    public function ventas() {
        $data = [];
        render_view('reportesVentas', $data);
    }

    public function inventario() {
        verificarLogin();
        $lotesModel = new Lotes();
        $inventario = $lotesModel->obtenerInventarioDetallado();

        $totalUnidades = 0;
        $totalValorUsd = 0;
        $itemsBajoStock = 0;
        $umbralBajo = 5; // Alert threshold

        foreach ($inventario as $item) {
            $totalUnidades += $item->total_stock;
            $valorItem = $item->total_stock * $item->precio;
            $totalValorUsd += $valorItem;

            // Add calculated fields to item object for display
            $item->total_valor_usd = $valorItem;

            if ($item->total_stock <= $umbralBajo) {
                $itemsBajoStock++;
            }
        }

        $data = [
            'moduloActivo' => 'reportes/inventario',
            'title' => 'Reporte de Inventario',
            'inventario' => $inventario,
            'totalUnidades' => $totalUnidades,
            'totalValorUsd' => $totalValorUsd,
            'itemsBajoStock' => $itemsBajoStock
        ];
        render_view('reportesInventario', $data);
    }

    public function clientes() {
        verificarLogin();
        $clientesModel = new Clientes();
        $clientesStats = $clientesModel->obtenerClientesConVentas();

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

    public function capital() {
        verificarLogin();
        $facturaModel = new Factura();
        $entradasModel = new Entradas();

        $facturas = $facturaModel->mostrar();
        $entradas = $entradasModel->mostrarEntradas();

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
