<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Acceso Administrativo - SISVO</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/SISVOX/PUBLIC/css/usuario.css">
</head>
<body>

    <div class="welcome-text">
        <h2>Panel de <br><i>Administración</i></h2>
        <p>Acceso restringido a personal autorizado</p>
    </div>

    <div class="register-box">
        <h3>AUTENTICACIÓN</h3>

        <?php if (isset($_GET['error'])): ?>
            <p style="color: #ff4d4d; font-size: 0.9rem; margin-bottom: 12px;">
                <?php
                    switch ($_GET['error']) {
                        case 'campos_vacios':
                            echo 'Completa todos los campos.';
                            break;
                        case 'credenciales_incorrectas':
                            echo 'Credenciales no válidas.';
                            break;
                        default:
                            echo 'Acceso denegado.';
                    }
                ?>
            </p>
        <?php endif; ?>

        <form action="/SISVOX/PUBLIC/index.php?route=authenticate" method="POST" autocomplete="off">
            <input type="hidden" name="tipo_acceso" value="admin">

            <div class="input-group">
                <label for="correo">Correo administrativo</label>
                <input type="email" id="correo" name="correo" required placeholder="admin@sisvo.com">
            </div>

            <div class="input-group">
                <label for="password">Clave de acceso</label>
                <input type="password" id="password" name="password" required placeholder="••••••••">
            </div>

            <button type="submit" class="register-btn">ingresar al panel →</button>
        </form>
    </div>

</body>
</html>