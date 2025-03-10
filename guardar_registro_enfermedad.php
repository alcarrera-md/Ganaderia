<?php
// Incluir la conexión
include 'Conexion.php';

// Obtener los datos del formulario
$animal_id = $_POST['animal_id'];
$enfermedad_id = $_POST['enfermedad_id'];
$fecha_diagnostico = $_POST['fecha_diagnostico'];
$severidad = $_POST['severidad'];

// Verificar si el animal_id existe en la tabla animales
$sql_verificar_animal = "SELECT id FROM animales WHERE id = ?";
$stmt_verificar_animal = $conexion->prepare($sql_verificar_animal);
$stmt_verificar_animal->bind_param("i", $animal_id);
$stmt_verificar_animal->execute();
$stmt_verificar_animal->store_result();

if ($stmt_verificar_animal->num_rows === 0) {
    die("Error: El animal con ID $animal_id no existe.");
}

// Verificar si la enfermedad_id existe en la tabla enfermedades
$sql_verificar_enfermedad = "SELECT id FROM enfermedades WHERE id = ?";
$stmt_verificar_enfermedad = $conexion->prepare($sql_verificar_enfermedad);
$stmt_verificar_enfermedad->bind_param("i", $enfermedad_id);
$stmt_verificar_enfermedad->execute();
$stmt_verificar_enfermedad->store_result();

if ($stmt_verificar_enfermedad->num_rows === 0) {
    die("Error: La enfermedad con ID $enfermedad_id no existe.");
}

// Insertar datos en la tabla registro_enfermedades
$sql = "INSERT INTO registro_enfermedades (animal_id, enfermedad_id, fecha_diagnostico, severidad) VALUES (?, ?, ?, ?)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("iiss", $animal_id, $enfermedad_id, $fecha_diagnostico, $severidad);

if ($stmt->execute()) {
    echo "Registro de enfermedad guardado con éxito.";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conexion->close();
?>