<?php
class SedeController {
    public function index() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Requerimos la conexión
        require_once __DIR__ . '/../../CONFIG/sisvo_conexion.php';
        global $pdo;

        // Si $pdo no está definido, lo creamos de forma directa
        if (!isset($pdo) || $pdo === null) {
            $host = 'localhost';
            $dbname = 'sisvo'; // Asegúrate que sea el nombre exacto de tu base de datos
            $username = 'root';
            $password = '';
            try {
                $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Error crítico de conexión BD: " . $e->getMessage());
            }
        }

        // Consulta directa y sencilla a la tabla sedes sin bloque try/catch para ver si hay errores
        $stmt = $pdo->query("SELECT * FROM sedes ORDER BY id_sede DESC");
        $sedesPublicas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Pasamos las sedes a la variable global para la vista
        $GLOBALS['sedesPublicas'] = $sedesPublicas;
        $_GET['route'] = 'instituciones';

        // Cargamos la vista pública
        $layoutPath = __DIR__ . '/../../VIEWS/layouts/app_layout.php';
        if (file_exists($layoutPath)) {
            require_once $layoutPath;
        } else {
            // Ruta alternativa por si acaso
            $altPath = __DIR__ . '/../../views/layouts/app_layout.php';
            if (file_exists($altPath)) {
                require_once $altPath;
            } else {
                // Si no encuentra el layout, cargamos directamente la vista de instituciones
                require_once __DIR__ . '/../../VIEWS/INSTITUCIONES/instituciones.php';
            }
        }
    }
}