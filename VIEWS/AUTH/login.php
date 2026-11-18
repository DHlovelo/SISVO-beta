<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - SISVOX</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;1,600;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/SISVOX/PUBLIC/css/usuario.css">
    <style>
        /* Estilo para posicionar el botón flotante en la esquina inferior derecha */
        .btn-volver-esquina {
            position: fixed;
            bottom: 25px;
            right: 25px;
            z-index: 100;
        }
    </style>
</head>
<body>

    <div class="welcome-text">
        <h2>bienvenido a <br><i>SISVO</i></h2>
        <p>Descubre tu verdadera vocación</p>
    </div>

    <div class="register-box">
        <h3>INICIAR SESION</h3>

        <?php if (isset($_GET['exito']) && $_GET['exito'] === 'registrado'): ?>
            <p style="color: #16a34a; font-size: 0.9rem; margin-bottom: 12px; font-weight: 500;">
                ¡Cuenta creada con éxito! Ya puedes iniciar sesión.
            </p>
        <?php endif; ?>

        <?php if (isset($_GET['error'])): ?>
            <p style="color: #e11d48; font-size: 0.9rem; margin-bottom: 12px; font-weight: 500;">
                <?php
                    switch ($_GET['error']) {
                        case 'campos_vacios':
                            echo 'Por favor, completa tu correo y contraseña.';
                            break;
                        case 'credenciales_incorrectas':
                            echo 'El correo o la contraseña son incorrectos.';
                            break;
                        case 'usar_portal_institucion':
                            echo 'Esta cuenta es institucional. Ingresa por el portal de instituciones.';
                            break;
                        case 'no_es_institucion':
                            echo 'Esta cuenta no está registrada como institución.';
                            break;
                        default:
                            echo 'Ocurrió un error al intentar iniciar sesión.';
                    }
                ?>
            </p>
        <?php endif; ?>
        
        <form action="/SISVOX/PUBLIC/index.php?route=authenticate" method="POST">
            <input type="hidden" name="tipo_acceso" value="<?= htmlspecialchars($tipoAcceso ?? 'usuario') ?>">

            <div class="input-group">
                <label for="correo">Correo electrónico</label>
                <input type="email" id="correo" name="correo" required placeholder="correo@domain.com">
            </div>

            <div class="input-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" placeholder="••••••••" required>
            </div>
            
            <button type="submit" class="register-btn">iniciar sesión →</button>
        </form>
        
        <div class="login-footer">
            <p>no tienes una cuenta aun? <a href="/SISVOX/PUBLIC/index.php?route=registro">crea aqui</a></p>
        </div>
    </div>

    <!-- Botón posicionado en la esquina inferior derecha -->
    <div class="btn-volver-esquina">
         <a href="/SISVOX/public/index.php?route=seleccionar_tipo" class="btn-primary" style="display:inline-block; text-decoration: none; background-color: #110d27; color: #fdfdfd; padding: 10px 24px; border-radius: 30px; font-weight: 600; font-size: 14px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">← Volver al inicio</a>
    </div>

</body>
</html>