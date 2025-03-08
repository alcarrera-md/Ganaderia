import pandas as pd
import mysql.connector

# Configuración CORRECTA (igual que tu conexion.php)
conexion = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",  # Contraseña vacía
    database="ganaderia_db"
)

# Ejemplo de consulta
query = "SELECT * FROM animales"
datos = pd.read_sql(query, conexion)

# Guardar en CSV
datos.to_csv('datos/animales.csv', index=False)
print("Datos exportados correctamente.")

# Cerrar conexión
conexion.close()