<?php
// PUBLIC/index.php

ini_set('display_errors', 1);
error_reporting(E_ALL);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$route = $_GET['route'] ?? 'home';
if ($route === 'registro_instituciones') {
    // Probamos primero con minúsculas
    $rutaMin = __DIR__ . '/../views/auth/registro_instituciones.php';
    // Probamos por si tu carpeta está en mayúsculas
    $rutaMay = __DIR__ . '/../VIEWS/auth/registro_instituciones.php';

    if (file_exists($rutaMin)) {
        require_once $rutaMin;
        exit(); // Corta la ejecución para que NUNCA llegue al home de los dos botones
    } elseif (file_exists($rutaMay)) {
        require_once $rutaMay;
        exit(); // Corta la ejecución
    } else {
        die("Error crítico: No se encontró el archivo registro_instituciones.php en ninguna de las rutas.");
    }
}

switch ($route) {
    case 'home':
        require_once __DIR__ . '/../APP/Controllers/AuthController.php';
        (new AuthController())->seleccionarRol();
        break;

    case 'login':
        require_once __DIR__ . '/../APP/Controllers/AuthController.php';
        (new AuthController())->login();
        break;

    case 'authenticate':
        require_once __DIR__ . '/../APP/Controllers/AuthController.php';
        (new AuthController())->authenticate();
        break;

    case 'registro':
        require_once __DIR__ . '/../APP/Controllers/AuthController.php';
        (new AuthController())->registro();
        break;

    case 'store_register':
        require_once __DIR__ . '/../APP/Controllers/AuthController.php';
        (new AuthController())->store();
        break;

    case 'logout':
        require_once __DIR__ . '/../APP/Controllers/AuthController.php';
        (new AuthController())->logout();
        break;

//--- SELECCIONAR EL ROL DE USUARIO ---
    case 'seleccionar_rol':
        require_once __DIR__ . '/../APP/Controllers/AuthController.php';
        (new AuthController())->seleccionarRol();
        break;

//--- ESTUDIANTE

    case 'inicio_estudiante':
        require_once __DIR__ . '/../APP/Controllers/HomeController.php';
        (new HomeController())->index();
        break;

//--- RUTAS PARA CARRERAS, INSTITUCIONES, CONVOCATORIAS, BECAS, CHATBOT, TEST Y ACERCA ---

    case 'carreras':
        require_once __DIR__ . '/../APP/Controllers/CarrerasController.php';
        (new CarrerasController())->index();
        break;

    case 'instituciones':
        require_once __DIR__ . '/../APP/Controllers/InstitucionController.php';
        (new InstitucionController())->index();
        break;

   case 'convocatorias':
        require_once __DIR__ . '/../APP/Controllers/ConvocatoriaController.php';
        (new ConvocatoriaController())->index();
        break;

    case 'becas':
        require_once __DIR__ . '/../APP/Controllers/BecaController.php';
        (new BecaController())->index();
        break;

    case 'chatbot':
        require_once __DIR__ . '/../app/Controllers/ChatbotController.php';
        (new ChatbotController())->index();
        break;

    case 'test':
        require_once __DIR__ . '/../app/Controllers/TestController.php';
        (new TestController())->index();
        break;

    case 'acerca':
        require_once __DIR__ . '/../app/Controllers/AcercaController.php';
        (new AcercaController())->index();
        break;
        
// --- RUTA PARA INSTITUCIONES
        //---LOGIN Y REGISTRO DE INSTITUCIONES
     case 'login_institucion':
        require_once __DIR__ . '/../APP/Controllers/AuthController.php';
        (new AuthController())->loginInstitucion();
        break;

    case 'authenticate_institucion':
        require_once __DIR__ . '/../APP/Controllers/AuthController.php';
        (new AuthController())->authenticateInstitucion();
        break; 
    
  case 'registro_institucion':
        // Carga directa de la vista de registro (asegúrate de que la ruta de la carpeta sea la correcta)
        $archivoRegistro = __DIR__ . '/../views/auth/registro_instituciones.php';
        if (file_exists($archivoRegistro)) {
            require_once $archivoRegistro;
        } else {
            // Si tu carpeta se llama VIEWS en mayúsculas, cámbiala aquí también:
            require_once __DIR__ . '/../VIEWS/auth/registro_instituciones.php';
        }
        exit(); // ¡Muy importante este exit para evitar que el script siga bajando y cargue el home!
        break;

    case 'procesar_registro_institucion':
        require_once __DIR__ . '/../app/Controllers/AuthController.php';
        (new AuthController())->procesarRegistroInstitucion();
        exit();
        break;

//--- PANEL DE CONTROL DE INSTITUCIONES
    case 'panel_institucion':
        require_once __DIR__ . '/../APP/Controllers/PanelInstitucionController.php';
        (new PanelInstitucionController())->index();
        break;

    case 'guardar_convocatoria':
        require_once __DIR__ . '/../APP/Controllers/PanelInstitucionController.php';
        (new PanelInstitucionController())->storeConvocatoria();
        break;

   

// --- ubi ---
    default:
        header("Location: /SISVOX/PUBLIC/index.php?route=home");
        exit;
}