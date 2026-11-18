<?php
// config/mail.example.php
// 1) Copia este archivo y renómbralo a:  config/mail.php
// 2) Rellena tus datos reales en mail.php
// 3) mail.php NO se sube a GitHub (está en .gitignore)

return [
    'host'             => 'smtp.gmail.com',
    'puerto'           => 587,                         // STARTTLS
    'usuario'          => 'sistema.sisvo@gmail.com',        // tu Gmail completo
    'password'         => 'hqjtuohwebevmpon',          // CONTRASEÑA DE APLICACIÓN (16 letras, sin espacios)
    'remitente_nombre' => 'SISVO',

    // URL base de tu index.php (se usa para armar el enlace del correo)
    // En local con XAMPP:
    'base_url'         => 'http://localhost/SISVOX/PUBLIC/index.php',
];
