<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Convocatorias - SISVO</title>
    <link rel="stylesheet" href="css/convocatoria.css">
</head>
<body>
<div class="container">

        <div class="header-section">
            <h1>Convocatorias Vigentes</h1>
            <p>Revisa las convocatorias académicas, exámenes de suficiencia y oportunidades abiertas en nuestras instituciones aliadas.</p>
        </div>

<div style="padding: 20px 10px; max-width: 1260px; margin: 0 auto;">
    <!-- Encabezado de la Sección -->
    <div style="text-align: center; margin-bottom: 30px;">
        <span style="background: #3a637015; color: #7e878b; font-size: 12px; font-weight: 600; padding: 6px 16px; border-radius: 20px; text-transform: uppercase; letter-spacing: 1px; border: 1px solid #0284c730; display: inline-block; margin-bottom: 12px;">
            Panel Institucional
        </span>
    </div>

    <!-- BARRA DE BÚSQUEDA INTEGRADA -->
    <div style="max-width: 500px; margin: 0 auto 35px auto;">
        <input type="text" id="buscadorPublicaciones" placeholder="Buscar por título, institución o categoría..." onkeyup="filtrarPublicaciones()" style="width: 100%; padding: 12px 20px; background: #0b1329; border: 1px solid #1f293d; color: #ffffff; border-radius: 10px; font-size: 14px; outline: none; box-shadow: 0 2px 4px rgba(0,0,0,0.05); transition: border-color 0.2s;">
    </div>

    <!-- CUADRÍCULA DE TARJETAS -->
    <div class="contenedor-tarjetas" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(340px, 1fr)); gap: 24px;">
        
        <?php if (empty($convocatorias) && empty($becas)): ?>
            <div style="grid-column: 1 / -1; text-align: center; padding: 50px; background: #f8fafc; border-radius: 12px; border: 1px dashed #cbd5e1;">
                <p style="color: #64748b; font-size: 16px; margin: 0;">No hay convocatorias ni becas publicadas por el momento.</p>
            </div>
        <?php else: ?>

            <!-- MOSTRAR CONVOCATORIAS -->
            <?php foreach ($convocatorias as $conv): ?>
                <div class="tarjeta-item" data-texto="<?= strtolower(htmlspecialchars($conv['titulo'] . ' ' . $conv['nombre_institucion'] . ' ' . ($conv['categoria'] ?? ''))) ?>" style="background: #0b1329; border: 1px solid #1f293d; border-radius: 14px; padding: 24px; display: flex; flex-direction: column; justify-content: space-between; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
                    <div>
                        <!-- Insignia de Institución -->
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                            <span style="background: #1e3a8a40; color: #60a5fa; font-size: 11px; font-weight: 700; padding: 5px 12px; border-radius: 6px; text-transform: uppercase; border: 1px solid #1e3a8a80; letter-spacing: 0.5px;">
                                <?= htmlspecialchars($conv['nombre_institucion']) ?>
                            </span>
                            <span style="color: #94a3b8; font-size: 12px;">Convocatoria</span>
                        </div>

                        <h3 style="color: #ffffff; font-size: 20px; font-weight: 600; margin-bottom: 12px; line-height: 1.3;">
                            <?= htmlspecialchars($conv['titulo']) ?>
                        </h3>

                        <?php if (!empty($conv['categoria'])): ?>
                            <div style="display: inline-block; background: #0284c720; color: #38bdf8; font-size: 12px; padding: 4px 10px; border-radius: 6px; margin-bottom: 14px; border: 1px solid #0284c740;">
                                <strong>Categoría:</strong> <?= htmlspecialchars($conv['categoria']) ?>
                            </div>
                        <?php endif; ?>

                        <p style="color: #94a3b8; font-size: 14px; line-height: 1.6; margin-bottom: 24px;">
                            <?= nl2br(htmlspecialchars($conv['descripcion'])) ?>
                        </p>
                    </div>

                    <!-- Pie de tarjeta -->
                    <div style="border-top: 1px solid #1f293d; padding-top: 16px; display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <span style="display: block; color: #64748b; font-size: 11px; text-transform: uppercase; font-weight: 600;">Fecha límite</span>
                            <span style="color: #cbd5e1; font-size: 13px; font-weight: 500;"><?= htmlspecialchars($conv['fecha_cierre']) ?></span>
                        </div>
                        <a href="#" style="background: #0284c7; color: #ffffff; padding: 8px 16px; border-radius: 8px; font-size: 13px; text-decoration: none; font-weight: 600; box-shadow: 0 2px 4px rgba(2, 132, 199, 0.3);">
                            Ver detalles &rarr;
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>

            <!-- MOSTRAR BECAS -->
            <?php foreach ($becas as $beca): ?>
                <div class="tarjeta-item" data-texto="<?= strtolower(htmlspecialchars($beca['titulo'] . ' ' . $beca['nombre_institucion'] . ' beca')) ?>" style="background: #0b1329; border: 1px solid #1f293d; border-radius: 14px; padding: 24px; display: flex; flex-direction: column; justify-content: space-between; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
                    <div>
                        <!-- Insignia de Institución -->
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                            <span style="background: #065f4640; color: #34d399; font-size: 11px; font-weight: 700; padding: 5px 12px; border-radius: 6px; text-transform: uppercase; border: 1px solid #065f4680; letter-spacing: 0.5px;">
                                <?= htmlspecialchars($beca['nombre_institucion']) ?>
                            </span>
                            <span style="background: #065f4620; color: #34d399; font-size: 11px; font-weight: 600; padding: 2px 8px; border-radius: 4px;">Beca</span>
                        </div>

                        <h3 style="color: #ffffff; font-size: 20px; font-weight: 600; margin-bottom: 12px; line-height: 1.3;">
                            <?= htmlspecialchars($beca['titulo']) ?>
                        </h3>

                        <p style="color: #94a3b8; font-size: 14px; line-height: 1.6; margin-bottom: 16px;">
                            <?= nl2br(htmlspecialchars($beca['descripcion'])) ?>
                        </p>

                        <?php if (!empty($beca['requisitos'])): ?>
                            <div style="background: #0f172a; border: 1px solid #1e293b; padding: 12px; border-radius: 8px; margin-bottom: 20px;">
                                <span style="display: block; color: #38bdf8; font-size: 12px; font-weight: 600; margin-bottom: 4px;">Requisitos principales:</span>
                                <p style="color: #cbd5e1; font-size: 13px; margin: 0; line-height: 1.4;"><?= nl2br(htmlspecialchars($beca['requisitos'])) ?></p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Pie de tarjeta -->
                    <div style="border-top: 1px solid #1f293d; padding-top: 16px; display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <span style="display: block; color: #64748b; font-size: 11px; text-transform: uppercase; font-weight: 600;">Fecha límite</span>
                            <span style="color: #cbd5e1; font-size: 13px; font-weight: 500;"><?= htmlspecialchars($beca['fecha_cierre']) ?></span>
                        </div>
                        <a href="#" style="background: #059669; color: #ffffff; padding: 8px 16px; border-radius: 8px; font-size: 13px; text-decoration: none; font-weight: 600; box-shadow: 0 2px 4px rgba(5, 150, 105, 0.3);">
                            Ver detalles &rarr;
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>

        <?php endif; ?>
    </div>
</div>

<div style="margin: 40px 0; text-align: center;">
    <a href="/SISVOX/public/index.php?route=inicio_estudiante" class="btn-primary" style="display:inline-block; text-decoration: none; background-color: #ffffff; color: #0b0b0b; padding: 12px 28px; border-radius: 30px; font-weight: 600; font-size: 15px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">← Volver al inicio</a>
</div>

<!-- SCRIPT DE FILTRADO EN TIEMPO REAL -->
<script>
function filtrarPublicaciones() {
    let input = document.getElementById('buscadorPublicaciones').value.toLowerCase();
    let tarjetas = document.getElementsByClassName('tarjeta-item');

    for (let i = 0; i < tarjetas.length; i++) {
        let textoBusqueda = tarjetas[i].getAttribute('data-texto');
        if (textoBusqueda.includes(input)) {
            tarjetas[i].style.display = "flex";
        } else {
            tarjetas[i].style.display = "none";
        }
    }
}
</script>

</body>
</html>