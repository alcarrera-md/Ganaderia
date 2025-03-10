from flask import Flask, request, jsonify
import joblib

app = Flask(__name__)

# Cargar el modelo entrenado
try:
    model = joblib.load('modelo_salud.pkl')
except Exception as e:
    print(f"Error al cargar el modelo: {e}")
    model = None

@app.route('/predecir', methods=['POST'])
def predecir():
    try:
        if model is None:
            return jsonify({"error": "Modelo no cargado"}), 500

        datos = request.json
        
        # Validar que los datos necesarios estén presentes
        required_keys = ['peso', 'edad', 'sexo', 'numero_partos', 'tipo']
        if not all(key in datos for key in required_keys):
            return jsonify({"error": "Faltan datos requeridos"}), 400

        # Hacer la predicción
        prediccion = model.predict([[
            datos['peso'],
            datos['edad'],
            datos['sexo'],
            datos['numero_partos'],
            datos['tipo']
        ]])

        return jsonify({'prediccion': int(prediccion[0])})
    
    except Exception as e:
        return jsonify({"error": str(e)}), 500

if __name__ == '__main__':
    app.run(debug=True)