<?php

namespace App\Controllers;

class VentasController {
    public function index() {

        $data = [
            'title' => 'Ventas',
            'moduloActivo' => 'ventas'
        ];
        render_view('ventas', $data);
    }
}
