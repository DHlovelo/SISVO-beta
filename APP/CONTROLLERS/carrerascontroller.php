<?php
class CarrerasController {
    public function index() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // 1. Conexión segura a la Base de Datos
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
                die("Error de conexión a la Base de Datos: " . $e->getMessage());
            }
        }

        $carrerasPublicas = [];
        try {
            $sql = "SELECT c.*, s.nombre_sede, s.ciudad, s.direccion, s.telefono_sede, s.url_maps,
                           COALESCE(i.nombre_institucion, i.nombre, 'Institución Aliada') AS nombre_institucion,
                           COALESCE(i.tipo_institucion, 'Privada') AS tipo_institucion,
                           COALESCE(i.sitio_web, '#') AS sitio_web
                    FROM carreras c 
                    LEFT JOIN sedes s ON c.id_sede = s.id_sede 
                    LEFT JOIN instituciones i ON c.CI_usu = i.CI_usu OR c.CI_usu = i.ci
                    ORDER BY c.id_carrera DESC";
            
            $stmt = $pdo->query($sql);
            $carrerasPublicas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            $carrerasPublicas = [];
        }

        // Pasamos los datos a la variable global para que los tome la vista
        $GLOBALS['carrerasPublicas'] = $carrerasPublicas;
        $_GET['route'] = 'carreras'; // Asegura la ruta activa en el menú

        // 2. Cargamos el layout principal de la aplicación (igual que en Instituciones)
        $layoutPath = __DIR__ . '/../../VIEWS/layouts/app_layout.php';
        $layoutMin = __DIR__ . '/../../views/layouts/app_layout.php';

        if (file_exists($layoutPath)) {
            require_once $layoutPath;
        } elseif (file_exists($layoutMin)) {
            require_once $layoutMin;
        } else {
            // Si por alguna razón no encuentra el layout, carga la vista directa
            require_once __DIR__ . '/../../VIEWS/CARRERAS/index.php';
        }
    }
}