<?php
$tituloPagina = 'Bitácora';
$navActivo = 'bitacora';
require __DIR__ . '/_header.php';

$color = function (string $a): string {
    if (in_array($a, ['login_fallido', 'acceso_denegado', 'csrf_invalido', 'login_bloqueado'], true)) return 'red';
    if ($a === 'eliminar') return 'amber';
    if ($a === 'editar') return 'blue';
    if ($a === 'login_ok') return 'green';
    return '';
};
$qs = fn(array $extra) => http_build_query(array_filter(array_merge(['route' => 'admin_bitacora'], $filtros, $extra), fn($v) => $v !== '' && $v !== null));
$qsCsv = http_build_query(array_filter(array_merge(['route' => 'admin_bitacora_csv'], $filtros), fn($v) => $v !== ''));

// Tabla de cambios (antes → después)
$diff = function (?string $a, ?string $d) {
    $antes = $a ? (json_decode($a, true) ?: []) : [];
    $desp  = $d ? (json_decode($d, true) ?: []) : [];
    $campos = array_unique(array_merge(array_keys($antes), array_keys($desp)));
    if (!$campos) return '';
    $h = '<details><summary>Ver cambios</summary><table class="diff"><thead><tr><th>Campo</th><th>Antes</th><th>Después</th></tr></thead><tbody>';
    foreach ($campos as $c) {
        $h .= '<tr><td>' . adm_h($c) . '</td><td class="old">' . adm_h($antes[$c] ?? '—') . '</td><td class="new">' . adm_h($desp[$c] ?? '—') . '</td></tr>';
    }
    return $h . '</tbody></table></details>';
};
?>
<h1>Bitácora</h1>
<p class="sub">Registro de inicios de sesión y de todo lo que se edita o elimina desde este panel. Solo se puede consultar y exportar.</p>

<form method="get" action="<?= $baseAdm ?>" class="card toolbar">
    <input type="hidden" name="route" value="admin_bitacora">
    <div class="form-group"><label>Desde</label><input class="form-control" type="date" name="desde" value="<?= adm_h($filtros['desde']) ?>"></div>
    <div class="form-group"><label>Hasta</label><input class="form-control" type="date" name="hasta" value="<?= adm_h($filtros['hasta']) ?>"></div>
    <div class="form-group"><label>Acción</label>
        <select class="form-control" name="accion"><option value="">Todas</option>
            <?php foreach ($acciones as $a): ?><option value="<?= adm_h($a) ?>" <?= $filtros['accion'] === $a ? 'selected' : '' ?>><?= adm_h($a) ?></option><?php endforeach; ?>
        </select></div>
    <div class="form-group"><label>Sección</label>
        <select class="form-control" name="entidad"><option value="">Todas</option>
            <?php foreach ($entidades as $en): ?><option value="<?= adm_h($en) ?>" <?= $filtros['entidad'] === $en ? 'selected' : '' ?>><?= adm_h($en) ?></option><?php endforeach; ?>
        </select></div>
    <div class="form-group"><label>Buscar (usuario, CI, detalle)</label><input class="form-control" type="search" name="q" value="<?= adm_h($filtros['q']) ?>"></div>
    <button class="btn" type="submit">Filtrar</button>
    <a class="btn sec" href="<?= $baseAdm ?>?route=admin_bitacora">Limpiar</a>
    <a class="btn sec" href="<?= $baseAdm ?>?<?= $qsCsv ?>">Exportar CSV</a>
</form>

<div class="card">
    <p class="muted" style="margin-bottom:12px"><?= $total ?> registro(s)</p>
<?php if (!$filas): ?>
    <p class="muted">No hay registros con esos filtros.</p>
<?php else: ?>
    <div class="table-wrap"><table>
        <thead><tr><th>Fecha</th><th>Usuario</th><th>Acción</th><th>Sobre</th><th>Detalle</th><th>IP</th></tr></thead>
        <tbody>
        <?php foreach ($filas as $r): ?>
            <tr>
                <td class="muted" style="white-space:nowrap"><?= adm_h($r['fecha']) ?></td>
                <td><?= adm_h($r['nombre'] ?? '—') ?><br><span class="muted"><?= adm_h($r['CI_usu'] ?? '') ?><?= $r['rol'] ? ' · ' . adm_h($r['rol']) : '' ?></span></td>
                <td><span class="badge <?= $color($r['accion']) ?>"><?= adm_h($r['accion']) ?></span></td>
                <td><?= adm_h(trim(($r['entidad'] ?? '') . ' ' . ($r['entidad_id'] ?? ''))) ?: '—' ?></td>
                <td><?= adm_h($r['detalle'] ?? '') ?><?= $diff($r['datos_antes'], $r['datos_despues']) ?></td>
                <td class="muted"><?= adm_h($r['ip'] ?? '') ?></td>
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
