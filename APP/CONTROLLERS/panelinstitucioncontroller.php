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
    // Vista exclusiva para Sedes
  public function sedes() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $ci_usu = $_SESSION['ci'] ?? $_SESSION['CI_usu'] ?? null;
        $nombreInstitucion = $_SESSION['nombre'] ?? $_SESSION['nombre_institucion'] ?? 'Institución';

        // 1. Requerimos la conexión a la base de datos
        require_once __DIR__ . '/../../CONFIG/sisvo_conexion.php';
        global $pdo;

        // 2. Si $pdo sigue sin estar definido, lo creamos manualmente para evitar el error
        if (!isset($pdo) || $pdo === null) {
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

        // 3. Ahora sí ejecutamos la consulta con seguridad
        $stmt = $pdo->prepare("SELECT * FROM sedes WHERE CI_usu = ? ORDER BY id_sede DESC");
        $stmt->execute([$ci_usu]);
        $sedes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // 4. Cargamos la vista
        require_once __DIR__ . '/../../VIEWS/INSTITUCIONES_PANEL/sedes.php';
    }
    // Guardar Sede
 public function storeSede() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Obtenemos el identificador de la institución logueada
        $ci_usu = $_SESSION['ci'] ?? $_SESSION['CI_usu'] ?? null;

        // Recogemos los datos enviados por el formulario
        $nombre_sede = $_POST['nombre_sede'] ?? '';
        $ciudad = $_POST['ciudad'] ?? '';
        $direccion = $_POST['direccion'] ?? '';
        $telefono_sede = $_POST['telefono_sede'] ?? '';
        $url_maps = $_POST['url_maps'] ?? '';

        // Validamos los campos obligatorios
        if (empty($nombre_sede) || empty($ciudad) || empty($direccion)) {
            header('Location: /SISVOX/PUBLIC/index.php?route=institucion_sedes&error=campos_vacios');
            exit;
        }

        // 1. Requerimos la conexión a la base de datos
        require_once __DIR__ . '/../../CONFIG/sisvo_conexion.php';
        global $pdo;

        // 2. Si $pdo no está definido, lo inicializamos de forma segura
        if (!isset($pdo) || $pdo === null) {
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

        // 3. Insertamos la sede en la base de datos vinculándola a la institución actual
        try {
            $stmt = $pdo->prepare("INSERT INTO sedes (CI_usu, nombre_sede, ciudad, direccion, telefono_sede, url_maps) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$ci_usu, $nombre_sede, $ciudad, $direccion, $telefono_sede, $url_maps]);

            // Redirección exitosa de vuelta a la vista de sedes
            header('Location: /SISVOX/PUBLIC/index.php?route=institucion_sedes&exito=creado');
            exit;
        } catch (Exception $e) {
            die("Error al guardar la sede: " . $e->getMessage());
        }
    }

    // Método para cargar la vista del panel de carreras con sus sedes
    public function carreras() {
        if (session_status() === PHP_SESSION_NONE) { session_start(); }
        $ci_usu = $_SESSION['ci'] ?? $_SESSION['CI_usu'] ?? null;
        $nombreInstitucion = $_SESSION['nombre'] ?? $_SESSION['nombre_institucion'] ?? 'Institución';

        require_once __DIR__ . '/../../CONFIG/sisvo_conexion.php';
        global $pdo;

        // 1. Obtenemos las sedes de esta institución para el menú desplegable
        $stmtSedes = $pdo->prepare("SELECT * FROM sedes WHERE CI_usu = ? ORDER BY id_sede DESC");
        $stmtSedes->execute([$ci_usu]);
        $sedes = $stmtSedes->fetchAll(PDO::FETCH_ASSOC);

        // 2. Obtenemos las carreras ya publicadas por esta institución
        $stmtCarreras = $pdo->prepare("SELECT c.*, s.nombre_sede FROM carreras c LEFT JOIN sedes s ON c.id_sede = s.id_sede WHERE c.CI_usu = ? ORDER BY c.id_carrera DESC");
        $stmtCarreras->execute([$ci_usu]);
        $carreras = $stmtCarreras->fetchAll(PDO::FETCH_ASSOC);

        // Cargamos la vista del panel
        require_once __DIR__ . '/../../VIEWS/INSTITUCIONES_PANEL/carreras.php';
    }

    // Método para guardar la nueva carrera seleccionando su sede
    public function storeCarrera() {
        if (session_status() === PHP_SESSION_NONE) { session_start(); }
        $ci_usu = $_SESSION['ci'] ?? $_SESSION['CI_usu'] ?? null;

        $nombre_carrera = $_POST['nombre_carrera'] ?? '';
        $id_sede = $_POST['id_sede'] ?? null;
        $nivel = $_POST['nivel'] ?? 'Licenciatura';
        $duracion = $_POST['duracion'] ?? '';
        $descripcion = $_POST['descripcion'] ?? '';

        if (empty($nombre_carrera) || empty($id_sede)) {
            header('Location: /SISVOX/PUBLIC/index.php?route=institucion_carreras&error=campos_vacios');
            exit;
        }

        require_once __DIR__ . '/../../CONFIG/sisvo_conexion.php';
        global $pdo;

        try {
            $stmt = $pdo->prepare("INSERT INTO carreras (CI_usu, id_sede, nombre_carrera, nivel, duracion, descripcion) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$ci_usu, $id_sede, $nombre_carrera, $nivel, $duracion, $descripcion]);

            header('Location: /SISVOX/PUBLIC/index.php?route=institucion_carreras&exito=creado');
            exit;
        } catch (Exception $e) {
            die("Error al guardar la carrera: " . $e->getMessage());
        }
    }
}
