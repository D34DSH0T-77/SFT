<?php
require_once __DIR__ . '/Config/config.php';
require_once __DIR__ . '/src/Conex/Conexion.php';
require_once __DIR__ . '/src/Models/Tortas.php';

use App\Models\Tortas;

header('Content-Type: application/json');

try {
    $model = new Tortas();
    // Use the raw query method to capture everything without filters
    $all = $model->mostrar();
    echo json_encode([
        'status' => 'success',
        'count' => count($all),
        'data' => $all
    ], JSON_PRETTY_PRINT);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
