<?php
// Incluir la conexión
include 'Conexion.php';

// Obtener los datos del formulario
$animal_id = $_POST['animal_id'];
$fecha = $_POST['fecha'];
$tipo = $_POST['tipo'];
$descripcion = $_POST['descripcion'];

// Verificar si el animal_id existe en la tabla animales
$sql_verificar = "SELECT id FROM animales WHERE id = ?";
$stmt_verificar = $conexion->prepare($sql_verificar);
$stmt_verificar->bind_param("i", $animal_id);
$stmt_verificar->execute();
$stmt_verificar->store_result();

if ($stmt_verificar->num_rows === 0) {
    die("Error: El animal con ID $animal_id no existe.");
}

// Insertar datos en la tabla historial_medico
$sql = "INSERT INTO historial_medico (animal_id, fecha, tipo, descripcion) VALUES (?, ?, ?, ?)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("isss", $animal_id, $fecha, $tipo, $descripcion);

if ($stmt->execute()) {
    // Redirigir al panel de salud del animal
    header("Location: panel_salud.php?id=$animal_id");
    exit(); // Asegura que el script se detenga después de la redirección
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conexion->close();
?>