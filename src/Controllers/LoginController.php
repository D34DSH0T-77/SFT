<?php

namespace App\Controllers;

use App\Models\Usuarios;

class LoginController {

    private Usuarios $usuarioModel;

    public function __construct() {
        $this->usuarioModel = new Usuarios();
    }

    public function index() {

        if (isset($_SESSION['logueado']) && $_SESSION['logueado'] === true) {
            header('Location: ' . RUTA_BASE . 'dashboard');
            exit;
        }

        $data = [
            'title' => 'Iniciar Sesión',
            'mensaje' => $_SESSION['mensaje'] ?? null
        ];
        render_view('login', $data);
        unset($_SESSION['mensaje']);
    }

    public function loguear() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . RUTA_BASE . 'login');
            exit;
        }

        $usuarioPost = trim($_POST['usuario'] ?? '');
        $cedulaPost = trim($_POST['cedula'] ?? '');

        if (empty($usuarioPost) || empty($cedulaPost)) {
            $_SESSION['mensaje'] = [
                'tipo' => 'danger',
                'texto' => 'Todos los campos son obligatorios'
            ];
            header('Location: ' . RUTA_BASE . 'login');
            exit;
        }

        $usuario = $this->usuarioModel->buscarPorUsuario($usuarioPost);

        if ($usuario && $cedulaPost === $usuario->cedula) {
            if ($usuario->estado == 'Activo') {
                $_SESSION['logueado'] = true;
                $_SESSION['id'] = $usuario->id;
                $_SESSION['nombre'] = $usuario->nombre;
                $_SESSION['apellido'] = $usuario->apellido;
                $_SESSION['usuario'] = $usuario->usuario;
                $_SESSION['rol'] = $usuario->rol;
                $_SESSION['estado'] = $usuario->estado;
                header('Location: ' . RUTA_BASE . 'dashboard');
                exit;
            } else {
                $_SESSION['mensaje'] = [
                    'tipo' => 'danger',
                    'texto' => 'Usuario inactivo'
                ];
                header('Location: ' . RUTA_BASE . 'login');
                exit;
            }
        } else {
            $_SESSION['mensaje'] = [
                'tipo' => 'danger',
                'texto' => 'Credenciales incorrectas'
            ];
            header('Location: ' . RUTA_BASE . 'login');
            exit;
        }
    }

    public function logout() {
        session_destroy();
        header('Location: ' . RUTA_BASE . 'login');
        exit;
    }
}
