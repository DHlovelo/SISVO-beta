<?php
require_once __DIR__ . '/../../config/sisvo_conexion.php';

class Usuario {
    public static function buscarPorCorreo($correo) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM nuevo_usu WHERE correo = ?");
        $stmt->execute([$correo]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function registrar($ci, $nombre, $telefono, $correo, $fecha_nac, $contrasena, $rol = 'usuario') {
        global $pdo;
        $hash = password_hash($contrasena, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO nuevo_usu (CI_usu, nombre_c_usu, telefono, correo, fecha_nacimiento, contrasena, rol) VALUES (?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$ci, $nombre, $telefono, $correo, $fecha_nac, $hash, $rol]);
    }
}