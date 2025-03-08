<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.html");
    exit;
}

include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $trabajador_id = $_POST['trabajador_id'];
    $corral_id = $_POST['corral_id'] ?? null;
    $tarea = $_POST['tarea'];
    $fecha_asignacion = $_POST['fecha_asignacion'];

    if ($id) {
        // Actualizar asignación existente
        $query = "UPDATE asignaciones SET 
                    trabajador_id = ?, 
                    corral_id = ?, 
                    tarea = ?, 
                    fecha_asignacion = ? 
                  WHERE id = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("iissi", $trabajador_id, $corral_id, $tarea, $fecha_asignacion, $id);
    } else {
        // Insertar nueva asignación
        $query = "INSERT INTO asignaciones (trabajador_id, corral_id, tarea, fecha_asignacion) 
                  VALUES (?, ?, ?, ?)";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("iiss", $trabajador_id, $corral_id, $tarea, $fecha_asignacion);
    }

    if ($stmt->execute()) {
        header("Location: asignaciones.php");
        exit;
    } else {
        die("Error al guardar: " . $stmt->error);
    }
}
?>