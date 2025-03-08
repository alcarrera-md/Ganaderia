<?php
session_start(); // Iniciar la sesión

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.html");
    exit;
}

// Incluir la conexión a la base de datos
include 'conexion.php';

// Verificar si se recibió un ID válido
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID de animal no válido.");
}

$id_animal = intval($_GET['id']); // Asegurarnos de que sea un entero

// Verificar si el animal existe y si está vendido
$sql = "SELECT id, vendido FROM animales WHERE id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id_animal);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    die("Animal no encontrado.");
}

$stmt->bind_result($animal_id, $vendido);
$stmt->fetch();


// Verificar si el animal existe en la base de datos
$sql = "SELECT id FROM animales WHERE id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id_animal);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    die("Animal no encontrado.");
}

// Recuperar los datos del animal
$sql = "SELECT * FROM animales WHERE id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id_animal);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {
    die("Animal no encontrado.");
}

$animal = $resultado->fetch_assoc();

// Recuperar el historial médico
$sql_medico = "SELECT * FROM historial_medico WHERE animal_id = ?";
$stmt_medico = $conexion->prepare($sql_medico);
$stmt_medico->bind_param("i", $id_animal);
$stmt_medico->execute();
$historial_medico = $stmt_medico->get_result();

// Recuperar el historial reproductivo
$sql_reproductivo = "SELECT * FROM historial_reproductivo WHERE animal_id = ?";
$stmt_reproductivo = $conexion->prepare($sql_reproductivo);
$stmt_reproductivo->bind_param("i", $id_animal);
$stmt_reproductivo->execute();
$historial_reproductivo = $stmt_reproductivo->get_result();

// Recuperar el historial de movimientos
$sql_movimientos = "SELECT * FROM historial_movimientos WHERE animal_id = ?";
$stmt_movimientos = $conexion->prepare($sql_movimientos);
$stmt_movimientos->bind_param("i", $id_animal);
$stmt_movimientos->execute();
$historial_movimientos = $stmt_movimientos->get_result();

// Recuperar el historial de peso
$sql_peso = "SELECT * FROM historial_peso WHERE animal_id = ?";
$stmt_peso = $conexion->prepare($sql_peso);
$stmt_peso->bind_param("i", $id_animal);
$stmt_peso->execute();
$historial_peso = $stmt_peso->get_result();

// Recuperar produccion leche
$sql_leche = "SELECT * FROM produccion_leche WHERE animal_id = ?";
$stmt_leche = $conexion->prepare($sql_leche);
$stmt_leche->bind_param("i", $id_animal);
$stmt_leche->execute();
$historial_leche = $stmt_leche->get_result();

// Recuperar costos
$sql_costos = "SELECT * FROM costos WHERE animal_id = ?";
$stmt_costos = $conexion->prepare($sql_costos);
$stmt_costos->bind_param("i", $id_animal);
$stmt_costos->execute();
$historial_costos = $stmt_costos->get_result();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de la Vaca - Sistema Ganadero</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Estilos personalizados -->
    <style>
    body {
        background-color: #f8f9fa;
    }
    .container {
        margin-top: 2rem;
    }
    .card {
        margin-bottom: 1.5rem;
        border-radius: 10px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        max-width: 800px; /* Limitar el ancho de la tarjeta */
        margin-left: auto;
        margin-right: auto; /* Centrar la tarjeta */
    }
    .card-header {
        background-color: #28a745;
        color: #fff;
        font-weight: bold;
        text-align: center; /* Centrar el texto del encabezado */
    }
    .card-body {
        padding: 1.5rem;
    }
    .img-fluid {
        max-width: 100%;
        height: auto;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        display: block;
        margin: 0 auto 1.5rem; /* Centrar la imagen */
    }
    .text-muted {
        font-style: italic;
        color: #6c757d;
    }
    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr); /* Dos columnas */
        gap: 1rem; /* Espacio entre elementos */
    }
    .info-grid p {
        margin: 0.5rem 0; /* Espaciado entre párrafos */
    }
</style>
</head>
<body>
    <div class="container">
        <h1 class="text-center mb-4">Perfil de la Vaca: <?php echo htmlspecialchars($animal['arete_id']); ?></h1>
        <div class="container">

          <!-- Mostrar mensaje si la vaca está vendida -->
          <?php if ($vendido): ?>
            <div class="vendido">
                <h3>¡Vaca Vendida!</h3>
                <p>Esta vaca ya no puede ser editada ni se le pueden agregar datos.</p>
            </div>
        <?php endif; ?>

        <!-- Barra de Navegación Superior -->
        <div class="nav-buttons">
            <div class="d-flex justify-content-between">
                <a href="consulta_animales.php" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Volver al Listado
                </a>
                <div>
                    <a href="registro_animal.html" class="btn btn-outline-success">
                        <i class="fas fa-plus"></i> Nuevo Animal
                    </a>
                    <a href="logout.php" class="btn btn-outline-danger">
                        <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                    </a>
                </div>
            </div>
        </div>

        <!-- Información General -->
<div class="card">
    <div class="card-header">Información General</div>
    <div class="card-body">
        <!-- Mostrar la foto de la vaca -->
        <?php if (!empty($animal['foto'])): ?>
            <div class="text-center mb-3">
                <img src="<?php echo htmlspecialchars($animal['foto']); ?>" alt="Foto de la vaca" class="img-fluid rounded" style="max-width: 300px;">
            </div>
        <?php else: ?>
            <div class="text-center mb-3">
                <p class="text-muted">No hay foto disponible.</p>
            </div>
        <?php endif; ?>

        <!-- Resto de la información en dos columnas -->
        <div class="info-grid">
            <p><strong>Arete ID:</strong> <?php echo htmlspecialchars($animal['arete_id']); ?></p>
            <p><strong>Fecha de Nacimiento:</strong> <?php echo htmlspecialchars($animal['fecha_nacimiento']); ?></p>
            <p><strong>Fecha de Entrada:</strong> <?php echo htmlspecialchars($animal['fecha_entrada']); ?></p>
            <p><strong>Color:</strong> <?php echo htmlspecialchars($animal['color']); ?></p>
            <p><strong>Sexo:</strong> <?php echo htmlspecialchars($animal['sexo']); ?></p>
            <p><strong>Peso:</strong> <?php echo htmlspecialchars($animal['peso']); ?> kg</p>
            <p><strong>Corral:</strong> <?php echo htmlspecialchars($animal['corral_actual']); ?></p>
            <p><strong>Estado de Salud:</strong> <?php echo htmlspecialchars($animal['estado_salud']); ?></p>
            <p><strong>Padre:</strong> <?php echo htmlspecialchars($animal['padre']); ?></p>
            <p><strong>Madre:</strong> <?php echo htmlspecialchars($animal['madre']); ?></p>
            <p><strong>Raza:</strong> <?php echo htmlspecialchars($animal['raza']); ?></p>
            <p><strong>Fierro:</strong> <?php echo htmlspecialchars($animal['fierro']); ?></p>
            <p><strong>Estado:</strong> <?php echo htmlspecialchars($animal['estado']); ?></p>
            <p><strong>Expectativa:</strong> <?php echo htmlspecialchars($animal['expectativa']); ?></p>
            <p><strong>Lugar de Nacimiento:</strong> <?php echo htmlspecialchars($animal['lugar_nacimiento']); ?></p>
            <p><strong>Fecha de Destete:</strong> <?php echo htmlspecialchars($animal['fecha_destete']); ?></p>
            <p><strong>Tipo de Alimentación:</strong> <?php echo htmlspecialchars($animal['tipo_alimentacion']); ?></p>
            <p><strong>Número de Partos:</strong> <?php echo htmlspecialchars($animal['numero_partos']); ?></p>
            <p><strong>Observaciones:</strong> <?php echo htmlspecialchars($animal['observaciones']); ?></p>
        </div>
    </div>
</div>

        <!-- Historial Médico -->
        <div class="card">
            <div class="card-header">Historial Médico</div>
            <div class="card-body">
                <!-- Tabla de historial médico -->
                <table class="table">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Tipo</th>
                            <th>Descripción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($fila = $historial_medico->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($fila['fecha']); ?></td>
                                <td><?php echo htmlspecialchars($fila['tipo']); ?></td>
                                <td><?php echo htmlspecialchars($fila['descripcion']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Historial Reproductivo -->
        <div class="card">
            <div class="card-header">Historial Reproductivo</div>
            <div class="card-body">
                <!-- Tabla de historial reproductivo -->
                <table class="table">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Evento</th>
                            <th>Descripción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($fila = $historial_reproductivo->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($fila['fecha']); ?></td>
                                <td><?php echo htmlspecialchars($fila['evento']); ?></td>
                                <td><?php echo htmlspecialchars($fila['descripcion']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
         <!-- Historial movimiento -->
         <div class="card">
            <div class="card-header">Historial Movimientos</div>
            <div class="card-body">
                <!-- Tabla de historial movimiento -->
                <table class="table">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Tipo</th>
                            <th>Descripción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($fila = $historial_movimientos->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($fila['fecha']); ?></td>
                                <td><?php echo htmlspecialchars($fila['tipo']); ?></td>
                                <td><?php echo htmlspecialchars($fila['descripcion']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Historial Peso -->
        <div class="card">
            <div class="card-header">Historial Peso</div>
            <div class="card-body">
                <!-- Tabla de historial peso -->
                <table class="table">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Peso</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($fila = $historial_peso->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($fila['fecha']); ?></td>
                                <td><?php echo htmlspecialchars($fila['peso']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Historial leche -->
        <div class="card">
            <div class="card-header">Historial Producción Leche</div>
            <div class="card-body">
                <!-- Tabla de historial leche -->
                <table class="table">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Litros</th>
                            <th>Grasa</th>
                            <th>Proteinas</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($fila = $historial_leche->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($fila['fecha']); ?></td>
                                <td><?php echo htmlspecialchars($fila['litros']); ?></td>
                                <td><?php echo htmlspecialchars($fila['grasa']); ?></td>
                                <td><?php echo htmlspecialchars($fila['proteina']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Historial costos -->
        <div class="card">
            <div class="card-header">Historial Costos</div>
            <div class="card-body">
                <!-- Tabla de costos -->
                <table class="table">
                    <thead>
                        <tr>
                            <th>Concepto</th>
                            <th>Tipo</th>
                            <th>Costo</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($fila = $historial_costos->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($fila['concepto']); ?></td>
                                <td><?php echo htmlspecialchars($fila['tipo']); ?></td>
                                <td><?php echo htmlspecialchars($fila['monto']); ?></td>
                                <td><?php echo htmlspecialchars($fila['fecha']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de la Vaca - Sistema Ganadero</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .nav-buttons {
            margin-bottom: 2rem;
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 10px;
        }
        .btn-action {
            margin: 0 5px;
            min-width: 200px;
        }
    </style>
</head>
<body>

        <h1 class="text-center mb-4"><?php echo htmlspecialchars($animal['arete_id']); ?></h1>

        <!-- Sección de Botones de Acción Rápidas -->
<div class="container mt-4">
    <div class="row g-3">
        <!-- Botón Historial Médico -->
        <div class="col-md-6">
            <a href="form_historial_medico.php?id=<?php echo $id_animal; ?>" class="btn btn-danger w-100">
                <i class="fas fa-file-medical"></i> Historial Médico
            </a>
        </div>

        <!-- Botón Historial de Movimientos -->
        <div class="col-md-6">
            <a href="form_historial_movimientos.php?id=<?php echo $id_animal; ?>" class="btn btn-info w-100">
                <i class="fas fa-truck-moving"></i> Movimientos
            </a>
        </div>

        <!-- Botón Historial Reproductivo -->
        <div class="col-md-6">
            <a href="guardar_reproductivo.php?id=<?php echo $id_animal; ?>" class="btn btn-warning w-100">
                <i class="fas fa-baby"></i> Reproducción
            </a>
        </div>

        <!-- Botón Producción de Leche -->
        <div class="col-md-6">
            <a href="form_produccion_leche.php?id=<?php echo $id_animal; ?>" class="btn btn-primary w-100">
                <i class="fas fa-prescription-bottle"></i> Producción de Leche
            </a>
        </div>

        <!-- Botón Ganancia de Peso -->
        <div class="col-md-6">
            <a href="form_ganancia_peso.php?id=<?php echo $id_animal; ?>" class="btn btn-success w-100">
                <i class="fas fa-weight"></i> Registrar Peso
            </a>
        </div>

        <!-- Botón Costos y Rentabilidad -->
        <div class="col-md-6">
            <a href="form_costos.php?id=<?php echo $id_animal; ?>" class="btn btn-dark w-100">
                <i class="fas fa-calculator"></i> Costos
            </a>
        </div>
    </div>
</div>

        <!-- Mantener el resto de tu contenido existente -->
        
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php

// Cerrar la conexión
$conexion->close();
?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</body>
</html>

