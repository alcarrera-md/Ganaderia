<?php
// Obtener el ID del animal desde la URL
$id_animal = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Conexión a la base de datos para obtener datos del animal
$conexion = new mysqli("localhost", "root", "", "ganaderia_db");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Obtener el arete_id del animal
$arete_id = "";
if ($id_animal > 0) {
    $sql = "SELECT arete_id FROM animales WHERE id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id_animal);
    $stmt->execute();
    $stmt->bind_result($arete_id);
    $stmt->fetch();
    $stmt->close();
}

$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Producción de Leche</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Registro de Producción de Leche</h1>
        <form action="guardar_produccion_leche.php" method="POST">
            <div class="mb-3">
                <label class="form-label">Animal</label>
                <input type="text" class="form-control" value="<?php echo htmlspecialchars($arete_id); ?>" readonly>
                <input type="hidden" name="animal_id" value="<?php echo $id_animal; ?>">
            </div>
            <div class="mb-3">
                <label for="fecha" class="form-label">Fecha</label>
                <input type="date" class="form-control" id="fecha" name="fecha" required>
            </div>
            <div class="mb-3">
                <label for="litros" class="form-label">Litros Producidos</label>
                <input type="number" step="0.01" class="form-control" id="litros" name="litros" required>
            </div>
            <div class="mb-3">
                <label for="grasa" class="form-label">% de Grasa</label>
                <input type="number" step="0.01" class="form-control" id="grasa" name="grasa">
            </div>
            <div class="mb-3">
                <label for="proteina" class="form-label">% de Proteína</label>
                <input type="number" step="0.01" class="form-control" id="proteina" name="proteina">
            </div>
            <button type="submit" class="btn btn-primary w-100">
                <i class="fas fa-save"></i> Guardar Producción
            </button>
        </form>
    </div>
</body>
</html>