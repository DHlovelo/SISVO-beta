<?php
// 1. Incluimos la conexión a la base de datos asegurando la ruta hacia tu carpeta config
require_once __DIR__ . '/../../config/sisvo_conexion.php';

// Verificación de respaldo para asegurar que $pdo funcione
if (!isset($pdo)) {
    $host = 'localhost';
    $dbname = 'sisvo';
    $username = 'root';
    $password = '';
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}

// 2. Consultamos las convocatorias uniendo con la tabla instituciones para traer el nombre real
$stmtConv = $pdo->query("SELECT c.*, i.nombre_institucion FROM convocatorias c JOIN instituciones i ON c.CI_usu = i.CI_usu ORDER BY c.created_at DESC");
$convocatorias = $stmtConv->fetchAll(PDO::FETCH_ASSOC);

// 3. Consultamos las becas uniendo con la tabla instituciones
$stmtBecas = $pdo->query("SELECT b.*, i.nombre_institucion FROM becas b JOIN instituciones i ON b.CI_usu = i.CI_usu ORDER BY b.created_at DESC");
$becas = $stmtBecas->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- SECCIÓN VISUAL PARA EL ESTUDIANTE -->
<div class="container-publicaciones" style="padding: 20px;">
    <h2>Convocatorias Disponibles</h2>
    <?php if (empty($convocatorias)): ?>
        <p>No hay convocatorias publicadas por el momento.</p>
    <?php else: ?>
        <?php foreach ($convocatorias as $conv): ?>
            <div class="card" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 8px; background: #fff;">
                <h3><?= htmlspecialchars($conv['titulo']) ?></h3>
                <p><strong>Institución:</strong> <?= htmlspecialchars($conv['nombre_institucion']) ?></p>
                <p><strong>Categoría:</strong> <?= htmlspecialchars($conv['categoria']) ?></p>
                <p><?= nl2br(htmlspecialchars($conv['descripcion'])) ?></p>
                <small style="color: #666;">Fecha de cierre: <?= htmlspecialchars($conv['fecha_cierre']) ?></small>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <h2 style="margin-top: 30px;">Becas Disponibles</h2>
    <?php if (empty($becas)): ?>
        <p>No hay becas publicadas por el momento.</p>
    <?php else: ?>
        <?php foreach ($becas as $beca): ?>
            <div class="card" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 8px; background: #fff;">
                <h3><?= htmlspecialchars($beca['titulo']) ?></h3>
                <p><strong>Institución:</strong> <?= htmlspecialchars($beca['nombre_institucion']) ?></p>
                <p><strong>Descripción:</strong> <?= nl2br(htmlspecialchars($beca['descripcion'])) ?></p>
                <p><strong>Requisitos:</strong> <?= nl2br(htmlspecialchars($beca['requisitos'])) ?></p>
                <small style="color: #666;">Fecha de cierre: <?= htmlspecialchars($beca['fecha_cierre']) ?></small>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>