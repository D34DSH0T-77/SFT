<?php

namespace App\Controllers;

use App\Models\Ventas;
use App\Models\Tortas;
use App\Models\Lotes;
use App\Models\Clientes;

class VentasController {
    // private factura $facturaModel;
    // private  $detallesfacturasModel;
    private  $tortasModel;
    private  $clientesModel;
    private  $lotesModel;

    public function __construct() {
        // $this->facturaModel = new factura();
        // $this->detallesfacturasModel = new DetallesFacturas();
        $this->tortasModel = new Tortas();
        $this->clientesModel = new Clientes();
        $this->lotesModel = new Lotes();
    }
    public function index() {
        verificarLogin();
        $clientes = $this->clientesModel->mostrar();
        $tortas = $this->tortasModel->mostrar();

        $stock = $this->lotesModel->inventario();
        foreach ($tortas as $torta) {
            $torta->stock = $stock[$torta->id] ?? 0;
        }

        $data = [
            'title' => 'Ventas',
            'moduloActivo' => 'ventas',
            'clientes' => $clientes,
            'tortas' => $tortas,
            'mensaje' => $_SESSION['mensaje'] ?? []
        ];
        render_view('ventas', $data);
        unset($_SESSION['mensaje']);
    }
}
