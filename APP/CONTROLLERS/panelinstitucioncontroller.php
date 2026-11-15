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

    public function index()
    {
        $this->verificarRolInstitucion();

        // Carga la vista del panel institucional
        require_once __DIR__ . '/../../VIEWS/instituciones_panel/dashboard.php';
    }

   public function storeConvocatoria()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        session_start();
        $ciUsu = $_SESSION['CI_usu'] ?? ''; 
        
        $titulo = trim($_POST['titulo'] ?? '');
        $categoria = trim($_POST['categoria'] ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');
        $fechaCierre = $_POST['fecha_cierre'] ?? '';

        // 1. Incluimos tu archivo de conexión (ajusta los niveles "../" según la ubicación real de tu controlador)
        require_once __DIR__ . '/../../config/sisvo_conexion.php';

        // 2. PEGA AQUÍ EL CÓDIGO DE RESPALDO:
        if (!isset($pdo)) {
            $host = 'localhost';
            $dbname = 'sisvo';
            $username = 'root';
            $password = '';
            $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        // 3. Ahora la variable $pdo ya tiene vida garantizada y no dará error
        $stmt = $pdo->prepare("INSERT INTO convocatorias (CI_usu, titulo, categoria, descripcion, fecha_cierre) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$ciUsu, $titulo, $categoria, $descripcion, $fechaCierre]);

        // Redirigir al panel con éxito
        header("Location: /SISVOX/PUBLIC/index.php?route=panel_institucion&exito=publicado");
        exit();
    }
}
    public function guardarPublicacion()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        session_start();
        // Asegúrate de guardar el CI del usuario en la sesión al momento del login institucional
        $ciUsu = $_SESSION['CI_usu'] ?? ''; 
        
        $tipo = $_POST['tipo_publicacion'];
        $titulo = trim($_POST['titulo']);
        $descripcion = trim($_POST['descripcion']);
        $fechaCierre = $_POST['fecha_cierre'];

        require_once __DIR__ . '/../../config/sisvo_conexion.php';
        global $pdo;

        if ($tipo === 'convocatoria') {
            $categoria = trim($_POST['categoria']);
            $stmt = $pdo->prepare("INSERT INTO convocatorias (CI_usu, titulo, categoria, descripcion, fecha_cierre) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$ciUsu, $titulo, $categoria, $descripcion, $fechaCierre]);
        } else {
            $requisitos = trim($_POST['requisitos']);
            $stmt = $pdo->prepare("INSERT INTO becas (CI_usu, titulo, descripcion, requisitos, fecha_cierre) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$ciUsu, $titulo, $descripcion, $requisitos, $fechaCierre]);
        }

        // Redirigir al panel de la institución con éxito
        header("Location: /SISVOX/PUBLIC/index.php?route=panel_institucion&exito=publicado");
        exit();
    }
}

public function dashboard() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $ciUsu = $_SESSION['CI_usu'] ?? '';

    // Conexión a la base de datos
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

    // Consultar SOLO las convocatorias de esta institución
    $stmtConv = $pdo->prepare("SELECT c.*, i.nombre_institucion FROM convocatorias c JOIN instituciones i ON c.CI_usu = i.CI_usu WHERE c.CI_usu = ? ORDER BY c.created_at DESC");
    $stmtConv->execute([$ciUsu]);
    $convocatorias = $stmtConv->fetchAll(PDO::FETCH_ASSOC);

    // Consultar SOLO las becas de esta institución
    $stmtBecas = $pdo->prepare("SELECT b.*, i.nombre_institucion FROM becas b JOIN instituciones i ON b.CI_usu = i.CI_usu WHERE b.CI_usu = ? ORDER BY b.created_at DESC");
    $stmtBecas->execute([$ciUsu]);
    $becas = $stmtBecas->fetchAll(PDO::FETCH_ASSOC);

    // Cargar la vista del panel institucional
    $viewPath = __DIR__ . '/../../VIEWS/INSTITUCIONES_PANEL/dashboard.php';
    if (file_exists($viewPath)) {
        require_once $viewPath;
    } else {
        echo "Error: No se encuentra la vista del panel institucional.";
    }
}

}