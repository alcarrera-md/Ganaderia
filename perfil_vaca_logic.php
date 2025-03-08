<?php
session_start(); // Iniciar la sesión

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.html");
    exit;
}

// Incluir la conexión a la base de datos
include 'conexion.php';

// Verificar si se recibió un ID válido
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID de animal no válido.");
}

$id_animal = intval($_GET['id']); // Asegurarnos de que sea un entero

// Verificar si el animal existe en la base de datos
$sql = "SELECT id FROM animales WHERE id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id_animal);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    die("Animal no encontrado.");
}

// Recuperar los datos del animal
$sql = "SELECT * FROM animales WHERE id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id_animal);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {
    die("Animal no encontrado.");
}

$animal = $resultado->fetch_assoc();

// Recuperar el historial médico
$sql_medico = "SELECT * FROM historial_medico WHERE animal_id = ?";
$stmt_medico = $conexion->prepare($sql_medico);
$stmt_medico->bind_param("i", $id_animal);
$stmt_medico->execute();
$historial_medico = $stmt_medico->get_result();

// Recuperar el historial reproductivo
$sql_reproductivo = "SELECT * FROM historial_reproductivo WHERE animal_id = ?";
$stmt_reproductivo = $conexion->prepare($sql_reproductivo);
$stmt_reproductivo->bind_param("i", $id_animal);
$stmt_reproductivo->execute();
$historial_reproductivo = $stmt_reproductivo->get_result();

// Recuperar el historial de movimientos
$sql_movimientos = "SELECT * FROM historial_movimientos WHERE animal_id = ?";
$stmt_movimientos = $conexion->prepare($sql_movimientos);
$stmt_movimientos->bind_param("i", $id_animal);
$stmt_movimientos->execute();
$historial_movimientos = $stmt_movimientos->get_result();
?>