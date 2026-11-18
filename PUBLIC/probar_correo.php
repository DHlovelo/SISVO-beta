<?php
// PUBLIC/probar_correo.php
// SOLO PARA PROBAR que Gmail + PHPMailer funcionan. BÓRRALO cuando termines.
// Abre: http://localhost/SISVOX/PUBLIC/probar_correo.php?para=OTRO_CORREO@gmail.com

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../vendor/autoload.php';
$cfg = require __DIR__ . '/../config/mail.php';

$para = $_GET['para'] ?? '';
if (!filter_var($para, FILTER_VALIDATE_EMAIL)) {
    die('Agrega ?para=tucorreo@ejemplo.com a la URL');
}

$mail = new PHPMailer(true);
try {
    $mail->SMTPDebug   = 2;           // muestra la conversación con Gmail (útil para errores)
    $mail->Debugoutput = 'html';
    $mail->isSMTP();
    $mail->Host       = $cfg['host'];
    $mail->SMTPAuth   = true;
    $mail->Username   = $cfg['usuario'];
    $mail->Password   = $cfg['password'];
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = $cfg['puerto'];
    $mail->CharSet    = 'UTF-8';

    $mail->setFrom($cfg['usuario'], $cfg['remitente_nombre']);
    $mail->addAddress($para);
    $mail->Subject = 'Prueba SISVO';
    $mail->Body    = 'Si lees esto, el envío con Gmail funciona.';
    $mail->send();
    echo '<h3 style="color:green">✔ Correo enviado</h3>';
} catch (Exception $e) {
    echo '<h3 style="color:red">✘ Error: ' . htmlspecialchars($mail->ErrorInfo) . '</h3>';
}
