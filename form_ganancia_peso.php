<?php
// Obtener el ID de la vaca desde la URL
$id_animal = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Conexión a la base de datos para obtener el arete_id del animal
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
    <title>Registro de Ganancia de Peso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Registro de Ganancia de Peso</h1>
        <form action="guardar_ganancia_peso.php" method="POST">
            <div class="mb-3">
                <label for="animal_id" class="form-label">Animal</label>
                <input type="text" class="form-control" value="<?php echo htmlspecialchars($arete_id); ?>" readonly>
                <input type="hidden" name="animal_id" value="<?php echo $id_animal; ?>">
            </div>
            <div class="mb-3">
                <label for="fecha" class="form-label">Fecha</label>
                <input type="date" class="form-control" id="fecha" name="fecha" required>
            </div>
            <div class="mb-3">
                <label for="peso" class="form-label">Peso Actual (kg)</label>
                <input type="number" step="0.01" class="form-control" id="peso" name="peso" required>
            </div>
            <button type="submit" class="btn btn-primary">Guardar Registro</button>
        </form>
    </div>
</body>
</html>