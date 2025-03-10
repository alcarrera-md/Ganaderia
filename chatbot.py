from flask import Flask, render_template, request, jsonify
from transformers import AutoModelForCausalLM, AutoTokenizer
import torch

app = Flask(__name__)

@app.route("/")
def home():
    return render_template("index.html")  # Servir la página HTML

# Cargar el modelo y el tokenizador
modelo_nombre = "microsoft/DialoGPT-medium"
tokenizer = AutoTokenizer.from_pretrained(modelo_nombre)
modelo = AutoModelForCausalLM.from_pretrained(modelo_nombre)

# Variable para almacenar el historial de conversación
chat_history_ids = None

@app.route("/chat", methods=["POST"])
def chat():
    global chat_history_ids  # Para mantener la conversación
    datos = request.json
    mensaje_usuario = datos.get("mensaje", "")

    if not mensaje_usuario:
        return jsonify({"respuesta": "Por favor, escribe un mensaje."})

    # Agregar instrucciones al prompt
    prompt = f"Eres un experto en ganado y responderás con precisión.\nUsuario: {mensaje_usuario}\nAsistente:"

    # Tokenizar entrada
    input_ids = tokenizer.encode(prompt, return_tensors="pt")

    # Mantener historial de conversación
    if chat_history_ids is None:
        chat_history_ids = input_ids
    else:
        chat_history_ids = torch.cat([chat_history_ids, input_ids], dim=-1)

    # Generar respuesta del chatbot
    respuesta_ids = modelo.generate(
        chat_history_ids,
        max_length=chat_history_ids.shape[-1] + 50,  # Se expande con historial
        temperature=0.7,  # Controla la creatividad
        top_p=0.9,  # Filtra respuestas irrelevantes
        pad_token_id=tokenizer.eos_token_id
    )

    # Decodificar respuesta
    respuesta = tokenizer.decode(respuesta_ids[:, input_ids.shape[-1]:][0], skip_special_tokens=True)

    # Retornar la respuesta en JSON
    return jsonify({"respuesta": respuesta})

if __name__ == "__main__":
    app.run(debug=True)
