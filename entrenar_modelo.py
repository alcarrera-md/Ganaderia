import pandas as pd
from sklearn.model_selection import train_test_split, cross_val_score, StratifiedKFold
from sklearn.ensemble import RandomForestClassifier
from sklearn.metrics import accuracy_score, classification_report
import joblib
import mysql.connector

# Conexión a la base de datos (CORRECTA)
conexion = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",
    database="ganaderia_db"
)

# Cargar datos preprocesados
datos = pd.read_sql("SELECT * FROM datos_preprocesados", conexion)

# Cerrar conexión
conexion.close()

# (El resto del código de entrenamiento sigue igual)

# Cargar los datos preprocesados
datos = pd.read_csv('datos/datos_preprocesados.csv')

# Verificar la distribución de clases
print("\nDistribución de clases:")
print(datos['estado_salud'].value_counts())

# Seleccionar características (features) y etiquetas (labels)
X = datos[['peso', 'edad', 'sexo', 'numero_partos', 'tipo']]
y = datos['estado_salud']

# Dividir los datos en entrenamiento y prueba
X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.2, random_state=42)

# Entrenar un modelo de Random Forest
model = RandomForestClassifier(n_estimators=100, random_state=42)
model.fit(X_train, y_train)

# Evaluar el modelo en el conjunto de prueba
y_pred = model.predict(X_test)
accuracy = accuracy_score(y_test, y_pred)
print(f'\nPrecisión en el conjunto de prueba: {accuracy * 100:.2f}%')

# Validación cruzada estratificada (ajusta n_splits según tus datos)
cv = StratifiedKFold(n_splits=3, shuffle=True, random_state=42)
scores = cross_val_score(model, X, y, cv=cv)
print(f'Precisión con validación cruzada: {scores.mean() * 100:.2f}% (± {scores.std() * 100:.2f}%)')

# Verificar las clases presentes en y_test
clases_presentes = set(y_test)
print("\nClases presentes en y_test:", clases_presentes)

# Mapear las clases a nombres
nombres_clases = {0: 'Sano', 1: 'Enfermo', 2: 'En tratamiento'}
nombres_presentes = [nombres_clases[clase] for clase in sorted(clases_presentes)]

# Generar el reporte de clasificación
print("\nReporte de clasificación:")
print(classification_report(y_test, y_pred, target_names=nombres_presentes))

# Guardar el modelo entrenado
joblib.dump(model, 'modelo_salud.pkl')
print("\nModelo entrenado y guardado en 'modelo_salud.pkl'")

def entrenar_modelo():
    # Cargar datos preprocesados
    datos = pd.read_csv('datos/datos_preprocesados.csv')
    
    # Entrenar el modelo
    X = datos[['peso', 'edad', 'sexo', 'numero_partos', 'tipo']]
    y = datos['estado_salud']
    model = RandomForestClassifier()
    model.fit(X, y)
    
    # Guardar el modelo
    joblib.dump(model, 'modelo_salud.pkl')
    print("Modelo reentrenado y guardado correctamente.")

# Pausa al final
input("Presiona Enter para salir...")