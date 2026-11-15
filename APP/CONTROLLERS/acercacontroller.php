<?php
class AcercaController {
    public function index() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['CI_usu'])) {
            header('Location: /SISVOX/public/index.php?route=login');
            exit;
        }
        require_once __DIR__ . '/../../views/acerca/index.php';
    }
}