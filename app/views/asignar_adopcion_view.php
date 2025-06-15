<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asignar Adopción</title>
</head>
<body>
    <?php
    if (!empty($data['error'])) {
        echo "<p style='color: red;'>{$data['error']}</p>";
    }
    if (!empty($data['success'])) {
        echo "<p style='color: green;'>{$data['success']}</p>";
    }
    ?>
    <h2>Asignar Adopción</h2>
    <form method="POST" action="/adopciones/asignar">
        <label for="adoptante_email">Email del Adoptante:</label>
        <input type="email" id="adoptante_email" name="adoptante_email">
        <br>
        <label for="mascota_nombre">Nombre de la Mascota:</label>
        <input type="text" id="mascota_nombre" name="mascota_nombre">
        <br>
        <button type="submit">Asignar Adopción</button>
    </form>
</body>
</html>