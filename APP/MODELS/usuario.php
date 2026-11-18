<?php

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

    public static function guardarTokenVerificacion($ci, $tokenHash) {
        global $pdo;
        $stmt = $pdo->prepare(
            "UPDATE nuevo_usu
                SET token_verificacion = ?,
                    token_expira = DATE_ADD(NOW(), INTERVAL 24 HOUR),
                    email_verificado = 0
              WHERE CI_usu = ?"
        );
        return $stmt->execute([$tokenHash, $ci]);
    }

    public static function buscarPorTokenVerificacion($tokenHash) {
        global $pdo;
        $stmt = $pdo->prepare(
            "SELECT *, (token_expira > NOW()) AS vigente
               FROM nuevo_usu
              WHERE token_verificacion = ?
              LIMIT 1"
        );
        $stmt->execute([$tokenHash]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function marcarCorreoVerificado($ci) {
        global $pdo;
        $stmt = $pdo->prepare(
            "UPDATE nuevo_usu
                SET email_verificado = 1,
                    token_verificacion = NULL,
                    token_expira = NULL
              WHERE CI_usu = ?"
        );
        return $stmt->execute([$ci]);
    }
}
