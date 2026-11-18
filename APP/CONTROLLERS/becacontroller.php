<?php
class BecaController {
    public function index() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

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

        $becas = [];
        try {
            $stmtBecas = $pdo->query("SELECT b.*, COALESCE(i.nombre_institucion, 'Institución Aliada') AS nombre_institucion 
                                      FROM becas b 
                                      LEFT JOIN instituciones i ON b.CI_usu = i.CI_usu 
                                      ORDER BY b.created_at DESC");
            $becas = $stmtBecas->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            $becas = [];
        }

        $GLOBALS['becas'] = $becas;

        $_GET['route'] = 'becas';

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