<?php

namespace App\Controllers;

use App\Models\Entradas;
use App\Models\Factura;

class CapitalController {
    private $facturaModel;
    private $entradasModel;

    public function __construct() {
        $this->facturaModel = new Factura();
        $this->entradasModel = new Entradas();
    }

    public function index() {
        verificarLogin();
        $facturas = $this->facturaModel->mostrar();
        $entradas = $this->entradasModel->mostrarEntradas();

        $totalIngresosUsd = 0;
        $totalIngresosBs = 0;
        $transactions = [];

        if ($facturas) {
            foreach ($facturas as $f) {
                if ($f->estado != 'Anulado') {
                    $totalIngresosUsd += floatval($f->total_usd);
                    $totalIngresosBs += floatval($f->total_bs);

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
            'title' => 'Capital',
            'moduloActivo' => 'capital',
            'totalIngresosUsd' => $totalIngresosUsd,
            'totalIngresosBs' => $totalIngresosBs,
            'totalEgresosUsd' => $totalEgresosUsd,
            'totalEgresosBs' => $totalEgresosBs,
            'capitalNetoUsd' => $capitalNetoUsd,
            'capitalNetoBs' => $capitalNetoBs,
            'chartData' => json_encode($chartData),
            'chartDataBs' => json_encode($chartDataBs)
        ];
        render_view('capital', $data);
    }
}
