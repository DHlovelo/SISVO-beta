<?php
// VIEWS/instituciones_panel/dashboard.php
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
        
        main {
            flex: 1;
            max-width: 1100px;
            width: 100%;
            margin: 0 auto;
            padding: 40px 20px;
        }
        .welcome-box {
            background: #141414;
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            padding: 30px;
            margin-bottom: 30px;
        }
        .welcome-box h1 { font-size: 28px; margin-bottom: 10px; color: #3b82f6; }
        .welcome-box p { color: #9ca3af; font-size: 15px; }

        .grid-panel {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }
        @media (max-width: 768px) {
            .grid-panel { grid-template-columns: 1fr; }
        }
        .card-panel {
            background: #141414;
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            padding: 30px;
        }
        .card-panel h3 { font-size: 18px; margin-bottom: 20px; color: #ffffff; border-bottom: 1px solid rgba(255,255,255,0.05); padding-bottom: 10px; }
        
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 6px; font-size: 14px; color: #9ca3af; }
        .form-control {
            width: 100%;
            padding: 12px;
            background: #0b0b0b;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            color: #fff;
            font-size: 14px;
            outline: none;
        }
        .form-control:focus { border-color: #3b82f6; }
        textarea.form-control { resize: vertical; min-height: 100px; }
        
        .btn-submit {
            background-color: #3b82f6;
            color: #ffffff;
            border: none;
            padding: 12px 24px;
            border-radius: 30px;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
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
        <a href="#" class="logo">SIS<span>VO</span> - Panel Institucional</a>
        <div>
            <span style="color: #9ca3af; margin-right: 15px; font-size: 14px;">Hola, <?php echo htmlspecialchars($nombreInstitucion); ?></span>
            <a href="/SISVOX/PUBLIC/index.php?route=logout" style="color: #ef4444; text-decoration: none; font-weight: 600; font-size: 14px;">Cerrar Sesión</a>
        </div>
    </header>

    <main>
        <div class="welcome-box">
            <h1>Gestión de Convocatorias y Becas</h1>
            <p>Desde este panel oficial podrás publicar oportunidades académicas, exámenes de admisión o becas que serán visibles para todos los estudiantes de SISVOX.</p>
        </div>

        <?php if (isset($_GET['exito']) && $_GET['exito'] === 'creado'): ?>
            <div class="alert alert-success">¡Convocatoria publicada con éxito y disponible para los estudiantes!</div>
        <?php endif; ?>

        <?php if (isset($_GET['error']) && $_GET['error'] === 'campos_vacios'): ?>
            <div class="alert alert-error">Por favor, complete todos los campos obligatorios del formulario.</div>
        <?php endif; ?>

        <div class="grid-panel">
            <!-- Columna Izquierda: Formulario para publicar -->
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

            <!-- Columna Derecha: Convocatorias Activas (Con diseño moderno de tarjetas) -->
            <div class="card-panel">
                <h3>Convocatorias Activas</h3>
                <p style="color: #9ca3af; font-size: 13px; line-height: 1.5; margin-bottom: 20px;">
                    Aquí puedes verificar las publicaciones exclusivas que tu institución ha realizado.
                </p>

                <?php if (empty($convocatorias) && empty($becas)): ?>
                    <div style="padding: 20px; background: #0b0b0b; border-radius: 8px; border: 1px dashed rgba(255,255,255,0.1); text-align: center; color: #6b7280; font-size: 14px;">
                        Tus publicaciones aparecerán listadas aquí.
                    </div>
                <?php else: ?>
                    <div style="display: flex; flex-direction: column; gap: 15px; max-height: 500px; overflow-y: auto; padding-right: 5px;">
                        
                        <!-- MOSTRAR CONVOCATORIAS -->
                        <?php if (!empty($convocatorias)): ?>
                            <?php foreach ($convocatorias as $conv): ?>
                                <div style="background: #0b1329; border: 1px solid #1f293d; border-radius: 12px; padding: 16px; display: flex; flex-direction: column; justify-content: space-between;">
                                    <div>
                                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                                            <span style="background: #1e3a8a40; color: #60a5fa; font-size: 10px; font-weight: 700; padding: 3px 8px; border-radius: 4px; text-transform: uppercase; border: 1px solid #1e3a8a80;">
                                                <?= htmlspecialchars($conv['nombre_institucion'] ?? $nombreInstitucion) ?>
                                            </span>
                                            <span style="color: #94a3b8; font-size: 11px;">Convocatoria</span>
                                        </div>
                                        <h4 style="color: #ffffff; font-size: 15px; font-weight: 600; margin-bottom: 6px;"><?= htmlspecialchars($conv['titulo']) ?></h4>
                                        <?php if (!empty($conv['categoria'])): ?>
                                            <div style="display: inline-block; background: #0284c720; color: #38bdf8; font-size: 11px; padding: 2px 6px; border-radius: 4px; margin-bottom: 8px;">
                                                Categoría: <?= htmlspecialchars($conv['categoria']) ?>
                                            </div>
                                        <?php endif; ?>
                                        <p style="color: #94a3b8; font-size: 13px; line-height: 1.4; margin-bottom: 12px;"><?= nl2br(htmlspecialchars($conv['descripcion'])) ?></p>
                                    </div>
                                    <div style="border-top: 1px solid #1f293d; padding-top: 10px; display: flex; justify-content: space-between; align-items: center;">
                                        <span style="color: #64748b; font-size: 12px;">Cierre: <?= htmlspecialchars($conv['fecha_cierre']) ?></span>
                                        <span style="color: #34d399; font-size: 11px; font-weight: 500;">● Activa</span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <!-- MOSTRAR BECAS -->
                        <?php if (!empty($becas)): ?>
                            <?php foreach ($becas as $beca): ?>
                                <div style="background: #0b1329; border: 1px solid #1f293d; border-radius: 12px; padding: 16px; display: flex; flex-direction: column; justify-content: space-between;">
                                    <div>
                                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                                            <span style="background: #065f4640; color: #34d399; font-size: 10px; font-weight: 700; padding: 3px 8px; border-radius: 4px; text-transform: uppercase; border: 1px solid #065f4680;">
                                                <?= htmlspecialchars($beca['nombre_institucion'] ?? $nombreInstitucion) ?>
                                            </span>
                                            <span style="background: #065f4620; color: #34d399; font-size: 10px; font-weight: 600; padding: 2px 6px; border-radius: 4px;">Beca</span>
                                        </div>
                                        <h4 style="color: #ffffff; font-size: 15px; font-weight: 600; margin-bottom: 6px;"><?= htmlspecialchars($beca['titulo']) ?></h4>
                                        <p style="color: #94a3b8; font-size: 13px; line-height: 1.4; margin-bottom: 10px;"><?= nl2br(htmlspecialchars($beca['descripcion'])) ?></p>
                                        <?php if (!empty($beca['requisitos'])): ?>
                                            <p style="color: #cbd5e1; font-size: 12px; background: #0b0b0b; padding: 8px; border-radius: 6px; margin-bottom: 10px;">
                                                <strong style="color: #38bdf8;">Requisitos:</strong> <?= nl2br(htmlspecialchars($beca['requisitos'])) ?>
                                            </p>
                                        <?php endif; ?>
                                    </div>
                                    <div style="border-top: 1px solid #1f293d; padding-top: 10px; display: flex; justify-content: space-between; align-items: center;">
                                        <span style="color: #64748b; font-size: 12px;">Cierre: <?= htmlspecialchars($beca['fecha_cierre']) ?></span>
                                        <span style="color: #34d399; font-size: 11px; font-weight: 500;">● Activa</span>
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