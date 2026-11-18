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
    <title>Acceso Institucional - SISVOX</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        
        html, body {
            background-color: #0b0b0b !important;
            color: #ffffff;
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            padding: 20px;
        }

        .login-container {
            max-width: 450px;
            width: 100%;
            background: #141414;
            padding: 40px;
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }

        h2 {
            font-size: 24px;
            margin-bottom: 8px;
            color: #3b82f6;
        }

        p.subtitle {
            color: #9ca3af;
            font-size: 14px;
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            font-size: 14px;
            color: #d1d5db;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            background: #0b0b0b;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            color: #fff;
            font-size: 14px;
            outline: none;
            transition: border-color 0.2s;
        }

        .form-control:focus {
            border-color: #3b82f6;
        }

        .btn-submit {
            width: 100%;
            background: #3b82f6;
            color: #fff;
            border: none;
            padding: 14px;
            border-radius: 30px;
            font-weight: 600;
            font-size: 15px;
            cursor: pointer;
            transition: background 0.2s;
            margin-top: 10px;
        }

        .btn-submit:hover {
            background: #2563eb;
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.2);
            padding: 12px;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 20px;
            text-align: center;
        }

        .links-container {
            margin-top: 25px;
            text-align: center;
            font-size: 13px;
        }

        .links-container a {
            color: #3b82f6;
            text-decoration: none;
            display: block;
            margin-top: 10px;
        }

        .links-container a:hover {
            text-decoration: underline;
        }

        .back-link {
            color: #9ca3af !important;
        }
        .back-link:hover {
            color: #ffffff !important;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <h2>Portal Institucional</h2>
        <p class="subtitle">Ingresa con tus credenciales oficiales de universidad o instituto.</p>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert-error">
                <?php 
                    if ($_GET['error'] === 'campos_vacios') echo 'Por favor, completa todos los campos.';
                    elseif ($_GET['error'] === 'credenciales_incorrectas') echo 'Correo o contraseña incorrectos.';
                    elseif ($_GET['error'] === 'no_es_institucion') echo 'Esta cuenta no pertenece a una institución.';
                    else echo 'Ocurrió un error al iniciar sesión.';
                ?>
            </div>
        <?php endif; ?>

        <form action="/SISVOX/PUBLIC/index.php?route=authenticate_institucion" method="POST">
            <div class="form-group">
                <label>Correo Electrónico</label>
                <input type="email" name="correo" class="form-control" required placeholder="correo@institucion.edu.bo">
            </div>

            <div class="form-group">
                <label>Contraseña</label>
                <input type="password" name="password" class="form-control" required placeholder="••••••••">
            </div>

            <button type="submit" class="btn-submit">Iniciar Sesión</button>
        </form>

        <div class="links-container">
            <a href="/SISVOX/PUBLIC/index.php?route=registro_instituciones&tipo=universidad">¿Aún no tienes cuenta? Crea aquí</a>
            <a href="/SISVOX/PUBLIC/index.php?route=home" class="back-link">← VOLVER</a>
        </div>
    </div>

</body>
</html>