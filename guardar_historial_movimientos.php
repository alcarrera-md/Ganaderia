<?php
// Configuración de la conexión
$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$basedatos = "ganaderia_db";

$conexion = new mysqli($servidor, $usuario, $contrasena, $basedatos);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $animal_id = $_POST["animal_id"];
    $fecha = $_POST["fecha"];
    $tipo = $_POST["tipo"];
    $descripcion = $_POST["descripcion"];

    // Insertar datos en la tabla historial_movimientos
    $sql = "INSERT INTO historial_movimientos (animal_id, fecha, tipo, descripcion) VALUES (?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("isss", $animal_id, $fecha, $tipo, $descripcion);

    if ($stmt->execute()) {
        echo "Movimiento registrado con éxito.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conexion->close();
?>