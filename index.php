<?php
// Cargar todas las configuraciones básicas
require_once __DIR__ . '/config/bootstrap.php';

// Router simple
$action = $_GET['action'] ?? 'index';

// Instanciar controladores y SessionManager
$sessionManager = SessionManager::getInstance();

switch ($action) {
    case 'inicio':
        // Cargar datos para la vista de inicio
        include VIEW_PATH . '/inicio.php';
        break;

    case 'terminos':
        include VIEW_PATH . '/terminos.php';
        break;

    case 'privacidad':
        include VIEW_PATH . '/privacidad.php';
        break;

    case 'consulta':
        include VIEW_PATH . '/consulta.php';
        break;

    case 'mailer':
        $mailerController = new MailerController();
        $mailerController->enviarEmailEvaluacion();
        break;
        

    default:
        // Cargar datos para la vista de inicio por defecto
        include VIEW_PATH . '/inicio.php';
        break;
}