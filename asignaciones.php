<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.html");
    exit;
}

include 'conexion.php';

// Obtener la lista de asignaciones
$query = "SELECT a.id, t.nombre AS trabajador, c.nombre AS corral, a.tarea, a.fecha_asignacion 
          FROM asignaciones a
          JOIN trabajadores t ON a.trabajador_id = t.id
          LEFT JOIN corrales c ON a.corral_id = c.id";
$result = mysqli_query($conexion, $query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asignaciones de Corrales</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Estilos personalizados para mejorar la experiencia en móviles */
        .table-responsive {
            overflow-x: auto;
        }
        .btn-sm {
            margin: 2px; /* Espaciado entre botones */
        }
        /* Ocultar columnas en móviles */
        @media (max-width: 767.98px) {
            .hide-on-mobile {
                display: none;
            }
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="container mt-4">
        <h1 class="text-center mb-4">Asignaciones de Corrales</h1>

        <!-- Botón para nueva asignación -->
        <div class="text-center mb-4">
            <a href="form_asignacion.php" class="btn btn-success">Nueva Asignación</a>
        </div>

        <!-- Tabla de asignaciones -->
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="hide-on-mobile">ID</th>
                        <th>Trabajador</th>
                        <th class="hide-on-mobile">Corral</th>
                        <th>Tarea</th>
                        <th class="hide-on-mobile">Fecha de Asignación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td class="hide-on-mobile"><?php echo $row['id']; ?></td>
                            <td><?php echo $row['trabajador']; ?></td>
                            <td class="hide-on-mobile"><?php echo $row['corral']; ?></td>
                            <td><?php echo $row['tarea']; ?></td>
                            <td class="hide-on-mobile"><?php echo $row['fecha_asignacion']; ?></td>
                            <td>
                                <a href="form_asignacion.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                                <a href="eliminar_asignacion.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Eliminar</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>