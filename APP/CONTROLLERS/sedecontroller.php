<?php
class SedeController {
    public function index() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        require_once __DIR__ . '/../../CONFIG/sisvo_conexion.php';
        global $pdo;

        if (!isset($pdo) || $pdo === null) {
            $host = 'localhost';
            $dbname = 'sisvo';
            $username = 'root';
            $password = '';
            try {
                $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Error crítico de conexión BD: " . $e->getMessage());
            }
        }

        $stmt = $pdo->query("SELECT * FROM sedes ORDER BY id_sede DESC");
        $sedesPublicas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $GLOBALS['sedesPublicas'] = $sedesPublicas;
        $_GET['route'] = 'instituciones';

        $layoutPath = __DIR__ . '/../../VIEWS/layouts/app_layout.php';
        if (file_exists($layoutPath)) {
            require_once $layoutPath;
        } else {
            $altPath = __DIR__ . '/../../views/layouts/app_layout.php';
            if (file_exists($altPath)) {
                require_once $altPath;
            } else {
                require_once __DIR__ . '/../../VIEWS/INSTITUCIONES/instituciones.php';
            }
        }
    }
}