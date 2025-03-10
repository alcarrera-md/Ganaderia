<?php
// Datos de ejemplo para predecir
$datos = [
    'peso' => 67,
    'edad' => 5,
    'sexo' => 0, // Macho
    'numero_partos' => 0,
    'tipo' => 1 // Tratamiento
];

// Convertir los datos a JSON
$datos_json = json_encode($datos);

// Configurar la solicitud HTTP
$opciones = [
    'http' => [
        'method' => 'POST',
        'header' => 'Content-Type: application/json',
        'content' => $datos_json
    ]
];

// Crear el contexto de la solicitud
$contexto = stream_context_create($opciones);

// Enviar la solicitud a la API
$respuesta = file_get_contents('http://127.0.0.1:5000/predecir', false, $contexto);

// Verificar si la solicitud fue exitosa
if ($respuesta === FALSE) {
    echo "Error al conectar con la API.";
} else {
    // Decodificar la respuesta JSON
    $prediccion = json_decode($respuesta, true);

    // Mostrar la predicción
    echo "Predicción: " . $prediccion['prediccion'];
}
?>