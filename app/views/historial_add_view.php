<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo registro</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <div class="add-mascota-container">
        <h2 class="add-mascota-title">Añadir al historial la adopción</h2>
        <form class="add-mascota-form" method="POST">
            <label for="resultado">Resultado:</label>
            <input class="add-mascota-input" type="text" id="resultado" name="resultado">

            <label for="observaciones">Observaciones:</label>
            <textarea class="add-mascota-input" id="observaciones" name="observaciones"></textarea>

            <label for="tipo_id">Tipo de seguimiento:</label>
            <select class="add-mascota-input" name="tipo_id" id="tipo_id">
                <?php
                foreach ($data['tipos_seguimiento'] as $tipo) {
                    echo "<option value='" . $tipo['id'] . "'>" . $tipo['nombre'] . "</option>";
                }
                ?>
            </select>

            <input class="add-mascota-btn" type="submit" value="Añadir observación">
        </form>
        <div class="add-mascota-back-link">
            <a href="/">Volver al inicio</a>
        </div>
    </div>
</body>
</html>