<?php
$estado = $estado ?? 'pendiente';
$correo = $correo ?? '';
$aviso  = $aviso  ?? '';

$titulos = [
    'pendiente' => 'Revisa tu correo',
    'exito'     => '¡Correo verificado!',
    'invalido'  => 'Enlace no válido',
    'expirado'  => 'El enlace venció',
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($titulos[$estado] ?? 'Verificación') ?> - SISVO</title>
    <link rel="stylesheet" href="/SISVOX/public/css/usuario.css">
</head>
<body>
    <div class="welcome-text">
        <h2>SISVO</h2>
        <p>Descubre tu verdadera vocación</p>
    </div>

    <div class="register-box">
        <h3><?= htmlspecialchars($titulos[$estado] ?? 'Verificación') ?></h3>

        <?php if ($aviso !== ''): ?>
            <p><strong><?= htmlspecialchars($aviso) ?></strong></p>
        <?php endif; ?>

        <?php if ($estado === 'pendiente'): ?>
            <p>
                Te enviamos un enlace de verificación
                <?php if ($correo !== ''): ?>a <strong><?= htmlspecialchars($correo) ?></strong><?php endif; ?>.
                Ábrelo para activar tu cuenta (revisa también la carpeta de spam).
            </p>

        <?php elseif ($estado === 'exito'): ?>
            <p>Tu cuenta ya está activa. Ya puedes iniciar sesión.</p>
            <a class="register-btn" href="/SISVOX/PUBLIC/index.php?route=login"
               style="display:block; text-align:center; text-decoration:none;">Iniciar sesión →</a>

        <?php elseif ($estado === 'invalido'): ?>
            <p>Este enlace no es válido o ya fue usado. Si ya verificaste tu cuenta, inicia sesión.</p>

        <?php elseif ($estado === 'expirado'): ?>
            <p>El enlace de verificación ya venció. Pide uno nuevo abajo.</p>
        <?php endif; ?>

        <?php if (in_array($estado, ['pendiente', 'expirado', 'invalido'], true)): ?>
            <form action="/SISVOX/PUBLIC/index.php?route=reenviar_verificacion" method="POST" style="margin-top:20px;">
                <div class="input-group">
                    <label for="correo">Correo electrónico</label>
                    <input type="email" id="correo" name="correo" required
                           value="<?= htmlspecialchars($correo) ?>" placeholder="correo@domain.com">
                </div>
                <button type="submit" class="register-btn">Reenviar correo de verificación</button>
            </form>
        <?php endif; ?>

        <div class="login-footer">
            <p><a href="/SISVOX/PUBLIC/index.php?route=login">Volver al inicio de sesión</a></p>
        </div>
    </div>
</body>
</html>
