<?php

namespace App\Controllers;

use App\Models\Tortas;

class EntradasController {
    public function index() {
        $tortasModel = new Tortas();
        $tortas = $tortasModel->mostrar();

        $data = [
            'title' => 'Entradas',
            'moduloActivo' => 'entradas',
            'tortas' => $tortas
        ];
        render_view('entradas', $data);
    }
}
