<?php

class Venta
{
    private $idventa;
    private $fk_idcliente;
    private $fk_idproducto;
    private $fecha;
    private $cantidad;
    private $precio;
    private $total;


    public function __construct()
    {
    }

    public function __get($propiedad)
    {
        return $this->$propiedad;
    }

    public function __set($propiedad, $valor)
    {
        $this->$propiedad = $valor;
        return $this;
    }

    public function cargarFormulario($request)
    {
        $this->idventa = isset($request["id"]) ? $request["id"] : "";
        $this->fk_idcliente = isset($request["lstCliente"]) ? $request["lstCliente"] : "";
        $this->fk_idproducto = isset($request["lstProducto"]) ? $request["lstProducto"] : "";
        $this->fecha = isset($request["txtFecha"]) ? $request["txtFecha"] . " " . $request["txtHora"] : "";
        $this->cantidad = isset($request["txtCantidad"]) ? $request["txtCantidad"] : "";
        $this->precio = isset($request["txtPrecio"]) ? $request["txtPrecio"] : "";
        $this->total = isset($request["txtTotal"]) ? $request["txtTotal"] : "";
    }

    public function insertar()
    {
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
        $sql = "INSERT INTO ventas (fk_idcliente, fk_idproducto, fecha, cantidad, preciounitario, total) 
                VALUES (" . $this->fk_idcliente . ",
                        " . $this->fk_idproducto . ",
                        '" .$this->fecha . "',
                        " . $this->cantidad . ",
                        " . $this->precio . ",
                        " . $this->total . ");";
        //print_r($sql);
        //exit;
        if (!$mysqli->query($sql)) {
            printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }
        $this->idventa = $mysqli->insert_id;
        $mysqli->close();
    }

    public function actualizar()
    {
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
        $sql = "UPDATE ventas
                SET fk_idcliente = ' $this->fk_idcliente',
                    fk_idproducto = '$this->fk_idproducto',
                    fecha = '" . $this->fecha . "',
                    cantidad = '$this->cantidad',
                    preciounitario = '$this->precio',
                    total = '$this->total'
                WHERE idventa = " . $this->idventa;
        $mysqli->query($sql);
        $mysqli->close();
    }

    public function eliminar()
    {
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
        $sql = "DELETE FROM ventas WHERE idventa = " . $this->idventa;
        $mysqli->query($sql);
        $mysqli->close();
    }

    public function obtenerPorId()
    {
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
        $sql = "SELECT fk_idcliente, fk_idproducto, fecha, cantidad, preciounitario, total
                FROM ventas
                WHERE idventa = " . $this->idventa;
        $resultado = $mysqli->query($sql);

        if ($resultado) {
            $fila = $resultado->fetch_assoc();
            $this->fk_idcliente = $fila["fk_idcliente"];
            $this->fk_idproducto = $fila["fk_idproducto"];
            $this->fecha = $fila["fecha"];
            $this->cantidad = $fila["cantidad"];
            $this->precio = $fila["preciounitario"];
            $this->total = $fila["total"];
        }
        $mysqli->close();
    }

    public function obtenerTodos(){
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
        $sql = "SELECT idventa, fk_idcliente, fk_idproducto, fecha, cantidad, preciounitario, total
                FROM ventas";
        $resultado = $mysqli->query($sql);
        $aResultado = array();
        if ($resultado) {
            while ($fila = $resultado->fetch_assoc()) {
                $ventaAux = new Venta();
                $ventaAux->idventa = $fila["idventa"];
                $ventaAux->fk_idcliente = $fila["fk_idcliente"];
                $ventaAux->fk_idproducto = $fila["fk_idproducto"];
                $ventaAux->fecha = $fila["fecha"];
                $ventaAux->cantidad = $fila["cantidad"];
                $ventaAux->precio = $fila["preciounitario"];
                $ventaAux->total = $fila["total"];
                $aResultado[] = $ventaAux;
            }
        }
        $mysqli->close();
        return $aResultado;
    }

    public function calcularFacturacionMensual($mes){
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
        $sql = "SELECT SUM(total) AS total FROM ventas WHERE MONTH(fecha) = $mes";
        if($resultado = $mysqli->query($sql)){
            $fila = $resultado->fetch_assoc();
        }
        $mysqli->close();
        return $fila["total"];
    }

    public function calcularFacturacionAnual($anio){
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
        $sql = "SELECT SUM(total) AS total FROM ventas WHERE YEAR(fecha) = $anio";
        if ($resultado = $mysqli->query($sql)) {
            $fila = $resultado->fetch_assoc();
        }
        $mysqli->close();
        return $fila["total"];
    
    }

    public function cargarGrilla(){
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
        $sql = "SELECT 
                A.idventa,
                A.fecha,
                A.cantidad,
                A.fk_idcliente,
                B.nombre as nombre_cliente,
                A.fk_idproducto,
                A.total,
                A.preciounitario,
                C.nombre as nombre_producto
            FROM ventas A
            INNER JOIN clientes B ON A.fk_idcliente = B.idcliente
            INNER JOIN productos C ON A.fk_idproducto = C.idproducto
            ORDER BY A.fecha DESC";
        if(!$resultado = $mysqli->query($sql)){
            printf("Error en query: %s\n", $mysqli->error ." " .$sql);
        }

        $aResultado = array();
        if ($resultado) {
            while ($fila = $resultado->fetch_assoc()) {
                $ventaAux = new Venta();
                $ventaAux->idventa = $fila["idventa"];
                $ventaAux->fk_idcliente = $fila["fk_idcliente"];
                $ventaAux->fk_idproducto = $fila["fk_idproducto"];
                $ventaAux->fecha = $fila["fecha"];
                $ventaAux->cantidad = $fila["cantidad"];
                $ventaAux->precio = $fila["preciounitario"];
                $ventaAux->nombre_cliente = $fila["nombre_cliente"];
                $ventaAux->nombre_producto = $fila["nombre_producto"];
                $ventaAux->total = $fila["total"];
                $aResultado[] = $ventaAux;
            }
        }
        $mysqli->close();
        return $aResultado;
    }
}

?>