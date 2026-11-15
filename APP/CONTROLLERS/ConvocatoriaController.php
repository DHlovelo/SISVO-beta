<?php
class ConvocatoriaController {
    public function index() {
        // 1. Incluimos la conexión a la base de datos asegurando la ruta
        require_once __DIR__ . '/../../CONFIG/sisvo_conexion.php';

        // Respaldo por si $pdo no se define globalmente
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

        // 2. Consultamos las convocatorias y las becas uniendo con la tabla instituciones
        try {
            $stmtConv = $pdo->query("SELECT c.*, i.nombre_institucion FROM convocatorias c JOIN instituciones i ON c.CI_usu = i.CI_usu ORDER BY c.created_at DESC");
            $convocatorias = $stmtConv->fetchAll(PDO::FETCH_ASSOC);

            $stmtBecas = $pdo->query("SELECT b.*, i.nombre_institucion FROM becas b JOIN instituciones i ON b.CI_usu = i.CI_usu ORDER BY b.created_at DESC");
            $becas = $stmtBecas->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            $convocatorias = [];
            $becas = [];
        }

        // 3. Definimos correctamente la ruta de la vista
        $viewPath = __DIR__ . '/../../VIEWS/CONVOCATORIAS/index.php';
        
        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            echo "Error crítico: No se encuentra la vista de convocatorias en: " . $viewPath;
        }
    }
}