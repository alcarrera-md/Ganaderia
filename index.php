<?php
session_start(); // Iniciar la sesión

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio - Sistema Ganadero</title>
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
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .btn-success {
            background-color: #28a745;
            border: none;
        }
        .btn-success:hover {
            background-color: #218838;
        }
        .btn-danger {
            background-color: #dc3545;
            border: none;
        }
        .btn-danger:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>

    </nav>
    <?php include 'includes/header.php'; ?>

    <!-- Contenido principal -->
    <div class="container">
        <h1>Bienvenido, Cesario Dominguez <?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?></h1>
        <p>Selecciona una opción para continuar:</p>
        <div class="d-grid gap-2">
            <a href="consulta_animales.php" class="btn btn-primary">Ver Animales</a>
            <a href="registro_animal.html" class="btn btn-success">Registrar Animal</a>
            <a href="logout.php" class="btn btn-danger">Cerrar Sesión</a>
        </div>
    </div>

    

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</body>
</html>