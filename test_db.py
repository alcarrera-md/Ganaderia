import mysql.connector

# Configuración de la base de datos
config = {
    'host': '127.0.0.1',  # O 'localhost'
    'user': 'root',
    'password': '',        # Agrega la contraseña si es necesaria
    'database': 'ganaderia_db',
    'port': 3306,
    'unix_socket': None,      # Forzar el uso de TCP/IP
    'auth_plugin': 'mysql_native_password'  # Usar autenticación nativa
}

# Probar conexión
try:
    conexion = mysql.connector.connect(**config)
    print("¡Conexión exitosa a la base de datos!")
    conexion.close()
except Exception as e:
    print(f"Error conectando a la base de datos: {e}")