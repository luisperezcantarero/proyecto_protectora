<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancelar adopcion</title>
</head>
<body>
    <h2>Cancelar la adopción</h2>
    <?php
    if (!empty($data['error'])) {
        echo "<p style='color: red;'>" . $data['error'] . "</p>";
    }
    ?>
    <form method="POST" action="/adopciones/cancelar">
        <label for="motivo_cancelacion">Motivo de la cancelación:</label>
        <textarea id="motivo_cancelacion" name="motivo_cancelacion"></textarea>
        <input type="hidden" name="adopcion_id" value="<?php echo $data['adopcion_id']; ?>">
        <button type="submit">Cancelar adopción</button>
    </form>
</body>
</html>