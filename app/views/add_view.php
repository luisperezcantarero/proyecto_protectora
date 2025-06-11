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

        <label for="tipoAnimal">Tipo de Animal:</label>
        <input type="text" id="tipoAnimal" name="tipoAnimal"><br><br>

        <label for="raza">Raza:</label>
        <input type="text" id="raza" name="raza"><br><br>

        <label for="edad">Edad:</label>
        <input type="number" id="edad" name="edad" min="0"><br><br>

        <input type="submit" value="Añadir">
    </form>
</body>
</html>