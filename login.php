<?php
session_start(); // Iniciar la sesión
include 'conexion.php'; // Ruta directa

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    // Consultar la base de datos
    $sql = "SELECT id, nombre, rol, contrasena_hash FROM usuarios WHERE usuario = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $fila = $resultado->fetch_assoc();
        if (password_verify($contrasena, $fila['contrasena_hash'])) {
            // Iniciar sesión
            $_SESSION['usuario_id'] = $fila['id'];
            $_SESSION['usuario_nombre'] = $fila['nombre'];
            $_SESSION['usuario_rol'] = $fila['rol'];

            // Redirigir a la página principal
            header("Location: index.php"); // Ruta directa
            exit;
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "Usuario no encontrado.";
    }
} else {
    header("Location: login.html");
    exit;
}
?>