<?php
// Configuración de la base de datos
$configFile = __DIR__ . '/config.json';

if (!file_exists($configFile)) {
    // Si no existe, intentamos buscar en la ruta antigua por compatibilidad o lanzamos error
    die("Error Crítico: No se encuentra el archivo de configuración en: " . $configFile);
}

$dbConfig = json_decode(file_get_contents($configFile), true);

function conectar()
{
    global $dbConfig;
    try {
        $dsn = "mysql:host={$dbConfig['host']};dbname={$dbConfig['db']};charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        return new PDO($dsn, $dbConfig['username'], $dbConfig['password'], $options);
    } catch (PDOException $e) {
        http_response_code(500);
        // En producción nunca mostrar detalles del error al usuario final
        error_log($e->getMessage()); 
        exit(json_encode(["error" => "Error de conexión con la base de datos."]));
    }
}
?>
