import pandas as pd
from datetime import datetime
import mysql.connector


# Conexión a la base de datos (CORRECTA)
conexion = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",
    database="ganaderia_db"
)
# Cerrar conexión
conexion.close()

# Cargar datos desde MySQL
animales = pd.read_sql("SELECT * FROM animales", conexion)
historial_medico = pd.read_sql("SELECT * FROM historial_medico", conexion)

# Cargar los datos desde los archivos CSV
animales = pd.read_csv('datos/animales.csv')
historial_medico = pd.read_csv('datos/historial_medico.csv')

# Convertir la columna 'fecha_nacimiento' a tipo datetime
animales['fecha_nacimiento'] = pd.to_datetime(animales['fecha_nacimiento'])

# Calcular la edad en años
hoy = datetime.now()
animales['edad'] = (hoy - animales['fecha_nacimiento']).dt.days // 365

# Unir las tablas en base al ID del animal
datos = pd.merge(animales, historial_medico, left_on='id', right_on='animal_id', how='left')

# Limpiar y transformar los datos
# Convertir el estado de salud a valores numéricos
datos['estado_salud'] = datos['estado_salud'].map({'Sano': 0, 'Enfermo': 1, 'En tratamiento': 2})

# Convertir el sexo a valores numéricos
datos['sexo'] = datos['sexo'].map({'Macho': 0, 'Hembra': 1})

# Convertir el tipo de evento médico a valores numéricos
datos['tipo'] = datos['tipo'].map({'Vacuna': 0, 'Tratamiento': 1, 'Enfermedad': 2})

# Seleccionar las columnas relevantes
columnas_relevantes = ['peso', 'edad', 'sexo', 'numero_partos', 'tipo', 'estado_salud']
datos = datos[columnas_relevantes]

# Eliminar filas con valores faltantes (si las hay)
datos = datos.dropna()

# Guardar los datos preprocesados en un nuevo archivo CSV
datos.to_csv('datos/datos_preprocesados.csv', index=False)

def preprocesar_datos():
    # Cargar datos antiguos y nuevos
    datos_antiguos = pd.read_csv('datos/datos_preprocesados.csv')
    nuevos_datos = pd.read_csv('datos/nuevos_datos.csv')
    
    # Combinar y preprocesar
    datos_completos = pd.concat([datos_antiguos, nuevos_datos])
    # (Aquí va el código de preprocesamiento)
    
    # Guardar los datos preprocesados
    datos_completos.to_csv('datos/datos_preprocesados.csv', index=False)
    print("Datos preprocesados y actualizados correctamente.")

print("Datos preprocesados y guardados en 'datos/datos_preprocesados.csv'")