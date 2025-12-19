<?php

namespace App\Controllers;

use App\Models\Clientes;
use App\Models\Lotes;

class DashboardController {
    private $clientes;
    private $lotes;

    public function __construct() {
        $this->clientes = new Clientes();
        $this->lotes = new Lotes();
    }
    public function index() {
        verificarLogin();

        $totalClientes = $this->clientes->contar();
        $totalTortas = $this->lotes->contar();

        $data = [
            'title' => 'Dashboard',
            'moduloActivo' => 'dashboard',
            'totalClientes' => $totalClientes,
            'totalTortas' => $totalTortas
        ];
        render_view('dashboard', $data);
    }
}
