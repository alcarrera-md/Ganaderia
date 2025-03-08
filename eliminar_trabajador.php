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

    // Preparar la consulta para eliminar el trabajador
    $query = "DELETE FROM trabajadores WHERE id = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $id);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Redirigir a la página de trabajadores con un mensaje de éxito
        header("Location: trabajadores.php?eliminado=1");
        exit;
    } else {
        // Si hay un error, mostrar un mensaje
        die("Error al eliminar el trabajador: " . $stmt->error);
    }
} else {
    // Si no se proporciona un ID válido, redirigir a la página de trabajadores
    header("Location: trabajadores.php");
    exit;
}
?>