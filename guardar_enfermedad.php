<?php
// Incluir la conexión
include 'Conexion.php';

// Obtener los datos del formulario
$nombre = $_POST['nombre'];
$tipo = $_POST['tipo'];

// Insertar datos en la tabla enfermedades
$sql = "INSERT INTO enfermedades (nombre, tipo) VALUES (?, ?)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("ss", $nombre, $tipo);

if ($stmt->execute()) {
    echo "Enfermedad guardada con éxito.";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conexion->close();
?>