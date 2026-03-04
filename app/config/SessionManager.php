<?php

class SessionManager {
    private static $instance = null;
    private $tiempo_inactividad = 3600; // 1 hora en segundos

    private function __construct() {
        // Configuración de sesión
        ini_set('session.cookie_lifetime', $this->tiempo_inactividad);
        ini_set('session.gc_maxlifetime', $this->tiempo_inactividad);
        session_set_cookie_params($this->tiempo_inactividad);

        // Iniciar o reanudar la sesión
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }        

        // 1. Verificar si la sesión ha expirado por inactividad.
        $this->verificarExpiracionSesion();

        // 2. Si la sesión fue destruida (o es nueva), inicializarla.
        // Inicializar usuario visitante si no existe sesión
        if (!isset($_SESSION['user'])) {
            $_SESSION['user'] = $this->getDefaultUser();
        }

        // 3. Asegurarse de que siempre haya un token CSRF.
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
    }
    
    public function obtenerUsuarioActual() {
        return $_SESSION['user'] ?? $this->getDefaultUser();
    }

    private function getDefaultUser() {
        return [
            'id' => null,
            'nombre' => 'visitante',
            'categoria' => 'visitante',
            'email' => null,
            'last_activity' => time()
        ];
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function verificarExpiracionSesion() {
        // Solo verificar si hay un usuario logueado (no visitante)
        if (isset($_SESSION['user']['id'])) {
            if (isset($_SESSION['user']['last_activity']) && (time() - $_SESSION['user']['last_activity'] > $this->tiempo_inactividad)) {
                // La sesión ha expirado, la destruimos.
                $this->destruirSesion(); // Esto limpiará todo, incluido el token.
                // No redirigimos aquí, dejamos que el constructor regenere una sesión de visitante.
                // Si se requiere login forzoso, la redirección debe hacerse en las páginas protegidas.
            } else {
                // Si la sesión es válida, actualizamos el tiempo de actividad.
                $_SESSION['user']['last_activity'] = time();
            }
        }
    }

    public function regenerarToken() {
        // Esta función permite regenerar el token después de un login exitoso o al procesar un formulario.
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    public function destruirSesion() {
        session_unset();
        session_destroy();
    }

    public function iniciarSesion($usuario) {
        session_regenerate_id(true); // Previene session fixation
        $_SESSION['user'] = [
            'id' => $usuario['id'],
            'nombre' => $usuario['nombre'],
            'categoria' => $usuario['categoria'],
            'email' => $usuario['email'],
            'last_activity' => time()
        ];
        // Regenerar el token CSRF después de iniciar sesión para mayor seguridad.
        $this->regenerarToken();
    }

    public function establecerMensaje($tipo, $texto) {
        $_SESSION['mensaje'] = [
            'tipo' => $tipo,
            'texto' => $texto
        ];
    }

    /**
     * Establece el ID del vendedor que un admin está viendo.
     * @param int $vendedor_id
     */
    public function setViewingContext($vendedor_id) {
        $_SESSION['viewing_vendedor_id'] = $vendedor_id;
    }

    /**
     * Limpia el contexto de visualización del vendedor.
     */
    public function clearViewingContext() {
        unset($_SESSION['viewing_vendedor_id']);
    }

    /**
     * Obtiene el ID del vendedor que se está viendo, si existe.
     * @return int|null
     */
    public function getViewingContext() {
        return $_SESSION['viewing_vendedor_id'] ?? null;
    }
} 