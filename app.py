from flask import Flask, request, jsonify
from flask_cors import CORS
import ollama
import mysql.connector
import random

# Configuración de la base de datos
config = {
    'host': '127.0.0.1',
    'user': 'root',
    'password': '',
    'database': 'ganaderia_db',
    'port': 3306,
    'unix_socket': None,
    'auth_plugin': 'mysql_native_password'
}

# Función para generar SQL con Ollama
def generar_sql(pregunta: str) -> str:
    esquema = """
    Esquema de la base de datos 'ganaderia_db':
    - Tabla Animales (id, nombre, raza, fecha_nacimiento, peso, id_corral)
    - Tabla Corrales (id, ubicacion, capacidad)
    - Tabla Vacunas (id, nombre_vacuna, fecha_aplicacion, id_animal)
    """
    
    prompt = f"""
    {esquema}
    
    Instrucciones:
    1. Genera SQL para: {pregunta}
    2. Usa solo JOINs explícitos.
    3. Limita los resultados a 100 registros.
    4. Solo devuelve el código SQL, sin explicaciones.
    """
    
    try:
        respuesta = ollama.generate(
            model='llama3',
            prompt=prompt,
            options={'temperature': 0.1}
        )
        sql = respuesta['response'].strip().replace('```sql', '').replace('```', '')
        return sql
    except Exception as e:
        print(f"Error generando SQL: {e}")
        return None

# Función para ejecutar consultas SQL
def ejecutar_sql(sql: str):
    try:
        conexion = mysql.connector.connect(**config)
        cursor = conexion.cursor(dictionary=True)
        cursor.execute(sql)
        resultados = cursor.fetchall()
        return resultados
    except Exception as e:
        print(f"Error ejecutando SQL: {e}")
        return []
    finally:
        if cursor:
            cursor.close()
        if conexion and conexion.is_connected():
            conexion.close()

# Respuestas generales de la IA
def responder_general(pregunta: str) -> str:
    # Saludos
    saludos = ["Hola", "¡Hola!", "¿Cómo estás?", "Buenos días", "Buenas tardes"]
    if any(saludo in pregunta.lower() for saludo in ["hola", "buenos días", "buenas tardes"]):
        return random.choice(saludos)

    # Chistes
    chistes = [
        "¿Qué hace una vaca en el gimnasio? ¡Lechera!",
        "¿Por qué las vacas no pueden usar computadoras? ¡Porque les da miedo el mouse!",
        "¿Qué le dice una vaca a otra? ¡Mu!",
    ]
    if any(palabra in pregunta.lower() for palabra in ["chiste", "broma", "risa"]):
        return random.choice(chistes)

    # Respuesta por defecto
    return "No entiendo tu pregunta. ¿Puedes ser más específico?"

# Configurar Flask
app = Flask(__name__)
CORS(app)  # Habilita CORS

# Endpoint para manejar preguntas
@app.route('/preguntar', methods=['POST'])
def preguntar():
    data = request.get_json()
    pregunta = data.get('pregunta', '')

    if not pregunta:
        return jsonify({'error': 'No se proporcionó una pregunta'}), 400

def responder_general(pregunta: str) -> str:
    print("Pregunta recibida en responder_general:", pregunta)  # Verifica que la pregunta llegue

    # Saludos
    saludos = ["Hola", "¡Hola!", "¿Cómo estás?", "Buenos días", "Buenas tardes"]
    if any(saludo in pregunta.lower() for saludo in ["hola", "buenos días", "buenas tardes"]):
        print("Respuesta general: Saludo")  # Verifica que se detecte un saludo
        return random.choice(saludos)

    # Chistes
    chistes = [
        "¿Qué hace una vaca en el gimnasio? ¡Lechera!",
        "¿Por qué las vacas no pueden usar computadoras? ¡Porque les da miedo el mouse!",
        "¿Qué le dice una vaca a otra? ¡Mu!",
    ]
    if any(palabra in pregunta.lower() for palabra in ["chiste", "broma", "risa"]):
        print("Respuesta general: Chiste")  # Verifica que se detecte una solicitud de chiste
        return random.choice(chistes)

    # Respuesta por defecto
    print("Respuesta general: No entendido")  # Verifica si no se detecta una pregunta válida
    return "No entiendo tu pregunta. ¿Puedes ser más específico?"
@app.route('/preguntar', methods=['POST'])
def preguntar():
    data = request.get_json()
    pregunta = data.get('pregunta', '')
    print("Pregunta recibida en /preguntar:", pregunta)  # Verifica que la pregunta llegue

    if not pregunta:
        return jsonify({'error': 'No se proporcionó una pregunta'}), 400

    # Respuesta general (saludos, chistes, etc.)
    respuesta_general = responder_general(pregunta)
    print("Respuesta general generada:", respuesta_general)  # Verifica la respuesta general

    if respuesta_general != "No entiendo tu pregunta. ¿Puedes ser más específico?":
        return jsonify({
            'respuesta': respuesta_general
        })

    # Generar SQL para preguntas sobre el sistema de ganado
    sql = generar_sql(pregunta)
    print("SQL generado:", sql)  # Verifica el SQL generado

    if not sql:
        return jsonify({'error': 'No se pudo generar SQL'}), 500

    # Ejecutar SQL
    resultados = ejecutar_sql(sql)
    print("Resultados de la consulta:", resultados)  # Verifica los resultados

    return jsonify({
        'sql': sql,
        'resultados': resultados
    })

# Iniciar la aplicación
if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000)