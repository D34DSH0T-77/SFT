<?php

namespace App\Controllers;

class ClientesController {
    public function index() {

        $data = [
            'title' => 'Clientes',
            'moduloActivo' => 'clientes'
        ];
        render_view('clientes', $data);
    }
}
