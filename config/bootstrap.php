<?php // --- INICIO DE SESIÓN --- git
// Es crucial iniciar la sesión ANTES de cualquier otra cosa para evitar errores de "headers already sent".
require_once __DIR__ . '/SessionManager.php';

$sessionManager = SessionManager::getInstance();

ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../error_log.log');
error_reporting(E_ALL);

// --- 1. Definición de constantes de RUTA FÍSICA ---
// Se definen aquí para que puedan ser usadas inmediatamente, especialmente para encontrar el archivo .env

// PROJECT_ROOT_PATH es la ruta raíz del proyecto (la carpeta 'vm').
define('PROJECT_ROOT_PATH', realpath(dirname(__DIR__)));

// Compatibilidad con código existente que pueda usar estas constantes.
define('APP_ROOT', PROJECT_ROOT_PATH); 
define('SITE_ROOT', dirname(PROJECT_ROOT_PATH)); // Directorio padre del proyecto.

// 2. Cargar Autoload (Necesario para Dotenv y otras librerías)
// require_once PROJECT_ROOT_PATH . '/vendor/autoload.php';

// 3. Cargar las variables de entorno desde el archivo .env
$envFile = PROJECT_ROOT_PATH . '/.env'; // El archivo .env debe estar en la raíz del proyecto ('vm').
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
            // Limpieza de seguridad: Eliminar comillas simples o dobles al inicio y final
            $value = trim($value, "'\"");
            
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

// 2. RUTA WEB (URL): Para el navegador (src, href, links)
$baseUrl = $_ENV['BASE_URL'] ?? 'https://agenciagaby.com/vm';
define('BASE_URL', rtrim($baseUrl, '/')); // Asegura que no tenga slash final extra

define('CHATBOT_API_URL', $_ENV['CHATBOT_API_URL'] ?? 'https://91a8-204-199-128-4.ngrok-free.app/api/chat');

// 3. ASSETS: Rutas web específicas para imágenes y estáticos
define('ASSETS_PATH', BASE_URL . '/frontend/assets');
define('VIEW_PATH', PROJECT_ROOT_PATH . '/frontend/vistas'); // Ruta física para incluir vistas

setlocale(LC_NUMERIC, 'es_ES.utf8mb4');

// Configuración de base de datos (Cargada después del .env para que Conexion pueda usar $_ENV)
require_once __DIR__ . '/Conexion.php';

// Controladores principales (solo sus definiciones de clase, no su ejecución)
require_once PROJECT_ROOT_PATH . '/controller/MailerController.php';