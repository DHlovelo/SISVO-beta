<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acerca de SISVO - Sistema de Orientación Vocacional</title>
    <link rel="stylesheet" href="/SISVOX/public/css/acerca.css">
</head>
<body>

    <div class="container">

        <div class="about-card">
            <div class="about-header">
                <h1>Acerca de SISVO</h1>
                <p>Sistema Inteligente de Orientación Vocacional</p>
            </div>

            <div class="about-section">
                <h3>¿Qué es SISVO?</h3>
                <p>SISVO es una plataforma web diseñada para guiar a los estudiantes en
                    su proceso de elección vocacional y profesional, conectándoles con un catálogo completo de 
                    carreras universitarias tanto publicas como privadas, institutos técnicos, 
                    convocatorias vigentes y herramientas interactivas.</p>
            </div>

            <div class="about-section">
                <h3>Propósito del Sistema</h3>
                <p>Brindar orientación estructurada, confiable y accesible, facilitando la toma de 
                    decisiones sobre el futuro académico mediante tests de afinidad con el indicador MBTI y asistencia virtual inteligente.
                    <br> Somos un proyecto sin fines de lucro, desarrollado por estudiantes de Ingeniería de Sistemas, con el objetivo de contribuir al desarrollo profesional y académico de la comunidad estudiantil.</p>
                </p>
            </div>
            </div>

            <div style="margin-top: 40px; text-align: center;">
                <a href="/SISVOX/public/index.php?route=inicio_estudiante" class="btn-primary" style="display:inline-block; text-decoration: none; background-color: #ffffff; color: #0b0b0b; padding: 12px 28px; border-radius: 30px; font-weight: 600; font-size: 15px;">← Volver al inicio</a>
            </div>
            <div class="about-section" style="text-align: center; margin-top: 30px; border-top: 1px solid #334155; padding-top: 20px;">
                <p style="color: #64748b; font-size: 0.85rem;">Plataforma desarrollada para el desarrollo profesional y académico en Ingeniería de Sistemas.</p>
            </div>
        </div>
        
    </div>

</body>
</html>