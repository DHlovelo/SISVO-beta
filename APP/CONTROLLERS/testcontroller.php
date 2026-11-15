<?php
// app/Controllers/TestController.php

class TestController {
    public function index() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $_GET['route'] = 'test';
        require_once __DIR__ . '/../../views/layouts/app_layout.php';
    }
}