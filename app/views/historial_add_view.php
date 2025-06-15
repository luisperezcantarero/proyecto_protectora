<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo registro</title>
</head>
<body>
    <h2>Añadir al historial la adopción</h2>
    <form method="POST">
        <label>Resultado:</label>
        <input type="text" name="resultado"><br/><br/>
        <label>Observaciones:</label>
        <textarea name="observaciones"></textarea><br/><br/>
        <label>Tipo de seguimiento:</label>
        <select name="tipo_id" id="tipo_id">
            <?php
            foreach ($data['tipos_seguimiento'] as $tipo) {
                echo "<option value='" . htmlspecialchars($tipo['id']) . "'>" . htmlspecialchars($tipo['nombre']) . "</option>";
            }
            ?>
        </select><br/><br/>
        <input type="submit" value="Añadir observación">
    </form>
</body>
</html>