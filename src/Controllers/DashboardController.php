<?php

namespace App\Controllers;

class DashboardController {
    public function index() {
        $data = [
            'title' => 'Dashboard',
            'moduloActivo' => 'dashboard'
        ];
        render_view('dashboard', $data);
    }
}
