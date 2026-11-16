<?php
// views/layouts/app_layout.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$route = $_GET['route'] ?? 'home';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SISVO - Portal de Orientación Vocacional</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            background-color: #0b0b0b;
            color: #ffffff;
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 25px 60px;
            max-width: 1400px;
            width: 100%;
            margin: 0 auto;
        }
        .logo {
            font-size: 22px;
            font-weight: 700;
            letter-spacing: 1px;
            color: #ffffff;
            text-decoration: none;
        }
        .logo span { color: #3b82f6; }
        .nav-links {
            display: flex;
            gap: 25px;
            align-items: center;
            flex-wrap: wrap;
        }
        .nav-links a {
            color: #9ca3af;
            text-decoration: none;
            font-size: 15px;
            font-weight: 500;
            transition: color 0.2s;
        }
        .nav-links a:hover, .nav-links a.active { color: #ffffff; }
        
        main {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 40px 20px;
        }
        .hero-section {
            text-align: center;
            max-width: 900px;
            margin: 0 auto;
        }
        .hero-section h1 {
            font-size: 48px;
            font-weight: 700;
            margin-bottom: 16px;
            letter-spacing: -0.5px;
        }
        .hero-section p {
            color: #9ca3af;
            font-size: 16px;
            margin-bottom: 35px;
            line-height: 1.6;
        }
        .hero-buttons {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 50px;
        }
        .btn-primary {
            background-color: #ffffff;
            color: #0b0b0b;
            padding: 12px 28px;
            border-radius: 30px;
            font-weight: 600;
            text-decoration: none;
            font-size: 15px;
            transition: background 0.2s;
        }
        .btn-primary:hover { background-color: #e5e7eb; }
        .btn-outline {
            background-color: transparent;
            color: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 12px 28px;
            border-radius: 30px;
            font-weight: 600;
            text-decoration: none;
            font-size: 15px;
            transition: border-color 0.2s;
        }
        .btn-outline:hover { border-color: #ffffff; }

        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 24px;
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 20px;
            width: 100%;
        }
        .card {
            background-color: #141414;
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            padding: 32px;
            text-align: left;
            transition: border-color 0.2s;
        }
        .card:hover { border-color: rgba(255, 255, 255, 0.2); }
        .card-icon { font-size: 28px; margin-bottom: 20px; }
        .card h3 { font-size: 18px; font-weight: 600; margin-bottom: 10px; color: #ffffff; }
        .card p { color: #9ca3af; font-size: 14px; line-height: 1.5; }

        .content-container {
            max-width: 900px;
            margin: 0 auto;
            background: #141414;
            padding: 40px;
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            width: 100%;
        }
        .content-container h2 { margin-bottom: 15px; color: #3b82f6; }
        .content-container p { color: #9ca3af; line-height: 1.6; }

        footer {
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            text-align: center;
            padding: 25px;
            color: #6b7280;
            font-size: 13px;
        }
    </style>
</head>
<body>

    <!-- Navbar con enlace de Inicio -->
    <header class="navbar">
        <a href="/SISVOX/PUBLIC/index.php?route=home" class="logo">SIS<span>VO</span></a>
        <nav class="nav-links">
            <a href="/SISVOX/PUBLIC/index.php?route=inicio_estudiante" class="<?php echo ($route === 'inicio_estudiante') ? 'active' : ''; ?>">Inicio</a>
            <a href="/SISVOX/PUBLIC/index.php?route=chatbot" class="<?php echo ($route === 'chatbot') ? 'active' : ''; ?>">Chatbot</a>
            <a href="/SISVOX/PUBLIC/index.php?route=test" class="<?php echo ($route === 'test') ? 'active' : ''; ?>">Test</a>
            <a href="/SISVOX/PUBLIC/index.php?route=carreras" class="<?php echo ($route === 'carreras') ? 'active' : ''; ?>">Carreras</a>
            <a href="/SISVOX/PUBLIC/index.php?route=instituciones" class="<?php echo ($route === 'instituciones') ? 'active' : ''; ?>">Instituciones</a>
            <a href="/SISVOX/PUBLIC/index.php?route=convocatorias" class="<?php echo ($route === 'convocatorias') ? 'active' : ''; ?>">Convocatorias</a>
            <a href="/SISVOX/PUBLIC/index.php?route=becas" class="<?php echo ($route === 'becas') ? 'active' : ''; ?>">Becas</a>
            <a href="/SISVOX/public/index.php?route=mi_cuenta" class="nav-link <?= ($_GET['route'] ?? '') === 'mi_cuenta' ? 'active' : '' ?>">Mi cuenta</a>

            <?php if (isset($_SESSION['CI_usu'])): ?>
                <a href="/SISVOX/PUBLIC/index.php?route=logout" style="color: #ef4444;">Salir (<?php echo htmlspecialchars($_SESSION['nombre'] ?? ''); ?>)</a>
            <?php else: ?>
                <a href="/SISVOX/PUBLIC/index.php?route=login" class="<?php echo ($route === 'login') ? 'active' : ''; ?>">Ingresar</a>
            <?php endif; ?>
        </nav>
    </header>

    <!-- Main Content -->
    <main>
        <?php if ($route === 'home'|| $route === 'inicio_estudiante'): ?>
            <section class="hero-section" style="margin-bottom: 50px;">
                <h1>Descubre qué carrera va contigo</h1>
                <p>SISVO te orienta con un chatbot, un test vocacional y la información de universidades, institutos y becas en un solo lugar.</p>
                <div class="hero-buttons">
                    <a href="/SISVOX/PUBLIC/index.php?route=test" class="btn-primary">Hacer el test</a>
                    <a href="/SISVOX/PUBLIC/index.php?route=acerca" class="btn-outline">Acerca de SISVO</a>
                </div>
            </section>

            <section class="cards-grid">
                <div class="card" style="cursor: pointer;" onclick="location.href='/SISVOX/PUBLIC/index.php?route=chatbot'">
                    <div class="card-icon">🤖</div>
                    <h3>Chatea con el asistente</h3>
                    <p>Pregunta sobre el test, las instituciones y las becas.</p>
                </div>
                <div class="card" style="cursor: pointer;" onclick="location.href='/SISVOX/PUBLIC/index.php?route=test'">
                    <div class="card-icon">📝</div>
                    <h3>Haz el test vocacional</h3>
                    <p>10 preguntas rápidas para conocer tu perfil y las carreras afines.</p>
                </div>
                <div class="card" style="cursor: pointer;" onclick="location.href='/SISVOX/PUBLIC/index.php?route=instituciones'">
                    <div class="card-icon">🎓</div>
                    <h3>Explora instituciones y becas</h3>
                    <p>Directorio de universidades e institutos, y becas con sus requisitos.</p>
                </div>
            </section>

        <?php elseif ($route === 'acerca'): ?>
            <div class="content-container">
                <h2>Acerca de SISVO</h2>
                <p>SISVO es un sistema inteligente de orientación vocacional diseñado para ayudar a los estudiantes a encontrar su camino profesional ideal mediante herramientas automatizadas, test vocacionales interactivos y un catálogo actualizado de instituciones de educación superior y becas.</p>
                <br>
                <a href="/SISVOX/public/index.php?route=home" class="btn-primary" style="display:inline-block; text-decoration: none;">Volver al inicio</a>
            </div>

        <?php elseif ($route === 'convocatorias'): ?>
            <?php
                $convocatorias = $GLOBALS['convocatorias'] ?? [];
                $becas = $GLOBALS['becas'] ?? [];
                require_once __DIR__ . '/../CONVOCATORIAS/index.php';
            ?>
        <?php elseif ($route === 'becas'): ?>
            <?php
                $becas = $GLOBALS['becas'] ?? [];
                require_once __DIR__ . '/../BECAS/index.php';
            ?>
        <?php else: ?>
            <div style="max-width: 1100px; margin: 0 auto; width: 100%; padding: 0 20px;">
                <?php 
                    $viewPath = '';

                    if ($route === 'carreras') {
                        $viewPath = __DIR__ . '/../carreras/index.php';
                    } elseif ($route === 'test') {
                        $viewPath = __DIR__ . '/../test/index.php';
                    } elseif ($route === 'becas') {
                        $viewPath = __DIR__ . '/../becas/index.php';
                    } elseif ($route === 'instituciones') {
                        $viewPath = __DIR__ . '/../instituciones/index.php';
                    } elseif ($route === 'chatbot') {
                        $viewPath = __DIR__ . '/../chatbot/index.php';
                    } elseif ($route === 'mi_cuenta') {
                        $usuario = $GLOBALS['usuario'] ?? [];
                        require_once __DIR__ . '/../PERFIL/index.php';
                    }

                    if ($route !== 'mi_cuenta') {
                        if (!empty($viewPath) && file_exists($viewPath)) {
                            include $viewPath;
                        } else {
                            echo '<div class="content-container"><h2>Módulo en desarrollo</h2><p>Esta sección estará disponible próximamente en el sistema.</p><br><a href="/SISVOX/public/index.php?route=home" class="btn-primary" style="display:inline-block; text-decoration: none;">Volver al inicio</a></div>';
                        }
                    }
                ?>
            </div>
        <?php endif; ?>
    </main>

    <!-- Footer -->
    <footer>
        SISVO - Proyecto de Programación &copy; 2026
    </footer>

</body>
</html>