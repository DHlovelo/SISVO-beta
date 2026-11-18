<?php

$route = $_GET['route'] ?? 'home';

$route = trim($route, '/');

switch ($route) {
    
    // RUTAS PÚBLICAS
    case 'login':
        require_once __DIR__ . '/../app/Controllers/AuthController.php';
        $controller = new AuthController();
        $controller->login();
        break;

    case 'authenticate':
        require_once __DIR__ . '/../app/Controllers/AuthController.php';
        $controller = new AuthController();
        $controller->authenticate();
        break;

    case 'registro':
        require_once __DIR__ . '/../app/Controllers/AuthController.php';
        $controller = new AuthController();
        $controller->registro();
        break;

    case 'store':
        require_once __DIR__ . '/../app/Controllers/AuthController.php';
        $controller = new AuthController();
        $controller->store();
        break;

    case 'logout':
        require_once __DIR__ . '/../app/Controllers/AuthController.php';
        $controller = new AuthController();
        $controller->logout();
        break;

    case 'home':
        // Página principal pública
        require_once __DIR__ . '/../app/Controllers/HomeController.php';
        $controller = new HomeController();
        $controller->index();
        break;

    // (Protegidas automáticamente por AdminController)
    case 'admin/dashboard':
        require_once __DIR__ . '/../app/Controllers/AdminController.php';
        $controller = new AdminController();
        $controller->index();
        break;

    case 'admin/usuarios':
        require_once __DIR__ . '/../app/Controllers/AdminController.php';
        $controller = new AdminController();
        $controller->gestionarUsuarios();
        break;

    case 'admin/instituciones':
        require_once __DIR__ . '/../app/Controllers/AdminController.php';
        $controller = new AdminController();
        $controller->gestionarInstituciones();
        break;

    // (Protegidas automáticamente por InstitucionController)
    case 'institucion/dashboard':
        require_once __DIR__ . '/../app/Controllers/InstitucionController.php';
        $controller = new InstitucionController();
        $controller->dashboard();
        break;

    // ==========================================
    // RUTA 404 (No encontrada)
    // ==========================================
    default:
        http_response_code(404);
        echo "<div style='text-align:center; margin-top:50px;'>";
        echo "<h1>404 - Página no encontrada</h1>";
        echo "<p>La ruta solicitada no existe en el sistema SISVOX.</p>";
        echo "<a href='/SISVOX/public/index.php?route=home'>Volver al Inicio</a>";
        echo "</div>";
        break;
}