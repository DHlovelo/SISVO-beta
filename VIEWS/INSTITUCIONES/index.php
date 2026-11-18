<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$sedesPublicas = $GLOBALS['sedesPublicas'] ?? [];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Directorio de Instituciones - SISVOX</title>
    <link rel="stylesheet" href="/SISVOX/public/css/instituciones.css">
</head>
<body>

    <div class="container">

        <div class="header-section">
            <h1>Directorio de Educación Superior y Técnica</h1>
            <p>Universidades, Institutos Tecnológicos, Comerciales y Academias con sede en La Paz y El Alto.</p>
        </div>

        <input type="text" id="buscador" class="search-box" placeholder="Buscar institución, sede o ciudad (ej. Unifranz, El Alto, Central)..." onkeyup="filtrarSedes()">

        <h2 class="section-title">Sedes y Campus Registrados</h2>
        
        <div class="grid-inst" id="lista-instituciones">
            <?php if (empty($sedesPublicas)): ?>
                <p style="color: #9ca3af; text-align: center; grid-column: span 2; padding: 40px;">
                    No hay sedes registradas en el sistema actualmente.
                </p>
            <?php else: ?>
                <?php foreach ($sedesPublicas as $sede): 
                    $textoBusq = strtolower(($sede['nombre_institucion'] ?? '') . ' ' . ($sede['nombre_sede'] ?? '') . ' ' . ($sede['ciudad'] ?? '') . ' ' . ($sede['direccion'] ?? ''));
                ?>
                    <div class="card-inst" data-nombre="<?= htmlspecialchars($textoBusq) ?>">
                        <div>
                            <span class="badge-tipo"><?= htmlspecialchars($sede['tipo_institucion'] ?? 'Institución') ?></span>
                            
                            <h3 style="margin-top: 6px; color: #ffffff;"><?= htmlspecialchars($sede['nombre_institucion'] ?? $sede['nombre'] ?? 'Institución') ?></h3>
                            
                            <p style="font-size: 15px; font-weight: 600; color: #3b82f6; margin-top: 8px;">
                                📍 Sede: <?= htmlspecialchars($sede['nombre_sede']) ?>
                            </p>

                            <div class="ubicacion" style="margin-top: 8px; font-size: 14px; color: #9ca3af;">
                                <p><strong>Ciudad / Depto:</strong> <?= htmlspecialchars($sede['ciudad']) ?></p>
                                <p><strong>Dirección:</strong> <?= htmlspecialchars($sede['direccion']) ?></p>
                                <?php if (!empty($sede['telefono_sede'])): ?>
                                    <p><strong>Teléfono:</strong> <?= htmlspecialchars($sede['telefono_sede']) ?></p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="card-footer" style="margin-top: 18px; display: flex; justify-content: space-between; align-items: center;">
                            <?php if (!empty($sede['url_maps'])): ?>
                                <a href="<?= htmlspecialchars($sede['url_maps']) ?>" target="_blank" class="link-map" style="color: #3b82f6; text-decoration: none; font-weight: 500;">Ver en Google Maps ↗</a>
                            <?php else: ?>
                                <span></span>
                            <?php endif; ?>

                            <?php if (!empty($sede['sitio_web'])): ?>
                                <a href="<?= htmlspecialchars($sede['sitio_web']) ?>" target="_blank" class="btn-sitio">Sitio Oficial →</a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <div style="margin-top: 40px; text-align: center;">
            <a href="/SISVOX/public/index.php?route=inicio_estudiante" class="btn-primary" style="display:inline-block; text-decoration: none; background-color: #ffffff; color: #0b0b0b; padding: 12px 28px; border-radius: 30px; font-weight: 600; font-size: 15px;">← Volver al inicio</a>
        </div>
    </div>

    <script>
        function filtrarSedes() {
            let input = document.getElementById('buscador').value.toLowerCase();
            let tarjetas = document.getElementsByClassName('card-inst');

            for (let i = 0; i < tarjetas.length; i++) {
                let texto = tarjetas[i].getAttribute('data-nombre').toLowerCase();
                if (texto.includes(input)) {
                    tarjetas[i].style.display = "";
                } else {
                    tarjetas[i].style.display = "none";
                }
            }
        }
    </script>
</body>
</html>