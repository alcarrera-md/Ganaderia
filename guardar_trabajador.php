<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.html");
    exit;
}

include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $nombre = $_POST['nombre'];
    $ultima_tarea = $_POST['ultima_tarea'];
    $corral_id = $_POST['corral_id'] ?? null;

    if ($id) {
        // Actualizar trabajador existente
        $query = "UPDATE trabajadores SET nombre = ? WHERE id = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("si", $nombre, $id);
    } else {
        // Insertar nuevo trabajador
        $query = "INSERT INTO trabajadores (nombre) VALUES (?)";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("s", $nombre);
    }

    if ($stmt->execute()) {
        // Guardar la asignación
        $trabajador_id = $id ? $id : $conexion->insert_id;
        $query_asignacion = "INSERT INTO asignaciones (trabajador_id, tarea, corral_id, fecha_asignacion) VALUES (?, ?, ?, NOW())";
        $stmt_asignacion = $conexion->prepare($query_asignacion);
        $stmt_asignacion->bind_param("iss", $trabajador_id, $ultima_tarea, $corral_id);
        $stmt_asignacion->execute();

        header("Location: trabajadores.php");
        exit;
    } else {
        die("Error al guardar: " . $stmt->error);
    }
}
?>