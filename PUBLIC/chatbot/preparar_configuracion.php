<?php

if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}
$target = __DIR__ . '/api/config.local.php';
if (file_exists($target)) {
    echo "api/config.local.php ya existe. No se sobrescribió.\n";
    exit;
}
$example = require __DIR__ . '/api/config.example.php';
$example['n8n_header_secret'] = bin2hex(random_bytes(24));
$code = "<?php\n// Archivo privado generado localmente. No publicar en repositorios.\nreturn "
    . var_export($example, true) . ";\n";
if (file_put_contents($target, $code, LOCK_EX) === false) {
    fwrite(STDERR, "No se pudo crear la configuración.\n");
    exit(1);
}
echo "Configuración creada en api/config.local.php\n";
echo "Credencial Header Auth de n8n:\n";
echo "  Name: X-SISVOV-TOKEN\n";
echo "  Value: {$example['n8n_header_secret']}\n";
echo "No compartas el valor con otros usuarios.\n";
