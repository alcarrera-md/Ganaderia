<?php
session_start();
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $animal_id = $_POST['animal_id'];
    $fecha_programada = $_POST['fecha_programada'];
    $tipo_vacuna = $_POST['tipo_vacuna'];
    $observaciones = $_POST['observaciones'];

    if (empty($animal_id) || empty($fecha_programada) || empty($tipo_vacuna)) {
        die("Por favor, completa todos los campos obligatorios.");
    }

    $sql = "INSERT INTO vacunas_programadas (animal_id, fecha_programada, tipo_vacuna, observaciones) VALUES (?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("isss", $animal_id, $fecha_programada, $tipo_vacuna, $observaciones);

    if ($stmt->execute()) {
        header("Location: perfil_vaca.php?id=$animal_id");
        exit;
    } else {
        die("Error al programar la vacuna: " . $stmt->error);
    }

    $stmt->close();
    $conexion->close();
} else {
    header("Location: registro_vacuna.html");
    exit;
}
?>