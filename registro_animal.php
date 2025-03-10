<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.html");
    exit;
}

include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger los datos del formulario
    $arete_id = $_POST['arete_id'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $fecha_entrada = $_POST['fecha_entrada'];
    $color = $_POST['color'];
    $sexo = $_POST['sexo'];
    $peso = $_POST['peso'];
    $corral = $_POST['corral_actual']; // Cambiar 'corral' por 'corral_actual'
    $estado_salud = $_POST['estado_salud'];
    $padre = $_POST['padre'];
    $madre = $_POST['madre'];
    $raza = $_POST['raza'];
    $fierro = $_POST['fierro'];
    $estado = $_POST['estado'];
    $expectativa = $_POST['expectativa'];
    $lugar_nacimiento = $_POST['lugar_nacimiento'];
    $fecha_destete = $_POST['fecha_destete'];
    $tipo_alimentacion = $_POST['tipo_alimentacion'];
    $numero_partos = $_POST['numero_partos'];
    $observaciones = $_POST['observaciones'];

    // Procesar la imagen
    $ruta_imagen = null; // Inicializar la variable

    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $foto = $_FILES['foto'];

        // Validar el tipo de archivo
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($foto['type'], $allowed_types)) {
            die("Error: Solo se permiten imágenes JPEG, PNG o GIF.");
        }

        // Validar el tamaño del archivo (ej: máximo 5MB)
        $max_size = 5 * 1024 * 1024; // 5MB
        if ($foto['size'] > $max_size) {
            die("Error: La imagen no puede superar los 5MB.");
        }

        // Crear un nombre único para la imagen
        $extension = pathinfo($foto['name'], PATHINFO_EXTENSION);
        $nombre_archivo = uniqid() . '.' . $extension;

        // Mover la imagen a la carpeta de uploads
        $ruta_carpeta = 'uploads/';
        if (!is_dir($ruta_carpeta)) {
            mkdir($ruta_carpeta, 0755, true); // Crear la carpeta si no existe
        }
        $ruta_imagen = $ruta_carpeta . $nombre_archivo;

        if (!move_uploaded_file($foto['tmp_name'], $ruta_imagen)) {
            die("Error: No se pudo guardar la imagen.");
        }
    }

    // Insertar los datos en la base de datos
    $sql = "INSERT INTO animales (arete_id, fecha_nacimiento, fecha_entrada, color, sexo, peso, corral_actual, estado_salud, padre, madre, raza, fierro, estado, expectativa, lugar_nacimiento, fecha_destete, tipo_alimentacion, numero_partos, observaciones, foto) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param(
        "sssssdssssssssssisss",
        $arete_id,
        $fecha_nacimiento,
        $fecha_entrada,
        $color,
        $sexo,
        $peso,
        $corral,
        $estado_salud,
        $padre,
        $madre,
        $raza,
        $fierro,
        $estado,
        $expectativa,
        $lugar_nacimiento,
        $fecha_destete,
        $tipo_alimentacion,
        $numero_partos,
        $observaciones,
        $ruta_imagen
    );

    if ($stmt->execute()) {
        header("Location: perfil_vaca.php?id=" . $conexion->insert_id);
        exit;
    } else {
        die("Error al guardar: " . $stmt->error);
    }

    $stmt->close();
    $conexion->close();
} else {
    header("Location: registro_animal.php");
    exit;
}

?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">