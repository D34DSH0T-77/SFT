<?php

session_start();

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/Core/funciones.php';
require_once __DIR__ . '/Config/config.php';

$url = $_GET['url'] ?? '';
$url = trim($url, '/');

$partes = explode('/', $url);

$controladorName = !empty($partes[0]) ? $partes[0] . 'Controller' : 'DashboardController';
$controlador = 'App\\Controllers\\' . $controladorName;
$metodo = $partes[1] ?? 'index';
$parametro = $partes[2] ?? '';

if (class_exists($controlador)) {
    $instancia = new $controlador();
    if (method_exists($instancia, $metodo)) {
        if (!empty($parametro)) {
            $instancia->$metodo($parametro);
        } else {
            try {
                $instancia->$metodo();
            } catch (ArgumentCountError $e) {
                $error = "El método '" . $metodo . "' esperaba un argumento (probablemente un ID) pero no se proporcionó en la URL.";
                require_once __DIR__ . '/src/Views/404.php';
            }
        }
    } else {
        $error = "El metodo '" . $metodo . "' no encontrado en '" . $controladorName . "'.";
        require_once __DIR__ . '/src/Views/404.php';
    }
} else {
    $error = "El controlador '" . $controladorName . "' no fue encontrado.";
    require_once __DIR__ . '/src/Views/404.php';
}
