<?php
function saludar($mensaje) {
    // URL de la API local de Ollama
    $api_url = "http://localhost:11434/api/generate";

    // Datos que se enviarán a la API
    $data = json_encode([
        "model" => "llama2",
        "prompt" => $mensaje,
        "stream" => false
    ]);

    // Iniciar cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Ejecutar la solicitud y obtener la respuesta
    $response = curl_exec($ch);

    // Verificar si hubo errores en la solicitud
    if (curl_errno($ch)) {
        die("Error en la solicitud cURL: " . curl_error($ch));
    }

    // Cerrar la conexión cURL
    curl_close($ch);

    // Decodificar la respuesta JSON
    $resultado = json_decode($response, true);

    // Verificar si la respuesta contiene el mensaje generado
    if (isset($resultado['response'])) {
        return $resultado['response'];  // Devolver la respuesta
    } else {
        return "Error: No se pudo generar una respuesta. Respuesta de la API: " . print_r($resultado, true);
    }
}

// Ejemplo de uso
$mensaje = "Hola, ¿cómo estás?";
$respuesta = saludar($mensaje);
echo $respuesta;
?>