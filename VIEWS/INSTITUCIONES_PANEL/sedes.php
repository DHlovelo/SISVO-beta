<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
$nombreInstitucion = $_SESSION['nombre'] ?? $_SESSION['nombre_institucion'] ?? 'Institución';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Sedes - SISVO</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { background-color: #0b0b0b; color: #ffffff; font-family: 'Plus Jakarta Sans', sans-serif; min-height: 100vh; display: flex; flex-direction: column; justify-content: space-between; }
        
        /* Navbar */
        .navbar { display: flex; justify-content: space-between; align-items: center; padding: 25px 60px; max-width: 1400px; width: 100%; margin: 0 auto; border-bottom: 1px solid rgba(255, 255, 255, 0.08); }
        .logo { font-size: 22px; font-weight: 700; letter-spacing: 1px; color: #ffffff; text-decoration: none; }
        .logo span { color: #3b82f6; }
        .nav-links { display: flex; gap: 25px; align-items: center; }
        .nav-links a { color: #9ca3af; text-decoration: none; font-size: 14px; font-weight: 500; transition: color 0.2s; }
        .nav-links a:hover, .nav-links a.active { color: #ffffff; }
        .nav-links a.logout { color: #ef4444; font-weight: 600; }

        main { flex: 1; max-width: 1260px; width: 100%; margin: 0 auto; padding: 40px 20px; }

        /* Alertas */
        .alert { padding: 12px 18px; border-radius: 10px; margin-bottom: 20px; font-size: 14px; }
        .alert-success { background: rgba(34,197,94,0.12); border: 1px solid rgba(34,197,94,0.3); color: #4ade80; }
        .alert-error { background: rgba(239,68,68,0.12); border: 1px solid rgba(239,68,68,0.3); color: #f87171; }

        /* Tarjetas */
        .card {
            background-color: #141414;
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 16px;
            padding: 30px;
            margin-bottom: 30px;
        }
        .card h2 { font-size: 20px; margin-bottom: 6px; color: #ffffff; }
        .card p.subtitle { color: #9ca3af; font-size: 14px; margin-bottom: 22px; }

        /* Formulario */
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .form-group { display: flex; flex-direction: column; margin-bottom: 4px; }
        .form-group.full { grid-column: span 2; }
        label { font-size: 13px; color: #9ca3af; margin-bottom: 8px; font-weight: 500; display: block; }
        input {
            width: 100%;
            background: #0b0b0b;
            border: 1px solid rgba(255,255,255,0.15);
            color: #ffffff;
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 14px;
            outline: none;
        }
        input:focus { border-color: #3b82f6; }
        
        .btn-save {
            background: #3b82f6;
            color: #ffffff;
            border: none;
            padding: 12px 28px;
            border-radius: 30px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 20px;
            font-size: 14px;
            transition: background 0.2s;
        }
        .btn-save:hover { background: #2563eb; }

        /* Tabla */
        .table-responsive { width: 100%; overflow-x: auto; margin-top: 10px; }
        table { width: 100%; border-collapse: collapse; text-align: left; }
        th, td { padding: 14px 12px; border-bottom: 1px solid rgba(255,255,255,0.08); font-size: 14px; }
        th { color: #9ca3af; font-weight: 600; }
        td { color: #ffffff; }
        
        .btn-del {
            background: rgba(239,68,68,0.15);
            color: #ef4444;
            border: 1px solid rgba(239,68,68,0.3);
            padding: 6px 14px;
            border-radius: 20px;
            cursor: pointer;
            font-size: 13px;
            transition: 0.2s;
        }
        .btn-del:hover { background: #ef4444; color: #ffffff; }
        .link-map { color: #3b82f6; text-decoration: none; font-weight: 500; }
        .link-map:hover { text-decoration: underline; }

        footer { border-top: 1px solid rgba(255, 255, 255, 0.08); text-align: center; padding: 25px; color: #6b7280; font-size: 13px; }

        @media (max-width: 768px) {
            .form-grid { grid-template-columns: 1fr; }
            .form-group.full { grid-column: span 1; }
            .navbar { padding: 20px; flex-direction: column; gap: 15px; }
        }
    </style>
</head>
<body>

    <!-- NAVBAR UNIFICADA -->
     <header class="navbar">
        <a href="#" class="logo">SIS<span>VO</span></a>
        <nav class="nav-links">
            <a href="/SISVOX/PUBLIC/index.php?route=institucion_convocatorias">Inicio</a>
            <a href="/SISVOX/PUBLIC/index.php?route=chatbot">Chatbot</a>
            <a href="/SISVOX/PUBLIC/index.php?route=carreras">Carreras</a>
            <a href="/SISVOX/PUBLIC/index.php?route=institucion_sedes">Sedes</a>
            <a href="/SISVOX/PUBLIC/index.php?route=institucion_convocatorias" class="active">Convocatorias</a>
            <a href="/SISVOX/PUBLIC/index.php?route=institucion_becas">Becas</a>
            <a href="#" style="color: #3b82f6; font-weight: 600; cursor: default;"><?php echo htmlspecialchars($nombreInstitucion); ?></a>
            <a href="/SISVOX/PUBLIC/index.php?route=logout" class="logout">Salir (<?php echo htmlspecialchars($nombreInstitucion); ?>)</a>
        </nav>
    </header>

    <main>
        <!-- Mensajes de confirmación o error -->
        <?php if (isset($_GET['exito'])): ?>
            <div class="alert alert-success">
                <?php
                    if ($_GET['exito'] === 'creado') echo '✓ Sede agregada correctamente. Ya es visible para los estudiantes.';
                    elseif ($_GET['exito'] === 'eliminado') echo '✓ Sede eliminada correctamente.';
                ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['error']) && $_GET['error'] === 'campos_vacios'): ?>
            <div class="alert alert-error">
                ⚠ Por favor completa el nombre de la sede, la ciudad y la dirección.
            </div>
        <?php endif; ?>

        <!-- Formulario para registrar una nueva sede -->
        <div class="card">
            <h2>Agregar Nueva Sede</h2>
            <p class="subtitle">Registra tus campus, sucursales o centros de atención para que los postulantes puedan ubicarlos.</p>

            <form action="/SISVOX/PUBLIC/index.php?route=institucion_guardar_sede" method="POST">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="nombre_sede">Nombre de la Sede *</label>
                        <input type="text" id="nombre_sede" name="nombre_sede" placeholder="Ej. Campus Central / Sede El Alto" required>
                    </div>
                    <div class="form-group">
                        <label for="ciudad">Ciudad / Departamento *</label>
                        <input type="text" id="ciudad" name="ciudad" placeholder="Ej. La Paz / El Alto" required>
                    </div>
                    <div class="form-group full">
                        <label for="direccion">Dirección exacta *</label>
                        <input type="text" id="direccion" name="direccion" placeholder="Ej. Av. 6 de Agosto #2170, Zona Sopocachi" required>
                    </div>
                    <div class="form-group">
                        <label for="telefono_sede">Teléfono / WhatsApp (Opcional)</label>
                        <input type="text" id="telefono_sede" name="telefono_sede" placeholder="Ej. 2-2441122">
                    </div>
                    <div class="form-group">
                        <label for="url_maps">Enlace de Google Maps (Opcional)</label>
                        <input type="url" id="url_maps" name="url_maps" placeholder="https://maps.google.com/...">
                    </div>
                </div>
                <button type="submit" class="btn-save">+ Guardar Sede</button>
            </form>
        </div>

        <!-- Listado de sedes registradas -->
        <div class="card">
            <h2>Sedes Registradas (<?= count($sedes ?? []) ?>)</h2>
            <p class="subtitle">Estas ubicaciones aparecen automáticamente en el directorio público de instituciones.</p>

            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Nombre de Sede</th>
                            <th>Ciudad</th>
                            <th>Dirección</th>
                            <th>Teléfono</th>
                            <th>Mapa</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($sedes)): ?>
                            <tr>
                                <td colspan="6" style="color: #9ca3af; text-align: center; padding: 24px;">
                                    Aún no has registrado ninguna sede.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($sedes as $sede): ?>
                                <tr>
                                    <td><strong><?= htmlspecialchars($sede['nombre_sede']) ?></strong></td>
                                    <td><?= htmlspecialchars($sede['ciudad']) ?></td>
                                    <td><?= htmlspecialchars($sede['direccion']) ?></td>
                                    <td><?= htmlspecialchars($sede['telefono_sede'] ?: '-') ?></td>
                                    <td>
                                        <?php if (!empty($sede['url_maps'])): ?>
                                            <a href="<?= htmlspecialchars($sede['url_maps']) ?>" target="_blank" class="link-map">Ver mapa ↗</a>
                                        <?php else: ?>
                                            <span style="color: #6b7280;">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <form action="/SISVOX/PUBLIC/index.php?route=institucion_eliminar_sede" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar esta sede?');">
                                            <input type="hidden" name="id_sede" value="<?= (int) $sede['id_sede'] ?>">
                                            <button type="submit" class="btn-del">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <footer>SISVO - Proyecto de Programación &copy; 2026</footer>

</body>
</html>