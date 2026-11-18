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
</head>
<body>

    <div class="welcome-text">
        <h2>bienvenido a <br><i>SISVO</i></h2>
        <p>Descubre tu verdadera vocación</p>
    </div>

    <div class="register-box">
        <h3>INICIAR SESIÓN</h3>

        <!-- Mostrar mensajes de error si existen en la URL -->
        <?php if (isset($_GET['error'])): ?>
            <p style="color: #ff4d4d; font-size: 0.9rem; margin-bottom: 10px;">
                <?php
                    switch ($_GET['error']) {
                        case 'campos_vacios': echo 'Por favor, completa todos los campos.'; break;
                        case 'credenciales_incorrectas': echo 'Correo o contraseña incorrectos.'; break;
                        case 'usar_portal_institucion': echo 'Esta cuenta pertenece a una institución. Usa el portal institucional.'; break;
                        default: echo 'Error al iniciar sesión.';
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
            <p>¿No tienes una cuenta aún? <a href="/SISVOX/PUBLIC/index.php?route=registro">Crea una aquí</a></p>
        </div>
    </div>

</body>
</html>