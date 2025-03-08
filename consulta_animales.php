<?php
session_start(); // Iniciar la sesión

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.html");
    exit;
}

// Incluir la conexión a la base de datos
include 'conexion.php';

// Consultar los animales registrados
$sql = "SELECT * FROM animales";
$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Animales - Sistema Ganadero</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Estilos personalizados -->
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar {
            background-color: #28a745;
        }
        .navbar-brand, .nav-link {
            color: #fff !important;
        }
        .container {
            margin-top: 2rem;
        }
        .table {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        .btn-action {
            margin: 0 2px;
        }
        .btn-edit {
            background-color: #ffc107;
            border: none;
        }
        .btn-edit:hover {
            background-color: #e0a800;
        }
        .btn-delete {
            background-color: #dc3545;
            border: none;
        }
        .btn-delete:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Sistema Ganadero</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="consulta_animales.php">Animales</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="registro_animal.html">Registrar Animal</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Cerrar Sesión</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenido principal -->
    <div class="container">
        <h1 class="text-center mb-4">Consulta de Animales</h1>
        

        <!-- Barra de búsqueda -->
        <div class="mb-3">
            <input type="text" id="searchInput" class="form-control" placeholder="Buscar por arete, corral, estado...">
        </div>

        <!-- Tabla de animales -->
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Arete ID</th>
                        <th>Fecha Nacimiento</th>
                        <th>Fecha Entrada</th>
                        <th>Color</th>
                        <th>Sexo</th>
                        <th>Peso (kg)</th>
                        <th>Corral</th>
                        <th>Estado de Salud</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($fila = $resultado->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($fila['arete_id']); ?></td>
                            <td><?php echo htmlspecialchars($fila['fecha_nacimiento']); ?></td>
                            <td><?php echo htmlspecialchars($fila['fecha_entrada']); ?></td>
                            <td><?php echo htmlspecialchars($fila['color']); ?></td>
                            <td><?php echo htmlspecialchars($fila['sexo']); ?></td>
                            <td><?php echo htmlspecialchars($fila['peso']); ?></td>
                            <td><?php echo htmlspecialchars($fila['corral_actual']); ?></td>
                            <td><?php echo htmlspecialchars($fila['estado_salud']); ?></td>
                            <td>
                            <a href="registro_animal.php?id=<?php echo $fila['id']; ?>" class="btn btn-sm btn-edit btn-action">Editar</a>
                            <a href="eliminar_animal.php?id=<?php echo $fila['id']; ?>" class="btn btn-sm btn-delete btn-action" onclick="return confirm('¿Estás seguro de eliminar este animal?');">Eliminar</a>
                            <a href="perfil_vaca.php?id=<?php echo $fila['id']; ?>" class="btn btn-sm btn-primary btn-action">Ver Perfil</a>
                        </tr>
                        
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Script para búsqueda -->
    <script>
        document.getElementById('searchInput').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
    </script>
</body>
</html>


<?php
// Cerrar la conexión
$conexion->close();
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">