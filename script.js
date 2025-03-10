async function enviarPregunta() {
    const pregunta = document.getElementById('pregunta').value;
    console.log("Pregunta:", pregunta);

    if (!pregunta) {
        alert("Por favor, escribe una pregunta.");
        return;
    }

    const conversacion = document.getElementById('conversacion');
    conversacion.innerHTML += `<div class="mensaje usuario">Tú: ${pregunta}</div>`;

    try {
        const respuesta = await fetch('http://127.0.0.1:5000/preguntar', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ pregunta })
        });

        console.log("Respuesta recibida:", respuesta);  // Verifica que se reciba una respuesta

        if (!respuesta.ok) {
            throw new Error(`Error ${respuesta.status}: ${respuesta.statusText}`);
        }

        const data = await respuesta.json();
        console.log("Datos de la respuesta:", data);  // Verifica los datos de la respuesta

        if (data.respuesta) {
            conversacion.innerHTML += `<div class="mensaje ia">IA: ${data.respuesta}</div>`;
        } else if (data.resultados) {
            conversacion.innerHTML += `<div class="mensaje ia">IA: ${JSON.stringify(data.resultados, null, 2)}</div>`;
        } else {
            conversacion.innerHTML += `<div class="mensaje error">Error: No se pudo obtener una respuesta.</div>`;
        }
    } catch (error) {
        console.error('Error:', error);
        conversacion.innerHTML += `<div class="mensaje error">Error: No se pudo obtener una respuesta.</div>`;
    }

    document.getElementById('pregunta').value = '';
    conversacion.scrollTop = conversacion.scrollHeight;
}