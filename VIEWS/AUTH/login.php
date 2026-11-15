<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - SISVOX</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;1,600;1,700&display=swap" rel="stylesheet">
    <!-- Asegúrate de que el archivo usuario.css esté en public/css/ -->
    <link rel="stylesheet" href="/SISVOX/public/css/usuario.css">
</head>
<body>

    <!-- Contenedor principal que divide la pantalla en dos (si tu CSS lo maneja por clases globales o contenedores) -->
    <div class="welcome-text">
        <h2>bienvenido a <br><i>SISVO</i></h2>
        <p>Descubre tu verdadera vocación</p>
    </div>

    <div class="register-box">
        <h3>INICIAR SESION</h3>
        
        <!-- El formulario apunta al enrutador central de tu MVC -->
        <form action="/SISVOX/public/index.php?route=authenticate" method="POST">

            <div class="input-group">
                <label for="nombre">nombre completo</label>
                <input type="text" id="nombre" name="nombre" placeholder="nombre" required>
            </div>

            <div class="input-group">
                <label for="CI">Cedula de identidad</label>
                <input type="text" id="CI" name="CI" placeholder="CI" required>
            </div>

            <div class="input-group">
                <label for="correo">Correo electrónico</label>
                <input type="email" id="correo" name="correo" required placeholder="correo@domain.com">
            </div>

            <div class="input-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" placeholder="••••••••" required>
            </div>
            
            <button type="submit" class="register-btn">registrarse →</button>
        </form>
        
        <div class="login-footer">
            <p>no tienes una cuenta aun? <a href="/SISVOX/public/index.php?route=registro">crea aqui</a></p>
        </div>
    </div>

    <script src="/SISVOX/public/js/registro.js"></script>
</body>
</html>