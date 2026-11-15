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
    <title>Directorio de Instituciones - SISVOX</title>
    <link rel="stylesheet" href="/SISVOX/public/css/instituciones.css">
</head>
<body>

    <div class="container">

        <div class="header-section">
            <h1>Directorio de Educación Superior y Técnica</h1>
            <p>Universidades, Institutos Tecnológicos, Comerciales y Academias con sede en La Paz y El Alto.</p>
        </div>

        <!-- Buscador interactivo -->
        <input type="text" id="buscador" class="search-box" placeholder="Buscar institución o sede (ej. UMSA, El Alto, Unifranz)..." onkeyup="filtrarInstituciones()">

        <!-- SECCIÓN 1: UNIVERSIDADES -->
        <h2 class="section-title">Universidades Públicas y Privadas</h2>
        <div class="grid-inst" id="lista-instituciones">
            
            <div class="card-inst" data-nombre="UMSA Universidad Mayor de San Andrés Monblock Sopocachi Miraflores La Paz Pública Autónoma">
                <div>
                    <span class="badge-tipo">Pública / Autónoma</span>
                    <h3>UMSA - Universidad Mayor de San Andrés</h3>
                    <p class="ubicacion">📍 Monblock, Sopocachi, Miraflores (La Paz)</p>
                </div>
                <div class="card-footer"><a href="#" target="_blank" class="btn-sitio">Sitio Oficial →</a></div>
            </div>

            <div class="card-inst" data-nombre="UPEA Universidad Pública de El Alto Villa Esperanza Pública">
                <div>
                    <span class="badge-tipo">Pública / Autónoma</span>
                    <h3>UPEA - Universidad Pública de El Alto</h3>
                    <p class="ubicacion">📍 Villa Esperanza (El Alto)</p>
                </div>
                <div class="card-footer"><a href="#" target="_blank" class="btn-sitio">Sitio Oficial →</a></div>
            </div>

            <div class="card-inst" data-nombre="UCB Universidad Católica Boliviana San Pablo Obrajes Calacoto La Paz Privada">
                <div>
                    <span class="badge-tipo">Privada</span>
                    <h3>UCB - Universidad Católica Boliviana "San Pablo"</h3>
                    <p class="ubicacion">📍 Obrajes / Calacoto (La Paz)</p>
                </div>
                <div class="card-footer"><a href="#" target="_blank" class="btn-sitio">Sitio Oficial →</a></div>
            </div>

            <div class="card-inst" data-nombre="UNIVALLE Universidad del Valle Miraflores Calacoto La Paz Privada">
                <div>
                    <span class="badge-tipo">Privada</span>
                    <h3>UNIVALLE - Universidad del Valle</h3>
                    <p class="ubicacion">📍 Miraflores / Calacoto (La Paz)</p>
                </div>
                <div class="card-footer"><a href="#" target="_blank" class="btn-sitio">Sitio Oficial →</a></div>
            </div>

            <div class="card-inst" data-nombre="UNIFRANZ Universidad Franz Tamayo Landaeta La Paz San Martin El Alto Privada">
                <div>
                    <span class="badge-tipo">Privada</span>
                    <h3>UNIFRANZ - Universidad Franz Tamayo</h3>
                    <p class="ubicacion">📍 Landaeta (La Paz) / San Martín (El Alto)</p>
                </div>
                <div class="card-footer"><a href="#" target="_blank" class="btn-sitio">Sitio Oficial →</a></div>
            </div>

            <div class="card-inst" data-nombre="EMI Escuela Militar de Ingeniería Alto Irpavi Av Arce La Paz Privada Militar">
                <div>
                    <span class="badge-tipo">Privada / Militar</span>
                    <h3>EMI - Escuela Militar de Ingeniería</h3>
                    <p class="ubicacion">📍 Alto Irpavi / Av. Arce (La Paz)</p>
                </div>
                <div class="card-footer"><a href="#" target="_blank" class="btn-sitio">Sitio Oficial →</a></div>
            </div>

            <div class="card-inst" data-nombre="UPB Universidad Privada Boliviana Achocalla La Paz Privada">
                <div>
                    <span class="badge-tipo">Privada</span>
                    <h3>UPB - Universidad Privada Boliviana</h3>
                    <p class="ubicacion">📍 Achocalla (La Paz)</p>
                </div>
                <div class="card-footer"><a href="#" target="_blank" class="btn-sitio">Sitio Oficial →</a></div>
            </div>

            <div class="card-inst" data-nombre="USB Universidad Salesiana de Bolivia Achachicala La Paz Privada">
                <div>
                    <span class="badge-tipo">Privada</span>
                    <h3>USB - Universidad Salesiana de Bolivia</h3>
                    <p class="ubicacion">📍 Achachicala (La Paz)</p>
                </div>
                <div class="card-footer"><a href="#" target="_blank" class="btn-sitio">Sitio Oficial →</a></div>
            </div>

            <div class="card-inst" data-nombre="ULP Universidad La Salle Bajo Llojeta La Paz Privada">
                <div>
                    <span class="badge-tipo">Privada</span>
                    <h3>ULP - Universidad La Salle</h3>
                    <p class="ubicacion">📍 Bajo Llojeta (La Paz)</p>
                </div>
                <div class="card-footer"><a href="#" target="_blank" class="btn-sitio">Sitio Oficial →</a></div>
            </div>

            <div class="card-inst" data-nombre="UNABOL UDABOL Universidad Aquino de Bolivia Sopocachi La Paz Privada">
                <div>
                    <span class="badge-tipo">Privada</span>
                    <h3>UNABOL - Universidad Aquino de Bolivia (UDABOL)</h3>
                    <p class="ubicacion">📍 Sopocachi (La Paz)</p>
                </div>
                <div class="card-footer"><a href="#" target="_blank" class="btn-sitio">Sitio Oficial →</a></div>
            </div>
        </div>

        <!-- SECCIÓN 2: INSTITUTOS -->
        <h2 class="section-title">Institutos Técnicos y Tecnológicos (Públicos y Privados)</h2>
        <div class="grid-inst">
            
            <div class="card-inst" data-nombre="INCOS La Paz Instituto Comercial Superior Fiscal Tecnico Sup Av Montes La Paz">
                <div>
                    <span class="badge-tipo">Fiscal / Técnico Sup.</span>
                    <h3>INCOS La Paz - Instituto Comercial Superior</h3>
                    <p class="ubicacion">📍 Av. Montes (La Paz)</p>
                </div>
                <div class="card-footer"><a href="#" target="_blank" class="btn-sitio">Sitio Oficial →</a></div>
            </div>

            <div class="card-inst" data-nombre="INCOS El Alto Instituto Comercial Superior Fiscal Tecnico Sup Zona Central El Alto">
                <div>
                    <span class="badge-tipo">Fiscal / Técnico Sup.</span>
                    <h3>INCOS El Alto - Instituto Comercial Superior</h3>
                    <p class="ubicacion">📍 Zona Central (El Alto)</p>
                </div>
                <div class="card-footer"><a href="#" target="_blank" class="btn-sitio">Sitio Oficial →</a></div>
            </div>

        </div>
        <div style="margin-top: 40px; text-align: center;">
    <a href="/SISVOX/public/index.php?route=inicio_estudiante" class="btn-primary" style="display:inline-block; text-decoration: none; background-color: #ffffff; color: #0b0b0b; padding: 12px 28px; border-radius: 30px; font-weight: 600; font-size: 15px;">← Volver al inicio</a>
</div>
    </div>

    <script>
        function filtrarInstituciones() {
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