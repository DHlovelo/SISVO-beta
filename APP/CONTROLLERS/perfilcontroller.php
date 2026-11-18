<?php
class PerfilController {
    public function index() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // 1. Conexión a la base de datos
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

        // 2. Obtenemos el CI de la sesión
        $ci_usu = $_SESSION['CI_usu'] ?? $_SESSION['ci_usu'] ?? $_SESSION['usuario']['ci'] ?? null;

        // 3. Procesar formulario si se envían cambios por POST
       // 3. Procesar formulario si se envían cambios por POST
        $mensaje = "";
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $ci_usu) {
            $nuevoNombre = trim($_POST['nombre'] ?? '');
            $nuevoPassword = trim($_POST['password'] ?? '');

            try {
                if (!empty($nuevoPassword)) {
                    // Encriptamos la contraseña igual que en el registro para que password_verify() la acepte
                    $passwordHash = password_hash($nuevoPassword, PASSWORD_DEFAULT);
                    $stmtUpdate = $pdo->prepare("UPDATE nuevo_usu SET nombre_c_usu = ?, contrasena = ? WHERE ci_usu = ?");
                    $stmtUpdate->execute([$nuevoNombre, $passwordHash, $ci_usu]);
                } else {
                    // Si dejó la contraseña en blanco, solo actualizamos nombre_c_usu
                    $stmtUpdate = $pdo->prepare("UPDATE nuevo_usu SET nombre_c_usu = ? WHERE ci_usu = ?");
                    $stmtUpdate->execute([$nuevoNombre, $ci_usu]);
                }
                
                // Actualizamos la sesión
                $_SESSION['nombre'] = $nuevoNombre;
                if (isset($_SESSION['usuario'])) {
                    $_SESSION['usuario']['nombre'] = $nuevoNombre;
                }

                $mensaje = "¡Perfil y contraseña actualizados con éxito!";
            } catch (Exception $e) {
                $mensaje = "Error al actualizar: " . $e->getMessage();
            }
        }

        // 4. Consultar los datos actuales del usuario desde 'nuevo_usu'
        $usuario = [];
        if ($ci_usu) {
            $stmt = $pdo->prepare("SELECT * FROM nuevo_usu WHERE ci_usu = ?");
            $stmt->execute([$ci_usu]);
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        }

        // 5. Blindar datos en GLOBALS y cargar layout
        $GLOBALS['usuario'] = $usuario;
        $GLOBALS['mensaje_perfil'] = $mensaje;
        $_GET['route'] = 'mi_cuenta';

        $layoutPath = __DIR__ . '/../../VIEWS/layouts/app_layout.php';
        if (file_exists($layoutPath)) {
            require_once $layoutPath;
        } else {
            require_once __DIR__ . '/../../views/layouts/app_layout.php';
        }
    }
}