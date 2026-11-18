<?php
declare(strict_types=1);
function sisvov_config(): array {
    $file = __DIR__ . '/config.local.php';
    if (!is_file($file)) {
        throw new RuntimeException('Falta configurar api/config.local.php.');
    }
    $config = require $file;
    if (!is_array($config)) {
        throw new RuntimeException('La configuración del sistema no es válida.');
    }
    return $config;
}

function sisvov_db(): PDO {
    $cfg = sisvov_config();
    $dsn = sprintf(
        'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
        $cfg['db_host'] ?? '127.0.0.1',
        $cfg['db_port'] ?? '3306',
        $cfg['db_name'] ?? 'sisvov_db'
    );
    return new PDO($dsn, (string)($cfg['db_user'] ?? ''), (string)($cfg['db_password'] ?? ''), [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
}

function sisvov_json(int $status, array $payload): never {
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    header('Cache-Control: no-store');
    echo json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE);
    exit;
}

function sisvov_read_json(): array {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        sisvov_json(405, ['status'=>'error','message'=>'Método no permitido.']);
    }
    $contentType = strtolower((string)($_SERVER['CONTENT_TYPE'] ?? ''));
    if (!str_starts_with($contentType, 'application/json')) {
        sisvov_json(415, ['status'=>'error','message'=>'Se requiere application/json.']);
    }
    if (($_SERVER['HTTP_X_SISVOV_CLIENT'] ?? '') !== 'web') {
        sisvov_json(403, ['status'=>'error','message'=>'Solicitud no autorizada.']);
    }
    $raw = file_get_contents('php://input', false, null, 0, 12000);
    $decoded = json_decode($raw ?: '', true);
    if (!is_array($decoded)) {
        sisvov_json(400, ['status'=>'error','message'=>'Datos JSON inválidos.']);
    }
    return $decoded;
}
