<?php
// Configuración de la conexión a la base de datos
$servidor = "localhost"; // Servidor de la base de datos (generalmente "localhost")
$usuario = "root";       // Usuario de la base de datos (por defecto "root" en XAMPP)
$contrasena = "";        // Contraseña de la base de datos (por defecto vacía en XAMPP)
$basedatos = "ganaderia_db"; // Nombre de la base de datos

// Crear conexión
$conexion = new mysqli($servidor, $usuario, $contrasena, $basedatos);

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Procesar formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
    $nombre = $_POST["nombre"];
    $descripcion = $_POST["descripcion"];

    // Preparar la consulta SQL para insertar datos
    $sql = "INSERT INTO hatos (nombre, descripcion) VALUES (?, ?)";

    // Usar sentencias preparadas para evitar inyecciones SQL
    $stmt = $conexion->prepare($sql);
    if ($stmt) {
        // Vincular parámetros
        $stmt->bind_param("ss", $nombre, $descripcion);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo "Hato registrado con éxito.";
        } else {
            echo "Error al registrar el hato: " . $stmt->error;
        }

        // Cerrar la sentencia preparada
        $stmt->close();
    } else {
        echo "Error al preparar la consulta: " . $conexion->error;
    }
}

// Cerrar la conexión
$conexion->close();
?>