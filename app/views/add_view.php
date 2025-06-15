<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Mascota</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <div class="add-mascota-container">
        <h2 class="add-mascota-title">Añadir mascota</h2>
        <form class="add-mascota-form" action="" method="post" enctype="multipart/form-data">
            <label for="nombre">Nombre:</label>
            <input class="add-mascota-input" type="text" id="nombre" name="nombre">

            <label for="especie">Especie:</label>
            <input class="add-mascota-input" type="text" id="especie" name="especie">

            <label for="raza">Raza:</label>
            <input class="add-mascota-input" type="text" id="raza" name="raza">

            <label for="edad">Edad:</label>
            <input class="add-mascota-input" type="number" id="edad" name="edad" min="0">

            <label for="historial_medico">Historial médico:</label>
            <textarea class="add-mascota-input" id="historial_medico" name="historial_medico"></textarea>

            <label for="foto_mascota">Foto:</label>
            <input class="add-mascota-input" type="file" id="foto_mascota" name="foto_mascota" accept="image/*">

            <input class="add-mascota-btn" type="submit" value="Añadir">
        </form>
        <div class="add-mascota-back-link">
            <a href="/">Volver a inicio</a>
        </div>
    </div>
</body>
</html>