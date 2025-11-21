<?php

namespace App\Controllers;

class InventarioController {
    public function index() {

        $data = [
            'title' => 'Inventario',
            'moduloActivo' => 'inventario'
        ];
        render_view('inventario', $data);
    }
}
