<?php // --- INICIO DE SESIÓN --- git
// Es crucial iniciar la sesión ANTES de cualquier otra cosa para evitar errores de "headers already sent".
require_once __DIR__ . '/SessionManager.php';

$sessionManager = SessionManager::getInstance();

ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../../error_log.log');
error_reporting(E_ALL);
// --- Definición de constantes ---

// 1. Constantes de RUTA DE SERVIDOR (Prioritarias para cargar .env)
define('APP_ROOT', realpath(dirname(__DIR__))); // Ruta al directorio /app absoluto
define('SITE_ROOT', realpath(dirname(APP_ROOT))); // Ruta al directorio raíz absoluto

// 2. Cargar Autoload (Necesario para Dotenv y otras librerías)
// require_once SITE_ROOT . '/vendor/autoload.php';

// 3. Cargar las variables de entorno desde el archivo .env
$envFile = APP_ROOT . '/app/.env';
if (file_exists($envFile)) {
    try {
        // Primero intentamos cargar con putenv si es necesario para $_ENV
        $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0)
                continue;
            list($name, $value) = explode('=', $line, 2);
            $name = trim($name);
            $value = trim($value);
            if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
                putenv(sprintf('%s=%s', $name, $value));
                $_ENV[$name] = $value;
                $_SERVER[$name] = $value;
            }
        }
    }
    catch (\Throwable $e) {
        error_log("Error al cargar .env: " . $e->getMessage());
    }
}
else {
    error_log("No se encontró el archivo .env en: " . $envFile);
}

// 4. Constantes de RUTA WEB (Ahora dinámicas)
// Se usa $_ENV['BASE_URL'] si existe, sino fallback a producción
$baseUrl = $_ENV['BASE_URL'] ?? 'https://agenciagaby.com/mv';
define('BASE_URL', rtrim($baseUrl, '/')); // Asegura que no tenga slash final extra
define('CHATBOT_API_URL', $_ENV['CHATBOT_API_URL'] ?? 'http://localhost:8000/api/chat');
define('ASSETS_PATH', BASE_URL . '/frontend/assets');

define('VIEW_PATH', APP_ROOT . '/frontend/vistas'); // Ruta centralizada a las vistas

setlocale(LC_NUMERIC, 'es_ES.utf8mb4');

// Configuración de base de datos (Cargada después del .env para que Conexion pueda usar $_ENV)
require_once __DIR__ . '/Conexion.php';

// Controladores principales (solo sus definiciones de clase, no su ejecución)
// require_once APP_ROOT . '/controladores/WebhookController.php';
