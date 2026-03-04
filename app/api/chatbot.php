<?php
/* El chatbot esta dividido en 3 partes: la api (donde estamos), el footer (que incluye el css), 
en inicio.php agregado al script existente de JS + más la función buscarArticulosPorNombre($userMessageLower) 
en ArticuloModel (chatbot.php es practicamente un controlador), ChatbotModel.php y el sql
CONDICIONES: 
* todos los articulos deben tener nombre único porque las búsquedas estan relacionadas con lastProductId (solo uno) */

// Incluir tu archivo de configuración (para BASE_URL, UPLOAD_URL_BASE, etc.)
// y tu modelo de Artículos. Ajusta las rutas según tu estructura.
require_once __DIR__ . '/../config/bootstrap.php';
require_once __DIR__ . '/../modelos/ServicioModel.php'; // LINEA 11
require_once __DIR__ . '/../modelos/ChatbotModel.php';

// Asegura que la respuesta sea JSON
header('Content-Type: application/json');

// Obtener el mensaje del usuario y el contexto del frontend
$input = json_decode(file_get_contents('php://input'), true);
$userMessage = strtolower(trim($input['message'] ?? '')); 
$context = $input['context'] ?? [];

// Inicializar el modelo de servicio con la conexión a la BD
$servicioModel = new ServicioModel();

// Inicializamos la respuesta. Por defecto, asumimos que mostraremos los botones, a menos que una lógica posterior identifique un servicio específico.
$response = [
    'message' => '¡Hola! Soy tu asistente. ¿En qué servicio estás interesado? Puedes seleccionar una de las opciones a continuación:',
    'type' => 'options', // Nuevo tipo para indicar al frontend que renderice botones
    'options' => [
        ['text' => 'Infraestructura Digital Esencial', 'value' => 'ver_servicio_1'],
        ['text' => 'Solución de Venta Online', 'value' => 'ver_servicio_2'],
        ['text' => 'Inteligencia Operacional y Automatización con Chatbots', 'value' => 'ver_servicio_3']
    ],
    'context' => $context
];

// --- Lógica para identificar si el usuario seleccionó un servicio ---
$foundService = null;

// Intentar encontrar un servicio por el "valor" de los botones
if ($userMessage === 'ver_servicio_1') {
    $foundService = $servicioModel->obtenerServicioPorId(1);
} elseif ($userMessage === 'ver_servicio_2') {
    $foundService = $servicioModel->obtenerServicioPorId(2);
} elseif ($userMessage === 'ver_servicio_3') {
    $foundService = $servicioModel->obtenerServicioPorId(3);
}
// --- Si se encontró un servicio, construir la respuesta detallada ---
if ($foundService) {
    $messageText = "Aquí tienes la descripción del servicio <b>{$foundService['nombre_servicio']}</b>:<br>
    <br>{$foundService['descripcion_completa']}";
    // Asumimos 'clp' como moneda por defecto para la respuesta del bot.
    // Podrías pasar la moneda desde el frontend en el contexto si necesitas dinamismo aquí.
    $currency = 'clp'; 

    $priceInfo = [];
    if ($foundService['precio_pago_unico_' . $currency] !== null) {
        $priceInfo[] = "Pago único: $" . number_format($foundService['precio_pago_unico_' . $currency], 0, ',', '.');
    }
    if ($foundService['precio_mantencion_mensual_' . $currency] !== null) {
        $mantencionText = "Mantención mensual: $" . number_format($foundService['precio_mantencion_mensual_' . $currency], 0, ',', '.');
        if ($foundService['duracion_gratis_mantencion_meses'] > 0) {
            $mantencionText .= " (gratis por {$foundService['duracion_gratis_mantencion_meses']} meses)";
        }
        if ($foundService['precio_oferta'] > 0) {
            $mantencionText .= " <br><br>Apoyamos a microemprendimientos con una oferta de <b>$ " . number_format($foundService['precio_oferta'], 0, ',', '.') . " </b>/mes <br>(cupos limitados)";
        }
        $priceInfo[] = $mantencionText;
    }

    if (!empty($priceInfo)) {
        $messageText .= "<br><br><strong>Precios en CLP:</strong><br>" . implode('<br>', $priceInfo) . "<br>";
    }    
    $response = [   // Aquí se arma la respuesta
        'type' => 'rich', 
        'message_data' => [
            'text' => $messageText,
        ],
        'context' => $context
    ];

} else if (!empty($userMessage) && !in_array($userMessage, ['hola', 'costo', 'precio', 'valor',
        'hi', 'saludos', 'que tal', 'servicios', 'ayuda'])) {
    // Si el usuario escribió algo que no es una selección de botón y no se encontró servicio, se le puede dar una respuesta que lo redirija a los botones.
    $response['message'] = 'No estoy entrenado para responder tu consulta específica. Si quieres selecciona uno de nuestros servicios o pregunta por ellos.';
    // $response['type'] = 'text'; // Cambia el tipo a 'text' para esta respuesta.
    // Opcional: podrías incluso volver a enviar los botones aquí si lo deseas
    $response['options'] = [
        ['text' => 'Infraestructura Digital Esencial', 'value' => 'ver_servicio_1'],
        ['text' => 'Solución de Venta Online', 'value' => 'ver_servicio_2'],
        ['text' => 'Inteligencia Operacional y Automatización con Chatbots', 'value' => 'ver_servicio_3']
    ];
    $response['type'] = 'options';
}
// Si $userMessage estaba vacío o era una bienvenida, la $response por defecto (con los botones) se mantiene.
echo json_encode($response);