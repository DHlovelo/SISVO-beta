<?php
// app/helpers/auth.php

/**
 * Verifica si el usuario ha iniciado sesión y tiene el rol permitido.
* /
 * @param string|array $rolesPermitidos Un rol (ej: 'admin') o un array de roles (ej: ['admin', 'institucion'])
 */
function verificarRol($rolesPermitidos) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['usuario']) || !isset($_SESSION['usuario']['rol'])) {
        header('Location: /SISVOX/public/index.php?route=login');
        exit;
    }

    if (!is_array($rolesPermitidos)) {
        $rolesPermitidos = [$rolesPermitidos];
    }

    $rolActual = $_SESSION['usuario']['rol'];

    if (!in_array($rolActual, $rolesPermitidos)) {
        header('Location: /SISVOX/public/index.php?route=home&error=unauthorized');
        exit;
    }
}

function require_login() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['usuario'])) {
        header('Location: /SISVOX/public/index.php?route=login');
        exit;
    }
}

function obtener_rol() {
    if (session_status() === PHP_SESSION_NONE) { session_start(); }
    return $_SESSION['usuario']['rol'] ?? null;
}

function es_admin() {
    return obtener_rol() === 'admin';
}

function es_institucion() {
    return obtener_rol() === 'institucion';
}