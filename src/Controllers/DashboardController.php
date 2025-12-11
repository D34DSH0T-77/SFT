<?php

namespace App\Controllers;

use App\Models\Clientes;

class DashboardController {
    private $clientes;

    public function __construct() {
        $this->clientes = new Clientes();
    }
    public function index() {
        verificarLogin();

        $totalClientes = $this->clientes->contar();

        $data = [
            'title' => 'Dashboard',
            'moduloActivo' => 'dashboard',
            'totalClientes' => $totalClientes
        ];
        render_view('dashboard', $data);
    }
}
