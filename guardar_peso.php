<?php
session_start();
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $animal_id = $_POST['animal_id'];
    $fecha = $_POST['fecha'];
    $peso = $_POST['peso'];

    if (empty($animal_id) || empty($fecha) || empty($peso)) {
        die("Por favor, completa todos los campos.");
    }

    $sql = "INSERT INTO historial_peso (animal_id, fecha, peso) VALUES (?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("isd", $animal_id, $fecha, $peso);

    if ($stmt->execute()) {
        header("Location: perfil_vaca.php?id=$animal_id");
        exit;
    } else {
        die("Error al guardar el peso: " . $stmt->error);
    }

    $stmt->close();
    $conexion->close();
} else {
    header("Location: registro_peso.html");
    exit;
}
?>