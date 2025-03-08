<?php
// Incluir la conexión
include 'Conexion.php';

// Obtener el animal_id desde la tabla costos
$sql_animal_id = "SELECT animal_id FROM costos LIMIT 1"; // Obtiene el primer animal_id disponible
$resultado_animal_id = $conexion->query($sql_animal_id);

if ($resultado_animal_id->num_rows > 0) {
    $fila_animal_id = $resultado_animal_id->fetch_assoc();
    $animal_id = $fila_animal_id['animal_id'];
} else {
    $animal_id = null; // Si no hay registros, no hay animal_id
}

// Obtener los datos de la tabla costos
$sql = "SELECT * FROM costos ORDER BY fecha DESC";
$resultado = $conexion->query($sql);

// Verificar si hay un error en la consulta
if (!$resultado) {
    die("Error en la consulta: " . $conexion->error);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualización de Costos</title>
    <!-- Incluir Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Incluir Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .chart-container {
            width: 50%;
            margin: 20px auto;
        }
        .btn-regresar {
            position: absolute;
            top: 20px;
            right: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Botón para regresar a perfil_vaca.php -->
        <?php if ($animal_id): ?>
            <a href="perfil_vaca.php?id=<?php echo $animal_id; ?>" class="btn btn-secondary btn-regresar">Regresar al Perfil de la Vaca</a>
        <?php else: ?>
            <a href="perfil_vaca.php" class="btn btn-secondary btn-regresar">Regresar al Perfil de la Vaca</a>
        <?php endif; ?>

        <h1 class="text-center">Costos Registrados</h1>

        <!-- Tabla para mostrar los datos -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>ID del Animal</th>
                    <th>Concepto</th>
                    <th>Tipo</th>
                    <th>Monto</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($resultado->num_rows > 0) {
                    while ($fila = $resultado->fetch_assoc()) {
                        echo "<tr>
                                <td>{$fila['id']}</td>
                                <td>{$fila['animal_id']}</td>
                                <td>{$fila['concepto']}</td>
                                <td>{$fila['tipo']}</td>
                                <td>{$fila['monto']}</td>
                                <td>{$fila['fecha']}</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No hay costos registrados.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Gráficos -->
        <div class="chart-container">
            <canvas id="graficoCostos"></canvas>
        </div>
    </div>

    <script>
        // Datos para el gráfico
        const datosCostos = {
            labels: [], // Fechas
            datasets: [{
                label: 'Monto de Costos',
                data: [], // Montos
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        };

        // Llenar los datos desde PHP
        <?php
        $resultado->data_seek(0); // Reiniciar el puntero del resultado
        while ($fila = $resultado->fetch_assoc()) {
            echo "datosCostos.labels.push('{$fila['fecha']}');";
            echo "datosCostos.datasets[0].data.push({$fila['monto']});";
        }
        ?>

        // Crear el gráfico
        const ctx = document.getElementById('graficoCostos').getContext('2d');
        const graficoCostos = new Chart(ctx, {
            type: 'bar', // Tipo de gráfico (puedes cambiarlo a 'line', 'pie', etc.)
            data: datosCostos,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>

<?php
// Cerrar la conexión
$conexion->close();
?>