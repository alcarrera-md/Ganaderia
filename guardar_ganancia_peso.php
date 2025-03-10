<?php
// Configuración de la conexión
$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$basedatos = "ganaderia_db";

$conexion = new mysqli($servidor, $usuario, $contrasena, $basedatos);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $animal_id = $_POST["animal_id"];
    $fecha = $_POST["fecha"];
    $peso = $_POST["peso"];

    // Verificar si el animal_id existe en la tabla animales
    $sql_verificar = "SELECT id FROM animales WHERE id = ?";
    $stmt_verificar = $conexion->prepare($sql_verificar);
    $stmt_verificar->bind_param("i", $animal_id);
    $stmt_verificar->execute();
    $stmt_verificar->store_result();

    if ($stmt_verificar->num_rows > 0) {
        // El animal_id existe, proceder con la inserción
        $sql = "INSERT INTO historial_peso (animal_id, fecha, peso) VALUES (?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("iss", $animal_id, $fecha, $peso);

        if ($stmt->execute()) {
            echo "Registro de peso guardado con éxito.";
        } else {
            echo "Error al guardar el registro: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error: El animal_id no existe en la tabla animales.";
    }

    $stmt_verificar->close();
}

$conexion->close();
?>