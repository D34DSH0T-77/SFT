<?php

namespace App\Controllers;

class TortasController {
    public function index() {

        $data = [
            'title' => 'Tortas',
            'moduloActivo' => 'tortas'
        ];
        render_view('tortas', $data);
    }
}
