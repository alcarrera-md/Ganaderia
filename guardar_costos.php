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
    // Obtener los datos del formulario
    $animal_id = $_POST["animal_id"];
    $concepto = $_POST["concepto"];
    $tipo = $_POST["tipo"];
    $monto = $_POST["monto"];
    $fecha = $_POST["fecha"];

    // Verificar si ya existe un registro con los mismos datos
    $sql_verificar = "SELECT id FROM costos WHERE animal_id = ? AND concepto = ? AND tipo = ? AND monto = ? AND fecha = ?";
    $stmt_verificar = $conexion->prepare($sql_verificar);
    $stmt_verificar->bind_param("issss", $animal_id, $concepto, $tipo, $monto, $fecha);
    $stmt_verificar->execute();
    $stmt_verificar->store_result();

    if ($stmt_verificar->num_rows > 0) {
        // Si ya existe un registro, mostrar un mensaje de error
        echo "Error: El registro ya existe.";
    } else {
        // Si no existe, insertar el nuevo registro
        $sql_insertar = "INSERT INTO costos (animal_id, concepto, tipo, monto, fecha) VALUES (?, ?, ?, ?, ?)";
        $stmt_insertar = $conexion->prepare($sql_insertar);
        $stmt_insertar->bind_param("issss", $animal_id, $concepto, $tipo, $monto, $fecha);

        if ($stmt_insertar->execute()) {
            // Redirigir a la página de visualización
            header("Location: ver_costos.php");
            exit(); // Asegura que el script se detenga después de la redirección
        } else {
            echo "Error: " . $stmt_insertar->error;
        }

        $stmt_insertar->close();
    }

    $stmt_verificar->close();
}

$conexion->close();
?>