-- Database Initialization Script
-- Project: Hotel Paradise API
-- Version: 2.0.0
-- Author: Gabi & Alex (Professional Edition)

CREATE DATABASE IF NOT EXISTS hotel_webservice CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE hotel_webservice;

SET FOREIGN_KEY_CHECKS = 0; -- Disable foreign key checks for dropping tables

-- 1. Drop existing tables to ensure clean slate
DROP TABLE IF EXISTS `reservas`;
DROP TABLE IF EXISTS `usuarios`;
DROP TABLE IF EXISTS `habitaciones`;

SET FOREIGN_KEY_CHECKS = 1; -- Re-enable foreign key checks

-- 2. Create Users Table (Admins & Guests)
CREATE TABLE `usuarios` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `nombre` VARCHAR(50) NOT NULL,
    `apellidos` VARCHAR(100) NOT NULL,
    `email` VARCHAR(100) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `rol` ENUM('admin', 'cliente') DEFAULT 'cliente',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Create Rooms/Types Table (Normalization)
CREATE TABLE `habitaciones` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `nombre` VARCHAR(50) NOT NULL, -- e.g., 'Suite Presidencial'
    `descripcion` TEXT,
    `precio_base` DECIMAL(10, 2) NOT NULL,
    `capacidad` INT(3) NOT NULL,
    `imagen_url` VARCHAR(255),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Create Reservations Table
CREATE TABLE `reservas` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `usuario_id` INT(11) UNSIGNED NOT NULL,
    `habitacion_id` INT(11) UNSIGNED DEFAULT NULL, -- Nullable if room is assigned later or free text
    `habitacion_numero` INT(5) NOT NULL, -- Logical room number (legacy field kept for compatibility or specific room assignment)
    `fecha_entrada` DATE NOT NULL,
    `fecha_salida` DATE NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`usuario_id`) REFERENCES `usuarios`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`habitacion_id`) REFERENCES `habitaciones`(`id`) ON DELETE SET NULL,
    CONSTRAINT `chk_fechas` CHECK (`fecha_salida` > `fecha_entrada`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. Create Service User (Webservice)
CREATE USER IF NOT EXISTS 'webservice'@'%' IDENTIFIED BY 'webservice';
GRANT ALL PRIVILEGES ON hotel_webservice.* TO 'webservice'@'%';
FLUSH PRIVILEGES;

-- 6. Seed Initial Data
-- Admin User
INSERT INTO `usuarios` (`nombre`, `apellidos`, `email`, `password`, `rol`) VALUES
('Admin', 'Sistema', 'webservice@hotel.com', '$2y$10$oIx3AndMvNNdXY4uoiKe8OR7/gSr4qJ1KJN3ixnYIz8vAVDIluNxu', 'admin'); -- Pass: webservice

-- Room Types
INSERT INTO `habitaciones` (`id`, `nombre`, `descripcion`, `precio_base`, `capacidad`) VALUES
(1, 'Suite Presidencial', 'Lujo supremo con jacuzzi y vistas panorámicas.', 350.00, 2),
(2, 'Habitación Deluxe', 'Confort elegante con todas las comodidades.', 180.00, 2),
(3, 'Junior Suite', 'Ideal para familias o largas estancias.', 240.00, 4);

-- Sample Reservation
INSERT INTO `reservas` (`usuario_id`, `habitacion_id`, `habitacion_numero`, `fecha_entrada`, `fecha_salida`) VALUES
(1, 1, 501, DATE_ADD(CURRENT_DATE, INTERVAL 5 DAY), DATE_ADD(CURRENT_DATE, INTERVAL 10 DAY));
