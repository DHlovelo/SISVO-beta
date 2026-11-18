<?php
// APP/HELPERS/mailer.php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../../vendor/autoload.php';

/**
 * Carga (una sola vez) la configuración de correo.
 */
function configCorreo(): array
{
    static $config = null;
    if ($config === null) {
        $config = require __DIR__ . '/../../config/mail.php';
    }
    return $config;
}

/**
 * Renderiza una plantilla de VIEWS/EMAILS/ y devuelve el HTML como texto.
 */
function renderizarCorreo(string $vista, array $datos = []): string
{
    $archivo = __DIR__ . '/../../VIEWS/EMAILS/' . $vista . '.php';
    extract($datos);
    ob_start();
    require $archivo;
    return ob_get_clean();
}

/**
 * Envía un correo HTML por SMTP (Gmail).
 * Devuelve true si se envió, false si falló (el motivo queda en el log de errores de PHP).
 */
function enviarCorreo(string $email, string $nombre, string $asunto, string $cuerpoHtml): bool
{
    $cfg  = configCorreo();
    $mail = new PHPMailer(true); // true = lanza excepciones

    try {
        $mail->isSMTP();
        $mail->Host       = $cfg['host'];
        $mail->SMTPAuth   = true;
        $mail->Username   = $cfg['usuario'];
        $mail->Password   = $cfg['password'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = $cfg['puerto'];
        $mail->CharSet    = 'UTF-8';

        $mail->setFrom($cfg['usuario'], $cfg['remitente_nombre']);
        $mail->addAddress($email, $nombre);

        $mail->isHTML(true);
        $mail->Subject = $asunto;
        $mail->Body    = $cuerpoHtml;
        $mail->AltBody = trim(html_entity_decode(strip_tags($cuerpoHtml)));

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log('[SISVO] Fallo al enviar correo a ' . $email . ': ' . $mail->ErrorInfo);
        return false;
    }
}
