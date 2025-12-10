<?php

namespace App\Controllers;

use App\Models\Usuarios;

class UsuariosController {
    private Usuarios $usuarioModel;

    public function __construct() {
        $this->usuarioModel = new Usuarios();
    }

    public function index() {
        verificarLogin();
        $usuarios = $this->usuarioModel->mostrar();

        $data = [
            'title' => 'Usuarios',
            'moduloActivo' => 'usuarios',
            'usuarios' => $usuarios,
            'mensaje' => $_SESSION['mensaje'] ?? null
        ];
        render_view('usuarios', $data);
        unset($_SESSION['mensaje']);
    }

    public function guardar() {
        verificarLogin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . RUTA_BASE . 'usuarios');
            exit();
        }

        $usuario = $this->usuarioModel;
        $usuario->nombre = $_POST['nombre'];
        $usuario->apellido = $_POST['apellido'];
        $usuario->cedula = $_POST['cedula'];
        $usuario->usuario = $_POST['usuario'];
        $usuario->rol = $_POST['rol'];
        $usuario->estado = $_POST['estado'];

        $errores = [];
        if (empty($errores)) {
            if ($this->usuarioModel->agregar($usuario)) {
                $_SESSION['mensaje'] = [
                    'tipo' => 'success',
                    'texto' => 'Usuario agregado correctamente'
                ];
                header('Location: ' . RUTA_BASE . 'usuarios');
                exit;
            } else {
                $_SESSION['mensaje'] = [
                    'tipo' => 'danger',
                    'texto' => 'Error al agregar el usuario'
                ];
                header('Location: ' . RUTA_BASE . 'usuarios');
                exit;
            }
        } else {
            $_SESSION['mensaje'] = [
                'tipo' => 'danger',
                'texto' => 'Error en el formulario'
            ];
            header('Location: ' . RUTA_BASE . 'usuarios');
            exit;
        }
    }

    public function editar($id) {
        error_log("Editar ID: " . $id);
        error_log("Method: " . $_SERVER['REQUEST_METHOD']);
        error_log("POST: " . print_r($_POST, true));
        verificarLogin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . RUTA_BASE . 'usuarios');
            exit();
        }
        if (empty($_POST)) {
            error_log("POST is empty!");
            $_SESSION['mensaje'] = ['tipo' => 'danger', 'texto' => 'No se recibieron datos del formulario'];
            header('Location: ' . RUTA_BASE . 'usuarios');
            exit();
        }
        $usuario = $this->usuarioModel->buscarPorid($id);
        if (!$usuario) {
            header('Location: ' . RUTA_BASE . 'usuarios');
            exit();
        }
        $usuario->nombre = $_POST['nombre'];
        $usuario->apellido = $_POST['apellido'];
        $usuario->cedula = $_POST['cedula'];
        $usuario->usuario = $_POST['usuario'];
        $usuario->rol = $_POST['rol'];
        $usuario->estado = $_POST['estado'];

        $errores = [];
        if (empty($errores)) {
            if ($this->usuarioModel->editar($usuario)) {
                $_SESSION['mensaje'] = [
                    'tipo' => 'success',
                    'texto' => 'Usuario editado correctamente'
                ];
                header('Location: ' . RUTA_BASE . 'usuarios');
                exit;
            } else {
                $_SESSION['mensaje'] = [
                    'tipo' => 'danger',
                    'texto' => 'Error al editar el usuario'
                ];
                header('Location: ' . RUTA_BASE . 'usuarios');
                exit;
            }
        } else {
            $_SESSION['mensaje'] = [
                'tipo' => 'danger',
                'texto' => 'Error en el formulario'
            ];
            header('Location: ' . RUTA_BASE . 'usuarios');
            exit;
        }
    }

    public function eliminar($id) {
        verificarLogin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . RUTA_BASE . 'usuarios');
            exit;
        }
        if ($this->usuarioModel->eliminar($id)) {
            $_SESSION['mensaje'] = [
                'tipo' => 'success',
                'texto' => 'Usuario eliminado correctamente'
            ];
            header('Location: ' . RUTA_BASE . 'usuarios');
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
