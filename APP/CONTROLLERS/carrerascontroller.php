<?php
// app/Controllers/CarrerasController.php

class CarrerasController {
    public function index() {
        // Verificar si la sesión está activa
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Proteger la ruta (si no ha iniciado sesión, lo manda al login)
        if (!isset($_SESSION['CI_usu'])) {
            header('Location: /SISVOX/public/index.php?route=login');
            exit;
        }

        // Ruta absoluta hacia tu vista de carreras
        $viewPath = __DIR__ . '/../../views/carreras/index.php';

        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            echo "Error crítico: No se encuentra la vista de carreras en: " . $viewPath;
        }
    }
}