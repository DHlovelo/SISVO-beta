<?php
// views/becas/index.php
?>
<div style="max-width: 1000px; margin: 0 auto; padding: 0 15px;">

    <div style="text-align: center; margin-bottom: 40px;">
        <h2 style="font-size: 32px; font-weight: 700; color: #ffffff; margin-bottom: 10px;">Becas y Apoyo Académico</h2>
        <p style="color: #94a3b8; font-size: 16px;">Consulta las oportunidades de descuento, programas de excelencia e incentivos económicos disponibles.</p>
    </div>

    <!-- Buscador o filtro rápido -->
    <div style="margin-bottom: 30px; display: flex; justify-content: center;">
        <input type="text" placeholder="Buscar por tipo de beca o institución..." style="width: 100%; max-width: 500px; background: #141414; border: 1px solid rgba(255, 255, 255, 0.1); padding: 14px 20px; border-radius: 30px; color: #fff; font-size: 14px; outline: none;">
    </div>

    <!-- Grid de Becas -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
        
        <div style="background: #141414; border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 16px; padding: 25px; position: relative;">
            <div style="font-size: 28px; margin-bottom: 15px;">🌟</div>
            <span style="font-size: 12px; font-weight: 600; color: #3b82f6; text-transform: uppercase; letter-spacing: 0.05em;">Excelencia Académica</span>
            <h3 style="font-size: 20px; color: #fff; margin: 10px 0;">Beca al Merito Estudiantil</h3>
            <p style="color: #94a3b8; font-size: 14px; line-height: 1.5; margin-bottom: 20px;">Dirigida a estudiantes destacados de secundaria o primeros semestres con promedios sobresalientes. Cobertura del 50% al 100% de la colegiatura.</p>
            <div style="border-top: 1px solid rgba(255,255,255,0.05); padding-top: 15px; display: flex; justify-content: space-between; align-items: center;">
                <span style="color: #64748b; font-size: 13px;">Requisito: Promedio &gt; 85/100</span>
                <a href="/SISVOX/public/index.php?route=test" style="color: #3b82f6; text-decoration: none; font-weight: 600; font-size: 13px;">Postular →</a>
            </div>
        </div>

        <div style="background: #141414; border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 16px; padding: 25px;">
            <div style="font-size: 28px; margin-bottom: 15px;">🤝</div>
            <span style="font-size: 12px; font-weight: 600; color: #3b82f6; text-transform: uppercase; letter-spacing: 0.05em;">Socioeconómica</span>
            <h3 style="font-size: 20px; color: #fff; margin: 10px 0;">Beca Social e Institucional</h3>
            <p style="color: #94a3b8; font-size: 14px; line-height: 1.5; margin-bottom: 20px;">Apoyo financiero diseñado para estudiantes que requieren respaldo económico verificado para culminar sus estudios profesionales.</p>
            <div style="border-top: 1px solid rgba(255,255,255,0.05); padding-top: 15px; display: flex; justify-content: space-between; align-items: center;">
                <span style="color: #64748b; font-size: 13px;">Estudio socioeconómico</span>
                <a href="/SISVOX/public/index.php?route=test" style="color: #3b82f6; text-decoration: none; font-weight: 600; font-size: 13px;">Postular →</a>
            </div>
        </div>

        <div style="background: #141414; border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 16px; padding: 25px;">
            <div style="font-size: 28px; margin-bottom: 15px;">💻</div>
            <span style="font-size: 12px; font-weight: 600; color: #3b82f6; text-transform: uppercase; letter-spacing: 0.05em;">Innovación & Tecnología</span>
            <h3 style="font-size: 20px; color: #fff; margin: 10px 0;">Beca Talento STEM</h3>
            <p style="color: #94a3b8; font-size: 14px; line-height: 1.5; margin-bottom: 20px;">Dirigida a postulantes interesados en carreras de Ingeniería de Sistemas, Robótica y áreas tecnológicas de alto impacto.</p>
            <div style="border-top: 1px solid rgba(255,255,255,0.05); padding-top: 15px; display: flex; justify-content: space-between; align-items: center;">
                <span style="color: #64748b; font-size: 13px;">Prueba de suficiencia</span>
                <a href="/SISVOX/public/index.php?route=test" style="color: #3b82f6; text-decoration: none; font-weight: 600; font-size: 13px;">Postular →</a>
            </div>
        </div>

    </div>

    <div style="margin-top: 40px; text-align: center;">
    <a href="/SISVOX/public/index.php?route=inicio_estudiante" class="btn-primary" style="display:inline-block; text-decoration: none; background-color: #ffffff; color: #0b0b0b; padding: 12px 28px; border-radius: 30px; font-weight: 600; font-size: 15px;">← Volver al inicio</a>
</div>
</div>