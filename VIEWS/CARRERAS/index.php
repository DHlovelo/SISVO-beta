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
    <title>Carreras Profesionales - SISVOX</title>
    <link rel="stylesheet" href="/SISVOX/public/css/carreras.css">
</head>
<body>

    <div class="container">

        <div class="header-section">
            <h1>Catálogo de Carreras</h1>
            <p>Explora las opciones profesionales y técnicas disponibles en nuestras instituciones aliadas.</p>
            <input type="text" id="buscadorCarreras" class="search-box" placeholder="Buscar carrera (ej. Ingeniería de Sistemas, Contaduría...)" onkeyup="filtrarCarreras()">
        </div>

        <div class="grid-carreras" id="lista-carreras">
            <!-- Carrera 1 -->
            <div class="card-carrera" data-nombre="ingenieria de sistemas tecnologia software bases de datos redes">
                <div>
                    <span class="carrera-tag">Ingeniería & Tecnología</span>
                    <h3>Ingeniería de Sistemas</h3>
                    <p>Diseño, desarrollo y gestión de sistemas de software, bases de datos y arquitecturas de red modernas.</p>
                </div>
                <div class="card-action">
                    <span style="font-size: 0.85rem; color: #64748b;">Duración: 4 - 5 años</span>
                    <a href="#" class="btn-afinidad">Evaluar afinidad →</a>
                </div>
            </div>

            <!-- Carrera 2 -->
            <div class="card-carrera" data-nombre="contaduria publica administracion finanzas auditoria tributacion">
                <div>
                    <span class="carrera-tag">Administración & Finanzas</span>
                    <h3>Contaduría Pública</h3>
                    <p>Gestión contable, auditoría financiera, tributación y simulación de balances empresariales estratégicos.</p>
                </div>
                <div class="card-action">
                    <span style="font-size: 0.85rem; color: #64748b;">Duración: 4 años</span>
                    <a href="#" class="btn-afinidad">Evaluar afinidad →</a>
                </div>
            </div>

            <!-- Carrera 3 -->
            <div class="card-carrera" data-nombre="linguistica e idiomas educacion lenguas traduccion">
                <div>
                    <span class="carrera-tag">Educación & Idiomas</span>
                    <h3>Lingüística e Idiomas</h3>
                    <p>Dominio avanzado de lenguas extranjeras, traducción técnica y metodologías innovadoras de enseñanza.</p>
                </div>
                <div class="card-action">
                    <span style="font-size: 0.85rem; color: #64748b;">Duración: 4 años</span>
                    <a href="#" class="btn-afinidad">Evaluar afinidad →</a>
                </div>
            </div>
        </div>
        <div style="margin-top: 40px; text-align: center;">
         <a href="/SISVOX/public/index.php?route=inicio_estudiante" class="btn-primary" style="display:inline-block; text-decoration: none; background-color: #ffffff; color: #0b0b0b; padding: 12px 28px; border-radius: 30px; font-weight: 600; font-size: 15px;">← Volver al inicio</a>
        </div>
    </div>

    <script>
        function filtrarCarreras() {
            let input = document.getElementById('buscadorCarreras').value.toLowerCase();
            let tarjetas = document.getElementsByClassName('card-carrera');
            for (let i = 0; i < tarjetas.length; i++) {
                let texto = tarjetas[i].getAttribute('data-nombre').toLowerCase();
                tarjetas[i].style.display = texto.includes(input) ? "" : "none";
            }
        }
    </script>
</body>
</html>