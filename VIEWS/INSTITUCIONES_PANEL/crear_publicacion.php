<form action="/SISVOX/PUBLIC/index.php?route=guardar_publicacion" method="POST">
    <label>Tipo de Publicación:</label>
    <select name="tipo_publicacion" required>
        <option value="convocatoria">Convocatoria</option>
        <option value="beca">Beca</option>
    </select>

    <label>Título:</label>
    <input type="text" name="titulo" required>

    <label>Categoría (Solo para convocatorias):</label>
    <input type="text" name="categoria">

    <label>Descripción:</label>
    <textarea name="descripcion" required></textarea>

    <label>Requisitos (Solo para becas):</label>
    <textarea name="requisitos"></textarea>

    <label>Fecha de Cierre:</label>
    <input type="date" name="fecha_cierre" required>

    <button type="submit">Publicar</button>
</form>