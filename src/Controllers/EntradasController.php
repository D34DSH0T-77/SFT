<?php

namespace App\Controllers;

use App\Models\DetallesEntradas;
use App\Models\Entradas;
use App\Models\Tortas;
use App\Models\lotes;

class EntradasController {
    private Entradas $entradasModel;
    private $tortasModel;
    private $detallesentradasModel;

    private $lotesModel;
    public function __construct() {
        $this->tortasModel = new Tortas();
        $this->entradasModel = new Entradas();
        $this->detallesentradasModel = new DetallesEntradas();
        $this->lotesModel = new Lotes();
    }

    public function index() {
        verificarLogin();
        $entradas = $this->entradasModel->mostrarEntradas();
        $tortas = $this->tortasModel->mostrar();

        $data = [
            'title' => 'Entradas',
            'moduloActivo' => 'entradas',
            'tortas' => $tortas,
            'entradas' => $entradas,
            'mensaje' => $_SESSION['mensaje'] ?? []
        ];
        render_view('entradas', $data);
        unset($_SESSION['mensaje']);
    }
    public function agregar() {
        verificarLogin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . RUTA_BASE . 'entradas');
            exit;
        }
        $entradas = $this->entradasModel;
        $entradas->codigo = $_POST['codigo'] ?? '';
        $entradas->fecha = $_POST['fecha'] ?? '';
        $entradas->local = $_POST['local'] ?? '';
        $entradas->precio_bs = $_POST['precio_bs'] ?? '';
        $entradas->precio_usd = $_POST['precio_usd'] ?? '';
        $id_entrada = $this->entradasModel->guardarEntrada($entradas);

        if ($id_entrada) {
            $id_tortas = $_POST['id_torta'] ?? [];
            $cantidades = $_POST['cantidad'] ?? [];

            // Ensure we have arrays
            if (!is_array($id_tortas)) $id_tortas = [$id_tortas];
            if (!is_array($cantidades)) $cantidades = [$cantidades];

            $detalles = $this->detallesentradasModel;
            $lotes = $this->lotesModel;

            for ($i = 0; $i < count($id_tortas); $i++) {
                if (empty($id_tortas[$i])) continue;

                $detalles->id_entrada = $id_entrada;
                $detalles->id_torta = $id_tortas[$i];
                $detalles->cantidad = $cantidades[$i] ?? 0;

                $detalles->AgregarDetalles($detalles);

                // Update stock
                $lotes->id_torta = $id_tortas[$i];
                $lotes->cantidad = $cantidades[$i];
                $lotes->guardarLote($lotes);
            }

            header('Location: ' . RUTA_BASE . 'entradas');
            $_SESSION['mensaje'] = [
                'tipo' => 'success',
                'texto' => 'Entrada registrada correctamente'
            ];
            exit;
        } else {
            // Manejar error si no se guarda la entrada
            $_SESSION['mensaje'] = [
                'tipo' => 'error',
                'texto' => 'Error al registrar entrada'
            ];
            header('Location: ' . RUTA_BASE . 'entradas');
            exit;
        }
    }


    public function ver($id) {
        verificarLogin();

        $entrada = $this->entradasModel->obtenerPorId($id);
        $detalles = $this->detallesentradasModel->obtenerPorEntradaId($id);

        if (!$entrada) {
            header('Location: ' . RUTA_BASE . 'entradas');
            exit;
        }

        $data = [
            'title' => 'Ver Entrada',
            'moduloActivo' => 'entradas',
            'entrada' => $entrada,
            'detalles' => $detalles
        ];
        render_view('entradas_ver', $data);
    }
}
