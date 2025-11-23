<?php

namespace App\Controllers;

use App\Models\Tortas;

class EntradasController {
    private $tortasModel;

    public function __construct() {
        $this->tortasModel = new Tortas();
    }

    public function index() {
        $tortas = $this->tortasModel->mostrar();

        $data = [
            'title' => 'Entradas',
            'moduloActivo' => 'entradas',
            'tortas' => $tortas
        ];
        render_view('entradas', $data);
    }
}
