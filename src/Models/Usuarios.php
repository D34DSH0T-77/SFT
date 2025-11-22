<?php 

namespace App\Models;
use App\Conex\Conexion; 

class Usuarios extends Conexion{
    public $id;
    public $nombre;
    public $apellido;
    public $usuario;
    public $contrasena;
    public $rol;    
    public $estado;

    public function agregar(Usuarios $usuarios){
        $sql="INSERT INTO usuarios (nombre,apellido,usuario,contrasena,rol,estado) VALUES (:nombre, :apellido, :usuario, :contrasena, :rol, :estado)";
        try{
            $stmt=$this->conn->prepare($sql);
            $stmt->bindParam(":nombre", $usuarios->nombre);
            $stmt->bindParam(":apellido", $usuarios->apellido);
            $stmt->bindParam(":estado", $usuarios->estado);
            $stmt->execute();
        }catch(\Throwable $th){
            error_log("fallo al agregar".$th->getMessage());
        }
        
    }
    public function editar(Usuarios $usuarios){
        $sql="UPDATE usuarios SET nombre=:nombre, apellido=:apellido, usuario=:usuario, contrasena=:contrasena, rol=:rol, estado=:estado WHERE id=:id";
        try{
            $stmt=$this->conn->prepare($sql);
            $stmt->bindParam(":nombre", $usuarios->nombre);
            $stmt->bindParam(":apellido", $usuarios->apellido);
            $stmt->bindParam(":usuario", $usuarios->usuario);
            $stmt->bindParam(":contrasena", $usuarios->contrasena);
            $stmt->bindParam(":rol", $usuarios->rol);
            $stmt->bindParam(":estado", $usuarios->estado);
           
            $stmt->execute();
        }catch(\Throwable $th){
            error_log("fallo al editar".$th->getMessage());
        }
    }
    public function eliminar($id){
        $sql="DELETE FROM usuarios WHERE id=:id";
        try{
            $stmt=$this->conn->prepare($sql);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
        }catch(\Throwable $th){
            error_log("fallo al eliminar".$th->getMessage());
        }
    }
    public function buscarPorid($id){
        $sql="SELECT * FROM usuarios WHERE id=:id";
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
        $sql="SELECT * FROM usuarios";
        try{
            $stmt=$this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();   
        }catch(\Throwable $th){
            error_log("fallo total".$th->getMessage());
        }
    }
}