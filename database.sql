CREATE DATABASE IF NOT EXISTS hotel_webservice;
USE hotel_webservice;

-- Tabla de usuarios (Siguiendo el modelo de la pág 17)
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL UNIQUE,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- Tabla de reservas
CREATE TABLE IF NOT EXISTS `reservas` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(10) NOT NULL,
  `fecha_entrada` date NOT NULL,
  `fecha_salida` date NOT NULL,
  `habitacion` int(5) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`usuario_id`) REFERENCES usuarios(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- Creación de usuario del servicio (pág 18)
CREATE USER IF NOT EXISTS 'webservice'@'%' IDENTIFIED BY 'webservice';
GRANT SELECT, INSERT, UPDATE, DELETE ON hotel_webservice.* TO 'webservice'@'%';