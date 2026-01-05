CREATE DATABASE IF NOT EXISTS hotel_webservice;

USE hotel_webservice;

-- Tabla de usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
    `id` int(10) NOT NULL AUTO_INCREMENT,
    `nombre` varchar(30) NOT NULL,
    `apellidos` varchar(50) NOT NULL,
    `email` varchar(50) NOT NULL UNIQUE,
    `password` varchar(255) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_spanish_ci;

-- Tabla de reservas
CREATE TABLE IF NOT EXISTS `reservas` (
    `id` int(10) NOT NULL AUTO_INCREMENT,
    `usuario_id` int(10) NOT NULL,
    `fecha_entrada` date NOT NULL,
    `fecha_salida` date NOT NULL,
    `habitacion` int(5) NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`usuario_id`) REFERENCES usuarios (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_spanish_ci;

-- Creación de usuario del servicio
CREATE USER IF NOT EXISTS 'webservice' @'%' IDENTIFIED BY 'webservice';

GRANT
SELECT,
INSERT
,
UPDATE,
DELETE ON hotel_webservice.* TO 'webservice' @'%';

-- Insertamos al admin con la contraseña 'webservice' cifrada
INSERT INTO
    usuarios (
        nombre,
        apellidos,
        email,
        password
    )
VALUES (
        'Admin',
        'Sistema',
        'webservice@hotel.com',
        '$2y$10$oIx3AndMvNNdXY4uoiKe8OR7/gSr4qJ1KJN3ixnYIz8vAVDIluNxu'
    );