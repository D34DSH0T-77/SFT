<?php 

namespace App\Models;
use App\Conex\Conexion; 

Class Clientes extends Conexio{
    public $id;
    public $nombre;
    public $apellido;
    public $estado;

    public function agregar(Clientes $clientes){
        $sql="INSERT INTO clientes (nombre,apellido,estado) VALUES (:nombre, :apellido, :estado)";
        try{
            $stmt=$this->conn->prepare($sql);
            $stmt->bindParam(":nombre", $clientes->nombre);
            $stmt->bindParam(":apellido", $clientes->apellido);
            $stmt->bindParam(":estado", $clientes->estado);
            $stmt->execute();
        }catch(\Throwable $th){
            error_log("fallo al agregar".$th->getMessage());
        }

    }
    public function editar(Clientes $clientes){
        $sql="UPDATE clientes SET nombre=:nombre, apellido=:apellido, estado=:estado WHERE id=:id";
        try{
            $stmt=$this->conn->prepare($sql);
            $stmt->bindParam(":nombre", $clientes->nombre);
            $stmt->bindParam(":apellido", $clientes->apellido);
            $stmt->bindParam(":estado", $clientes->estado);
            $stmt->execute();
        }catch(\Throwable $th){
            error_log("fallo al editar".$th->getMessage());
        }
    }
    public function eliminar($id){
        $sql="DELETE FROM clientes WHERE id=:id";
        try{
            $stmt=$this->conn->prepare($sql);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
        }catch(\Throwable $th){
            error_log("fallo al eliminar".$th->getMessage());
        }
    }
    public function buscarPorid($id){
        $sql="SELECT * FROM clientes WHERE id=:id";
        try{
            $stmt=$this->conn->prepare($sql);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            return $stmt->fetch();
        }catch(\Throwable $th){
            error_log("fallo al buscar por id".$th->getMessage());
        }
    }
    public function mostrar(){
        $sql="SELECT * FROM clientes";
        try{
            $stmt=$this-conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();   
        }catch(\Throwable $th){
            error_log("fallo total".$th->getMessage());
        }
    }
}