<?php
class Conexion {
    private static $db;

    public static function conectar() {
        if (!isset(self::$db)) {
            try {
                $host = $_ENV['DB_HOST'] ?? null;
                $dbname = $_ENV['DB_NAME'] ?? null;
                $user = $_ENV['DB_USER'] ?? null;
                $pass = $_ENV['DB_PASS'] ?? null;
                
                self::$db = new PDO(
                    "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
                    $user,
                    $pass,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_PERSISTENT => true, // Conexiones persistentes
                        // Verificar si la constante existe para evitar errores en entornos donde no está definida
                        defined('PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT') ? PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT : 1014 => true
                    ]
                );
            } catch (PDOException $e) {
                $errorDetails = [
                    'message' => $e->getMessage(),
                    'code' => $e->getCode(),
                    'trace' => $e->getTraceAsString(),
                    'timestamp' => date('Y-m-d H:i:s')
                ];                
                error_log("Fallo de conexión PDO: " . json_encode($errorDetails));                
                // Mensaje seguro para producción
                throw new Exception("Error crítico: No se pudo conectar al sistema. Código: DB".time());
            }
        }
        return self::$db;
    }
}