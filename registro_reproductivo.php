<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Historial Reproductivo</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1 class="text-center mb-4">Registrar Historial Reproductivo</h1>
        <form action="guardar_reproductivo.php" method="POST">
            <!-- Campo oculto para el ID del animal -->
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($_GET['id']); ?>">

            <!-- Fecha del evento reproductivo -->
            <div class="mb-3">
                <label for="fecha" class="form-label">Fecha del Evento</label>
                <input type="date" class="form-control" id="fecha" name="fecha" required>
            </div>

            <!-- Tipo de evento (parto, preñez, ciclo) -->
            <div class="mb-3">
                <label for="evento" class="form-label">Evento</label>
                <select class="form-select" id="evento" name="evento" required>
                    <option value="">Seleccione una opción</option>
                    <option value="Parto">Parto</option>
                    <option value="Preñez">Preñez</option>
                    <option value="Ciclo">Ciclo Reproductivo</option>
                    <option value="Servicio">Servicio</option>
                    <option value="Inseminación">Inseminación</option>
                    <option value="Diagnóstico de preñez">Diagnóstico de preñez</option>
                    <option value="Aborto">Aborto</option>
                </select>
            </div>

            <!-- Nombre del Toro -->
            <div class="mb-3">
                <label for="toro_nombre" class="form-label">Nombre del Toro</label>
                <input type="text" class="form-control" id="toro_nombre" name="toro_nombre">
            </div>

            <!-- Raza del Toro -->
            <div class="mb-3">
                <label for="toro_raza" class="form-label">Raza del Toro</label>
                <input type="text" class="form-control" id="toro_raza" name="toro_raza">
            </div>

            <!-- Estado del Evento -->
            <div class="mb-3">
                <label for="estado" class="form-label">Estado</label>
                <select class="form-select" id="estado" name="estado">
                    <option value="Completado">Completado</option>
                    <option value="Pendiente">Pendiente</option>
                    <option value="Cancelado">Cancelado</option>
                </select>
            </div>

            <!-- Observaciones -->
            <div class="mb-3">
                <label for="observaciones" class="form-label">Observaciones</label>
                <textarea class="form-control" id="observaciones" name="observaciones" rows="3"></textarea>
            </div>

            <!-- Fecha de Confirmación -->
            <div class="mb-3">
                <label for="fecha_confirmacion" class="form-label">Fecha de Confirmación</label>
                <input type="date" class="form-control" id="fecha_confirmacion" name="fecha_confirmacion">
            </div>

            <!-- Descripción del evento -->
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
            </div>

            <!-- Botón de envío -->
            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>