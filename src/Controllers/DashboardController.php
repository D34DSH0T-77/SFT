<?php

namespace App\Controllers;

use App\Models\Clientes;
use App\Models\Entradas;
use App\Models\Factura;
use App\Models\Lotes;

class DashboardController {
    private $clientes;
    private $lotes;
    private $entradasModel;
    private $facturaModel;

    public function __construct() {
        $this->clientes = new Clientes();
        $this->lotes = new Lotes();
        $this->entradasModel = new Entradas();
        $this->facturaModel = new Factura();
    }

    public function index() {
        // Dashboard Index
        verificarLogin();

        $totalClientes = $this->clientes->contar();
        $totalTortas = $this->lotes->contar();

        // Capital Chart Logic
        $facturas = $this->facturaModel->mostrar();
        $entradas = $this->entradasModel->mostrarEntradas();
        $transactions = [];

        if ($facturas) {
            foreach ($facturas as $f) {
                if ($f->estado != 'Anulado') {
                    $date = date('Y-m-d', strtotime($f->fecha));
                    if (!isset($transactions[$date])) {
                        $transactions[$date] = ['income_usd' => 0, 'expense_usd' => 0, 'income_bs' => 0, 'expense_bs' => 0];
                    }
                    $transactions[$date]['income_usd'] += floatval($f->total_usd);
                    $transactions[$date]['income_bs'] += floatval($f->total_bs);
                }
            }
        }

        if ($entradas) {
            foreach ($entradas as $e) {
                $date = date('Y-m-d', strtotime($e->fecha));
                if (!isset($transactions[$date])) {
                    $transactions[$date] = ['income_usd' => 0, 'expense_usd' => 0, 'income_bs' => 0, 'expense_bs' => 0];
                }
                $transactions[$date]['expense_usd'] += floatval($e->precio_usd);
                $transactions[$date]['expense_bs'] += floatval($e->precio_bs);
            }
        }

        ksort($transactions);

        $chartData = [];
        $chartDataBs = [];
        $runningCapital = 0;
        $runningCapitalBs = 0;

        foreach ($transactions as $date => $dayData) {
            // USD
            $open = $runningCapital;
            $close = $open + $dayData['income_usd'] - $dayData['expense_usd'];
            $high = max($open, $close, $open + $dayData['income_usd']);
            $low = min($open, $close, $open - $dayData['expense_usd']);
            // Use timestamp for ApexCharts
            $timestamp = strtotime($date) * 1000;
            $chartData[] = ['x' => $timestamp, 'y' => [$open, $high, $low, $close]];
            $runningCapital = $close;

            // BS
            $openBs = $runningCapitalBs;
            $closeBs = $openBs + $dayData['income_bs'] - $dayData['expense_bs'];
            $highBs = max($openBs, $closeBs, $openBs + $dayData['income_bs']);
            $lowBs = min($openBs, $closeBs, $openBs - $dayData['expense_bs']);
            $chartDataBs[] = ['x' => $timestamp, 'y' => [$openBs, $highBs, $lowBs, $closeBs]];
            $runningCapitalBs = $closeBs;
        }

        $data = [
            'title' => 'Dashboard',
            'moduloActivo' => 'dashboard',
            'totalClientes' => $totalClientes,
            'totalTortas' => $totalTortas,
            'chartData' => json_encode($chartData),
            'chartDataBs' => json_encode($chartDataBs)
        ];
        render_view('dashboard', $data);
    }
}
