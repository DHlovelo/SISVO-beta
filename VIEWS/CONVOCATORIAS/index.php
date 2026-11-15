<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Aseguramos que $convocatorias tenga datos (ya sea de la variable local o global)
$listaConvocatorias = $convocatorias ?? ($GLOBALS['convocatorias'] ?? []);
?>

<div class="container" style="max-width: 1400px; margin: 0 auto; padding: 30px 20px;">

    <!-- Encabezado Principal -->
    <div class="header-section" style="text-align: center; margin-bottom: 40px;">
        <h1 style="color: #ffffff; font-size: 32px; font-weight: 700; margin-bottom: 10px;">Convocatorias Vigentes</h1>
        <p style="color: #94a3b8; font-size: 15px; max-width: 700px; margin: 0 auto;">Revisa las convocatorias académicas, exámenes de suficiencia y oportunidades abiertas en nuestras instituciones aliadas.</p>
    </div>

    <div style="padding: 10px 0; max-width: 1260px; margin: 0 auto;">
        
        <!-- Insignia de Panel -->
        <div style="text-align: center; margin-bottom: 30px;">
            <span style="background: rgba(2, 132, 199, 0.1); color: #38bdf8; font-size: 12px; font-weight: 600; padding: 6px 16px; border-radius: 20px; text-transform: uppercase; letter-spacing: 1px; border: 1px solid rgba(2, 132, 199, 0.2); display: inline-block;">
                Panel de Convocatorias Institucionales
            </span>
        </div>

        <!-- BARRA DE BÚSQUEDA INTEGRADA -->
        <div style="max-width: 500px; margin: 0 auto 35px auto;">
            <input type="text" id="buscadorConvocatorias" placeholder="Buscar por título, institución o categoría..." onkeyup="filtrarConvocatorias()" style="width: 100%; padding: 12px 20px; background: #0b1329; border: 1px solid #1f293d; color: #ffffff; border-radius: 10px; font-size: 14px; outline: none; box-shadow: 0 2px 4px rgba(0,0,0,0.05); transition: border-color 0.2s;">
        </div>

        <!-- CUADRÍCULA DE TARJETAS DE CONVOCATORIAS -->
        <div class="contenedor-tarjetas" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(340px, 1fr)); gap: 24px;">
            
            <?php if (empty($listaConvocatorias)): ?>
                <!-- Estado vacío -->
                <div style="grid-column: 1 / -1; text-align: center; padding: 50px; background: #0b1329; border-radius: 14px; border: 1px dashed #1f293d;">
                    <p style="color: #94a3b8; font-size: 16px; margin: 0;">No hay convocatorias publicadas por el momento.</p>
                </div>
            <?php else: ?>

                <!-- Bucle dinámico de convocatorias -->
                <?php foreach ($listaConvocatorias as $conv): ?>
                    <div class="tarjeta-item" data-texto="<?= strtolower(htmlspecialchars(($conv['titulo'] ?? '') . ' ' . ($conv['nombre_institucion'] ?? '') . ' ' . ($conv['categoria'] ?? ''))) ?>" style="background: #0b1329; border: 1px solid #1f293d; border-radius: 14px; padding: 24px; display: flex; flex-direction: column; justify-content: space-between; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); transition: border-color 0.2s;">
                        
                        <div>
                            <!-- Insignia de Institución y Tipo -->
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                                <span style="background: rgba(37, 99, 235, 0.15); color: #60a5fa; font-size: 11px; font-weight: 700; padding: 5px 12px; border-radius: 6px; text-transform: uppercase; border: 1px solid rgba(37, 99, 235, 0.3); letter-spacing: 0.5px;">
                                    <?= htmlspecialchars($conv['nombre_institucion'] ?? 'Institución') ?>
                                </span>
                                <span style="background: rgba(37, 99, 235, 0.1); color: #60a5fa; font-size: 11px; font-weight: 600; padding: 2px 8px; border-radius: 4px;">Convocatoria</span>
                            </div>

                            <!-- Título -->
                            <h3 style="color: #ffffff; font-size: 20px; font-weight: 600; margin-bottom: 12px; line-height: 1.3;">
                                <?= htmlspecialchars($conv['titulo'] ?? '') ?>
                            </h3>

                            <!-- Categoría (si existe) -->
                            <?php if (!empty($conv['categoria'])): ?>
                                <div style="display: inline-block; background: rgba(2, 132, 199, 0.1); color: #38bdf8; font-size: 12px; padding: 4px 10px; border-radius: 6px; margin-bottom: 14px; border: 1px solid rgba(2, 132, 199, 0.2);">
                                    <strong>Categoría:</strong> <?= htmlspecialchars($conv['categoria']) ?>
                                </div>
                            <?php endif; ?>

                            <!-- Descripción -->
                            <p style="color: #94a3b8; font-size: 14px; line-height: 1.6; margin-bottom: 20px;">
                                <?= nl2br(htmlspecialchars($conv['descripcion'] ?? '')) ?>
                            </p>
                        </div>

                        <!-- Pie de tarjeta: Fecha y Botón -->
                        <div style="border-top: 1px solid #1f293d; padding-top: 16px; display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <span style="display: block; color: #64748b; font-size: 11px; text-transform: uppercase; font-weight: 600;">Fecha límite</span>
                                <span style="color: #cbd5e1; font-size: 13px; font-weight: 500;"><?= htmlspecialchars($conv['fecha_cierre'] ?? 'No definida') ?></span>
                            </div>
                            <a href="#" style="background: #0284c7; color: #ffffff; padding: 8px 16px; border-radius: 8px; font-size: 13px; text-decoration: none; font-weight: 600; box-shadow: 0 2px 4px rgba(2, 132, 199, 0.3); transition: background 0.2s;">
                                Ver detalles &rarr;
                            </a>
                        </div>

                    </div>
                <?php endforeach; ?>

            <?php endif; ?>
        </div>
    </div>

    <!-- Botón de retorno -->
    <div style="margin: 40px 0; text-align: center;">
        <a href="/SISVOX/public/index.php?route=inicio_estudiante" class="btn-primary" style="display:inline-block; text-decoration: none; background-color: #ffffff; color: #0b0b0b; padding: 12px 28px; border-radius: 30px; font-weight: 600; font-size: 15px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">← Volver al inicio</a>
    </div>

</div>

<!-- SCRIPT DE FILTRADO EN TIEMPO REAL -->
<script>
function filtrarConvocatorias() {
    let input = document.getElementById('buscadorConvocatorias').value.toLowerCase();
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