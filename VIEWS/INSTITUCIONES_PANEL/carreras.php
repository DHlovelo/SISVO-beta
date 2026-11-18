<?php
// Aseguramos las variables pasadas desde el controlador
$sedes = $GLOBALS['sedes_institucion'] ?? [];
$carreras = $GLOBALS['carreras_institucion'] ?? [];
?>

<style>

    .content-container input[type="text"],
    .content-container select,
    .content-container textarea {
        width: 100%;
        background-color: #0b0b0b;
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 8px;
        padding: 12px 15px;
        color: #ffffff;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 14px;
        margin-top: 8px;
        margin-bottom: 20px;
        outline: none;
        transition: border-color 0.2s;
    }

    .content-container input[type="text"]:focus,
    .content-container select:focus,
    .content-container textarea:focus {
        border-color: #3b82f6;
    }

    .content-container label {
        color: #9ca3af;
        font-size: 14px;
        font-weight: 500;
    }

    .content-container button[type="submit"],
    .content-container .btn-publicar {
        background-color: #ffffff;
        color: #0b0b0b;
        padding: 12px 25px;
        border-radius: 30px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        font-size: 15px;
        transition: background 0.2s;
    }

    .content-container button[type="submit"]:hover {
        background-color: #e5e7eb;
    }
</style>

<div class="content-container">
    <h2>Publicar Nueva Carrera</h2>
    <p>Selecciona la sede o campus donde se ofertará esta carrera.</p>
    <br>

    <form action="/SISVOX/PUBLIC/index.php?route=guardar_carrera" method="POST">
        <div>
            <label for="nombre_carrera">Nombre de la Carrera *</label>
            <input type="text" id="nombre_carrera" name="nombre_carrera" placeholder="Ej. Ingeniería de Sistemas" required>
        </div>

        <div>
            <label for="id_sede">Sede / Campus Disponible *</label>
            <select id="id_sede" name="id_sede" required>
                <option value="">Selecciona una sede...</option>
                <?php foreach ($sedes as $sede): ?>
                    <option value="<?php echo htmlspecialchars($sede['id_sede']); ?>">
                        <?php echo htmlspecialchars($sede['nombre_sede'] ?? $sede['nombre'] ?? 'Sede sin nombre'); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label for="nivel">Nivel Académico</label>
            <input type="text" id="nive" name="nivel" placeholder="Ej. Licenciatura / Técnico Superior">
        </div>

        <div>
            <label for="duracion">Duración</label>
            <input type="text" id="duracion" name="duracion" placeholder="Ej. 4 años / 8 semestres">
        </div>

        <div>
            <label for="descripcion">Descripción o Perfil</label>
            <textarea id="descripcion" name="descripcion" rows="4" placeholder="Breve detalle de la carrera..."></textarea>
        </div>

        <button type="submit" class="btn-publicar">+ Publicar Carrera</button>
    </form>
</div>