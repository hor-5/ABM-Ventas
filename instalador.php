<?php
include_once "config.php";
include_once "entidades/usuario.php";

$usuario = new Usuario();
$usuario->usuario = "hcapdevila";
$usuario->clave = $usuario->encriptarClave("admin123");
$usuario->nombre = "Horacio";
$usuario->apellido = "Capdevila";
$usuario->correo = "hc.horaciocapdevila@gmail.com";
$usuario->insertar();

?>