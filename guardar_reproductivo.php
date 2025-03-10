<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.html");
    exit;
}

include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar que el campo "id" existe en $_POST
    if (!isset($_POST['id'])) {
        die("Error: El ID del animal no fue proporcionado.");
    }

    $id = $_POST['id'];
    $fecha = $_POST['fecha'] ?? null;
    $evento = $_POST['evento'] ?? null;
    $descripcion = $_POST['descripcion'] ?? null;

    // Campos opcionales
    $toro_nombre = $_POST['toro_nombre'] ?? null;
    $toro_raza = $_POST['toro_raza'] ?? null;
    $estado = $_POST['estado'] ?? null;
    $observaciones = $_POST['observaciones'] ?? null;
    $fecha_confirmacion = $_POST['fecha_confirmacion'] ?? null;

    // Validar campos obligatorios
    if (empty($id) || empty($fecha) || empty($evento) || empty($descripcion)) {
        die("Por favor, completa todos los campos obligatorios.");
    }

    // Verificar si el animal existe
    $sql_verificar = "SELECT id FROM animales WHERE id = ?";
    $stmt_verificar = $conexion->prepare($sql_verificar);
    $stmt_verificar->bind_param("i", $id);
    $stmt_verificar->execute();
    $stmt_verificar->store_result();

    if ($stmt_verificar->num_rows === 0) {
        die("Error: El ID del animal no existe.");
    }

    // Insertar datos
    $sql = "INSERT INTO historial_reproductivo 
            (animal_id, fecha, evento, descripcion, toro_nombre, toro_raza, estado, observaciones, fecha_confirmacion) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("issssssss", $id, $fecha, $evento, $descripcion, $toro_nombre, $toro_raza, $estado, $observaciones, $fecha_confirmacion);

    if ($stmt->execute()) {
        header("Location: perfil_vaca.php?id=$id");
        exit;
    } else {
        die("Error al guardar: " . $stmt->error);
    }

    $stmt->close();
    $stmt_verificar->close();
    $conexion->close();
} else {
    header("Location: registro_reproductivo.php?id=" . ($_GET['id'] ?? ''));
    exit;
}
?>