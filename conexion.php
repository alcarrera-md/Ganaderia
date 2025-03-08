<?php
$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$basedatos = "ganaderia_db";


$conexion = new mysqli($servidor, $usuario, $contrasena, $basedatos);


if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
?>