<?php
$tituloPagina = $cfg['titulo'];
$navActivo = $e;
require __DIR__ . '/_header.php';

// Convierte un valor guardado en su etiqueta legible (p. ej. rol, activo, verificado)
$mostrar = function (string $col, $valor) use ($cfg) {
    $def = $cfg['campos'][$col] ?? null;
    if ($def && $def['tipo'] === 'select' && isset($def['opciones'][(string) $valor])) {
        return $def['opciones'][(string) $valor];
    }
    return $valor === null || $valor === '' ? '—' : $valor;
};
$badge = function (string $col, $valor): string {
    if (in_array($col, ['activo', 'verificado'], true)) return (string) $valor === '1' ? 'green' : 'red';
    if ($col === 'rol') return $valor === 'admin' ? 'amber' : 'blue';
    return '';
};
$qs = fn(array $extra) => http_build_query(array_filter(array_merge(['route' => 'admin_listado', 'e' => $e, 'q' => $q], $extra), fn($v) => $v !== '' && $v !== null));
?>
<h1><?= adm_h($cfg['titulo']) ?></h1>
<p class="sub"><?= $total ?> registro(s)<?= $q !== '' ? ' para «' . adm_h($q) . '»' : '' ?>. Los cambios quedan registrados en la bitácora.</p>

<form method="get" action="<?= $baseAdm ?>" class="toolbar">
    <input type="hidden" name="route" value="admin_listado">
    <input type="hidden" name="e" value="<?= adm_h($e) ?>">
    <div class="form-group"><input class="form-control" type="search" name="q" value="<?= adm_h($q) ?>" placeholder="Buscar…" style="min-width:260px"></div>
    <button class="btn" type="submit">Buscar</button>
    <?php if ($q !== ''): ?><a class="btn sec" href="<?= $baseAdm ?>?route=admin_listado&e=<?= adm_h($e) ?>">Limpiar</a><?php endif; ?>
</form>

<div class="card">
<?php if (!$filas): ?>
    <p class="muted">No hay registros.</p>
<?php else: ?>
    <div class="table-wrap"><table>
        <thead><tr>
            <?php foreach ($cfg['columnas'] as $etq): ?><th><?= adm_h($etq) ?></th><?php endforeach; ?>
            <th>Acciones</th>
        </tr></thead>
        <tbody>
        <?php foreach ($filas as $f): ?>
            <?php $idFila = $f[$cfg['pk_col']]; ?>
            <tr>
                <?php foreach ($cfg['columnas'] as $col => $etq): ?>
                    <td>
                        <?php $cls = $badge($col, $f[$col] ?? ''); ?>
                        <?php if ($cls !== ''): ?>
                            <span class="badge <?= $cls ?>"><?= adm_h($mostrar($col, $f[$col] ?? '')) ?></span>
                        <?php else: ?>
                            <?= adm_h($mostrar($col, $f[$col] ?? '')) ?>
                        <?php endif; ?>
                    </td>
                <?php endforeach; ?>
                <td><div class="acciones">
                    <a class="btn sm" href="<?= $baseAdm ?>?route=admin_editar&e=<?= adm_h($e) ?>&id=<?= urlencode((string) $idFila) ?>">Editar</a>
                    <?php if (!empty($cfg['eliminable'])): ?>
                        <form method="post" action="<?= $baseAdm ?>?route=admin_eliminar" onsubmit="return confirm('¿Eliminar este registro? Esta acción no se puede deshacer.');">
                            <?= csrf_campo() ?>
                            <input type="hidden" name="e" value="<?= adm_h($e) ?>">
                            <input type="hidden" name="id" value="<?= adm_h($idFila) ?>">
                            <button class="btn del sm" type="submit">Eliminar</button>
                        </form>
                    <?php endif; ?>
                </div></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table></div>

    <?php if ($paginas > 1): ?>
        <div class="pager">
            <?php if ($pagina > 1): ?><a class="btn sec sm" href="?<?= $qs(['p' => $pagina - 1]) ?>">&larr; Anterior</a><?php endif; ?>
            <span>Página <?= $pagina ?> de <?= $paginas ?></span>
            <?php if ($pagina < $paginas): ?><a class="btn sec sm" href="?<?= $qs(['p' => $pagina + 1]) ?>">Siguiente &rarr;</a><?php endif; ?>
        </div>
    <?php endif; ?>
<?php endif; ?>
</div>
<?php require __DIR__ . '/_footer.php'; ?>
