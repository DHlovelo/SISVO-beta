<?php
// views/components/navbar.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<nav class="navbar">
    <!-- Logo o título -->
    <a href="<?php echo url('home'); ?>" class="logo">SISVOX</a>

    <div class="nav-links">
        <!-- Botones generales accesibles para todos -->
        <a href="<?php echo url('home'); ?>">Inicio</a>
        <a href="<?php echo url('carreras'); ?>">Carreras</a>
        <a href="<?php echo url('test'); ?>">Test Vocacional</a>
        <a href="<?php echo url('becas'); ?>">Becas</a>
        <a href="<?php echo url('chatbot'); ?>">Asistente</a>
        <a href="<?php echo url('instituciones'); ?>">Instituciones</a>
        <a href="<?php echo url('convocatorias'); ?>">Convocatorias</a>

        <!-- Validación dinámica según la sesión -->
        <?php if (!empty($_SESSION['usuario'])): ?>
            <!-- Si el usuario YA inició sesión -->
            <span class="bienvenida">Hola, <?php echo htmlspecialchars($_SESSION['usuario']['nombre']); ?></span>
            
            <?php if ($_SESSION['usuario']['rol'] === 'admin'): ?>
                <a href="<?php echo url('admin/dashboard'); ?>">Panel Admin</a>
            <?php elseif ($_SESSION['usuario']['rol'] === 'institucion'): ?>
                <a href="<?php echo url('institucion/dashboard'); ?>">Panel Institución</a>
            <?php endif; ?>

            <!-- Botón de Cerrar Sesión -->
            <a href="<?php echo url('logout'); ?>" class="btn-logout">Cerrar Sesión</a>

        <?php else: ?>
            <!-- Si el usuario NO ha iniciado sesión -->
            <a href="<?php echo url('login'); ?>" class="btn-login">Iniciar Sesión</a>
            <a href="<?php echo url('registro'); ?>" class="btn-registro">Registrarse</a>
        <?php endif; ?>
    </div>
</nav>