<?php
// views/becas/index.php
?>
<div style="max-width: 1000px; margin: 0 auto; padding: 0 15px;">

    <div style="text-align: center; margin-bottom: 40px;">
        <h2 style="font-size: 32px; font-weight: 700; color: #ffffff; margin-bottom: 10px;">Becas y Apoyo Académico</h2>
        <p style="color: #94a3b8; font-size: 16px;">Consulta las oportunidades de descuento, programas de excelencia e incentivos económicos disponibles.</p>
    </div>
 <div style="margin-bottom: 30px; display: flex; justify-content: center;">
        <input type="text" placeholder="Buscar por tipo de beca o institución..." style="width: 100%; max-width: 500px; background: #141414; border: 1px solid rgba(255, 255, 255, 0.1); padding: 14px 20px; border-radius: 30px; color: #fff; font-size: 14px; outline: none;">
    </div>


<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 24px; padding: 20px 0;">
    
    <?php if (empty($becas)): ?>
        <div style="grid-column: 1 / -1; text-align: center; padding: 50px; background: #141414; border-radius: 16px; border: 1px dashed rgba(255,255,255,0.1);">
            <p style="color: #9ca3af; font-size: 15px; margin: 0;">No hay programas de becas disponibles en este momento.</p>
        </div>
    <?php else: ?>
        <?php foreach ($becas as $beca): ?>
            <!-- CADA TARJETA COMPARTE EXACTAMENTE LA MISMA ESTRUCTURA Y TAMAÑO -->
            <div style="background: #141414; border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 16px; padding: 24px; display: flex; flex-direction: column; justify-content: space-between; transition: border-color 0.2s;">
                
                <div>
                    <!-- Insignia de la Institución y Etiqueta -->
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                        <span style="background: rgba(16, 185, 129, 0.15); color: #10b981; font-size: 11px; font-weight: 700; padding: 4px 10px; border-radius: 6px; text-transform: uppercase;">
                            <?= htmlspecialchars($beca['nombre_institucion'] ?? 'Institución') ?>
                        </span>
                        <span style="background: rgba(16, 185, 129, 0.1); color: #10b981; font-size: 11px; font-weight: 600; padding: 2px 8px; border-radius: 4px;">Beca</span>
                    </div>

                    <!-- Título -->
                    <h3 style="color: #ffffff; font-size: 18px; font-weight: 600; margin-bottom: 10px; line-height: 1.4;">
                        <?= htmlspecialchars($beca['titulo']) ?>
                    </h3>

                    <!-- Descripción -->
                    <p style="color: #9ca3af; font-size: 13px; line-height: 1.6; margin-bottom: 16px;">
                        <?= nl2br(htmlspecialchars($beca['descripcion'])) ?>
                    </p>

                    <!-- Requisitos (si existen) -->
                    <?php if (!empty($beca['requisitos'])): ?>
                        <div style="background: #0b0b0b; border: 1px solid rgba(255, 255, 255, 0.05); padding: 12px; border-radius: 8px; margin-bottom: 20px;">
                            <span style="display: block; color: #3b82f6; font-size: 11px; font-weight: 600; margin-bottom: 4px; text-transform: uppercase;">Requisitos:</span>
                            <p style="color: #d1d5db; font-size: 12px; margin: 0; line-height: 1.4;"><?= nl2br(htmlspecialchars($beca['requisitos'])) ?></p>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Pie de tarjeta: Fecha y Botón alineados perfectamente -->
                <div style="border-top: 1px solid rgba(255, 255, 255, 0.05); padding-top: 16px; display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <span style="display: block; color: #6b7280; font-size: 10px; text-transform: uppercase; font-weight: 600;">Cierre</span>
                        <span style="color: #e5e7eb; font-size: 12px; font-weight: 500;"><?= htmlspecialchars($beca['fecha_cierre']) ?></span>
                    </div>
                    <a href="#" style="background: #10b981; color: #ffffff; padding: 8px 16px; border-radius: 8px; font-size: 12px; text-decoration: none; font-weight: 600; transition: background 0.2s;">
                        Postularse &rarr;
                    </a>
                </div>
            </div>
            <br>
            <div style="margin-top: 40px; text-align: center;">
    <a href="/SISVOX/public/index.php?route=inicio_estudiante" class="btn-primary" style="display:inline-block; text-decoration: none; background-color: #ffffff; color: #0b0b0b; padding: 12px 28px; border-radius: 30px; font-weight: 600; font-size: 15px;">← Volver al inicio</a>
</div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>