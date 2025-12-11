<?php

namespace App\Controllers;

class ReportesController {
    public function entradas() {
        $data = [];
        render_view('reportesEntradas', $data);
    }

    public function ventas() {
        $data = [];
        render_view('reportesVentas', $data);
    }

    public function inventario() {
        $data = [];
        render_view('reportesInventario', $data);
    }

    public function clientes() {
        $data = [];
        render_view('reportesClientes', $data);
    }
}
