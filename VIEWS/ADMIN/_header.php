<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }

$flash = $_SESSION['admin_flash'] ?? null;
unset($_SESSION['admin_flash']);

$baseAdm = '/SISVOX/PUBLIC/index.php';
$navItems = [
    'dashboard'     => ['Panel',          "$baseAdm?route=admin_dashboard"],
    'usuarios'      => ['Usuarios',       "$baseAdm?route=admin_listado&e=usuarios"],
    'directorio'    => ['Universidades',  "$baseAdm?route=admin_listado&e=directorio"],
    'instituciones' => ['Instituciones',  "$baseAdm?route=admin_listado&e=instituciones"],
    'becas'         => ['Becas',          "$baseAdm?route=admin_listado&e=becas"],
    'convocatorias' => ['Convocatorias',  "$baseAdm?route=admin_listado&e=convocatorias"],
    'bitacora'      => ['Bitácora',       "$baseAdm?route=admin_bitacora"],
];
$navActivo = $navActivo ?? '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= adm_h($tituloPagina ?? 'Administración') ?> - SISVOX</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { background:#0b0b0b; color:#fff; font-family:'Plus Jakarta Sans',sans-serif; min-height:100vh; display:flex; flex-direction:column; }
        .navbar { display:flex; justify-content:space-between; align-items:center; gap:20px; flex-wrap:wrap; padding:20px 40px; max-width:1400px; width:100%; margin:0 auto; border-bottom:1px solid rgba(255,255,255,.08); }
        .logo { font-size:22px; font-weight:700; letter-spacing:1px; color:#fff; text-decoration:none; }
        .logo span { color:#3b82f6; }
        .logo small { font-size:11px; color:#9ca3af; margin-left:8px; font-weight:500; letter-spacing:0; }
        .nav-links { display:flex; gap:22px; align-items:center; flex-wrap:wrap; }
        .nav-links a { color:#9ca3af; text-decoration:none; font-size:14px; font-weight:500; }
        .nav-links a:hover, .nav-links a.active { color:#fff; }
        .nav-links a.active { border-bottom:2px solid #3b82f6; padding-bottom:3px; }
        .nav-links a.logout { color:#ef4444; font-weight:600; }
        main { flex:1; max-width:1260px; width:100%; margin:0 auto; padding:35px 20px; }
        h1 { font-size:26px; margin-bottom:6px; }
        .sub { color:#9ca3af; font-size:14px; margin-bottom:25px; }
        .card { background:#141414; border:1px solid rgba(255,255,255,.08); border-radius:16px; padding:24px; margin-bottom:24px; }
        .card h3 { font-size:16px; margin-bottom:14px; }
        .stats { display:grid; grid-template-columns:repeat(auto-fit,minmax(180px,1fr)); gap:16px; margin-bottom:24px; }
        .stat { background:#141414; border:1px solid rgba(255,255,255,.08); border-radius:16px; padding:20px; text-decoration:none; color:#fff; display:block; }
        .stat:hover { border-color:#3b82f6; }
        .stat b { font-size:30px; display:block; }
        .stat span { color:#9ca3af; font-size:13px; }
        .stat.warn b { color:#f59e0b; } .stat.danger b { color:#ef4444; }
        .table-wrap { overflow-x:auto; }
        table { width:100%; border-collapse:collapse; font-size:14px; }
        th { text-align:left; color:#9ca3af; font-weight:600; font-size:12px; text-transform:uppercase; letter-spacing:.5px; padding:10px 12px; border-bottom:1px solid rgba(255,255,255,.1); white-space:nowrap; }
        td { padding:12px; border-bottom:1px solid rgba(255,255,255,.05); vertical-align:top; }
        tr:hover td { background:rgba(255,255,255,.02); }
        .acciones { display:flex; gap:8px; align-items:center; white-space:nowrap; }
        .btn { display:inline-block; background:#3b82f6; color:#fff; border:none; padding:9px 18px; border-radius:30px; font-weight:600; font-size:13px; cursor:pointer; text-decoration:none; font-family:inherit; }
        .btn:hover { background:#2563eb; }
        .btn.sec { background:transparent; border:1px solid rgba(255,255,255,.2); color:#d1d5db; }
        .btn.sec:hover { border-color:#fff; color:#fff; }
        .btn.del { background:transparent; border:1px solid rgba(239,68,68,.5); color:#ef4444; }
        .btn.del:hover { background:rgba(239,68,68,.12); }
        .btn.sm { padding:6px 14px; font-size:12px; }
        .form-group { margin-bottom:18px; }
        .form-group label { display:block; margin-bottom:6px; font-size:13px; color:#9ca3af; font-weight:500; }
        .form-control { width:100%; padding:11px 12px; background:#0b0b0b; border:1px solid rgba(255,255,255,.12); border-radius:8px; color:#fff; font-size:14px; font-family:inherit; outline:none; }
        .form-control:focus { border-color:#3b82f6; }
        textarea.form-control { min-height:120px; resize:vertical; }
        .hint { font-size:12px; color:#6b7280; margin-top:5px; }
        .grid-2 { display:grid; grid-template-columns:1fr 1fr; gap:0 24px; }
        @media (max-width:760px) { .grid-2 { grid-template-columns:1fr; } .navbar { padding:16px 20px; } }
        .alert { padding:12px 18px; border-radius:8px; margin-bottom:20px; font-size:14px; }
        .alert.ok { background:rgba(16,185,129,.1); color:#10b981; border:1px solid rgba(16,185,129,.25); }
        .alert.error { background:rgba(239,68,68,.1); color:#f87171; border:1px solid rgba(239,68,68,.25); }
        .alert.info { background:rgba(59,130,246,.1); color:#60a5fa; border:1px solid rgba(59,130,246,.25); }
        .alert ul { margin:6px 0 0 18px; }
        .toolbar { display:flex; gap:12px; flex-wrap:wrap; align-items:end; margin-bottom:18px; }
        .toolbar .form-group { margin-bottom:0; }
        .badge { display:inline-block; padding:3px 10px; border-radius:20px; font-size:12px; font-weight:600; background:rgba(156,163,175,.15); color:#d1d5db; }
        .badge.green { background:rgba(16,185,129,.15); color:#34d399; }
        .badge.red { background:rgba(239,68,68,.15); color:#f87171; }
        .badge.blue { background:rgba(59,130,246,.15); color:#60a5fa; }
        .badge.amber { background:rgba(245,158,11,.15); color:#fbbf24; }
        .pager { display:flex; gap:8px; align-items:center; justify-content:center; margin-top:18px; color:#9ca3af; font-size:13px; }
        details summary { cursor:pointer; color:#60a5fa; font-size:13px; }
        .diff { margin-top:8px; font-size:13px; }
        .diff td, .diff th { padding:6px 10px; }
        .old { color:#f87171; } .new { color:#34d399; }
        .muted { color:#6b7280; font-size:13px; }
        footer { border-top:1px solid rgba(255,255,255,.08); text-align:center; padding:22px; color:#6b7280; font-size:13px; }
    </style>
</head>
<body>
<header class="navbar">
    <a href="<?= $baseAdm ?>?route=admin_dashboard" class="logo">SIS<span>VO</span><small>Administración</small></a>
    <nav class="nav-links">
        <?php foreach ($navItems as $clave => [$texto, $url]): ?>
            <a href="<?= $url ?>" class="<?= $navActivo === $clave ? 'active' : '' ?>"><?= $texto ?></a>
        <?php endforeach; ?>
        <span class="muted">👤 <?= adm_h($admin['nombre'] ?? '') ?></span>
        <a href="<?= $baseAdm ?>?route=logout" class="logout">Cerrar sesión</a>
    </nav>
</header>
<main>
<?php if ($flash): ?>
    <div class="alert <?= adm_h($flash['tipo']) ?>"><?= adm_h($flash['msg']) ?></div>
<?php endif; ?>
