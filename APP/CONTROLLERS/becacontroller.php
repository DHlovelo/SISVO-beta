<?php
// app/Controllers/BecaController.php

class BecaController {
    public function index() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // 1. Incluir la conexión a la base de datos
        require_once __DIR__ . '/../../config/sisvo_conexion.php'; 
        global $pdo;

        if (!isset($pdo)) {
            $host = 'localhost';
            $dbname = 'sisvo';
            $username = 'root';
            $password = '';
            try {
                $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Error de conexión: " . $e->getMessage());
            }
        }

        $becas = [];
        try {
            // 2. Preparar la consulta
            $stmt = $pdo->prepare("SELECT b.*, i.nombre_institucion FROM becas b JOIN instituciones i ON b.CI_usu = i.CI_usu ORDER BY b.created_at DESC");
            
            // 3. LLAMAR CORRECTAMENTE A EXECUTE USANDO $stmt->
            $stmt->execute(); 
            
            $becas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            $becas = [];
        }

        $_GET['route'] = 'becas';
        
        // 4. Cargar el layout (la variable $becas ya estará disponible para la vista)
        require_once __DIR__ . '/../../views/layouts/app_layout.php';
    }
}