<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asignar Adopción</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <div class="add-mascota-container">
        <?php
        if (!empty($data['error'])) {
            echo "<p class='register-error'>{$data['error']}</p>";
        }
        if (!empty($data['success'])) {
            echo "<p class='register-success'>{$data['success']}</p>";
        }
        ?>
        <h2 class="add-mascota-title">Asignar Adopción</h2>
        <form class="add-mascota-form" method="POST" action="/adopciones/asignar">
            <label for="adoptante_email">Email del Adoptante:</label>
            <input class="add-mascota-input" type="email" id="adoptante_email" name="adoptante_email">

            <label for="mascota_nombre">Nombre de la Mascota:</label>
            <input class="add-mascota-input" type="text" id="mascota_nombre" name="mascota_nombre">

            <input class="add-mascota-btn" type="submit" value="Asignar Adopción">
        </form>
        <div class="add-mascota-back-link">
            <a href="/">Volver al inicio</a>
        </div>
    </div>
</body>
</html>