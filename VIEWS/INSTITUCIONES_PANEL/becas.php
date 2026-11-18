<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
$nombreInstitucion = $_SESSION['nombre'] ?? 'Institución';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Becas - SISVOX</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { background-color: #0b0b0b; color: #ffffff; font-family: 'Plus Jakarta Sans', sans-serif; min-height: 100vh; display: flex; flex-direction: column; justify-content: space-between; }
        
        /* Navbar idéntica a la del estudiante */
        .navbar { display: flex; justify-content: space-between; align-items: center; padding: 25px 60px; max-width: 1400px; width: 100%; margin: 0 auto; border-bottom: 1px solid rgba(255, 255, 255, 0.08); }
        .logo { font-size: 22px; font-weight: 700; letter-spacing: 1px; color: #ffffff; text-decoration: none; }
        .logo span { color: #3b82f6; }
        .nav-links { display: flex; gap: 25px; align-items: center; }
        .nav-links a { color: #9ca3af; text-decoration: none; font-size: 14px; font-weight: 500; transition: color 0.2s; }
        .nav-links a:hover, .nav-links a.active { color: #ffffff; }
        .nav-links a.logout { color: #ef4444; font-weight: 600; }

        main { flex: 1; max-width: 1260px; width: 100%; margin: 0 auto; padding: 40px 20px; }
        .welcome-box { background: #141414; border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 16px; padding: 30px; margin-bottom: 35px; }
        .welcome-box h1 { font-size: 26px; margin-bottom: 8px; color: #10b981; }
        .welcome-box p { color: #9ca3af; font-size: 15px; line-height: 1.5; }

        .grid-layout { display: grid; grid-template-columns: 400px 1fr; gap: 30px; }
        @media (max-width: 968px) { .grid-layout { grid-template-columns: 1fr; } }

        .card-panel { background: #141414; border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 16px; padding: 30px; height: fit-content; }
        .card-panel h3 { font-size: 18px; margin-bottom: 20px; color: #ffffff; border-bottom: 1px solid rgba(255,255,255,0.05); padding-bottom: 12px; }
        
        .form-group { margin-bottom: 18px; }
        .form-group label { display: block; margin-bottom: 6px; font-size: 13px; color: #9ca3af; font-weight: 500; }
        .form-control { width: 100%; padding: 12px; background: #0b0b0b; border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 8px; color: #fff; font-size: 14px; outline: none; }
        .form-control:focus { border-color: #10b981; }
        textarea.form-control { resize: vertical; min-height: 110px; }
        
        .btn-submit { background-color: #10b981; color: #ffffff; border: none; padding: 12px 24px; border-radius: 30px; font-weight: 600; cursor: pointer; width: 100%; font-size: 14px; transition: background 0.2s; }
        .btn-submit:hover { background-color: #059669; }

        .alert { padding: 12px 20px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; }
        .alert-success { background: rgba(16, 185, 129, 0.1); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.2); }
        .alert-error { background: rgba(239, 68, 68, 0.1); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.2); }

        footer { border-top: 1px solid rgba(255, 255, 255, 0.08); text-align: center; padding: 25px; color: #6b7280; font-size: 13px; }
    </style>
</head>
<body>

    <!-- NAVBAR CON LOS BOTONES SOLICITADOS -->
    <header class="navbar">
        <a href="#" class="logo">SIS<span>VO</span></a>
        <nav class="nav-links">
            <a href="/SISVOX/PUBLIC/index.php?route=institucion_convocatorias">Inicio</a>
            <a href="/SISVOX/PUBLIC/index.php?route=carreras">Carreras</a>
            <a href="/SISVOX/PUBLIC/index.php?route=institucion_sedes">Sedes</a>
            <a href="/SISVOX/PUBLIC/index.php?route=institucion_convocatorias">Convocatorias</a>
            <a href="/SISVOX/PUBLIC/index.php?route=institucion_becas" class="active">Becas</a>
            <a href="#" style="color: #10b981; font-weight: 600; cursor: default;"><?php echo htmlspecialchars($nombreInstitucion); ?></a>
            <a href="/SISVOX/PUBLIC/index.php?route=logout" class="logout">Salir (<?php echo htmlspecialchars($nombreInstitucion); ?>)</a>
        </nav>
    </header>

    <main>
        <div class="welcome-box">
            <h1>Gestión de Programas de Becas</h1>
            <p>Administra los programas de apoyo económico o incentivos que tu institución ofrece. Las tarjetas a la derecha muestran tus becas activas en tiempo real.</p>
        </div>

        <?php if (isset($_GET['exito']) && $_GET['exito'] === 'creado'): ?>
            <div class="alert alert-success">¡Beca publicada con éxito!</div>
        <?php endif; ?>
        <?php if (isset($_GET['error']) && $_GET['error'] === 'campos_vacios'): ?>
            <div class="alert alert-error">Por favor, completa todos los campos requeridos.</div>
        <?php endif; ?>

        <div class="grid-layout">
            <div class="card-panel">
                <h3>Publicar Nueva Beca</h3>
                <form action="/SISVOX/PUBLIC/index.php?route=guardar_beca" method="POST">
                    <div class="form-group">
                        <label>Título de la Beca</label>
                        <input type="text" name="titulo" class="form-control" required placeholder="Ej. Beca Excelencia 2026">
                    </div>
                    <div class="form-group">
                        <label>Fecha Límite / Cierre</label>
                        <input type="date" name="fecha_cierre" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Descripción General</label>
                        <textarea name="descripcion" class="form-control" required placeholder="Detalles de la beca..."></textarea>
                    </div>
                    <div class="form-group">
                        <label>Requisitos</label>
                        <textarea name="requisitos" class="form-control" placeholder="Promedio, documentación necesaria..."></textarea>
                    </div>
                    <button type="submit" class="btn-submit">Publicar Beca</button>
                </form>
            </div>

            <div class="card-panel">
                <h3>Tus Becas Publicadas</h3>
                <?php if (empty($becas)): ?>
                    <div style="padding: 30px; background: #0b0b0b; border-radius: 8px; border: 1px dashed rgba(255,255,255,0.1); text-align: center; color: #6b7280; font-size: 14px;">
                        Aún no has publicado ninguna beca.
                    </div>
                <?php else: ?>
                    <div style="display: flex; flex-direction: column; gap: 16px; max-height: 650px; overflow-y: auto;">
                        <?php foreach ($becas as $beca): ?>
                            <div style="background: #0b0b0b; border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 12px; padding: 18px;">
                                <h4 style="color: #ffffff; font-size: 16px; margin-bottom: 6px;"><?= htmlspecialchars($beca['titulo']) ?></h4>
                                <p style="color: #9ca3af; font-size: 13px; margin-bottom: 8px;"><?= nl2br(htmlspecialchars($beca['descripcion'])) ?></p>
                                <?php if (!empty($beca['requisitos'])): ?>
                                    <p style="color: #d1d5db; font-size: 12px; background: #141414; padding: 8px; border-radius: 6px; margin-bottom: 8px;">
                                        <strong style="color: #10b981;">Requisitos:</strong> <?= nl2br(htmlspecialchars($beca['requisitos'])) ?>
                                    </p>
                                <?php endif; ?>
                                <span style="color: #6b7280; font-size: 12px;">Cierre: <?= htmlspecialchars($beca['fecha_cierre']) ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <footer>SISVO - Proyecto de Programación &copy; 2026</footer>
</body>
</html>