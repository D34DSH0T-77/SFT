<?php

namespace App\Controllers;

class DashboardController {
    public function index() {
        $data = [
            'title' => 'Dashboard'
        ];
        render_view('dashboard', $data);
    }
}
