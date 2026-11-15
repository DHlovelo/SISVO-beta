<?php
// VIEWS/AUTH/seleccionar_rol.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seleccionar Tipo de Acceso - SISVO</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body {
            background-color: #0f172a;
            color: #f8fafc;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .header-select { text-align: center; margin-bottom: 40px; max-width: 600px; }
        .header-select h1 { font-size: 2.2rem; color: #fff; margin-bottom: 10px; }
        .header-select h1 span { color: #38bdf8; }
        .header-select p { color: #94a3b8; font-size: 1.05rem; }

        .cards-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            max-width: 750px;
            width: 100%;
        }
        .role-card {
            background: #1e293b;
            border: 1px solid #334155;
            border-radius: 16px;
            padding: 35px 25px;
            text-align: center;
            text-decoration: none;
            color: inherit;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }
        .role-card:hover {
            transform: translateY(-6px);
            border-color: #38bdf8;
            box-shadow: 0 12px 30px rgba(56, 189, 248, 0.15);
        }
        .icon-circle {
            width: 70px;
            height: 70px;
            background: rgba(56, 189, 248, 0.1);
            border: 1px solid rgba(56, 189, 248, 0.3);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin: 0 auto 20px auto;
        }
        .role-card h2 { font-size: 1.4rem; color: #fff; margin-bottom: 12px; }
        .role-card p { color: #94a3b8; font-size: 0.95rem; line-height: 1.5; margin-bottom: 25px; }
        .btn-select {
            background: #0284c7;
            color: #fff;
            padding: 12px 20px;
            border-radius: 8px;
            font-weight: 600;
            transition: background 0.3s;
        }
        .role-card:hover .btn-select { background: #38bdf8; color: #0f172a; }
        
        .back-link { margin-top: 35px; color: #94a3b8; text-decoration: none; font-size: 0.95rem; transition: color 0.3s; }
        .back-link:hover { color: #38bdf8; }
    </style>
</head>
<body>

    <div class="header-select">
        <h1>Bienvenido a <span>SISVO</span></h1>
        <p>Selecciona cómo deseas ingresar a la plataforma para continuar con tu inicio de sesión.</p>
    </div>

    <div class="cards-container">
        <!-- Opción 1: Estudiante / Usuario Normal -->
        <a href="/SISVOX/PUBLIC/index.php?route=login&tipo=usuario" class="role-card">
            <div>
                <div class="icon-circle">🎓</div>
                <h2>Estudiante / Usuario</h2>
                <p>Accede para realizar el test vocacional, explorar carreras, revisar convocatorias, becas y usar el chatbot orientador.</p>
            </div>
            <div class="btn-select">Ingresar como Estudiante</div>
        </a>

        <!-- Opción 2: Institución Educativa -->
        <a href="/SISVOX/PUBLIC/index.php?route=login&tipo=institucion" class="role-card">
            <div>
                <div class="icon-circle">🏛️</div>
                <h2>Institución Educativa</h2>
                <p>Portal exclusivo para universidades e institutos. Publica y administra tus convocatorias, becas y oferta académica.</p>
            </div>
            <div class="btn-select">Ingresar como Institución</div>
        </a>
    </div>

    <a href="/SISVOX/PUBLIC/index.php?route=home" class="back-link">← Volver al inicio</a>

</body>
</html>