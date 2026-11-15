<?php
// app/Controllers/AdminController.php

// Asegúrate de incluir tu helper de autenticación
require_once __DIR__ . '/../helpers/auth.php'; 

class AdminController {

    public function __construct() {
        // Protege automáticamente cualquier método de este controlador.
        // Si no es 'admin', lo redirige al login o al home según tu auth.php
        verificarRol('admin');
    }

    // Método para mostrar el panel principal del Administrador
    public function index() {
        // No necesitas repetir verificarRol aquí, ya se ejecutó en el constructor
        require_once __DIR__ . '/../../views/admin/dashboard.php';
    }

    // Método para listar o gestionar usuarios
    public function gestionarUsuarios() {
        // Lógica para obtener usuarios...
        require_once __DIR__ . '/../../views/admin/usuarios.php';
    }

    // Método para aprobar o administrar instituciones
    public function gestionarInstituciones() {
        // Lógica para instituciones...
        require_once __DIR__ . '/../../views/admin/instituciones.php';
    }
}
