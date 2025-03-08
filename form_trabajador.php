<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.html");
    exit;
}

include 'conexion.php';

$trabajador = null;
$corral_asignado = null;
$id = isset($_GET['id']) ? intval($_GET['id']) : null;

if ($id) {
    // Obtener los datos del trabajador
    $query = "SELECT t.*, 
                 (SELECT a.tarea 
                  FROM asignaciones a 
                  WHERE a.trabajador_id = t.id 
                  ORDER BY a.fecha_asignacion DESC 
                  LIMIT 1) AS ultima_tarea,
                 (SELECT c.nombre 
                  FROM corrales c
                  JOIN asignaciones a ON a.corral_id = c.id
                  WHERE a.trabajador_id = t.id 
                  ORDER BY a.fecha_asignacion DESC 
                  LIMIT 1) AS corral_asignado
          FROM trabajadores t 
          WHERE t.id = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $trabajador = $result->fetch_assoc();
    $corral_asignado = $trabajador['corral_asignado'];
}

// Obtener la lista de corrales
$query_corrales = "SELECT id, nombre FROM corrales";
$result_corrales = $conexion->query($query_corrales);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo $trabajador ? 'Editar' : 'Añadir'; ?> Trabajador</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="container mt-4">
        <h1><?php echo $trabajador ? 'Editar' : 'Añadir'; ?> Trabajador</h1>
        <form action="guardar_trabajador.php" method="POST">
            <?php if ($trabajador): ?>
                <input type="hidden" name="id" value="<?php echo $trabajador['id']; ?>">
            <?php endif; ?>
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $trabajador ? $trabajador['nombre'] : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="ultima_tarea" class="form-label">Asignación</label>
                <select class="form-select" id="ultima_tarea" name="ultima_tarea" required>
                    <option value="Alimentación" <?php echo $trabajador && $trabajador['ultima_tarea'] === 'Alimentación' ? 'selected' : ''; ?>>Alimentación</option>
                    <option value="Salud" <?php echo $trabajador && $trabajador['ultima_tarea'] === 'Salud' ? 'selected' : ''; ?>>Salud</option>
                    <option value="Reproducción" <?php echo $trabajador && $trabajador['ultima_tarea'] === 'Reproducción' ? 'selected' : ''; ?>>Reproducción</option>
                    <option value="Limpieza" <?php echo $trabajador && $trabajador['ultima_tarea'] === 'Limpieza' ? 'selected' : ''; ?>>Limpieza</option>
                    <option value="Ventas" <?php echo $trabajador && $trabajador['ultima_tarea'] === 'Ventas' ? 'selected' : ''; ?>>Ventas</option>
                    <option value="Transporte" <?php echo $trabajador && $trabajador['ultima_tarea'] === 'Transporte' ? 'selected' : ''; ?>>Transporte</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="corral_id" class="form-label">Corral Asignado</label>
                <select class="form-select" id="corral_id" name="corral_id">
                    <option value="">-- Selecciona un corral --</option>
                    <?php while ($corral = $result_corrales->fetch_assoc()): ?>
                        <option value="<?php echo $corral['id']; ?>" <?php echo ($corral_asignado == $corral['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($corral['nombre']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="trabajadores.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
