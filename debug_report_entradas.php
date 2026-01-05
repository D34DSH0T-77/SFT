<?php
require 'vendor/autoload.php';
require 'Config/config.php';

use App\Models\Entradas;

$entradasModel = new Entradas();
$entradas = $entradasModel->obtenerEntradasConCantidad();

echo "Total entradas found: " . count($entradas) . "\n";

if (!empty($entradas)) {
    echo "First entry date: " . $entradas[0]->fecha . "\n";
    echo "Sample data format check:\n";
    foreach (array_slice($entradas, 0, 3) as $e) {
        echo "ID: $e->id | Date: $e->fecha | Local: $e->local\n";
    }
}

// simulate filter
$fechaInicio = '2024-01-01'; // Adjust as needed based on expected data
$fechaFinal = '2025-12-31';

echo "\nFiltering between $fechaInicio and $fechaFinal ...\n";

$filtered = array_filter($entradas, function ($e) use ($fechaInicio, $fechaFinal) {
    // Replicate controller logic exactly
    $fechaEntrada = date('Y-m-d', strtotime($e->fecha));
    return $fechaEntrada >= $fechaInicio && $fechaEntrada <= $fechaFinal;
});

echo "Filtered count: " . count($filtered) . "\n";

// Check if there are entries that SHOULD have been filtered
$outOfRange = count($entradas) - count($filtered);
echo "Entries filtered out: $outOfRange\n";
