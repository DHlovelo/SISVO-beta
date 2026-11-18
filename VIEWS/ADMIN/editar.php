<?php
$tituloPagina = 'Editar ' . $cfg['singular'];
$navActivo = $e;
require __DIR__ . '/_header.php';
$idFila = $fila[$cfg['pk_col']];
?>
<h1>Editar <?= adm_h($cfg['singular']) ?></h1>
<p class="sub">
    Registro <b><?= adm_h($idFila) ?></b><?php $nomFila = $fila['nombre_institucion'] ?? ($e === 'directorio' ? ($fila['nombre'] ?? '') : ''); ?><?= $nomFila !== '' && $e !== 'instituciones' ? ' · ' . adm_h($nomFila) : '' ?>.
    Se guardará en la bitácora qué campos cambiaste, con su valor anterior y el nuevo.
</p>

<?php if (!empty($errores)): ?>
    <div class="alert error">Revisa los datos:<ul><?php foreach ($errores as $m): ?><li><?= adm_h($m) ?></li><?php endforeach; ?></ul></div>
<?php endif; ?>

<form method="post" action="<?= $baseAdm ?>?route=admin_guardar" class="card" autocomplete="off">
    <?= csrf_campo() ?>
    <input type="hidden" name="e" value="<?= adm_h($e) ?>">
    <input type="hidden" name="id" value="<?= adm_h($idFila) ?>">

    <div class="grid-2">
    <?php foreach ($cfg['campos'] as $campo => $def): ?>
        <?php $valor = $fila[$campo] ?? ''; $ancho = $def['tipo'] === 'textarea' ? 'grid-column:1 / -1;' : ''; ?>
        <div class="form-group" style="<?= $ancho ?>">
            <label for="f_<?= adm_h($campo) ?>"><?= adm_h($def['label']) ?><?= !empty($def['req']) ? ' *' : '' ?></label>
            <?php if ($def['tipo'] === 'textarea'): ?>
                <textarea class="form-control" id="f_<?= adm_h($campo) ?>" name="<?= adm_h($campo) ?>" maxlength="<?= (int) ($def['max'] ?? 5000) ?>"><?= adm_h($valor) ?></textarea>
            <?php elseif ($def['tipo'] === 'select'): ?>
                <select class="form-control" id="f_<?= adm_h($campo) ?>" name="<?= adm_h($campo) ?>">
                    <?php foreach ($def['opciones'] as $v => $etq): ?>
                        <option value="<?= adm_h($v) ?>" <?= (string) $valor === (string) $v ? 'selected' : '' ?>><?= adm_h($etq) ?></option>
                    <?php endforeach; ?>
                </select>
            <?php else: ?>
                <input class="form-control" id="f_<?= adm_h($campo) ?>" name="<?= adm_h($campo) ?>"
                       type="<?= $def['tipo'] === 'email' ? 'email' : ($def['tipo'] === 'date' ? 'date' : 'text') ?>"
                       value="<?= adm_h($valor) ?>" <?= isset($def['max']) ? 'maxlength="' . (int) $def['max'] . '"' : '' ?> <?= !empty($def['req']) ? 'required' : '' ?>>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
    </div>

    <?php if ($e === 'usuarios'): ?>
        <div class="form-group">
            <label for="f_clave">Nueva contraseña (opcional)</label>
            <input class="form-control" id="f_clave" name="nueva_contrasena" type="password" minlength="8" autocomplete="new-password">
            <p class="hint">Déjala vacía para no cambiarla. Mínimo 8 caracteres. En la bitácora solo queda constancia de que se restableció, nunca la contraseña.</p>
        </div>
        <?php if ((string) $idFila === (string) ($admin['ci'] ?? '')): ?>
            <p class="hint" style="margin-bottom:16px">Es tu propia cuenta: no puedes quitarte el rol de administrador ni desactivarla.</p>
        <?php endif; ?>
    <?php endif; ?>

    <div style="display:flex; gap:10px">
        <button class="btn" type="submit">Guardar cambios</button>
        <a class="btn sec" href="<?= $baseAdm ?>?route=admin_listado&e=<?= adm_h($e) ?>">Cancelar</a>
    </div>
</form>
<?php require __DIR__ . '/_footer.php'; ?>
