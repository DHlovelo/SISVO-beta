<?php
$tituloPagina = 'Panel de administración';
$navActivo = 'dashboard';
require __DIR__ . '/_header.php';

$colorAccion = function (string $a): string {
    if (in_array($a, ['login_fallido', 'acceso_denegado', 'csrf_invalido', 'login_bloqueado'], true)) return 'red';
    if ($a === 'eliminar') return 'amber';
    if ($a === 'editar') return 'blue';
    if ($a === 'login_ok') return 'green';
    return '';
};
?>
<h1>Panel de administración</h1>
<p class="sub">Gestiona usuarios, universidades, instituciones, becas y convocatorias. Cada cambio queda en la bitácora.</p>

<?php if (!$bitacoraLista): ?>
    <div class="alert error">La tabla <b>bitacora</b> no existe todavía. Ejecuta <code>config/migracion_admin_bitacora.sql</code> en phpMyAdmin.</div>
<?php endif; ?>

<div class="stats">
    <a class="stat" href="<?= $baseAdm ?>?route=admin_listado&e=usuarios"><b><?= $stats['usuarios'] ?></b><span>Usuarios registrados</span></a>
    <a class="stat" href="<?= $baseAdm ?>?route=admin_listado&e=directorio"><b><?= $stats['directorio'] ?></b><span>Universidades en el directorio</span></a>
    <a class="stat" href="<?= $baseAdm ?>?route=admin_listado&e=instituciones"><b class="<?= $stats['inst_pendientes'] ? 'warn' : '' ?>"><?= $stats['inst_pendientes'] ?></b><span>Instituciones por verificar</span></a>
    <a class="stat" href="<?= $baseAdm ?>?route=admin_listado&e=becas"><b><?= $stats['becas'] ?></b><span>Becas publicadas</span></a>
    <a class="stat" href="<?= $baseAdm ?>?route=admin_listado&e=convocatorias"><b><?= $stats['convocatorias'] ?></b><span>Convocatorias publicadas</span></a>
    <a class="stat <?= $fallidos24h >= 5 ? 'danger' : '' ?>" href="<?= $baseAdm ?>?route=admin_bitacora&accion=login_fallido"><b><?= $fallidos24h ?></b><span>Inicios de sesión fallidos (24 h)</span></a>
</div>

<div class="card">
    <h3>Actividad reciente</h3>
    <?php if (!$ultimos): ?>
        <p class="muted">Aún no hay registros.</p>
    <?php else: ?>
        <div class="table-wrap"><table>
            <thead><tr><th>Fecha</th><th>Usuario</th><th>Acción</th><th>Sobre</th></tr></thead>
            <tbody>
            <?php foreach ($ultimos as $r): ?>
                <tr>
                    <td class="muted"><?= adm_h($r['fecha']) ?></td>
                    <td><?= adm_h($r['nombre'] ?? '—') ?></td>
                    <td><span class="badge <?= $colorAccion($r['accion']) ?>"><?= adm_h($r['accion']) ?></span></td>
                    <td><?= adm_h(trim(($r['entidad'] ?? '') . ' ' . ($r['entidad_id'] ?? ''))) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table></div>
        <p style="margin-top:14px"><a class="btn sec sm" href="<?= $baseAdm ?>?route=admin_bitacora">Ver bitácora completa</a></p>
    <?php endif; ?>
</div>
<?php require __DIR__ . '/_footer.php'; ?>