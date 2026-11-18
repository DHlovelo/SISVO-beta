<?php
/**
 * Bitácora de auditoría de SISVOX.
 *
 * - bitacora_registrar():         lanza excepción si falla (úsala dentro de una transacción,
 *                                 así no existe un cambio sin su registro).
 * - bitacora_registrar_seguro():  nunca lanza; para eventos como login/logout.
 *
 * Nunca se guardan contraseñas ni tokens (ver bitacora_limpiar()).
 */
require_once __DIR__ . '/../../config/sisvo_conexion.php';

function bitacora_actor_actual(): array
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    return [
        'ci'     => $_SESSION['CI_usu']   ?? null,
        'nombre' => $_SESSION['nombre']   ?? null,
        'rol'    => $_SESSION['user_rol'] ?? null,
    ];
}

/** Quita campos sensibles antes de guardar un snapshot. */
function bitacora_limpiar(?array $fila): ?array
{
    if ($fila === null) {
        return null;
    }
    foreach (['contrasena', 'token_verificacion', 'token_expira'] as $campo) {
        unset($fila[$campo]);
    }
    return $fila;
}

function bitacora_registrar(
    string $accion,
    ?string $entidad = null,
    $entidadId = null,
    ?array $antes = null,
    ?array $despues = null,
    ?string $detalle = null,
    ?array $actor = null
): bool {
    global $pdo;

    $actor = $actor ?? bitacora_actor_actual();
    $json  = fn(?array $d) => $d === null ? null : json_encode(bitacora_limpiar($d), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

    $stmt = $pdo->prepare(
        "INSERT INTO bitacora
            (CI_usu, nombre, rol, accion, entidad, entidad_id, datos_antes, datos_despues, detalle, ip, user_agent)
         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
    );

    return $stmt->execute([
        $actor['ci'] ?? null,
        isset($actor['nombre']) ? mb_substr((string) $actor['nombre'], 0, 200) : null,
        $actor['rol'] ?? null,
        mb_substr($accion, 0, 50),
        $entidad,
        $entidadId !== null ? mb_substr((string) $entidadId, 0, 50) : null,
        $json($antes),
        $json($despues),
        $detalle !== null ? mb_substr($detalle, 0, 500) : null,
        $_SERVER['REMOTE_ADDR'] ?? null,   // no se confía en X-Forwarded-For (es falsificable)
        mb_substr((string) ($_SERVER['HTTP_USER_AGENT'] ?? ''), 0, 255),
    ]);
}

function bitacora_registrar_seguro(
    string $accion,
    ?string $entidad = null,
    $entidadId = null,
    ?array $antes = null,
    ?array $despues = null,
    ?string $detalle = null,
    ?array $actor = null
): void {
    try {
        bitacora_registrar($accion, $entidad, $entidadId, $antes, $despues, $detalle, $actor);
    } catch (Throwable $e) {
        error_log('[bitacora] ' . $e->getMessage());
    }
}
