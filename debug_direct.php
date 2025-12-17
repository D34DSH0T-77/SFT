<?php
// Direct debug without class loaders to avoid path issues
header('Content-Type: application/json');

$host = 'mysql-deadshot.alwaysdata.net';
$user = 'deadshot';
$pass = '__Hola1234__';
$db   = 'deadshot_tortas';

try {
    $conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 1. Get Tortas
    $stmt = $conn->query("SELECT * FROM tortas LIMIT 5");
    $tortas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 2. Get Lotes
    $stmt2 = $conn->query("SELECT * FROM lotes LIMIT 5");
    $lotes = $stmt2->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'status' => 'success',
        'tortas' => $tortas,
        'lotes' => $lotes
    ], JSON_PRETTY_PRINT);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
