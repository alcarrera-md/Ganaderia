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

$id_animal = $_GET['id'];

// Eliminar el animal de la base de datos
$sql = "DELETE FROM animales WHERE id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id_animal);

if ($stmt->execute()) {
    // Redirigir a la página de consulta de animales
    header("Location: consulta_animales.php");
    exit;
} else {
    die("Error al eliminar el animal: " . $stmt->error);
}

// Cerrar la conexión
$stmt->close();
$conexion->close();
?>