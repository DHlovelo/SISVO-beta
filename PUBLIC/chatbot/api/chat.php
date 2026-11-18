<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';

$input = sisvov_read_json();
$message = trim((string)($input['message'] ?? ''));
if ($message === '' || mb_strlen($message) > 500) {
    sisvov_json(422, ['status'=>'error','message'=>'Escribe una consulta de hasta 500 caracteres.']);
}
if (!extension_loaded('curl')) {
    sisvov_json(503, ['status'=>'error','message'=>'PHP necesita tener habilitada la extensión cURL.']);
}

$session = (string)($input['session_id'] ?? '');
if (!preg_match('/^[a-zA-Z0-9_-]{8,64}$/', $session)) {
    $session = bin2hex(random_bytes(16));
}
$history = [];
if (isset($input['history']) && is_array($input['history'])) {
    foreach (array_slice($input['history'], -6) as $entry) {
        if (!is_array($entry)) continue;
        $role = (string)($entry['role'] ?? '');
        $content = trim((string)($entry['content'] ?? ''));
        if (in_array($role, ['user','assistant'], true) && $content !== '') {
            $history[] = ['role'=>$role, 'content'=>mb_substr($content, 0, 600)];
        }
    }
}

try {
    $cfg = sisvov_config();
    $url = (string)($cfg['n8n_webhook_url'] ?? '');
    $headerName = (string)($cfg['n8n_header_name'] ?? '');
    $secret = (string)($cfg['n8n_header_secret'] ?? '');
    if (!filter_var($url, FILTER_VALIDATE_URL)
        || !preg_match('/^X-[A-Za-z0-9-]{3,50}$/', $headerName)
        || strlen($secret) < 24 || str_contains($secret, 'REEMPLAZAR')) {
        sisvov_json(503, ['status'=>'error','message'=>'Falta completar la URL o la clave de n8n en api/config.local.php.']);
    }
    $payload = json_encode([
        'message'=>$message,
        'session_id'=>$session,
        'history'=>$history,
    ], JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE);
    $curl = curl_init($url);
    curl_setopt_array($curl, [
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $payload,
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            $headerName . ': ' . $secret,
        ],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CONNECTTIMEOUT => 5,
        CURLOPT_TIMEOUT => 28,
        CURLOPT_FOLLOWLOCATION => false,
    ]);
    $rawResponse = curl_exec($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);
    if ($rawResponse === false || $httpCode < 200 || $httpCode >= 300) {
        error_log('SISVOV: n8n no disponible, HTTP ' . $httpCode);
        sisvov_json(502, ['status'=>'error','message'=>'n8n no respondió. Comprueba que esté abierto, que el flujo esté publicado y que la credencial Webhook sea correcta.']);
    }
    $data = json_decode($rawResponse, true);
    if (!is_array($data) || !is_string($data['reply'] ?? null) || trim($data['reply']) === '') {
        sisvov_json(502, ['status'=>'error','message'=>'La respuesta de n8n no tiene el formato esperado.']);
    }
    sisvov_json(200, [
        'status'=>'success',
        'reply'=>mb_substr(trim($data['reply']), 0, 2000),
        'source'=>in_array(($data['source'] ?? ''), ['faq','ia','sin_verificar','ia_no_disponible'], true) ? $data['source'] : 'sin_verificar',
    ]);
} catch (Throwable $e) {
    error_log('SISVOV Chat: ' . $e->getMessage());
    sisvov_json(503, ['status'=>'error','message'=>'No se pudo conectar el chatbot. Revisa la configuración local.']);
}
