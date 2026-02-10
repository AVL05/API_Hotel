-- Script de Reparación para XAMPP/MySQL
-- Ejecuta este script si recibes el error #1034 "Clave de archivo erronea para la tabla: 'db'"
-- Esto repara las tablas de permisos del sistema que suelen corromperse en XAMPP.

USE mysql;

REPAIR TABLE db;
REPAIR TABLE user;
REPAIR TABLE tables_priv;
REPAIR TABLE columns_priv;
REPAIR TABLE procs_priv;
REPAIR TABLE proxies_priv;

FLUSH PRIVILEGES;

-- Una vez ejecutado esto, vuelve a importar el archivo schema.sql
