<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Mascota</title>
</head>
<body>
    <h2>Añadir mascota</h2>
    <form action="" method="post">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre"><br><br>

        <label for="especie">Especie:</label>
        <input type="text" id="especie" name="especie"><br><br>

        <label for="raza">Raza:</label>
        <input type="text" id="raza" name="raza"><br><br>

        <label for="edad">Edad:</label>
        <input type="number" id="edad" name="edad" min="0"><br><br>

        <label for="estado">Estado:</label>
        <input type="text" id="estado" name="estado_id"><br><br>

        <label for="historial_medico">Historial médico:</label>
        <textarea id="historial_medico" name="historial_medico"></textarea><br><br>

        <label for="foto">Foto:</label>
        <input type="text" id="foto" name="foto"><br><br>

        <input type="submit" value="Añadir">
    </form>
</body>
</html>