# 🏨 Hotel Paradise - Enterprise Backend API

![Version](https://img.shields.io/badge/version-2.0.0-blue.svg) ![PHP](https://img.shields.io/badge/PHP-8.1+-purple.svg) ![License](https://img.shields.io/badge/license-MIT-green.svg)

**Hotel Paradise API** es un sistema de gestión hotelera robusto, escalable y seguro. Esta plataforma integra una API RESTful con una interfaz de usuario moderna (SPA/Frontend) para ofrecer una experiencia completa tanto a administradores como a huéspedes.

---

## 🏗️ Arquitectura del Proyecto

El proyecto sigue una estructura modular y profesional, separando claramente responsabilidades:

```
API_Hotel/
├── assets/             # Recursos estáticos (Frontend)
│   ├── css/            # Estilos (styles.css)
│   └── js/             # Lógica de cliente (app.js)
├── config/             # Configuración del sistema
│   ├── config.json     # Credenciales (NO subir a repo público en prod)
│   └── db.php          # Singleton de conexión PDO
├── database/           # Migraciones y esquemas
│   └── schema.sql      # Script de inicialización
├── includes/           # Componentes reutilizables (Header, Footer)
├── api.php             # API Gateway (REST Controller)
├── index.php           # Landing Page (Public)
└── admin.php           # Panel Administrativo (Private)
```

## ✨ Características Principales

- **API RESTful Segura**: Endpoints protegidos para operaciones CRUD.
- **Autenticación**: Sistema de login basado en sesiones y hashing con BCRYPT.
- **Gestión de Base de Datos**: Uso de PDO con sentencias preparadas para prevenir SQL Injection.
- **Diseño Premium**: Interfaz responsive con animaciones y UX cuidada.
- **Transacciones Atómicas**: Integridad de datos garantizada en operaciones críticas.

---

## 🚀 Instalación y Despliegue (XAMPP)

1.  **Clonar/Copiar Proyecto**:
    Ubica la carpeta `API_Hotel` en tu directorio `htdocs` (ej: `C:\xampp\htdocs\API_Hotel`).

2.  **Base de Datos**:
    - Abre tu gestor MySQL (phpMyAdmin).
    - Importa el archivo `/database/schema.sql`.
    - Esto creará la base de datos `hotel_webservice` y las tablas necesarias.

3.  **Configuración**:
    Verifica que `/config/config.json` coincida con tu entorno:

    ```json
    {
      "host": "localhost",
      "username": "webservice",
      "password": "webservice",
      "db": "hotel_webservice"
    }
    ```

4.  **Ejecutar**:
    Accede a `http://localhost/API_Hotel/`.

---

## 🔌 Documentación de la API

| Método   | Endpoint                | Acción          | Auth Requerida |
| :------- | :---------------------- | :-------------- | :------------- |
| `POST`   | `/api.php?action=login` | Iniciar Sesión  | No             |
| `GET`    | `/api.php`              | Listar Reservas | **Sí (Admin)** |
| `POST`   | `/api.php`              | Crear Reserva   | No             |
| `PUT`    | `/api.php`              | Editar Reserva  | **Sí (Admin)** |
| `DELETE` | `/api.php`              | Borrar Reserva  | **Sí (Admin)** |

---

## 🛡️ Credenciales de Prueba

Para acceder al panel de administración:

- **Usuario:** `webservice@hotel.com`
- **Contraseña:** `webservice`

---

## ⚠️ Solución de Problemas (Troubleshooting)

### Error #1034 - Clave de archivo erronea para la tabla: 'db'

Si al importar la base de datos recibes este error, significa que tu instalación de MySQL en XAMPP tiene archivos corruptos (común tras apagados inesperados).

**Solución:**

1.  En phpMyAdmin, importa el archivo `/database/repair_xampp.sql`.
2.  Si esto funciona, vuelve a importar `/database/schema.sql`.
3.  **Alternativa rápida:** Si no logras repararlo, edita `/config/config.json` y usa el usuario `root` (sin contraseña) y en `/database/schema.sql` borra las líneas de `CREATE USER` y `GRANT`.

---

## 👨‍💻 Autores

Desarrollado por **Gabriel Daniel Manea & Álex Vicente López**.
_Módulo: Desarrollo Web en Entorno Servidor_
