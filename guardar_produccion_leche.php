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
    $litros = $_POST["litros"];
    $grasa = $_POST["grasa"];
    $proteina = $_POST["proteina"];

    // Insertar datos en la tabla produccion_leche
    $sql = "INSERT INTO produccion_leche (animal_id, fecha, litros, grasa, proteina) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("issdd", $animal_id, $fecha, $litros, $grasa, $proteina);

    if ($stmt->execute()) {
        echo "Producción de leche registrada con éxito.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conexion->close();
?>