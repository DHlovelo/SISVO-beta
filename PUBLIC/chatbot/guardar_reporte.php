<?php
declare(strict_types=1);
require_once __DIR__ . '/api/db.php';

$input = sisvov_read_json();
$tipo = trim((string)($input['tipo'] ?? ''));
$email = trim((string)($input['email'] ?? ''));
$mensaje = trim((string)($input['mensaje'] ?? ''));
$tiposPermitidos = ['Error Técnico', 'Actualización', 'Sugerencia'];

if (!in_array($tipo, $tiposPermitidos, true) || !filter_var($email, FILTER_VALIDATE_EMAIL)
    || mb_strlen($email) > 150 || mb_strlen($mensaje) < 10 || mb_strlen($mensaje) > 3000) {
    sisvov_json(422, ['status'=>'error','message'=>'Revisa el tipo, el correo y la descripción (de 10 a 3000 caracteres).']);
}

try {
    $pdo = sisvov_db();
    $statement = $pdo->prepare('INSERT INTO reportes_mantenimiento (tipo_reporte, correo_contacto, detalle_mensaje) VALUES (?, ?, ?)');
    $statement->execute([$tipo, $email, $mensaje]);
    sisvov_json(200, [
        'status'=>'success',
        'message'=>'Reporte guardado correctamente.',
        'id_reporte'=>(int)$pdo->lastInsertId(),
    ]);
} catch (Throwable $e) {
    error_log('SISVOV Buzón: ' . $e->getMessage());
    sisvov_json(503, ['status'=>'error','message'=>'No se pudo guardar el reporte. Revisa MySQL y la configuración.']);
}
