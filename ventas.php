<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.html");
    exit;
}

include 'conexion.php';

// Obtener la lista de ventas
$query = "SELECT v.id, a.arete_id, v.fecha_venta, v.precio, v.comprador 
          FROM ventas v
          JOIN animales a ON v.animal_id = a.id";
$result = mysqli_query($conexion, $query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ventas de Animales</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="container mt-4">
        <h1>Ventas de Animales</h1>
        <a href="form_venta.php" class="btn btn-success mb-3">Registrar Venta</a>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Arete ID</th>
                    <th>Fecha de Venta</th>
                    <th>Precio</th>
                    <th>Comprador</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['arete_id']; ?></td>
                        <td><?php echo $row['fecha_venta']; ?></td>
                        <td><?php echo number_format($row['precio'], 2); ?></td>
                        <td><?php echo $row['comprador']; ?></td>
                        <td>
                            <a href="form_venta.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                            <a href="eliminar_venta.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Eliminar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <?php include 'includes/footer.php'; ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</body>
</html>