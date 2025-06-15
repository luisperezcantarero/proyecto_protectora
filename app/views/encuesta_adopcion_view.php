<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encuesta</title>
</head>
<body>
    <h2>Encuesta de Adopción</h2>
    <?php
    if (!empty($data['errorEncuesta'])) {
        echo "<p style='color: red;'>" . $data['errorEncuesta'] . "</p>";
    }
    ?>
    <form method="POST">
        <label>Animal adoptado: <?php $data['adopcion']['mascota_id'] ?></label>
        <label>Estado de salud del animal:</label>
        <select name="estado_salud_id">
            <option value="">Seleccione...</option>
            <?php
            foreach ($data['estados_salud'] as $estado) {
                echo "<option value='" . $estado['id'] . "'>" . $estado['nombre'] . "</option>";
            }
            ?>
        </select><br/><br/>
        <label>Nivel de adaptación:</label>
        <select name="adaptacion_id">
            <option value="">Seleccione...</option>
            <?php
            foreach ($data['adaptaciones'] as $adaptacion) {
                echo "<option value='" . $adaptacion['id'] . "'>" . $adaptacion['nombre'] . "</option>";
            }
            ?>
        </select><br/><br/>
        <label>Comentarios:</label><br/>
        <textarea name="comentarios" rows="4" cols="50"></textarea><br/><br/>
        <input type="submit" value="Enviar Encuesta">
    </form>
</body>
</html>