<?php

namespace App\Controllers;

class UsuariosController {
    public function index() {

        $data = [
            'title' => 'Usuarios',
            'moduloActivo' => 'usuarios'
        ];
        render_view('usuarios', $data);
    }
}
