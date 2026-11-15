<?php
// app/Controllers/InstitucionController.php

class InstitucionController {
    public function index() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Carga tu vista gráfica intacta de instituciones
        require_once __DIR__ . '/../../views/instituciones/index.php';
    }
}