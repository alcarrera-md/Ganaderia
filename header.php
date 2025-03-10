<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Ganadero</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Estilos personalizados -->
    <style>
        .navbar {
            background-color: #28a745; /* Color verde para el menú */
        }
        .navbar-brand, .nav-link {
            color: #fff !important; /* Texto blanco */
        }
        .navbar-brand:hover, .nav-link:hover {
            color: #f8f9fa !important; /* Texto más claro al pasar el mouse */
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
                        <a class="nav-link" href="trabajadores.php">Trabajadores</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="asignaciones.php">Asignaciones</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="ventas.php">Ventas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Cerrar Sesión</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenido principal -->
    <div class="container mt-4">