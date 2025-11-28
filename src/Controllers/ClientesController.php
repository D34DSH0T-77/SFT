<?php

namespace App\Controllers;

use App\Models\Clientes;

class ClientesController {
    private Clientes $clientesModel;

    public function __construct() {
        $this->clientesModel = new Clientes();
    }

    public function index() {
        verificarLogin();
        $clientes = $this->clientesModel->mostrar();
        $data = [
            'title' => 'Clientes',
            'moduloActivo' => 'clientes',
            'clientes' => $clientes,
            'mensaje' => $_SESSION['mensaje'] ?? null
        ];
        render_view('clientes', $data);
        unset($_SESSION['mensaje']);
    }

    public function agregar() {
        verificarLogin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . RUTA_BASE . 'clientes');
            exit;
        }

        $clientes = $this->clientesModel;
        $clientes->nombre = $_POST['nombre'] ?? '';
        $clientes->apellido = $_POST['apellido'] ?? '';
        $clientes->estado = $_POST['estado'] ?? 'Activo';

        $errores = [];

        if (empty($errores)) {
            if ($this->clientesModel->agregar($clientes)) {
                $_SESSION['mensaje'] = [
                    'tipo' => 'success',
                    'texto' => 'Cliente agregado correctamente'
                ];
                header('Location: ' . RUTA_BASE . 'clientes');
                exit;
            } else {
                $_SESSION['mensaje'] = [
                    'tipo' => 'danger',
                    'texto' => 'Error al agregar el cliente'
                ];
                header('Location: ' . RUTA_BASE . 'clientes');
                exit;
            }
        } else {
            $_SESSION['mensaje'] = [
                'tipo' => 'danger',
                'texto' => 'Error en el formulario'
            ];
            header('Location: ' . RUTA_BASE . 'clientes');
            exit;
        }
    }
    public function editar($id) {
        verificarLogin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . RUTA_BASE . 'clientes');
            exit;
        }
        $clientes = $this->clientesModel->buscarPorid($id);
        if (!$clientes) {
            header('Location: ' . RUTA_BASE . 'clientes');
            exit;
        }
        $clientes->nombre = $_POST['editarnombre'] ?? $clientes->nombre;
        $clientes->apellido = $_POST['editarapellido'] ?? $clientes->apellido;
        $clientes->estado = $_POST['editarestado'] ?? $clientes->estado;

        $errores = [];
        if (empty($errores)) {
            if ($this->clientesModel->editar($clientes)) {
                $_SESSION['mensaje'] = [
                    'tipo' => 'success',
                    'texto' => 'Cliente editado correctamente'
                ];
                header('Location: ' . RUTA_BASE . 'clientes');
                exit;
            } else {
                $_SESSION['mensaje'] = [
                    'tipo' => 'danger',
                    'texto' => 'Error al editar el cliente'
                ];
                header('Location: ' . RUTA_BASE . 'clientes');
                exit;
            }
        } else {
            $_SESSION['mensaje'] = [
                'tipo' => 'danger',
                'texto' => 'Error en el formulario'
            ];
            header('Location: ' . RUTA_BASE . 'clientes');
            exit;
        }
    }
    public function eliminar($id) {
        verificarLogin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . RUTA_BASE . 'clientes');
            exit;
        }
        if ($this->clientesModel->eliminar($id)) {
            $_SESSION['mensaje'] = [
                'tipo' => 'success',
                'texto' => 'Cliente eliminado correctamente'
            ];
            header('Location: ' . RUTA_BASE . 'clientes');
            exit;
        } else {
            $_SESSION['mensaje'] = [
                'tipo' => 'danger',
                'texto' => 'Error al eliminar el cliente'
            ];
            header('Location: ' . RUTA_BASE . 'clientes');
            exit;
        }
    }
}
