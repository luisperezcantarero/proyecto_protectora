<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar mascota</title>
</head>
<body>
    <h2>Editar mascota</h2>
    <form action="" method="post">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($data['mascota']['id']); ?>"/>
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($data['mascota']['nombre']); ?>"><br><br>
        <label for="especie">Especie:</label>
        <input type="text" id="especie" name="especie" value="<?php echo htmlspecialchars($data['mascota']['especie']); ?>"><br><br>
        <label for="raza">Raza:</label>
        <input type="text" id="raza" name="raza" value="<?php echo htmlspecialchars($data['mascota']['raza']); ?>"><br><br>
        <label for="edad">Edad:</label>
        <input type="number" id="edad" name="edad" value="<?php echo htmlspecialchars($data['mascota']['edad']); ?>" min="0"><br><br>
        <label for="estado">Estado:</label>
        <input type="text" id="estado" name="estado_id" value="<?php echo htmlspecialchars($data['mascota']['estado_id']); ?>"><br><br>
        <label for="historial_medico">Historial médico:</label>
        <textarea id="historial_medico" name="historial_medico"><?php echo htmlspecialchars($data['mascota']['historial_medico']); ?></textarea><br><br>
        <label for="foto">Foto:</label>
        <input type="text" id="foto" name="foto" value="<?php echo htmlspecialchars($data['mascota']['foto']); ?>"><br><br>
        <input type="submit" value="Guardar cambios">
    </form>
</body>
</html>