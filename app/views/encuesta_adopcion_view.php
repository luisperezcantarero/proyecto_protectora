<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encuesta</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <div class="add-mascota-container">
        <h2 class="add-mascota-title">Encuesta de Adopción</h2>
        <?php
        if (!empty($data['errorEncuesta'])) {
            echo "<p class='register-error'>" . $data['errorEncuesta'] . "</p>";
        }
        ?>
        <form class="add-mascota-form" method="POST">
            <label>Animal adoptado: <?php echo $data['mascota_nombre']; ?></label>

            <label for="estado_salud_id">Estado de salud del animal:</label>
            <select class="add-mascota-input" name="estado_salud_id" id="estado_salud_id">
                <option value="">Seleccione...</option>
                <?php
                foreach ($data['estados_salud'] as $estado) {
                    echo "<option value='" . $estado['id'] . "'>" . $estado['nombre'] . "</option>";
                }
                ?>
            </select>

            <label for="adaptacion_id">Nivel de adaptación:</label>
            <select class="add-mascota-input" name="adaptacion_id" id="adaptacion_id">
                <option value="">Seleccione...</option>
                <?php
                foreach ($data['adaptaciones'] as $adaptacion) {
                    echo "<option value='" . $adaptacion['id'] . "'>" . $adaptacion['nombre'] . "</option>";
                }
                ?>
            </select>

            <label for="comentarios">Comentarios:</label>
            <textarea class="add-mascota-input" name="comentarios" id="comentarios" rows="4"></textarea>

            <input class="add-mascota-btn" type="submit" value="Enviar Encuesta">
        </form>
        <div class="add-mascota-back-link">
            <a href="/adopciones/mostrar">Volver al inicio</a>
        </div>
    </div>
</body>
</html>