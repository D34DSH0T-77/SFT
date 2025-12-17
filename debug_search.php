<?php
require_once __DIR__ . '/Config/config.php';
require_once __DIR__ . '/src/Conex/Conexion.php';
require_once __DIR__ . '/src/Models/Tortas.php';

use App\Models\Tortas;

header('Content-Type: application/json');

$q = $_GET['q'] ?? '21';

try {
    $model = new Tortas();
    $results = $model->buscar($q);

    echo json_encode([
        'term' => $q,
        'count' => count($results),
        'results' => $results
    ], JSON_PRETTY_PRINT);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
