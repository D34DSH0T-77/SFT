<?php

function render_view(string $viewName, array $data = []) {
    extract($data, EXTR_SKIP);

    $viewPath = __DIR__ . '/../../src/Views/' . $viewName . '.php';

    if (file_exists($viewPath)) {
        require $viewPath;
    } else {
        $error = "Error en la Vista, archivo no encontrado en '$viewPath'";
        require_once __DIR__ . '/../Views/404.php';
    }
}

function verificarLogin() {
    if (!isset($_SESSION['logueado']) || $_SESSION['logueado'] !== true) {
        header('Location: ' . RUTA_BASE . 'login');
        exit;
    }
}
