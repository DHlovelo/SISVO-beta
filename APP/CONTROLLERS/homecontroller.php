<?php
// app/Controllers/HomeController.php

class HomeController {
    public function index() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['CI_usu'])) {
            header('Location: /SISVOX/PUBLIC/index.php?route=login');
            exit;
        }

        // Definimos qué vista interna va a mostrar el layout
        $vistaInterna = __DIR__ . '/../../views/inicio_estudiante.php';
        
        // Ruta absoluta del layout principal
        $layoutPath = __DIR__ . '/../../views/layouts/app_layout.php';
        
        if (file_exists($layoutPath)) {
            require_once $layoutPath;
        } else {
            echo "Error crítico: No se encuentra el archivo de layout en: " . $layoutPath;
        }
    }
}