<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<nav class="navbar">
    <a href="<?php echo url('home'); ?>" class="logo">SISVOX</a>

    <div class="nav-links">
        <a href="<?php echo url('home'); ?>">Inicio</a>
        <a href="<?php echo url('carreras'); ?>">Carreras</a>
        <a href="<?php echo url('test'); ?>">Test Vocacional</a>
        <a href="<?php echo url('becas'); ?>">Becas</a>
        <a href="<?php echo url('chatbot'); ?>">Asistente</a>
        <a href="<?php echo url('instituciones'); ?>">Instituciones</a>
        <a href="<?php echo url('convocatorias'); ?>">Convocatorias</a>

        <?php if (!empty($_SESSION['usuario'])): ?>
            <span class="bienvenida">Hola, <?php echo htmlspecialchars($_SESSION['usuario']['nombre']); ?></span>
            
            <?php if ($_SESSION['usuario']['rol'] === 'admin'): ?>
                <a href="<?php echo url('admin/dashboard'); ?>">Panel Admin</a>
            <?php elseif ($_SESSION['usuario']['rol'] === 'institucion'): ?>
                <a href="<?php echo url('institucion/dashboard'); ?>">Panel Institución</a>
            <?php endif; ?>

            <a href="<?php echo url('logout'); ?>" class="btn-logout">Cerrar Sesión</a>

        <?php else: ?>
            <a href="<?php echo url('login'); ?>" class="btn-login">Iniciar Sesión</a>
            <a href="<?php echo url('registro'); ?>" class="btn-registro">Registrarse</a>
        <?php endif; ?>
    </div>
</nav>