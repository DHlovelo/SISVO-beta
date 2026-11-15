<?php
// APP/CONTROLLERS/PanelInstitucionController.php

class PanelInstitucionController
{
    private function verificarRolInstitucion()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Validar que haya sesión iniciada y que el rol sea 'institucion'
        if (!isset($_SESSION['CI_usu']) || ($_SESSION['user_rol'] ?? '') !== 'institucion') {
            header("Location: /SISVOX/PUBLIC/index.php?route=login");
            exit();
        }
    }

    private function obtenerConexion()
    {
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
        return $pdo;
    }

    // Vista exclusiva para Convocatorias
    public function convocatorias()
    {
        $this->verificarRolInstitucion();
        $ciUsu = $_SESSION['CI_usu'] ?? '';
        $pdo = $this->obtenerConexion();

        $convocatorias = [];
        try {
            if (!empty($ciUsu)) {
                $stmtConv = $pdo->prepare("SELECT c.*, i.nombre_institucion FROM convocatorias c JOIN instituciones i ON c.CI_usu = i.CI_usu WHERE c.CI_usu = ? ORDER BY c.created_at DESC");
                $stmtConv->execute([$ciUsu]);
                $convocatorias = $stmtConv->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (Exception $e) {
            $convocatorias = [];
        }

        $viewPath = __DIR__ . '/../../VIEWS/INSTITUCIONES_PANEL/convocatorias.php';
        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            echo "Error crítico: No se encuentra la vista de convocatorias en: " . $viewPath;
        }
    }

    // Vista exclusiva para Becas
    // En APP/CONTROLLERS/PanelInstitucionController.php

    public function becas()
    {
        $this->verificarRolInstitucion();
        $ciUsu = $_SESSION['CI_usu'] ?? '';
        $pdo = $this->obtenerConexion();

        $becas = [];
        try {
            if (!empty($ciUsu)) {
                $stmtBecas = $pdo->prepare("SELECT b.*, i.nombre_institucion FROM becas b JOIN instituciones i ON b.CI_usu = i.CI_usu WHERE b.CI_usu = ? ORDER BY b.created_at DESC");
                $stmtBecas->execute([$ciUsu]);
                $becas = $stmtBecas->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (Exception $e) {
            $becas = [];
        }

        require_once __DIR__ . '/../../VIEWS/INSTITUCIONES_PANEL/becas.php';
    }

    // Mantener index apuntando por defecto a convocatorias o al panel general
    public function index()
    {
        $this->convocatorias();
    }

    // Guardar Convocatoria
    public function storeConvocatoria() 
    {
        $this->verificarRolInstitucion();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ciUsu = $_SESSION['CI_usu'] ?? ''; 
            
            $titulo = trim($_POST['titulo'] ?? '');
            $categoria = trim($_POST['categoria'] ?? '');
            $descripcion = trim($_POST['descripcion'] ?? '');
            $fechaCierre = $_POST['fecha_cierre'] ?? '';

            $pdo = $this->obtenerConexion();

            if (!empty($titulo) && !empty($categoria) && !empty($fechaCierre)) {
                $stmt = $pdo->prepare("INSERT INTO convocatorias (CI_usu, titulo, categoria, descripcion, fecha_cierre) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$ciUsu, $titulo, $categoria, $descripcion, $fechaCierre]);
                
                header("Location: /SISVOX/PUBLIC/index.php?route=institucion_convocatorias&exito=creado");
                exit();
            } else {
                header("Location: /SISVOX/PUBLIC/index.php?route=institucion_convocatorias&error=campos_vacios");
                exit();
            }
        }
    }

    // Guardar Beca
    public function storeBeca() 
    {
        $this->verificarRolInstitucion();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ciUsu = $_SESSION['CI_usu'] ?? ''; 
            
            $titulo = trim($_POST['titulo'] ?? '');
            $descripcion = trim($_POST['descripcion'] ?? '');
            $requisitos = trim($_POST['requisitos'] ?? '');
            $fechaCierre = $_POST['fecha_cierre'] ?? '';

            $pdo = $this->obtenerConexion();

            if (!empty($titulo) && !empty($fechaCierre)) {
                $stmt = $pdo->prepare("INSERT INTO becas (CI_usu, titulo, descripcion, requisitos, fecha_cierre) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$ciUsu, $titulo, $descripcion, $requisitos, $fechaCierre]);
                
                header("Location: /SISVOX/PUBLIC/index.php?route=institucion_becas&exito=creado");
                exit();
            } else {
                header("Location: /SISVOX/PUBLIC/index.php?route=institucion_becas&error=campos_vacios");
                exit();
            }
        }
    }
}