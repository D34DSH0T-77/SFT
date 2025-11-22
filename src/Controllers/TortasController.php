<?php

namespace App\Controllers;

use App\Models\Tortas;

class TortasController {

    private Tortas $tortasModelo;

    public function __construct() {
        $this->tortasModelo = new Tortas();
    }
    public function index() {

        $tortas = $this->tortasModelo->mostrar();

        $data = [
            'title' => 'Tortas',
            'moduloActivo' => 'tortas',
            'tortas' => $tortas
        ];
        render_view('tortas', $data);
    }

    public function agregar() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . RUTA_BASE . 'tortas');
            exit();
        }

        $torta = $this->tortasModelo;
        $torta->nombre = trim($_POST['nombre'] ?? '');
        $torta->precio = trim($_POST['precio'] ?? '');
        $torta->estado = trim($_POST['estado'] ?? '');
        $torta->img = trim($_POST['imagen'] ?? '');

        $errores = [];

        if (empty($errores)) {
            if ($this->tortasModelo->agregar($torta)) {
            }
            header('Location: ' . RUTA_BASE . 'tortas');

            exit();
        }
    }
    public function editar($id){
        if($_SERVER['REQUEST_METHOD']!== 'POST'){
            header('Location: ' . RUTA_BASE .'tortas');
            exit();
        }
        $torta =$this->tortasModelo->buscarPorid($id);
        if(!$torta){
            header('Location: ' . RUTA_BASE .'tortas');
            exit();
        }
        $torta->nombre = trim($_POST['editarnombre'] ?? $torta->nombre);
        $torta->precio = trim($_POST['editarprecio'] ?? $torta->precio);
        $torta->estado = trim($_POST['editarestado'] ?? $torta->estado);
        $torta->img = trim($_POST['editarimagen'] ?? $torta->img);
        
        $errores =[];
        if(empty($errores)){
            if($this->tortasModelo->editar($torta)){
                header('Location: '.RUTA_BASE.'tortas');
                exit();
            }

        }
    }
    public function eliminar($id){
        if($_SERVER['REQUEST_METHOD']!== 'POST'){
            header('Location: ' . RUTA_BASE .'tortas');
            exit();
        }
   
        if($this->tortasModelo->eliminar($id)){
            header('Location: '.RUTA_BASE.'tortas');
            exit();
        }   
        
    }
}
