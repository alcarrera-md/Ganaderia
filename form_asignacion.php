<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.html");
    exit;
}

include 'conexion.php';

$asignacion = null;
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = "SELECT * FROM asignaciones WHERE id = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $asignacion = $result->fetch_assoc();
}

// Obtener lista de trabajadores y corrales
$trabajadores = mysqli_query($conexion, "SELECT id, nombre FROM trabajadores");
$corrales = mysqli_query($conexion, "SELECT id, nombre FROM corrales");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo $asignacion ? 'Editar' : 'Nueva'; ?> Asignación</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="container mt-4">
        <h1><?php echo $asignacion ? 'Editar' : 'Nueva'; ?> Asignación</h1>
        <form action="guardar_asignacion.php" method="POST">
            <?php if ($asignacion): ?>
                <input type="hidden" name="id" value="<?php echo $asignacion['id']; ?>">
            <?php endif; ?>

            <div class="mb-3">
                <label class="form-label">Trabajador</label>
                <select name="trabajador_id" class="form-select" required>
                    <?php while ($t = mysqli_fetch_assoc($trabajadores)): ?>
                        <option value="<?php echo $t['id']; ?>" 
                            <?php echo ($asignacion && $asignacion['trabajador_id'] == $t['id']) ? 'selected' : ''; ?>>
                            <?php echo $t['nombre']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Corral</label>
                <select name="corral_id" class="form-select">
                    <option value="">Seleccionar corral (opcional)</option>
                    <?php while ($c = mysqli_fetch_assoc($corrales)): ?>
                        <option value="<?php echo $c['id']; ?>" 
                            <?php echo ($asignacion && $asignacion['corral_id'] == $c['id']) ? 'selected' : ''; ?>>
                            <?php echo $c['nombre']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Tarea</label>
                <select name="tarea" class="form-select" required>
                    <option value="Alimentación" <?php echo ($asignacion && $asignacion['tarea'] === 'Alimentación') ? 'selected' : ''; ?>>Alimentación</option>
                    <option value="Salud" <?php echo ($asignacion && $asignacion['tarea'] === 'Salud') ? 'selected' : ''; ?>>Salud</option>
                    <option value="Reproducción" <?php echo ($asignacion && $asignacion['tarea'] === 'Reproducción') ? 'selected' : ''; ?>>Reproducción</option>
                    <option value="Limpieza" <?php echo ($asignacion && $asignacion['tarea'] === 'Limpieza') ? 'selected' : ''; ?>>Limpieza</option>
                    <option value="Ventas" <?php echo ($asignacion && $asignacion['tarea'] === 'Ventas') ? 'selected' : ''; ?>>Ventas</option>
                    <option value="Transporte" <?php echo ($asignacion && $asignacion['tarea'] === 'Transporte') ? 'selected' : ''; ?>>Transporte</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Fecha de Asignación</label>
                <input type="date" class="form-control" name="fecha_asignacion" 
                    value="<?php echo $asignacion ? $asignacion['fecha_asignacion'] : date('Y-m-d'); ?>" required>
            </div>

            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="asignaciones.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>