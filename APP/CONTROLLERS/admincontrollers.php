<?php
require_once __DIR__ . '/../helpers/auth.php'; 

class AdminController {

    public function __construct() {
        verificarRol('admin');
    }

    public function index() {
        require_once __DIR__ . '/../../views/admin/dashboard.php';
    }

    //----listar o gestionar usuarios
    public function gestionarUsuarios() {
        // Lógica para obtener usuarios...
        require_once __DIR__ . '/../../views/admin/usuarios.php';
    }

    //----aprobar o administrar instituciones
    public function gestionarInstituciones() {
        require_once __DIR__ . '/../../views/admin/instituciones.php';
    }
}
