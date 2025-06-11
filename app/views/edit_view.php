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
        <label for="tipoAnimal">Tipo de Animal:</label>
        <input type="text" id="tipoAnimal" name="tipoAnimal" value="<?php echo htmlspecialchars($data['mascota']['tipoAnimal']); ?>"><br><br>
        <label for="raza">Raza:</label>
        <input type="text" id="raza" name="raza" value="<?php echo htmlspecialchars($data['mascota']['raza']); ?>"><br><br>
        <label for="edad">Edad:</label>
        <input type="number" id="edad" name="edad" value="<?php echo htmlspecialchars($data['mascota']['edad']); ?>" min="0"><br><br>
        <input type="submit" value="Guardar cambios">
    </form>
</body>
</html>