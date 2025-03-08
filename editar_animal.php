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

$id_animal = $_GET['id'];

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

// Procesar el formulario de edición
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger los datos del formulario
    $arete_id = $_POST['arete_id'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $fecha_entrada = $_POST['fecha_entrada'];
    $color = $_POST['color'];
    $sexo = $_POST['sexo'];
    $peso = $_POST['peso'];
    $corral = $_POST['corral'];
    $estado_salud = $_POST['estado_salud'];

    // Validar que los campos no estén vacíos
    if (empty($arete_id) || empty($fecha_nacimiento) || empty($fecha_entrada) || empty($color) || empty($sexo) || empty($peso) || empty($corral) || empty($estado_salud)) {
        die("Por favor, completa todos los campos.");
    }

    // Validar que la fecha de entrada no sea anterior a la de nacimiento
    if (strtotime($fecha_entrada) < strtotime($fecha_nacimiento)) {
        die("Error: La fecha de entrada no puede ser anterior a la fecha de nacimiento.");
    }

    // Actualizar los datos en la base de datos
    $sql_update = "UPDATE animales 
                   SET arete_id = ?, fecha_nacimiento = ?, fecha_entrada = ?, color = ?, sexo = ?, peso = ?, corral_actual = ?, estado_salud = ?
                   WHERE id = ?";
    $stmt_update = $conexion->prepare($sql_update);
    $stmt_update->bind_param("sssssdssi", $arete_id, $fecha_nacimiento, $fecha_entrada, $color, $sexo, $peso, $corral, $estado_salud, $id_animal);

    if ($stmt_update->execute()) {
        // Redirigir a la página de consulta de animales
        header("Location: consulta_animales.php");
        exit;
    } else {
        die("Error al actualizar el animal: " . $stmt_update->error);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Animal - Sistema Ganadero</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Estilos personalizados -->
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .form-container {
            background: #fff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            width: 100%;
        }
        .form-container h2 {
            text-align: center;
            margin-bottom: 1.5rem;
            color: #333;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-group label {
            font-weight: 500;
            color: #555;
        }
        .form-control {
            border-radius: 5px;
            border: 1px solid #ddd;
            padding: 0.75rem;
        }
        .form-control:focus {
            border-color: #28a745;
            box-shadow: 0 0 5px rgba(40, 167, 69, 0.5);
        }
        .btn-guardar {
            width: 100%;
            background-color: #28a745;
            border: none;
            padding: 0.75rem;
            font-size: 1rem;
            font-weight: 500;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .btn-guardar:hover {
            background-color: #218838;
        }
        .required-label::after {
            content: "*";
            color: red;
            margin-left: 3px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Editar Animal</h2>
        <form method="POST">
            <!-- Arete ID -->
            <div class="form-group">
                <label class="required-label" for="arete_id">Número de Arete</label>
                <input type="text" class="form-control" id="arete_id" name="arete_id" value="<?php echo htmlspecialchars($animal['arete_id']); ?>" required>
            </div>

            <!-- Fecha de Nacimiento y Fecha de Entrada -->
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="required-label" for="fecha_nacimiento">Fecha de Nacimiento</label>
                        <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo htmlspecialchars($animal['fecha_nacimiento']); ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="required-label" for="fecha_entrada">Fecha de Entrada al Corral</label>
                        <input type="date" class="form-control" id="fecha_entrada" name="fecha_entrada" value="<?php echo htmlspecialchars($animal['fecha_entrada']); ?>" required>
                    </div>
                </div>
            </div>

            <!-- Color y Sexo -->
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="required-label" for="color">Color</label>
                        <input type="text" class="form-control" id="color" name="color" value="<?php echo htmlspecialchars($animal['color']); ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="required-label" for="sexo">Sexo</label>
                        <select class="form-select" id="sexo" name="sexo" required>
                            <option value="Macho" <?php echo ($animal['sexo'] === 'Macho') ? 'selected' : ''; ?>>Macho</option>
                            <option value="Hembra" <?php echo ($animal['sexo'] === 'Hembra') ? 'selected' : ''; ?>>Hembra</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Peso y Corral -->
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="required-label" for="peso">Peso (kg)</label>
                        <input type="number" step="0.01" class="form-control" id="peso" name="peso" value="<?php echo htmlspecialchars($animal['peso']); ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="required-label" for="corral">Corral Asignado</label>
                        <input type="text" class="form-control" id="corral" name="corral" value="<?php echo htmlspecialchars($animal['corral_actual']); ?>" required>
                    </div>
                </div>
            </div>

            <!-- Estado de Salud -->
            <div class="form-group">
                <label class="required-label" for="estado_salud">Estado de Salud</label>
                <select class="form-select" id="estado_salud" name="estado_salud" required>
                    <option value="Sano" <?php echo ($animal['estado_salud'] === 'Sano') ? 'selected' : ''; ?>>Sano</option>
                    <option value="Enfermo" <?php echo ($animal['estado_salud'] === 'Enfermo') ? 'selected' : ''; ?>>Enfermo</option>
                    <option value="En tratamiento" <?php echo ($animal['estado_salud'] === 'En tratamiento') ? 'selected' : ''; ?>>En tratamiento</option>
                </select>
            </div>

            <!-- Botón de Envío -->
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-guardar">Guardar Cambios</button>
            </div>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Cerrar la conexión
$conexion->close();
?>