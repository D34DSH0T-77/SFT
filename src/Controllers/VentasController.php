<?php

namespace App\Controllers;

class VentasController {
    public function index() {
        verificarLogin();
        $data = [
            'title' => 'Ventas',
            'moduloActivo' => 'ventas'
        ];
        render_view('ventas', $data);
    }
}
