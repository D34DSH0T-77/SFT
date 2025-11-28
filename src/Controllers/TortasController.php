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

        // Inicializamos la imagen como vacía por defecto
        $torta->img = '';

        // --- LÓGICA DE IMAGEN ---
        if (!empty($_FILES['imagen']['name'])) {

            $directorio = "src/Assets/img/tortas/";
            $nombreOriginal = $_FILES["imagen"]["name"];
            $tmpName = $_FILES["imagen"]["tmp_name"];
            $tipoImagen = strtolower(pathinfo($nombreOriginal, PATHINFO_EXTENSION));
            $permitidos = ['jpg', 'jpeg', 'png'];

            if (in_array($tipoImagen, $permitidos)) {
                // Generamos nombre ÚNICO (igual que en editar)
                $nuevoNombre = "torta_" . time() . "." . $tipoImagen;
                $rutaDestino = $directorio . $nuevoNombre;

                if (move_uploaded_file($tmpName, $rutaDestino)) {
                    // Solo si se mueve bien, asignamos la ruta al objeto
                    $torta->img = $rutaDestino;
                } else {
                    $_SESSION['mensaje'] = ['tipo' => 'danger', 'texto' => 'Error al subir la imagen'];
                    header('Location: ' . RUTA_BASE . 'tortas');
                    exit();
                }
            } else {
                $_SESSION['mensaje'] = ['tipo' => 'danger', 'texto' => 'Formato no permitido (solo JPG/PNG)'];
                header('Location: ' . RUTA_BASE . 'tortas');
                exit();
            }
        }

        // --- GUARDADO EN BD ---
        // Validamos que los campos obligatorios no estén vacíos
        if (!empty($torta->nombre) && !empty($torta->precio)) {
            if ($this->tortasModelo->agregar($torta)) {
                $_SESSION['mensaje'] = ['tipo' => 'success', 'texto' => 'Torta agregada correctamente'];
            } else {
                $_SESSION['mensaje'] = ['tipo' => 'danger', 'texto' => 'Error al guardar en BD'];
            }
        } else {
            $_SESSION['mensaje'] = ['tipo' => 'warning', 'texto' => 'Nombre y Precio son obligatorios'];
        }

        header('Location: ' . RUTA_BASE . 'tortas');
        exit();
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

        if (!empty($_FILES['imagen']['name'])) {

            $directorio = "src/Assets/img/tortas/";

            $nombreOriginal = $_FILES["imagen"]["name"];
            $tmpName = $_FILES["imagen"]["tmp_name"];

            $tipoImagen = strtolower(pathinfo($nombreOriginal, PATHINFO_EXTENSION));
            $permitidos = ['jpg', 'jpeg', 'png'];

            if (in_array($tipoImagen, $permitidos)) {

                if (!empty($torta->img) && file_exists($torta->img)) {
                    unlink($torta->img);
                }


                $nuevoNombre = "torta_" . time() . "." . $tipoImagen;
                $rutaDestino = $directorio . $nuevoNombre;


                if (move_uploaded_file($tmpName, $rutaDestino)) {

                    $torta->img = $rutaDestino;
                } else {
                    $_SESSION['mensaje'] = ['tipo' => 'danger', 'texto' => 'Error al mover la imagen a la carpeta'];
                    header('Location: ' . RUTA_BASE . 'tortas');
                    exit();
                }
            } else {
                $_SESSION['mensaje'] = ['tipo' => 'danger', 'texto' => 'Formato de imagen no permitido (solo JPG, PNG)'];
                header('Location: ' . RUTA_BASE . 'tortas');
                exit();
            }
        }

        if ($this->tortasModelo->editar($torta)) {
            $_SESSION['mensaje'] = [
                'tipo' => 'success',
                'texto' => 'Torta editada correctamente'
            ];
        } else {
            $_SESSION['mensaje'] = [
                'tipo' => 'danger',
                'texto' => 'Error al guardar los cambios en la BD'
            ];
        }

        header('Location: ' . RUTA_BASE . 'tortas');
        exit();
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
