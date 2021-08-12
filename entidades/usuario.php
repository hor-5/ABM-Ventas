<?php

class Usuario{

    private $idusuario;
    private $usuario;
    private $clave;
    private $nombre;
    private $apellido;
    private $correo;

    public function __construct(){
    }

    public function __get($propiedad){
        return $this->$propiedad;
    }

    public function __set($propiedad, $valor){
        $this->$propiedad = $valor;
        return $this;
    }

    public function encriptarClave($clave){
        $claveEncriptada = password_hash($clave, PASSWORD_DEFAULT);
        return $claveEncriptada;
    }

    public function verificarClave($claveIngresada, $claveEnBBDD){
        return password_verify($claveIngresada, $claveEnBBDD);
    }

    public function insertar(){
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
        $sql = "INSERT INTO usuarios (usuario, clave, nombre, apellido, correo) 
                VALUES ('".$this->usuario. "', '" . $this->clave . "', '" . $this->nombre . "', '" . $this->apellido . "', '" . $this->correo. "')"; 
        $mysqli->query($sql);
        $this->idusuario = $mysqli->insert_id;
        $mysqli->close();
    }

    public function obtenerPorUsuario($usuario){
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
        $sql = "SELECT idusuario, usuario, clave, nombre, apellido, correo
                FROM usuarios
                WHERE usuario = '$usuario'";
        $resultado = $mysqli->query($sql);

        if($fila = $resultado->fetch_assoc()) {
            $this->idusuario = $fila["idusuario"];
            $this->usuario = $fila["usuario"];
            $this->clave = $fila["clave"];
            $this->nombre = $fila["nombre"];
            $this->apellido = $fila["apellido"];
            $this->correo = $fila["correo"];
        }
        $mysqli->close();
    }
}

?>