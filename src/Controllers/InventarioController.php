<?php

namespace App\Controllers;

use JasonGrimes\Paginator;
use App\Models\Tortas;
use App\Models\lotes;

class InventarioController {
    private Tortas $tortasModel;
    private lotes $lotesModel;
    public function __construct() {
        $this->tortasModel = new Tortas();
        $this->lotesModel = new Lotes();
    }

    public function index() {
        verificarLogin();
        $paginaActual = isset($_POST['page']) ? (int)$_POST['page'] : 1;
        $itemsPorPagina = 6;
        $offset = ($paginaActual - 1) * $itemsPorPagina;

        $totalItems = $this->tortasModel->contar();
        $tortas = $this->tortasModel->mostrarPaginado($itemsPorPagina, $offset);
        $stock = $this->lotesModel->inventario();

        foreach ($tortas as $torta) {
            $torta->stock = $stock[$torta->id] ?? 0;
        }

        $urlPattern = '(:num)';
        $paginator = new Paginator($totalItems, $itemsPorPagina, $paginaActual, $urlPattern);

        $paginator->setPreviousText('Anterior');
        $paginator->setNextText('Siguiente');

        $data = [
            'title' => 'Inventario',
            'moduloActivo' => 'inventario',
            'tortas' => $tortas,
            'paginator' => $paginator
        ];
        render_view('inventario', $data);
    }
}
