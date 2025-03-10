<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.html");
    exit;
}

include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $animal_id = $_POST['animal_id'];
    $trabajador_id = $_POST['trabajador_id'];
    $fecha_venta = $_POST['fecha_venta'];
    $precio = $_POST['precio'];
    $comprador = $_POST['comprador'];
    $metodo_pago = $_POST['metodo_pago'];

    if ($id) {
        // ACTUALIZAR VENTA EXISTENTE (7 parámetros)
        $query = "UPDATE ventas SET 
                    animal_id = ?, 
                    trabajador_id = ?, 
                    fecha_venta = ?, 
                    precio = ?, 
                    comprador = ?, 
                    metodo_pago = ? 
                  WHERE id = ?";
        $stmt = $conexion->prepare($query);
        // Formato: "iisdsi" (6 tipos) + 1 "i" final = 7 parámetros.
        $stmt->bind_param("iisdsi", $animal_id, $trabajador_id, $fecha_venta, $precio, $comprador, $metodo_pago, $id);
    } else {
        // INSERTAR NUEVA VENTA (6 parámetros)
        $query = "INSERT INTO ventas (animal_id, trabajador_id, fecha_venta, precio, comprador, metodo_pago) 
                  VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($query);
        // Formato: "iisds" (5 tipos) + 1 "s" adicional = 6 parámetros.
        $stmt->bind_param("iisdss", $animal_id, $trabajador_id, $fecha_venta, $precio, $comprador, $metodo_pago);
    }

    if ($stmt->execute()) {
        // Actualizar el estado de la vaca a "vendida"
        $query_update = "UPDATE animales SET vendido = 1 WHERE id = ?";
        $stmt_update = $conexion->prepare($query_update);
        $stmt_update->bind_param("i", $animal_id);
        $stmt_update->execute();

        header("Location: ventas.php");
        exit;
    } else {
        die("Error al guardar la venta: " . $stmt->error);
    }
}
?>