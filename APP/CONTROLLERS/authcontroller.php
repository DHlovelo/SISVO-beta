<?php
// APP/CONTROLLERS/authcontroller.php

require_once __DIR__ . '/../MODELS/usuario.php';
require_once __DIR__ . '/../HELPERS/mailer.php'; // [NUEVO]

class AuthController
{
//--- CORREOS / VERIFICACIÓN DE CORREO  [NUEVO]

    /**
     * Genera el token, lo guarda (hasheado) y envía el correo de verificación.
     * Lo usan: store(), procesarRegistroInstitucion() y reenviarVerificacion().
     */
    private function enviarVerificacion($ci, $nombre, $email): bool
    {
        $token = bin2hex(random_bytes(32));                    // 64 caracteres hex
        Usuario::guardarTokenVerificacion($ci, hash('sha256', $token));

        $cfg    = configCorreo();
        $enlace = rtrim($cfg['base_url'], '/') . '?route=verificar_correo&token=' . $token;

        $cuerpo = renderizarCorreo('verificacion', [
            'nombre' => $nombre,
            'enlace' => $enlace,
            'horas'  => 24,
        ]);

        return enviarCorreo($email, $nombre, 'Verifica tu correo en SISVO', $cuerpo);
    }

    /**
     * Pantalla "revisa tu correo".
     */
    public function verificacionPendiente()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $estado = 'pendiente';
        $correo = $_SESSION['verificacion_correo'] ?? '';
        $aviso  = '';

        if (isset($_GET['reenviado'])) {
            $aviso = 'Si el correo existe y falta verificarlo, te enviamos un nuevo enlace.';
        } elseif (($_GET['error'] ?? '') === 'espera') {
            $aviso = 'Espera un minuto antes de pedir otro correo.';
        } elseif (($_GET['error'] ?? '') === 'correo_no_verificado') {
            $aviso = 'Primero debes verificar tu correo para iniciar sesión.';
        }

        require_once __DIR__ . '/../../VIEWS/AUTH/verificacion.php';
    }

    /**
     * El usuario hace clic en el enlace del correo: ?route=verificar_correo&token=...
     */
    public function verificarCorreo()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $token  = $_GET['token'] ?? '';
        $correo = '';
        $aviso  = '';

        // Un token válido siempre son 64 caracteres hexadecimales
        if (!preg_match('/^[a-f0-9]{64}$/', $token)) {
            $estado = 'invalido';
            require_once __DIR__ . '/../../VIEWS/AUTH/verificacion.php';
            return;
        }

        $usuario = Usuario::buscarPorTokenVerificacion(hash('sha256', $token));

        if (!$usuario) {
            $estado = 'invalido';
        } elseif (!(int) $usuario['vigente']) {
            $estado = 'expirado';
            $correo = $usuario['correo'];
        } else {
            Usuario::marcarCorreoVerificado($usuario['CI_usu']);
            $estado = 'exito';

            // Correo de bienvenida (si falla, no bloqueamos al usuario)
            $cfg    = configCorreo();
            $cuerpo = renderizarCorreo('bienvenida', [
                'nombre'   => $usuario['nombre_c_usu'],
                'urlLogin' => rtrim($cfg['base_url'], '/') . '?route=login',
            ]);
            enviarCorreo($usuario['correo'], $usuario['nombre_c_usu'], '¡Bienvenido a SISVO!', $cuerpo);
        }

        require_once __DIR__ . '/../../VIEWS/AUTH/verificacion.php';
    }

    /**
     * Botón "Reenviar correo de verificación" (POST).
     */
    public function reenviarVerificacion()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /SISVOX/PUBLIC/index.php?route=login");
            exit();
        }

        // Freno anti-spam: máximo 1 reenvío por minuto por sesión
        if (time() - ($_SESSION['ultimo_reenvio'] ?? 0) < 60) {
            header("Location: /SISVOX/PUBLIC/index.php?route=verificacion_pendiente&error=espera");
            exit();
        }

        $email   = trim($_POST['correo'] ?? '');
        $usuario = $email !== '' ? Usuario::buscarPorEmail($email) : false;

        // Solo reenviamos si existe y aún no está verificado.
        // La respuesta es la misma en ambos casos para no revelar qué correos existen.
        if ($usuario && (int) ($usuario['email_verificado'] ?? 0) !== 1) {
            $this->enviarVerificacion($usuario['CI_usu'], $usuario['nombre_c_usu'], $usuario['correo']);
        }

        $_SESSION['ultimo_reenvio']       = time();
        $_SESSION['verificacion_correo']  = $email;

        header("Location: /SISVOX/PUBLIC/index.php?route=verificacion_pendiente&reenviado=1");
        exit();
    }

    public function seleccionarRol()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        require_once __DIR__ . '/../../VIEWS/AUTH/seleccionar_rol.php';
    }

    public function login()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Capturamos qué opción eligió en la pantalla anterior ('usuario' o 'institucion')
        $tipoAcceso = $_GET['tipo'] ?? 'usuario';
        if (!in_array($tipoAcceso, ['usuario', 'institucion'])) {
            $tipoAcceso = 'usuario';
        }

        require_once __DIR__ . '/../../VIEWS/AUTH/login.php';
    }

   public function authenticate()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $email = trim($_POST['correo'] ?? $_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $tipoAcceso = trim($_POST['tipo_acceso'] ?? 'usuario');

        if (empty($email) || empty($password)) {
            header("Location: /SISVOX/PUBLIC/index.php?route=login&tipo=" . urlencode($tipoAcceso) . "&error=campos_vacios");
            exit();
        }

        $usuario = Usuario::buscarPorEmail($email);

        if ($usuario && password_verify($password, $usuario['contrasena'])) {
            $rolReal = $usuario['rol'] ?? 'usuario';

            // Validación de coherencia: evitar que entren por el portal equivocado
            if ($tipoAcceso === 'institucion' && $rolReal !== 'institucion') {
                header("Location: /SISVOX/PUBLIC/index.php?route=login&tipo=institucion&error=no_es_institucion");
                exit();
            }

            if ($tipoAcceso === 'usuario' && $rolReal === 'institucion') {
                header("Location: /SISVOX/PUBLIC/index.php?route=login&tipo=usuario&error=usar_portal_institucion");
                exit();
            }

            // [NUEVO] No dejar entrar si no verificó el correo
            if ((int) ($usuario['email_verificado'] ?? 0) !== 1) {
                $_SESSION['verificacion_correo'] = $usuario['correo'];
                header("Location: /SISVOX/PUBLIC/index.php?route=verificacion_pendiente&error=correo_no_verificado");
                exit();
            }

            $_SESSION['CI_usu'] = $usuario['CI_usu'];
            $_SESSION['nombre'] = $usuario['nombre_c_usu']; // Para que el dashboard muestre el nombre
            $_SESSION['user_rol'] = $rolReal;
            $_SESSION['usuario'] = [
                'ci' => $usuario['CI_usu'] ?? null,
                'nombre' => $usuario['nombre_c_usu'] ?? '',
                'email' => $usuario['correo'] ?? ''
            ];

            // --- ESTO ES LO QUE FALTABA: REDIRIGIR AL USUARIO ---
            $this->redirigirSegunRol($rolReal);

        } else {
            // Si la contraseña o el correo fallan, devolver al login con error
            header("Location: /SISVOX/PUBLIC/index.php?route=login&tipo=" . urlencode($tipoAcceso) . "&error=credenciales_incorrectas");
            exit();
        }
    }
    public function registro()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        require_once __DIR__ . '/../../VIEWS/AUTH/registro.php';
    }

    public function store()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $ci = trim($_POST['CI_usu'] ?? '');
        $nombre = trim($_POST['nombre_c_usu'] ?? '');
        $telefono = trim($_POST['telefono'] ?? '');
        $email = trim($_POST['correo'] ?? '');
        $fecha_nacimiento = trim($_POST['fecha_nacimiento'] ?? '');
        $password = $_POST['password'] ?? '';
        $rol = 'usuario'; 

        if (empty($ci) || empty($nombre) || empty($email) || empty($password)) {
            header("Location: /SISVOX/PUBLIC/index.php?route=registro&error=campos_vacios");
            exit();
        }

        if (Usuario::buscarPorEmail($email)) {
            header("Location: /SISVOX/PUBLIC/index.php?route=registro&error=email_duplicado");
            exit();
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        try {
            $creado = Usuario::crear($ci, $nombre, $telefono, $email, $fecha_nacimiento, $passwordHash, $rol);

            if ($creado) {
                // [NUEVO] Enviar correo de verificación. Si falla el envío, el usuario
                // igual queda registrado y puede pedir el reenvío desde la pantalla siguiente.
                if (!$this->enviarVerificacion($ci, $nombre, $email)) {
                    error_log("Usuario registrado pero falló el correo de verificación: " . $email);
                }
                $_SESSION['verificacion_correo'] = $email;
                header("Location: /SISVOX/PUBLIC/index.php?route=verificacion_pendiente");
                exit();
            } else {
                header("Location: /SISVOX/PUBLIC/index.php?route=registro&error=fallo_registro");
                exit();
            }
        } catch (PDOException $e) {
            echo "Error de Base de Datos: " . $e->getMessage();
            exit();
        }
    }

    public function logout()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        session_unset();
        session_destroy();
        
        header("Location: /SISVOX/PUBLIC/index.php?route=home&mensaje=sesion_cerrada");
        exit();
    }
//--- ROLES

    private function redirigirSegunRol($rol)
    {
        switch ($rol) {
            case 'admin':
                header("Location: /SISVOX/PUBLIC/index.php?route=admin/dashboard");
                break;
            case 'institucion':
                header("Location: /SISVOX/PUBLIC/index.php?route=institucion/dashboard");
                break;
            case 'usuario':
            default:
                header("Location: /SISVOX/PUBLIC/index.php?route=inicio_estudiante");
                break;
        }
        exit();
    }
//--- PARA INSTITUCIONES ---

    public function loginInstitucion()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        require_once __DIR__ . '/../../VIEWS/AUTH/login_instituciones.php';
    }

    public function authenticateInstitucion()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $email = trim($_POST['correo'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if (empty($email) || empty($password)) {
            header("Location: /SISVOX/PUBLIC/index.php?route=login_instituciones&error=campos_vacios");
            exit();
        }

        $usuario = Usuario::buscarPorEmail($email);

        // Verificamos contraseña y que el rol en la base de datos sea estrictamente 'institucion'
        if ($usuario && password_verify($password, $usuario['contrasena'])) {
            if (($usuario['rol'] ?? '') !== 'institucion') {
                header("Location: /SISVOX/PUBLIC/index.php?route=login_instituciones&error=no_es_institucion");
                exit();
            }

            // No dejar entrar si no verificó el correo
            if ((int) ($usuario['email_verificado'] ?? 0) !== 1) {
                $_SESSION['verificacion_correo'] = $usuario['correo'];
                header("Location: /SISVOX/PUBLIC/index.php?route=verificacion_pendiente&error=correo_no_verificado");
                exit();
            }

            // Estado original de la sesión
            $_SESSION['CI_usu'] = $usuario['CI_usu'];
            $_SESSION['nombre'] = $usuario['nombre_c_usu'];
            $_SESSION['user_rol'] = 'institucion';
            $_SESSION['usuario'] = [
                'ci' => $usuario['CI_usu'] ?? null,
                'nombre' => $usuario['nombre_c_usu'] ?? '',
                'email' => $usuario['correo'] ?? ''
            ];

            header("Location: /SISVOX/PUBLIC/index.php?route=panel_institucion");
            exit();
        } else {
            header("Location: /SISVOX/PUBLIC/index.php?route=login_instituciones&error=credenciales_incorrectas");
            exit();
        }
    }
   public function procesarRegistroInstitucion()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $tipoInstitucion = trim($_POST['tipo_institucion'] ?? '');
        $nombreInstitucion = trim($_POST['nombre_institucion'] ?? '');
        $correo = trim($_POST['correo'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $infoVerificacion = trim($_POST['info_verificacion'] ?? '');

        // Generamos un identificador único temporal para la institución
        $ciUsu = 'INS' . rand(10000, 99999); 
        $telefono = ''; 
        $contrasenaHash = password_hash($password, PASSWORD_DEFAULT);
        $rol = 'institucion';

        // Incluimos tu archivo de conexión exacto (ajusta los niveles "../" según la ubicación real de tu carpeta config)
        require_once __DIR__ . '/../../config/sisvo_conexion.php'; // O '/../../Config/sisvo_conexion.php'

        // Como tu archivo usa la variable global $pdo, la asignamos aquí:
        global $pdo;
        $db = $pdo; 

        try {
            // Iniciamos una transacción para guardar en ambas tablas de forma sincronizada
            $db->beginTransaction();

            // 1. Insertar en la tabla nuevo_usu
            $stmtUsuario = $db->prepare("INSERT INTO nuevo_usu (CI_usu, nombre_c_usu, telefono, correo, fecha_nacimiento, contrasena, rol) VALUES (?, ?, ?, ?, CURDATE(), ?, ?)");
            $stmtUsuario->execute([$ciUsu, $nombreInstitucion, $telefono, $correo, $contrasenaHash, $rol]);

            // 2. Insertar en la tabla instituciones (con verificado = 0 por defecto)
            $stmtInst = $db->prepare("INSERT INTO instituciones (CI_usu, nombre_institucion, nit, info_verificacion, verificado) VALUES (?, ?, ?, ?, 0)");
            $stmtInst->execute([$ciUsu, $nombreInstitucion, $infoVerificacion, $infoVerificacion]);

            $db->commit();

            // [NUEVO] Enviar correo de verificación a la institución
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            if (!$this->enviarVerificacion($ciUsu, $nombreInstitucion, $correo)) {
                error_log("Institución registrada pero falló el correo de verificación: " . $correo);
            }
            $_SESSION['verificacion_correo'] = $correo;
            header("Location: /SISVOX/PUBLIC/index.php?route=verificacion_pendiente");
            exit();

        } catch (Exception $e) {
            $db->rollBack();
            echo "Error al registrar la institución: " . $e->getMessage();
        }
    }
}
}