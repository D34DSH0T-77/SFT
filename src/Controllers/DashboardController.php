<?php

namespace App\Controllers;

use App\Models\Clientes;
use App\Models\Tortas;

class DashboardController {
    private $clientes;
    private $tortas;

    public function __construct() {
        $this->clientes = new Clientes();
        $this->tortas = new Tortas();
    }
    public function index() {
        verificarLogin();

        $totalClientes = $this->clientes->contar();
        $totalTortas = $this->tortas->contar();

        $data = [
            'title' => 'Dashboard',
            'moduloActivo' => 'dashboard',
            'totalClientes' => $totalClientes,
            'totalTortas' => $totalTortas
        ];
        render_view('dashboard', $data);
    }
}
