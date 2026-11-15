<!DOCTYPE html>
<html lang="es" data-theme="dark" data-estilo="cristal" data-esquinas="redondas" data-decoracion="si">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Cuenta - SISVO</title>
    <!-- Tu archivo CSS original con todas las variables y colores -->
    <link rel="stylesheet" href="/SISVOX/public/css/nuevo_usu.css?v=<?php echo time(); ?>">
</head>
<body>

    <!-- Panel Izquierdo con los colores, gradientes y decoraciones exactas del CSS -->
    <section class="welcome-text">
        <h2>SISVO</h2>
        <p>Crea tu cuenta para poder descubrir tu verdadera vocación</p>
    </section>

    <!-- Caja del Formulario con el efecto cristal (Glassmorphism) del CSS -->
    <main class="register-box">
        <h3>Crear Cuenta</h3>

        <!-- Conectado al enrutador central para guardar en la base de datos sisvo -->
        <form action="/SISVOX/public/index.php?route=store_register" method="POST">
            <div class="form-grid">
                
                <!-- Nombre completo (Ocupa todo el ancho) -->
                <div class="input-group full-width">
                    <label for="nombre_c_usu">Nombre completo</label>
                    <input type="text" id="nombre_c_usu" name="nombre_c_usu" required placeholder="nombre completo">
                </div>

                <!-- Cédula de identidad -->
                <div class="input-group">
                    <label for="CI_usu">Cedula de identidad</label>
                    <input type="text" id="CI_usu" name="CI_usu" required placeholder="CI">
                </div>

                <!-- Teléfono -->
                <div class="input-group">
                    <label for="telefono">Telefono</label>
                    <input type="text" id="telefono" name="telefono" placeholder="telf">
                </div>

                <!-- Correo electrónico (Ocupa todo el ancho) -->
                <div class="input-group full-width">
                    <label for="correo">Correo electronico</label>
                    <input type="email" id="correo" name="correo" required placeholder="@">
                </div>

                <!-- Fecha de nacimiento -->
                <div class="input-group">
                    <label for="fecha_nacimiento">Fecha de nacimiento</label>
                    <input type="date" id="fecha_nacimiento" name="fecha_nacimiento">
                </div>

                <!-- Contraseña -->
                <div class="input-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" required placeholder="********">
                </div>

            </div>

            <!-- Botón y efectos definidos en tu CSS -->
            <button type="submit" class="register-btn">
                <a style="pointer-events: none;">Registrarse</a>
            </button>
        </form>

        <div class="login-footer">
            <p>ya tienes una cuenta? <a href="/SISVOX/public/index.php?route=login">Inicia aqui</a></p>
        </div>
    </main>

</body>
</html>