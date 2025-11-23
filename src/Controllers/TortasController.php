<?php

namespace App\Controllers;

use App\Models\Tortas;

class TortasController {

    private Tortas $tortasModelo;

    public function __construct() {
        $this->tortasModelo = new Tortas();
    }
    public function index() {

        $tortas = $this->tortasModelo->mostrar();

        $data = [
            'title' => 'Tortas',
            'moduloActivo' => 'tortas',
            'tortas' => $tortas,
            'mensaje' => $_SESSION['mensaje'] ?? null
        ];
        render_view('tortas', $data);
        unset($_SESSION['mensaje']);
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
                $_SESSION['mensaje'] = [
                    'tipo' => 'success',
                    'texto' => 'Torta agregada correctamente'
                ];
                header('Location: ' . RUTA_BASE . 'tortas');

                exit();
            } else {
                $_SESSION['mensaje'] = [
                    'tipo' => 'danger',
                    'texto' => 'Error al agregar la torta'
                ];
                header('Location: ' . RUTA_BASE . 'tortas');

                exit();
            }
        }
    }
    public function editar($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . RUTA_BASE . 'tortas');
            exit();
        }
        $torta = $this->tortasModelo->buscarPorid($id);
        if (!$torta) {
            header('Location: ' . RUTA_BASE . 'tortas');
            exit();
        }
        $torta->nombre = trim($_POST['editarnombre'] ?? $torta->nombre);
        $torta->precio = trim($_POST['editarprecio'] ?? $torta->precio);
        $torta->estado = trim($_POST['editarestado'] ?? $torta->estado);
        $torta->img = trim($_POST['editarimagen'] ?? $torta->img);

        $errores = [];
        if (empty($errores)) {
            if ($this->tortasModelo->editar($torta)) {
                $_SESSION['mensaje'] = [
                    'tipo' => 'success',
                    'texto' => 'Torta editada correctamente'
                ];
                header('Location: ' . RUTA_BASE . 'tortas');
                exit();
            } else {
                $_SESSION['mensaje'] = [
                    'tipo' => 'danger',
                    'texto' => 'Error al editar la torta'
                ];
                header('Location: ' . RUTA_BASE . 'tortas');
                exit();
            }
        }
    }
    public function eliminar($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . RUTA_BASE . 'tortas');
            exit();
        }

        if ($this->tortasModelo->eliminar($id)) {
            $_SESSION['mensaje'] = [
                'tipo' => 'success',
                'texto' => 'Torta eliminada correctamente'
            ];
            header('Location: ' . RUTA_BASE . 'tortas');
            exit();
        } else {
            $_SESSION['mensaje'] = [
                'tipo' => 'danger',
                'texto' => 'Error al eliminar la torta'
            ];
            header('Location: ' . RUTA_BASE . 'tortas');
            exit();
        }
    }
}
