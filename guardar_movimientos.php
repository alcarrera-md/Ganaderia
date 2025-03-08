<?php
session_start(); // Iniciar la sesión

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.html");
    exit;
}

// Incluir la conexión a la base de datos
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger los datos del formulario
    $animal_id = $_POST['animal_id'];
    $fecha = $_POST['fecha'];
    $tipo = $_POST['tipo'];
    $descripcion = $_POST['descripcion'];

    // Validar que los campos no estén vacíos
    if (empty($animal_id) || empty($fecha) || empty($tipo) || empty($descripcion)) {
        die("Por favor, completa todos los campos.");
    }

    // Insertar los datos en la tabla historial_movimientos
    $sql = "INSERT INTO historial_movimientos (animal_id, fecha, tipo, descripcion) VALUES (?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("isss", $animal_id, $fecha, $tipo, $descripcion);

    if ($stmt->execute()) {
        // Redirigir a la página de perfil del animal
        header("Location: perfil_vaca.php?id=$animal_id");
        exit;
    } else {
        die("Error al guardar el historial de movimientos: " . $stmt->error);
    }

    // Cerrar la conexión
    $stmt->close();
    $conexion->close();
} else {
    // Si no se envió el formulario, redirigir al formulario de registro
    header("Location: registro_movimientos.html?id=" . $_GET['id']);
    exit;
}
?>