<?php
class InstitucionController {
    public function index() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // 1. Incluimos la conexión a la base de datos
        require_once __DIR__ . '/../../CONFIG/sisvo_conexion.php';
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

        // 2. Consultamos todas las instituciones registradas
        $instituciones = [];
        try {
            $stmt = $pdo->query("SELECT * FROM instituciones ORDER BY nombre_institucion ASC");
            $instituciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            $instituciones = [];
        }

        // 3. Blindamos los datos en GLOBALS por seguridad del layout
        $GLOBALS['instituciones'] = $instituciones;

        // 4. Indicamos la ruta actual para el layout
        $_GET['route'] = 'instituciones';

        // 5. Cargamos el layout principal (barra de navegación superior)
        $layoutPath = __DIR__ . '/../../VIEWS/layouts/app_layout.php';
        
        if (file_exists($layoutPath)) {
            require_once $layoutPath;
        } else {
            $layoutPathAlt = __DIR__ . '/../../views/layouts/app_layout.php';
            if (file_exists($layoutPathAlt)) {
                require_once $layoutPathAlt;
            } else {
                echo "Error crítico: No se encuentra el layout principal.";
            }
        }
    }
}