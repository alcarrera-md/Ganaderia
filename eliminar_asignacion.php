<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.html");
    exit;
}

include 'conexion.php';

// Verificar si se ha proporcionado un ID válido
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);

    // Preparar la consulta para eliminar la asignacion
    $query = "DELETE FROM asignaciones WHERE id = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $id);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Redirigir a la página de asignaciones con un mensaje de éxito
        header("Location: asignaciones.php");
        exit;
    } else {
        // Si hay un error, mostrar un mensaje
        die("Error al eliminar la asignacion: " . $stmt->error);
    }
} else {
    // Si no se proporciona un ID válido, redirigir a la página de asignaciones
    header("Location: asignaciones.php");
    exit;
}
?>