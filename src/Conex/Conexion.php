<?php

namespace App\Conex;

use PDO;
use PDOException;

class Conexion {

    protected $conn;

    public function __construct() {
        try {
            $this->conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . UTF8, DB_USER, DB_PASS);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Conexion fallida :V " . $e->getMessage());
        }
    }
}
