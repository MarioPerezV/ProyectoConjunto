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
/* $envFile = SITE_ROOT . '/.env';
if (file_exists($envFile)) {
    try { 
        $dotenv = Dotenv\Dotenv::createImmutable(SITE_ROOT);
        $dotenv->load();
    } catch (\Throwable $e) {
        error_log("Error al cargar .env: " . $e->getMessage());
    }
} else {
    error_log("No se encontró el archivo .env en: " . $envFile);
} */

// 4. Constantes de RUTA WEB (Ahora dinámicas)
// Se usa $_ENV['BASE_URL'] si existe, sino fallback a producción
$baseUrl = $_ENV['BASE_URL'] ?? 'https://agenciagaby.com/vm';
define('BASE_URL', rtrim($baseUrl, '/')); // Asegura que no tenga slash final extra
define('ASSETS_PATH', 'assets');

define('VIEW_PATH', APP_ROOT . '/vistas'); // Ruta centralizada a las vistas
define('UPLOAD_PATH', '/home2/mariope1/public_html/assets/uploads/articulos/'); // ¿línea obsoleta?
define('UPLOAD_URL_BASE', BASE_URL . '/assets/uploads/articulos/'); // Refactorizado para usar BASE_URL

setlocale(LC_NUMERIC, 'es_ES.utf8mb4');

// Configuración de base de datos (Cargada después del .env para que Conexion pueda usar $_ENV)
require_once __DIR__ . '/Conexion.php';

// Controladores principales (solo sus definiciones de clase, no su ejecución)
// require_once APP_ROOT . '/controladores/WebhookController.php';
