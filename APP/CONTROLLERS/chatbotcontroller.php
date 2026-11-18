<?php
class ChatbotController {

    public function index() {
        // Opcional: Validar que el usuario haya iniciado sesión si el chat es privado
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        require_once __DIR__ . '/../../views/chatbot/index.php';
    }

    public function responder() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $mensajeUsuario = strtolower(trim($_POST['mensaje'] ?? ''));

            $respuesta = "Lo siento, no entendí tu pregunta. ¿Puedes reformularla sobre orientación vocacional o becas?";

            if (strpos($mensajeUsuario, 'hola') !== false) {
                $respuesta = "¡Hola! Soy el asistente virtual de SISVOX. ¿En qué puedo ayudarte hoy con tu vocación o tus estudios?";
            } elseif (strpos($mensajeUsuario, 'becas') !== false) {
                $respuesta = "Puedes revisar la sección de becas disponibles en nuestro menú principal para ver los requisitos y fechas de postulación.";
            } elseif (strpos($mensajeUsuario, 'carreras') !== false) {
                $respuesta = "SISVOX te ayuda a evaluar tus opciones profesionales mediante nuestros tests vocacionales.";
            }

            header('Content-Type: application/json');
            echo json_encode(['respuesta' => $respuesta]);
            exit;
        }
    }
}