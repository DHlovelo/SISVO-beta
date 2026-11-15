<?php
// APP/MODELS/usuario.php

require_once __DIR__ . '/../../CONFIG/sisvo_conexion.php';

class Usuario {
    
    public static function buscarPorEmail($correo) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM nuevo_usu WHERE correo = ?");
        $stmt->execute([$correo]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function crear($ci, $nombre, $telefono, $correo, $fecha_nacimiento, $passwordHash, $rol = 'usuario') {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO nuevo_usu (CI_usu, nombre_c_usu, telefono, correo, fecha_nacimiento, contrasena, rol) VALUES (?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$ci, $nombre, $telefono, $correo, $fecha_nacimiento, $passwordHash, $rol]);
    }
}