<?php

namespace App\Controllers;

use App\Models\DetallesEntradas;
use App\Models\Entradas;
use App\Models\Tortas;

class EntradasController {
    private Entradas $entradasModel;
    private $tortasModel;
    private $detallesentradasModel;

    public function __construct() {
        $this->tortasModel = new Tortas();
        $this->entradasModel = new Entradas();
        $this->detallesentradasModel = new DetallesEntradas();
    }

    public function index() {
        verificarLogin();
        $entradas = $this->entradasModel->mostrarEntradas();
        $tortas = $this->tortasModel->mostrar();

        $data = [
            'title' => 'Entradas',
            'moduloActivo' => 'entradas',
            'tortas' => $tortas,
            'entradas' => $entradas
        ];
        render_view('entradas', $data);
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
        $id_entrada = $this->entradasModel->guardarEntrada($entradas);

        if ($id_entrada) {
            $id_tortas = $_POST['id_torta'] ?? [];
            $cantidades = $_POST['cantidad'] ?? [];
            $precios_bs = $_POST['precio_bs'] ?? [];
            $precios_usd = $_POST['precio_usd'] ?? [];

            // Ensure we have arrays
            if (!is_array($id_tortas)) $id_tortas = [$id_tortas];
            if (!is_array($cantidades)) $cantidades = [$cantidades];
            if (!is_array($precios_bs)) $precios_bs = [$precios_bs];
            if (!is_array($precios_usd)) $precios_usd = [$precios_usd];

            $detalles = $this->detallesentradasModel;

            for ($i = 0; $i < count($id_tortas); $i++) {
                if (empty($id_tortas[$i])) continue;

                $detalles->id_entrada = $id_entrada;
                $detalles->id_torta = $id_tortas[$i];
                $detalles->precio_bs = $precios_bs[$i] ?? 0;
                $detalles->precio_usd = $precios_usd[$i] ?? 0;
                $detalles->cantidad = $cantidades[$i] ?? 0;

                $detalles->AgregarDetalles($detalles);

                // Update stock
                $this->tortasModel->sumarStock($id_tortas[$i], $cantidades[$i]);
            }

            header('Location: ' . RUTA_BASE . 'entradas');
            exit;
        } else {
            // Manejar error si no se guarda la entrada
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
