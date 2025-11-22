<?php

namespace App\Controllers;

use App\Models\Tortas;
use Dom\RandomError;

class TortasController {

    private Tortas $tortasModelo;

    public function __construct() {
        $this->tortasModelo = new Tortas();
    }
    public function index() {

        $data = [
            'title' => 'Tortas',
            'moduloActivo' => 'tortas'
        ];
        render_view('tortas', $data);
    }

    public function agregar() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . RUTA_BASE . 'tortas');
            exit();
        }

        $torta = $this->tortasModelo;
        $torta->nombre = trim($_POST['nombre'] ?? '');
        $torta->precio = trim($_POST['precio'] ?? '');
        $torta->estado = trim($_POST['estado'] ?? '');
        $torta->img = trim($_POST['imagen'] ?? '');

        $errores = [];

        if (empty($errores)) {
            if ($this->tortasModelo->agregar($torta)) {
            }
            header('Location: ' . RUTA_BASE . 'tortas');

            exit();
        }
    }
    
}
