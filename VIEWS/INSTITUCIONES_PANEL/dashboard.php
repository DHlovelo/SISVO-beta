<?php
// VIEWS/INSTITUCIONES_PANEL/dashboard.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$nombreInstitucion = $_SESSION['nombre'] ?? 'Institución';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Institucional - SISVOX</title>
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
        /* Barra de navegación idéntica a la vista de usuario */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 25px 60px;
            max-width: 1400px;
            width: 100%;
            margin: 0 auto;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }
        .logo { font-size: 22px; font-weight: 700; letter-spacing: 1px; color: #ffffff; text-decoration: none; }
        .logo span { color: #3b82f6; }
        
        .nav-links {
            display: flex;
            gap: 25px;
            align-items: center;
        }
        .nav-links a {
            color: #9ca3af;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: color 0.2s;
        }
        .nav-links a:hover, .nav-links a.active {
            color: #ffffff;
        }
        .nav-links a.logout {
            color: #ef4444;
            font-weight: 600;
        }

        main {
            flex: 1;
            max-width: 1260px;
            width: 100%;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .welcome-box {
            background: #141414;
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            padding: 30px;
            margin-bottom: 35px;
        }
        .welcome-box h1 { font-size: 26px; margin-bottom: 8px; color: #3b82f6; }
        .welcome-box p { color: #9ca3af; font-size: 15px; line-height: 1.5; }

        .grid-layout {
            display: grid;
            grid-template-columns: 400px 1fr;
            gap: 30px;
        }
        @media (max-width: 968px) {
            .grid-layout { grid-template-columns: 1fr; }
        }

        .card-panel {
            background: #141414;
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            padding: 30px;
            height: fit-content;
        }
        .card-panel h3 { font-size: 18px; margin-bottom: 20px; color: #ffffff; border-bottom: 1px solid rgba(255,255,255,0.05); padding-bottom: 12px; }
        
        .form-group { margin-bottom: 18px; }
        .form-group label { display: block; margin-bottom: 6px; font-size: 13px; color: #9ca3af; font-weight: 500; }
        .form-control {
            width: 100%;
            padding: 12px;
            background: #0b0b0b;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            color: #fff;
            font-size: 14px;
            outline: none;
            transition: border-color 0.2s;
        }
        .form-control:focus { border-color: #3b82f6; }
        textarea.form-control { resize: vertical; min-height: 110px; }
        
        .btn-submit {
            background-color: #3b82f6;
            color: #ffffff;
            border: none;
            padding: 12px 24px;
            border-radius: 30px;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            font-size: 14px;
            transition: background 0.2s;
        }
        .btn-submit:hover { background-color: #2563eb; }

        .alert {
            padding: 12px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        .alert-success { background: rgba(16, 185, 129, 0.1); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.2); }
        .alert-error { background: rgba(239, 68, 68, 0.1); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.2); }

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

    <header class="navbar">
        <a href="#" class="logo">SIS<span>VO</span></a>
        <nav class="nav-links">
            <a href="/SISVOX/PUBLIC/index.php?route=panel_institucion" class="active">Inicio</a>
            <a href="/SISVOX/PUBLIC/index.php?route=carreras">Carreras</a>
            <a href="/SISVOX/PUBLIC/index.php?route=sedes">Sedes</a>
            <a href="/SISVOX/PUBLIC/index.php?route=convocatorias">Convocatorias</a>
            <a href="/SISVOX/PUBLIC/index.php?route=becas">Becas</a>
            <a href="#" style="color: #3b82f6; font-weight: 600; cursor: default;"><?php echo htmlspecialchars($nombreInstitucion); ?></a>
            <a href="/SISVOX/PUBLIC/index.php?route=logout" class="logout">Salir (<?php echo htmlspecialchars($nombreInstitucion); ?>)</a>
        </nav>
    </header>

    <main>
        <div class="welcome-box">
            <h1>Gestión de Convocatorias y Becas</h1>
            <p>Desde este panel oficial puedes publicar oportunidades académicas, exámenes de admisión o becas. Las tarjetas a la derecha muestran en tiempo real exactamente lo que tus postulantes visualizarán.</p>
        </div>

        <?php if (isset($_GET['exito']) && $_GET['exito'] === 'creado'): ?>
            <div class="alert alert-success">¡Convocatoria publicada con éxito y disponible para los estudiantes!</div>
        <?php endif; ?>

        <?php if (isset($_GET['error']) && $_GET['error'] === 'campos_vacios'): ?>
            <div class="alert alert-error">Por favor, complete todos los campos obligatorios del formulario.</div>
        <?php endif; ?>

        <div class="grid-layout">
            <div class="card-panel">
                <h3>Publicar Nueva Convocatoria</h3>
                <form action="/SISVOX/PUBLIC/index.php?route=guardar_convocatoria" method="POST">
                    <div class="form-group">
                        <label>Título de la Convocatoria / Beca</label>
                        <input type="text" name="titulo" class="form-control" required placeholder="Ej. Beca Excelencia Académica 2026">
                    </div>

                    <div class="form-group">
                        <label>Categoría</label>
                        <select name="categoria" class="form-control" required>
                            <option value="">Seleccione una categoría</option>
                            <option value="Admision">Examen de Admisión</option>
                            <option value="Beca">Beca de Estudio</option>
                            <option value="Curso">Curso Especial / Taller</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Fecha Límite / Cierre</label>
                        <input type="date" name="fecha_cierre" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Descripción y Requisitos</label>
                        <textarea name="descripcion" class="form-control" required placeholder="Detalle los requisitos, beneficios y pasos para postularse..."></textarea>
                    </div>

                    <button type="submit" class="btn-submit">Publicar Convocatoria</button>
                </form>
            </div>

            <div class="card-panel">
                <h3>Tus Convocatorias y Becas Publicadas</h3>

                <?php if (empty($convocatorias) && empty($becas)): ?>
                    <div style="padding: 30px; background: #0b0b0b; border-radius: 8px; border: 1px dashed rgba(255,255,255,0.1); text-align: center; color: #6b7280; font-size: 14px;">
                        Aún no has realizado ninguna publicación. ¡Usa el formulario de la izquierda para crear la primera!
                    </div>
                <?php else: ?>
                    <div style="display: flex; flex-direction: column; gap: 16px; max-height: 650px; overflow-y: auto; padding-right: 5px;">
                        
                        <?php if (!empty($convocatorias)): ?>
                            <?php foreach ($convocatorias as $conv): ?>
                                <div style="background: #0b0b0b; border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 12px; padding: 18px; display: flex; flex-direction: column; justify-content: space-between;">
                                    <div>
                                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                                            <span style="background: rgba(59, 130, 246, 0.15); color: #3b82f6; font-size: 11px; font-weight: 700; padding: 3px 8px; border-radius: 4px; text-transform: uppercase;">
                                                <?= htmlspecialchars($conv['nombre_institucion'] ?? $nombreInstitucion) ?>
                                            </span>
                                            <span style="color: #9ca3af; font-size: 11px;">Convocatoria</span>
                                        </div>
                                        <h4 style="color: #ffffff; font-size: 16px; font-weight: 600; margin-bottom: 8px;"><?= htmlspecialchars($conv['titulo']) ?></h4>
                                        <?php if (!empty($conv['categoria'])): ?>
                                            <div style="display: inline-block; background: rgba(59, 130, 246, 0.1); color: #60a5fa; font-size: 11px; padding: 2px 8px; border-radius: 4px; margin-bottom: 8px;">
                                                Categoría: <?= htmlspecialchars($conv['categoria']) ?>
                                            </div>
                                        <?php endif; ?>
                                        <p style="color: #9ca3af; font-size: 13px; line-height: 1.5; margin-bottom: 12px;"><?= nl2br(htmlspecialchars($conv['descripcion'])) ?></p>
                                    </div>
                                    <div style="border-top: 1px solid rgba(255,255,255,0.05); padding-top: 10px; display: flex; justify-content: space-between; align-items: center;">
                                        <span style="color: #6b7280; font-size: 12px;">Cierre: <?= htmlspecialchars($conv['fecha_cierre']) ?></span>
                                        <span style="color: #10b981; font-size: 11px; font-weight: 500;">● Visible para estudiantes</span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <?php if (!empty($becas)): ?>
                            <?php foreach ($becas as $beca): ?>
                                <div style="background: #0b0b0b; border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 12px; padding: 18px; display: flex; flex-direction: column; justify-content: space-between;">
                                    <div>
                                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                                            <span style="background: rgba(16, 185, 129, 0.15); color: #10b981; font-size: 11px; font-weight: 700; padding: 3px 8px; border-radius: 4px; text-transform: uppercase;">
                                                <?= htmlspecialchars($beca['nombre_institucion'] ?? $nombreInstitucion) ?>
                                            </span>
                                            <span style="background: rgba(16, 185, 129, 0.1); color: #10b981; font-size: 11px; font-weight: 600; padding: 2px 6px; border-radius: 4px;">Beca</span>
                                        </div>
                                        <h4 style="color: #ffffff; font-size: 16px; font-weight: 600; margin-bottom: 8px;"><?= htmlspecialchars($beca['titulo']) ?></h4>
                                        <p style="color: #9ca3af; font-size: 13px; line-height: 1.5; margin-bottom: 10px;"><?= nl2br(htmlspecialchars($beca['descripcion'])) ?></p>
                                        <?php if (!empty($beca['requisitos'])): ?>
                                            <p style="color: #d1d5db; font-size: 12px; background: #141414; padding: 8px; border-radius: 6px; margin-bottom: 10px;">
                                                <strong style="color: #3b82f6;">Requisitos:</strong> <?= nl2br(htmlspecialchars($beca['requisitos'])) ?>
                                            </p>
                                        <?php endif; ?>
                                    </div>
                                    <div style="border-top: 1px solid rgba(255,255,255,0.05); padding-top: 10px; display: flex; justify-content: space-between; align-items: center;">
                                        <span style="color: #6b7280; font-size: 12px;">Cierre: <?= htmlspecialchars($beca['fecha_cierre']) ?></span>
                                        <span style="color: #10b981; font-size: 11px; font-weight: 500;">● Visible para estudiantes</span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>

                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <footer>
        SISVO - Proyecto de Programación &copy; 2026
    </footer>

</body>
</html>