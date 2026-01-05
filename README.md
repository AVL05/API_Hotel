# 🏨 Sistema de Gestión de Reservas - Paradise Hotel

¡Bienvenido! Este es el proyecto desarrollado en común por **Gabi y Alex**. Hemos diseñado y programado una **API RESTful** en PHP que permite gestionar las reservas de un hotel de lujo, integrando seguridad de grado administrativo y una interfaz de usuario moderna.

La aplicación se divide en dos capas principales:
1.  **Capa de Servicio (Backend):** Una API que procesa peticiones JSON y gestiona la persistencia en MySQL.
2.  **Capa de Presentación (Frontend):** Una interfaz SPA (*Single Page Application*) que interactúa con la API de forma asíncrona.

---

## 🚀 Despliegue y Configuración (XAMPP)

Hemos simplificado el proceso para que la instalación sea inmediata en un entorno local:

### 1. Preparación de la Base de Datos
* Accede a `phpMyAdmin`.
* Importa el archivo `database.sql`. Este script:
    * Crea la base de datos `hotel_webservice`.
    * Define las tablas con **integridad referencial** (Claves Foráneas).
    * Configura el usuario de sistema `webservice`.
    * Inserta el perfil de Administrador con contraseña encriptada por BCRYPT.

### 2. Configuración del Servidor
* Asegúrate de que el archivo `credenciales.txt` esté en la raíz del proyecto. El sistema leerá este JSON para conectar con la BD:
    ```json
    {
      "host": "localhost",
      "db": "hotel_webservice",
      "username": "webservice",
      "password": "webservice"
    }
    ```

### 3. Acceso al Proyecto
* Ubica la carpeta en `C:/xampp/htdocs/API_Hotel/`.
* Accede desde el navegador: `http://localhost/API_Hotel/`

---

## 🔒 Seguridad y Lógica de Negocio

El proyecto implementa un flujo de trabajo profesional para garantizar la seguridad:

* **Autenticación BCRYPT:** Las contraseñas se procesan mediante algoritmos de hash seguros, cumpliendo con los estándares actuales de protección de datos.
* **Control de Sesiones:** Se utiliza `session_start()` para validar el rol de administrador. Las acciones sensibles (Listar, Editar, Eliminar) están protegidas y devolverán un **Error 401** si no hay una sesión activa.
* **Transacciones Atómicas:** En el registro de reservas, se utilizan transacciones SQL para asegurar que la creación del usuario y su reserva se realicen correctamente de forma conjunta.

### 🔑 Acceso Administrativo para Pruebas:
* **Usuario:** `webservice@hotel.com`
* **Password:** `webservice`

---

## 🛠️ Guía Detallada de Pruebas con Thunder Client

Debido a la seguridad por sesiones, para probar los métodos privados, primero debes autenticarte en la herramienta.



### 1. Autenticación (Login) - **Paso Obligatorio**
Para activar la sesión en el cliente de API (acceder como administrador) y poder acceder a los datos:
* **Método:** `POST`
* **URL:** `http://localhost/API_Hotel/index.php?api=true&action=login`
* **Body (JSON):**
    ```json
    {
      "email": "webservice@hotel.com",
      "password": "webservice"
    }
    ```
* **Resultado:** Recibirás un mensaje de "Acceso concedido". Thunder Client mantendrá la cookie `PHPSESSID` para las siguientes peticiones.

### 2. Consultar Reservas (GET)
* **Método:** `GET`
* **URL:** `http://localhost/API_Hotel/index.php?api=true`
* **Resultado:** Listado completo de reservas en formato JSON.

### 3. Crear nueva reserva (POST) - **Público**
Este método simula a un cliente externo y no requiere estar logueado.
* **Método:** `POST`
* **URL:** `http://localhost/API_Hotel/index.php?api=true`
* **Body (JSON):**
    ```json
    {
      "nombre": "Gabi",
      "apellidos": "Alex",
      "entrada": "2026-06-01",
      "salida": "2026-06-15",
      "habitacion": 105
    }
    ```

### 4. Modificar reserva (PUT)
* **Método:** `PUT`
* **URL:** `http://localhost/API_Hotel/index.php?api=true`
* **Body (JSON):**
    ```json
    {
      "id": 1,
      "entrada": "2026-07-01",
      "salida": "2026-07-20",
      "habitacion": 202
    }
    ```

### 5. Eliminar reserva (DELETE)
* **Método:** `DELETE`
* **URL:** `http://localhost/API_Hotel/index.php?api=true`
* **Body (JSON):**
  ```json
    { 
      "id": 1 
    }
  ```

---

## 🛠️ Solución de Problemas (Troubleshooting)

* **Error 500:** Revisa que el archivo `credenciales.txt` tenga los datos correctos de tu MySQL.
* **Error 401 en Thunder Client:** Asegúrate de haber realizado el **Paso 1 (Login)** con éxito antes de intentar un GET o DELETE.
* **Puertos de Apache:** Si usas un puerto distinto al 80 (ej. 8080), cambia las URLs a `http://localhost:8080/API_Hotel/...`.
* **Cierre de Sesión:** Si deseas forzar el cierre de sesión para probar la restricción, usa: `http://localhost/API_Hotel/index.php?api=true&action=logout`.

---

## 📂 Estructura del Repositorio
* `index.php`: Router de la API y renderizado del Frontend.
* `/css/styles.css`: Diseño corporativo y estilos de componentes.
* `/js/app.js`: Lógica asíncrona y comunicación con la API.
* `database.sql`: Esquema de base de datos y datos iniciales.
* `credenciales.txt`: Parámetros de conexión dinámica.
* `README.md`: Este manual.

---
**Proyecto realizado en común por Gabriel Daniel Manea y Álex Vicente López** *Módulo: Desarrollo Web en Entorno Servidor*
