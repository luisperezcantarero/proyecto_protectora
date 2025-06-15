<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar mascota</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <div class="edit-mascota-container">
        <h2 class="edit-mascota-title">Editar mascota</h2>
        <form class="edit-mascota-form" action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $data['mascota']['id']; ?>"/>
            <label for="nombre">Nombre:</label>
            <input class="edit-mascota-input" type="text" id="nombre" name="nombre" value="<?php echo $data['mascota']['nombre']; ?>">

            <label for="especie">Especie:</label>
            <input class="edit-mascota-input" type="text" id="especie" name="especie" value="<?php echo $data['mascota']['especie']; ?>">

            <label for="raza">Raza:</label>
            <input class="edit-mascota-input" type="text" id="raza" name="raza" value="<?php echo $data['mascota']['raza']; ?>">

            <label for="edad">Edad:</label>
            <input class="edit-mascota-input" type="number" id="edad" name="edad" value="<?php echo $data['mascota']['edad']; ?>" min="0">

            <label for="historial_medico">Historial médico:</label>
            <textarea class="edit-mascota-input" id="historial_medico" name="historial_medico"><?php echo $data['mascota']['historial_medico']; ?></textarea>

            <label>Foto actual:</label>
            <img class="edit-mascota-foto" src="/imagenes/<?php echo $data['mascota']['foto']; ?>" alt="Foto actual">

            <label for="foto_mascota">Nueva foto (opcional):</label>
            <input class="edit-mascota-input" type="file" id="foto_mascota" name="foto_mascota" accept="image/*">

            <input class="edit-mascota-btn" type="submit" value="Guardar cambios">
        </form>
        <div class="edit-mascota-back-link">
            <a href="/">Volver al inicio</a>
        </div>
    </div>
</body>
</html>