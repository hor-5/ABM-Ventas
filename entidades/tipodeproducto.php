<?php

class Tipodeproducto{

    private $idtipodeproducto;
    private $nombre;

    public function __construct(){
    }

    public function __get($propiedad){
        return $this->$propiedad;
    }

    public function __set($propiedad, $valor){
        $this->$propiedad = $valor;
        return $this;
    }

    public function cargarFormulario($request){
        $this->idtipodeproducto = isset($request["id"]) ? $request["id"] : "";
        $this->nombre = isset($request["txtNombre"]) ? $request["txtNombre"] : "";
    }

    public function insertar(){
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
        $sql = "INSERT INTO tipo_productos (nombre)
                VALUES ('" .$this->nombre ."')";
        $mysqli->query($sql);
        $this->idtipodeproducto = $mysqli->insert_id;
        $mysqli->close();
    }

    public function actualizar(){
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
        $sql = "UPDATE tipo_productos
                SET nombre = '" .$this->nombre ."'
                WHERE idtipoproducto = " .$this->idtipodeproducto ;
        $mysqli->query($sql);
        $mysqli->close();
    }

    public function eliminar(){
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
        $sql = "DELETE FROM tipo_productos
                WHERE idtipoproducto =" .$this->idtipodeproducto;
        $mysqli->query($sql);
        $mysqli->close();
    }

    public function obtenerPorId(){
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
        $sql = "SELECT idtipoproducto, nombre
                FROM tipo_productos
                WHERE idtipoproducto= " .$this->idtipodeproducto;
        $resultado = $mysqli->query($sql);
        
        if($fila = $resultado->fetch_assoc()){
            $this->nombre = $fila["nombre"];
        }
        $mysqli->close();
    }

    public function obtenerTodos(){
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
        $sql = "SELECT idtipoproducto, nombre
                FROM tipo_productos";
        $resultado = $mysqli->query($sql);
        $aResultado = array();

        if($resultado){
            while($fila = $resultado->fetch_assoc()){
                $tipoAux = new Tipodeproducto();
                $tipoAux->idtipodeproducto = $fila["idtipoproducto"];
                $tipoAux->nombre = $fila["nombre"];
                $aResultado[] = $tipoAux;
            }
        }
        $mysqli->close();
        return $aResultado;
    }
}

?>