<?php
include 'Conexion.php';

$id_animal = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Obtener datos del animal
$sql_animal = "SELECT arete_id, estado_salud FROM animales WHERE id = ?";
$stmt_animal = $conexion->prepare($sql_animal);
$stmt_animal->bind_param("i", $id_animal);
$stmt_animal->execute();
$animal = $stmt_animal->get_result()->fetch_assoc();

// Obtener historial médico (últimos 5 registros)
$sql_historial = "SELECT fecha, tipo, descripcion FROM historial_medico WHERE animal_id = ? ORDER BY fecha DESC LIMIT 5";
$stmt_historial = $conexion->prepare($sql_historial);
$stmt_historial->bind_param("i", $id_animal);
$stmt_historial->execute();
$historial = $stmt_historial->get_result();

// Obtener datos para gráficos (ejemplo: eventos por tipo)
$sql_eventos = "SELECT tipo, COUNT(*) as total FROM historial_medico WHERE animal_id = ? GROUP BY tipo";
$stmt_eventos = $conexion->prepare($sql_eventos);
$stmt_eventos->bind_param("i", $id_animal);
$stmt_eventos->execute();
$eventos = $stmt_eventos->get_result();

// Obtener datos para consejos dinámicos
$sql_vacunas = "SELECT fecha FROM historial_medico WHERE animal_id = ? AND tipo = 'Vacuna' ORDER BY fecha DESC LIMIT 1";
$stmt_vacunas = $conexion->prepare($sql_vacunas);
$stmt_vacunas->bind_param("i", $id_animal);
$stmt_vacunas->execute();
$ultima_vacuna = $stmt_vacunas->get_result()->fetch_assoc();

$sql_enfermedades = "SELECT tipo, COUNT(*) as total FROM historial_medico WHERE animal_id = ? AND tipo = 'Enfermedad' GROUP BY tipo";
$stmt_enfermedades = $conexion->prepare($sql_enfermedades);
$stmt_enfermedades->bind_param("i", $id_animal);
$stmt_enfermedades->execute();
$enfermedades = $stmt_enfermedades->get_result();

// Generar consejos
$consejos = [];

// Consejo 1: Vacunas pendientes
if ($ultima_vacuna) {
    $fecha_ultima_vacuna = new DateTime($ultima_vacuna['fecha']);
    $hoy = new DateTime();
    $diferencia = $hoy->diff($fecha_ultima_vacuna)->days;

    if ($diferencia > 180) { // Si la última vacuna fue hace más de 6 meses
        $consejos[] = "⚠️ Vacuna recomendada: Han pasado más de 6 meses desde la última vacuna.";
    }
}

// Consejo 2: Enfermedades recurrentes
while ($fila = $enfermedades->fetch_assoc()) {
    if ($fila['total'] > 2) { // Si la enfermedad ha ocurrido más de 2 veces
        $consejos[] = "⚠️ Enfermedad recurrente: {$fila['tipo']} ({$fila['total']} veces). Considera un tratamiento preventivo.";
    }
}

// Consejo 3: Chequeo periódico
$consejos[] = "✅ Realizar chequeo de peso y salud mensual.";

// Consejo 4: Agua limpia
$consejos[] = "💧 Asegurar acceso constante a agua limpia.";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Salud - <?php echo $animal['arete_id']; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container mt-4">
        <h1 class="text-center mb-4">Panel de Salud - <?php echo $animal['arete_id']; ?></h1>
        
        <!-- Tarjetas de KPI's -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card text-white bg-primary">
                    <div class="card-body">
                        <h5 class="card-title">Estado Actual</h5>
                        <p class="card-text"><?php echo $animal['estado_salud']; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-success">
                    <div class="card-body">
                        <h5 class="card-title">Última Vacuna</h5>
                        <p class="card-text"><?php echo $ultima_vacuna ? $ultima_vacuna['fecha'] : 'N/A'; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-warning">
                    <div class="card-body">
                        <h5 class="card-title">Enfermedades (Último Año)</h5>
                        <p class="card-text"><?php echo $enfermedades->num_rows; ?> casos</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráfico de Eventos Médicos -->
        <div class="card mb-4">
            <div class="card-header">Distribución de Eventos Médicos</div>
            <div class="card-body">
                <canvas id="graficoEventos"></canvas>
            </div>
        </div>

        <!-- Historial Reciente -->
        <div class="card mb-4">
            <div class="card-header">Historial Médico Reciente</div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Tipo</th>
                            <th>Descripción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($fila = $historial->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $fila['fecha']; ?></td>
                                <td><?php echo $fila['tipo']; ?></td>
                                <td><?php echo $fila['descripcion']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Consejos de Salud -->
        <div class="card mb-4">
            <div class="card-header">Consejos de Salud</div>
            <div class="card-body">
                <ul class="list-group">
                    <?php if (empty($consejos)): ?>
                        <li class="list-group-item">✅ Todo parece estar en orden. ¡Buen trabajo!</li>
                    <?php else: ?>
                        <?php foreach ($consejos as $consejo): ?>
                            <li class="list-group-item"><?php echo $consejo; ?></li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>

    <script>
        // Datos para el gráfico
        const eventosData = {
            labels: <?php echo json_encode(array_column($eventos->fetch_all(MYSQLI_ASSOC), 'tipo')); ?>,
            datasets: [{
                data: <?php echo json_encode(array_column($eventos->fetch_all(MYSQLI_ASSOC), 'total')); ?>,
                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56']
            }]
        };

        // Crear gráfico de pastel
        const ctx = document.getElementById('graficoEventos').getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: eventosData
        });
    </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</body>
</html>