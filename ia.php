<?php
set_time_limit(300);  // Aumenta el tiempo de ejecución

function consultarIA($pregunta) {
    // URL de la API local de Ollama
    $api_url = "http://localhost:11434/api/generate";

    // Esquema de la base de datos
    $esquema = "
    -- Esquema de la base de datos:
    -- Tabla: animales
    -- Campos: id (int), arete_id (varchar), corral_actual (int), estado_salud (enum), fecha_nacimiento (date)
    ";

    // Formatear la pregunta con el esquema
    $pregunta_formateada = $esquema . "\n-- Pregunta: " . $pregunta . "\n-- Consulta SQL:";

    // Datos que se enviarán a la API
    $data = json_encode([
        "model" => "llama2",  // Usamos llama2
        "prompt" => $pregunta_formateada,
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
        return "Error en la solicitud cURL: " . curl_error($ch);
    }

    // Cerrar la conexión cURL
    curl_close($ch);

    // Decodificar la respuesta JSON
    $resultado = json_decode($response, true);

    // Verificar si la respuesta contiene la consulta SQL generada
    if (isset($resultado['response'])) {
        // Imprimir la respuesta completa para depuración
        echo "Respuesta completa del modelo: " . $resultado['response'] . "<br>";

        // Intentar extraer la consulta SQL usando una expresión regular más flexible
        if (preg_match('/```sql\s*(.*?)\s*```/s', $resultado['response'], $matches)) {
            return trim($matches[1]);  // Devolver solo la consulta SQL
        } elseif (preg_match('/```\s*(SELECT.*?)\s*```/s', $resultado['response'], $matches)) {
            return trim($matches[1]);  // Devolver solo la consulta SQL
        } else {
            return "Error: No se pudo extraer la consulta SQL de la respuesta.";
        }
    } else {
        return "Error: No se pudo generar la consulta. Respuesta de la API: " . print_r($resultado, true);
    }
}



// Ejemplo de uso
$pregunta = "¿Cuántas vacas están en el lote 5?";
$sql_generado = consultarIA($pregunta);

// Verificar si la consulta SQL es válida
if (stripos(trim($sql_generado), 'SELECT') === 0) {
    echo "SQL generado: " . $sql_generado;
} else {
    echo "Consulta no permitida: " . $sql_generado;
}
?>