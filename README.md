# 🏨 Sistema de Gestión de Reservas - Paradise Hotel

¡Bienvenido! Este es el proyecto de Gabi y Alex. Hemod desarrollado una **API RESTful** en PHP que permite gestionar las reservas de un hotel de lujo. 

La aplicación cumple con dos funciones:
1.  **Interfaz Web:** Una web elegante para que los clientes reserven y el administrador las pueda gestionar.
2.  **Servicio Web (API):** Intercambio de datos puro en formato **JSON** para ser usado con herramientas como Thunder Client.

## 🚀 Cómo ponerlo en marcha (Despliegue)

He preparado todo para que sea muy fácil de instalar en un entorno local con **XAMPP**:

1.  **Base de Datos:**
    * Entra en `phpMyAdmin`.
    * Importa el archivo `database.sql` que he incluido. Esto creará la tabla de reservas y el usuario de base de datos `webservice`.

2.  **Archivos del Proyecto:**
    * Copia todos los archivos dentro de `C:/xampp/htdocs/hotel_api/`.
    * Asegúrate de que el archivo `credenciales.txt` esté en la misma carpeta que el `index.php`.

3.  **Acceso:**
    * Abre tu navegador en: `http://localhost/hotel_api/`

---

## 🛠️ Uso de la API con Thunder Client

Hemos diseñado la API para que responda con **JSON** siguiendo los estándares REST. Aquí te explico cómo probarla:

### 1. Consultar Reservas (GET)
* **URL:** `http://localhost/hotel_api/index.php?api=true`
* **Acción:** Devuelve un listado completo de las reservas actuales en JSON.

### 2. Crear nueva reserva (POST)
* **URL:** `http://localhost/hotel_api/index.php`
* **Body (JSON):**
    ```json
    {
      "nombre": "TuNombre",
      "apellidos": "TusApellidos",
      "entrada": "2024-06-01",
      "salida": "2024-06-10",
      "habitacion": 101
    }
    ```

### 3. Eliminar reserva (DELETE)
* **URL:** `http://localhost/hotel_api/index.php`
* **Body (JSON):**
    ```json
    {
      "id": 1
    }
    ```

---

## 🔒 Seguridad y Acceso
Siguiendo las instrucciones del ejercicio (pág 26):
* El acceso a la base de datos se hace a través de un usuario limitado (`webservice`).
* La modificación y borrado de datos está pensada para ser gestionada desde el panel de administración o mediante llamadas directas a la API, protegiendo así la integridad de las reservas.

## 📂 Contenido del Repositorio
* `index.php`: Lógica de la API + Interfaz Web (HTML/CSS/JS).
* `database.sql`: Estructura de la BD y permisos.
* `credenciales.txt`: Configuración de conexión (JSON).
* `README.md`: Este manual de instrucciones.
