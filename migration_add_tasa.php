<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/Config/config.php';
require_once __DIR__ . '/src/Conex/Conexion.php';

use App\Conex\Conexion;

class Migration extends Conexion {
    public function up() {
        $sql = "ALTER TABLE pago ADD COLUMN tasa DECIMAL(10,2) DEFAULT 1.00";
        try {
            // Check if column exists first to avoid error
            $check = "SHOW COLUMNS FROM pago LIKE 'tasa'";
            $stmt = $this->conn->prepare($check);
            $stmt->execute();
            if ($stmt->rowCount() == 0) {
                $this->conn->exec($sql);
                echo "Columna 'tasa' agregada exitosamente.";
            } else {
                echo "La columna 'tasa' ya existe.";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}

$migration = new Migration();
$migration->up();
