<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$userData = $usuario ?? ($GLOBALS['usuario'] ?? []);
$mensajeAlerta = $GLOBALS['mensaje_perfil'] ?? '';
?>

<div class="container" style="max-width: 800px; margin: 0 auto; padding: 40px 20px;">

    <div style="text-align: center; margin-bottom: 30px;">
        <h1 style="color: #ffffff; font-size: 32px; font-weight: 700; margin-bottom: 10px;">Mi Cuenta</h1>
        <p style="color: #94a3b8; font-size: 15px;">Administra y actualiza la información de tu perfil en el sistema.</p>
    </div>

    <?php if (!empty($mensajeAlerta)): ?>
        <div style="background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.3); color: #34d399; padding: 12px 20px; border-radius: 10px; margin-bottom: 25px; text-align: center; font-size: 14px; font-weight: 500;">
            <?= htmlspecialchars($mensajeAlerta) ?>
        </div>
    <?php endif; ?>

    <div style="background: #0b1329; border: 1px solid #1f293d; border-radius: 16px; padding: 35px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
        <form action="" method="POST">
            
            <div style="margin-bottom: 20px;">
                <label style="display: block; color: #94a3b8; font-size: 13px; font-weight: 600; text-transform: uppercase; margin-bottom: 8px; letter-spacing: 0.5px;">Carnet de Identidad (CI)</label>
                <input type="text" value="<?= htmlspecialchars($userData['ci_usu'] ?? '') ?>" disabled style="width: 100%; padding: 12px 16px; background: #070d1d; border: 1px solid #1f293d; color: #64748b; border-radius: 10px; font-size: 14px; cursor: not-allowed;">
                <small style="color: #64748b; font-size: 12px; margin-top: 4px; display: block;">El CI no se puede modificar por motivos de seguridad.</small>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; color: #cbd5e1; font-size: 13px; font-weight: 600; text-transform: uppercase; margin-bottom: 8px; letter-spacing: 0.5px;">Nombre Completo</label>
                <input type="text" name="nombre" value="<?= htmlspecialchars($userData['nombre_c_usu'] ?? '') ?>" required style="width: 100%; padding: 12px 16px; background: #070d1d; border: 1px solid #1f293d; color: #ffffff; border-radius: 10px; font-size: 14px; outline: none;">
            </div>

            <div style="margin-bottom: 30px;">
                <label style="display: block; color: #cbd5e1; font-size: 13px; font-weight: 600; text-transform: uppercase; margin-bottom: 8px; letter-spacing: 0.5px;">Nueva Contraseña <span style="font-weight: normal; color: #64748b;">(Opcional)</span></label>
                <input type="password" name="password" placeholder="Déjalo en blanco si no deseas cambiarla" style="width: 100%; padding: 12px 16px; background: #070d1d; border: 1px solid #1f293d; color: #ffffff; border-radius: 10px; font-size: 14px; outline: none;">
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #1f293d; padding-top: 25px;">
                <a href="/SISVOX/public/index.php?route=inicio_estudiante" style="color: #94a3b8; text-decoration: none; font-size: 14px; font-weight: 500;">&larr; Cancelar y volver</a>
                <button type="submit" style="background: #0284c7; color: #ffffff; padding: 12px 28px; border-radius: 10px; font-size: 14px; font-weight: 600; border: none; cursor: pointer; box-shadow: 0 2px 4px rgba(2, 132, 199, 0.3);">
                    Guardar Cambios
                </button>
            </div>

        </form>
    </div>

</div>