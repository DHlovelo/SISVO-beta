<?php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido a SISVO</title>
</head>
<body style="margin:0; padding:0; background-color:#fffaf6;">

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#fffaf6;">
<tr>
<td align="center" style="padding:32px 16px;">

    <table role="presentation" width="560" cellpadding="0" cellspacing="0" border="0"
           style="width:100%; max-width:560px; background-color:#ffffff; border-radius:20px; border:1px solid #f0e4dc; overflow:hidden;">

        <tr>
            <td align="center" bgcolor="#d6336c"
                style="background-color:#d6336c; background-image:linear-gradient(150deg,#c92a5b,#ee5a24); padding:40px 24px;">
                <div style="font-family:'Segoe UI',Arial,sans-serif; font-size:38px; font-weight:800; letter-spacing:3px; color:#ffffff; line-height:1;">
                    SISVO
                </div>
                <div style="font-family:'Segoe UI',Arial,sans-serif; font-size:14px; color:#ffe3ec; margin-top:10px;">
                    Descubre tu verdadera vocación
                </div>
            </td>
        </tr>

        <tr>
            <td style="padding:36px 36px 12px 36px; font-family:'Segoe UI',Arial,sans-serif; color:#2b2430;">
                <div style="font-size:24px; font-weight:800; color:#1f1a24; margin-bottom:16px;">
                    ¡Tu cuenta está lista! 🎉
                </div>
                <p style="font-size:16px; line-height:1.6; margin:0 0 12px 0;">
                    Hola <strong><?= htmlspecialchars($nombre) ?></strong>,
                </p>
                <p style="font-size:16px; line-height:1.6; margin:0; color:#4a4152;">
                    Verificamos tu correo y tu cuenta ya está activa. Esto es lo que puedes hacer en SISVO:
                </p>
            </td>
        </tr>

        <tr>
            <td style="padding:20px 36px 4px 36px;">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td width="44" valign="top" style="font-size:26px; padding:6px 0;">🧭</td>
                        <td style="padding:6px 0 14px 0; font-family:'Segoe UI',Arial,sans-serif; font-size:15px; line-height:1.5; color:#2b2430;">
                            <strong>Test vocacional</strong><br>
                            <span style="color:#6f6577;">Descubre qué carreras van con tu perfil.</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="44" valign="top" style="font-size:26px; padding:6px 0;">🎓</td>
                        <td style="padding:6px 0 14px 0; font-family:'Segoe UI',Arial,sans-serif; font-size:15px; line-height:1.5; color:#2b2430;">
                            <strong>Carreras e instituciones</strong><br>
                            <span style="color:#6f6577;">Explora opciones y compáralas con calma.</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="44" valign="top" style="font-size:26px; padding:6px 0;">🏅</td>
                        <td style="padding:6px 0 14px 0; font-family:'Segoe UI',Arial,sans-serif; font-size:15px; line-height:1.5; color:#2b2430;">
                            <strong>Becas y convocatorias</strong><br>
                            <span style="color:#6f6577;">Entérate de las oportunidades disponibles.</span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td align="center" style="padding:16px 36px 36px 36px;">
                <table role="presentation" cellpadding="0" cellspacing="0" border="0" align="center">
                    <tr>
                        <td align="center" bgcolor="#d6336c" style="border-radius:999px; background-color:#d6336c;">
                            <a href="<?= htmlspecialchars($urlLogin) ?>"
                               style="display:inline-block; padding:16px 40px; font-family:'Segoe UI',Arial,sans-serif; font-size:16px; font-weight:700; color:#ffffff; text-decoration:none; border-radius:999px;">
                                Iniciar sesión
                            </a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td align="center" style="padding:20px 36px 28px 36px; border-top:1px solid #f0e4dc; font-family:'Segoe UI',Arial,sans-serif; font-size:12px; line-height:1.6; color:#a2989b;">
                © SISVO · Sistema de orientación vocacional
            </td>
        </tr>

    </table>

</td>
</tr>
</table>

</body>
</html>