<?php

namespace App\Controllers;

class EntradasController {
    public function index() {

        $data = [
            'title' => 'Entradas',
            'moduloActivo' => 'entradas'
        ];
        render_view('entradas', $data);
    }
}
