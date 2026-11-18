<?php
$tipoInstitucion = $_GET['tipo'] ?? 'instituto'; // Puede ser 'universidad' o 'instituto'
$esUniversidad = ($tipoInstitucion === 'universidad');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de <?php echo $esUniversidad ? 'Universidad' : 'Instituto'; ?> - SISVOX</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        
        html, body {
            background-color: #0b0b0b !important;
            color: #ffffff;
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            padding: 20px;
        }

        .registro-container {
            max-width: 550px;
            width: 100%;
            background: #141414;
            padding: 40px;
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }

        h2 {
            font-size: 24px;
            margin-bottom: 8px;
            color: #3b82f6;
        }

        p.subtitle {
            color: #9ca3af;
            font-size: 14px;
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            font-size: 14px;
            color: #d1d5db;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            background: #0b0b0b;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            color: #fff;
            font-size: 14px;
            outline: none;
            transition: border-color 0.2s;
        }

        .form-control:focus {
            border-color: #3b82f6;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }

        .btn-submit {
            width: 100%;
            background: #3b82f6;
            color: #fff;
            border: none;
            padding: 14px;
            border-radius: 30px;
            font-weight: 600;
            font-size: 15px;
            cursor: pointer;
            transition: background 0.2s;
            margin-top: 10px;
        }

        .btn-submit:hover {
            background: #2563eb;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #9ca3af;
            text-decoration: none;
            font-size: 13px;
        }

        .back-link:hover {
            color: #ffffff;
        }
    </style>
</head>
<body>

    <div class="registro-container">
        <h2><?php echo $esUniversidad ? 'Registro de Universidad' : 'Registro de Instituto o Escuela'; ?></h2>
        <p class="subtitle">Completa la información oficial para verificar tu institución en SISVOX.</p>

        <form action="/SISVOX/PUBLIC/index.php?route=procesar_registro_institucion" method="POST">
            <input type="hidden" name="tipo_institucion" value="<?php echo htmlspecialchars($tipoInstitucion); ?>">

            <div class="form-group">
                <label>Nombre de la Institución</label>
                <input type="text" name="nombre_institucion" class="form-control" required placeholder="Ej. Universidad Privada / Instituto Tecnológico">
            </div>

            <div class="form-group">
                <label><?php echo $esUniversidad ? 'Correo Institucional (Debe incluir dominio oficial .edu)' : 'Correo Electrónico de Contacto'; ?></label>
                <input type="email" name="correo" class="form-control" required placeholder="<?php echo $esUniversidad ? 'contacto@universidad.edu.bo' : 'contacto@instituto.com'; ?>">
            </div>

            <div class="form-group">
                <label>Contraseña</label>
                <input type="password" name="password" class="form-control" required placeholder="••••••••">
            </div>

            <div class="form-group">
                <label>Información Verídica de Verificación</label>
                <textarea name="info_verificacion" class="form-control" required placeholder="<?php echo $esUniversidad ? 'Indique resolución ministerial, sitio web oficial o datos de acreditación.' : 'Indique código de autorización, NIT o datos legales del instituto.'; ?>"></textarea>
            </div>

            <button type="submit" class="btn-submit">Registrar Institución</button>
        </form>

        <a href="/SISVOX/PUBLIC/index.php?route=home" class="back-link">← VOLVER</a>
    </div>

</body>
</html>