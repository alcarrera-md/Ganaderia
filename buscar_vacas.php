<?php
include 'conexion.php';

$query = $_GET['q'] ?? '';

if (!empty($query)) {
    $sql = "SELECT id, arete_id FROM animales WHERE arete_id LIKE ?";
    $stmt = $conexion->prepare($sql);
    $likeQuery = "%$query%";
    $stmt->bind_param("s", $likeQuery);
    $stmt->execute();
    $resultado = $stmt->get_result();

    $vacas = [];
    while ($fila = $resultado->fetch_assoc()) {
        $vacas[] = $fila;
    }

    echo json_encode($vacas);
}
?>