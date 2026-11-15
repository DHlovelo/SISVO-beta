<?php
// app/Controllers/BecaController.php

class BecaController {
    public function index() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $_GET['route'] = 'becas';
        require_once __DIR__ . '/../../views/layouts/app_layout.php';
    }
}