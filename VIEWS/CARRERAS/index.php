<?php
// views/CARRERAS/index.php
require_once __DIR__ . '/../../CONFIG/sisvo_conexion.php';
global $pdo;

// Si por alguna razón $pdo llega nulo, lo inicializamos de forma segura
if (!isset($pdo) || $pdo === null) {
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=sisvo;charset=utf8", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        $listaCarreras = [];
    }
}

// Consultamos las carreras unidas con sus respectivas sedes
try {
    $stmt = $pdo->prepare("
        SELECT c.*, s.nombre_sede 
        FROM carreras c 
        LEFT JOIN sedes s ON c.id_sede = s.id_sede 
        ORDER BY c.id_carrera DESC
    ");
    $stmt->execute();
    $listaCarreras = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $listaCarreras = [];
}
?>

<div style="max-width: 1100px; margin: 0 auto; width: 100%; padding: 0 20px;">
    <div style="text-align: center; margin-bottom: 40px;">
        <h2 style="font-size: 36px; font-weight: 700; margin-bottom: 12px; color: #ffffff;">Oferta Académica de Carreras</h2>
        <p style="color: #9ca3af; font-size: 15px; margin-bottom: 25px;">Encuentra tu carrera ideal por institución y sede.</p>
        
        <div style="max-width: 600px; margin: 0 auto;">
            <input type="text" id="buscadorCarreras" placeholder="Buscar por carrera, universidad o sede (ej. Sistemas, El Alto)..." style="width: 100%; background-color: #141414; border: 1px solid rgba(255, 255, 255, 0.15); border-radius: 30px; padding: 14px 20px; color: #ffffff; outline: none; font-size: 14px;">
        </div>
    </div>

    <?php if (empty($listaCarreras)): ?>
        <p style="color: #9ca3af; text-align: center; padding: 40px; font-size: 15px;">No hay carreras publicadas en el sistema actualmente.</p>
    <?php else: ?>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 24px;">
            <?php foreach ($listaCarreras as $carrera): ?>
                <div style="background-color: #141414; border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 16px; padding: 28px; transition: border-color 0.2s;">
                    <h3 style="color: #ffffff; font-size: 18px; font-weight: 600; margin-bottom: 10px;"><?php echo htmlspecialchars($carrera['nombre_carrera']); ?></h3>
                    <p style="color: #3b82f6; font-size: 14px; font-weight: 600; margin-bottom: 12px;">
                        📍 Sede: <?php echo htmlspecialchars($carrera['nombre_sede'] ?? 'Sede Principal'); ?>
                    </p>
                    <p style="color: #9ca3af; font-size: 14px; margin-bottom: 6px;"><strong>Nivel:</strong> <?php echo htmlspecialchars($carrera['nivel'] ?? 'No especificado'); ?></p>
                    <p style="color: #9ca3af; font-size: 14px; margin-bottom: 12px;"><strong>Duración:</strong> <?php echo htmlspecialchars($carrera['duracion'] ?? 'No especificada'); ?></p>
                    <p style="color: #d1d5db; font-size: 14px; line-height: 1.5;"><?php echo nl2br(htmlspecialchars($carrera['descripcion'] ?? 'Sin descripción.')); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>