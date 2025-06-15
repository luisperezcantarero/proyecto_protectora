<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancelar adopción</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <div class="add-mascota-container">
        <h2 class="add-mascota-title">Cancelar la adopción</h2>
        <?php
        if (!empty($data['error'])) {
            echo "<p class='register-error'>" . $data['error'] . "</p>";
        }
        ?>
        <form class="add-mascota-form" method="POST" action="/adopciones/cancelar">
            <label for="motivo_cancelacion">Motivo de la cancelación:</label>
            <textarea class="add-mascota-input" id="motivo_cancelacion" name="motivo_cancelacion"></textarea>
            <input type="hidden" name="adopcion_id" value="<?php echo $data['adopcion_id']; ?>">
            <input class="add-mascota-btn" type="submit" value="Cancelar adopción">
        </form>
        <div class="add-mascota-back-link">
            <a href="/adopciones/mostrar">Volver</a>
        </div>
    </div>
</body>
</html>