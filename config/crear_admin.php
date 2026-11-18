<?php

if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}

require_once __DIR__ . '/sisvo_conexion.php';

function pedir(string $texto): string
{
    echo $texto;
    return trim((string) fgets(STDIN));
}

$ci       = pedir('CI (máx. 10 caracteres): ');
$nombre   = pedir('Nombre completo: ');
$correo   = pedir('Correo: ');
$telefono = pedir('Teléfono (opcional): ');
$clave    = pedir('Contraseña (mín. 10 caracteres): ');

if ($ci === '' || strlen($ci) > 10 || $nombre === '' || !filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    exit("Datos inválidos: revisa CI (máx. 10), nombre y correo.\n");
}
if (strlen($clave) < 10) {
    exit("La contraseña debe tener al menos 10 caracteres.\n");
}

$hash = password_hash($clave, PASSWORD_DEFAULT);

$stmt = $pdo->prepare('SELECT CI_usu FROM nuevo_usu WHERE correo = ? OR CI_usu = ?');
$stmt->execute([$correo, $ci]);
$existente = $stmt->fetch(PDO::FETCH_ASSOC);

if ($existente) {
    $resp = pedir("Ya existe la cuenta {$existente['CI_usu']}. ¿Promoverla a admin y cambiar su contraseña? (s/N): ");
    if (strtolower($resp) !== 's') {
        exit("Cancelado.\n");
    }
    $pdo->prepare("UPDATE nuevo_usu SET rol='admin', contrasena=?, email_verificado=1, activo=1 WHERE CI_usu=?")
        ->execute([$hash, $existente['CI_usu']]);
    $ciFinal = $existente['CI_usu'];
} else {
    $pdo->prepare(
        "INSERT INTO nuevo_usu (CI_usu, nombre_c_usu, telefono, correo, fecha_nacimiento, contrasena, rol, token_verificacion, email_verificado, activo)
         VALUES (?, ?, ?, ?, CURDATE(), ?, 'admin', '', 1, 1)"
    )->execute([$ci, $nombre, $telefono, $correo, $hash]);
    $ciFinal = $ci;
}

try {
    $pdo->prepare("INSERT INTO bitacora (CI_usu, nombre, rol, accion, entidad, entidad_id, detalle, ip) VALUES (NULL, 'consola', NULL, 'admin_creado', 'usuarios', ?, 'Cuenta administrador creada o promovida por consola', 'cli')")
        ->execute([$ciFinal]);
} catch (Throwable $e) {
    echo "Aviso: no se pudo escribir en la bitácora (¿corriste la migración?).\n";
}

echo "Listo. Administrador: $correo (CI $ciFinal)\n";
