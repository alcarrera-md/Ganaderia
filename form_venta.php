<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.html");
    exit;
}

include 'conexion.php';

$venta = null;
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = "SELECT * FROM ventas WHERE id = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $venta = $result->fetch_assoc();
}

// Obtener animales no vendidos
$query_animales = "SELECT id, arete_id FROM animales WHERE estado = 'Viva' AND vendido = 0";
$animales = mysqli_query($conexion, $query_animales);

// Obtener trabajadores
$query_trabajadores = "SELECT id, nombre FROM trabajadores";
$trabajadores = mysqli_query($conexion, $query_trabajadores);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo $venta ? 'Editar' : 'Registrar'; ?> Venta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="container mt-4">
        <h1><?php echo $venta ? 'Editar' : 'Registrar'; ?> Venta</h1>
        <form action="guardar_venta.php" method="POST">
            <?php if ($venta): ?>
                <input type="hidden" name="id" value="<?php echo $venta['id']; ?>">
            <?php endif; ?>

            <!-- Animal -->
            <div class="mb-3">
                <label for="animal_id" class="form-label">Animal</label>
                <select class="form-select" id="animal_id" name="animal_id" required>
                    <option value="">Seleccione un animal</option>
                    <?php while ($row = mysqli_fetch_assoc($animales)): ?>
                        <option value="<?php echo $row['id']; ?>" <?php echo $venta && $venta['animal_id'] == $row['id'] ? 'selected' : ''; ?>>
                            <?php echo $row['arete_id']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <!-- Trabajador -->
            <div class="mb-3">
                <label for="trabajador_id" class="form-label">Trabajador</label>
                <select class="form-select" id="trabajador_id" name="trabajador_id" required>
                    <option value="">Seleccione un trabajador</option>
                    <?php while ($row = mysqli_fetch_assoc($trabajadores)): ?>
                        <option value="<?php echo $row['id']; ?>" <?php echo $venta && $venta['trabajador_id'] == $row['id'] ? 'selected' : ''; ?>>
                            <?php echo $row['nombre']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <!-- Fecha de venta -->
            <div class="mb-3">
                <label for="fecha_venta" class="form-label">Fecha de Venta</label>
                <input type="date" class="form-control" id="fecha_venta" name="fecha_venta" value="<?php echo $venta ? $venta['fecha_venta'] : date('Y-m-d'); ?>" required>
            </div>

            <!-- Precio -->
            <div class="mb-3">
                <label for="precio" class="form-label">Precio</label>
                <input type="number" step="0.01" class="form-control" id="precio" name="precio" value="<?php echo $venta ? $venta['precio'] : ''; ?>" required>
            </div>

            <!-- Comprador -->
            <div class="mb-3">
                <label for="comprador" class="form-label">Comprador</label>
                <input type="text" class="form-control" id="comprador" name="comprador" value="<?php echo $venta ? $venta['comprador'] : ''; ?>" required>
            </div>

            <!-- Método de pago -->
            <div class="mb-3">
                <label for="metodo_pago" class="form-label">Método de Pago</label>
                <select class="form-select" id="metodo_pago" name="metodo_pago" required>
                    <option value="">Seleccione un método</option>
                    <option value="Efectivo" <?php echo $venta && $venta['metodo_pago'] == 'Efectivo' ? 'selected' : ''; ?>>Efectivo</option>
                    <option value="Transferencia" <?php echo $venta && $venta['metodo_pago'] == 'Transferencia' ? 'selected' : ''; ?>>Transferencia</option>
                    <option value="Tarjeta" <?php echo $venta && $venta['metodo_pago'] == 'Tarjeta' ? 'selected' : ''; ?>>Tarjeta</option>
                    <option value="Cheque" <?php echo $venta && $venta['metodo_pago'] == 'Cheque' ? 'selected' : ''; ?>>Cheque</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="ventas.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">