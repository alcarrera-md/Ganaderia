<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.html");
    exit;
}

include 'conexion.php';

// Obtener todos los trabajadores con su última asignación y corral
$query = "SELECT 
            t.id,
            t.nombre,
            a.tarea AS ultima_tarea,
            a.fecha_asignacion AS ultima_fecha,
            c.nombre AS corral
          FROM trabajadores t
          LEFT JOIN asignaciones a ON t.id = a.trabajador_id
          LEFT JOIN corrales c ON a.corral_id = c.id
          WHERE a.id = (
              SELECT MAX(a2.id) 
              FROM asignaciones a2 
              WHERE a2.trabajador_id = t.id
          )";
$result = $conexion->query($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Trabajadores</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
        <h1 class="text-center mb-4">Lista de Trabajadores</h1>

        <!-- Campo de búsqueda -->
        <div class="row mb-3">
            <div class="col-md-6 offset-md-3">
                <input type="text" id="buscar" class="form-control" placeholder="Buscar trabajador..." onkeyup="buscarTrabajador()">
            </div>
        </div>

        <!-- Tabla de trabajadores -->
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th class="hide-on-mobile">Tarea</th>
                        <th class="hide-on-mobile">Fecha</th>
                        <th class="hide-on-mobile">Corral</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="tabla-trabajadores">
                    <?php while ($trabajador = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($trabajador['nombre']); ?></td>
                            <td class="hide-on-mobile"><?php echo $trabajador['ultima_tarea'] ?: 'N/A'; ?></td>
                            <td class="hide-on-mobile"><?php echo $trabajador['ultima_fecha'] ?: 'N/A'; ?></td>
                            <td class="hide-on-mobile"><?php echo !empty($trabajador['corral']) ? htmlspecialchars($trabajador['corral']) : 'N/A'; ?></td>
                            <td>
                                <a href="form_trabajador.php?id=<?php echo $trabajador['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                                <a href="eliminar_trabajador.php?id=<?php echo $trabajador['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este trabajador?');">Eliminar</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- Botón para añadir trabajador -->
        <div class="text-center mt-4">
            <a href="form_trabajador.php" class="btn btn-primary">Añadir Trabajador</a>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>

    <script>
        function buscarTrabajador() {
            var texto = $("#buscar").val();
            $.ajax({
                url: "buscar_trabajador.php",
                type: "GET",
                data: { q: texto },
                success: function(response) {
                    $("#tabla-trabajadores").html(response);
                }
            });
        }
    </script>
</body>
</html>