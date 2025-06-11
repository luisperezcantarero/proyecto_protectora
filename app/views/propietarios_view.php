<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Propietarios</title>
</head>
<body>
    <?php
    if (!empty($_SESSION['mensaje'])) {
        echo "<p>" . $_SESSION['mensaje'] . "</p>";
        unset($_SESSION['mensaje']);
    }
    ?>
    <h2>¿Te interesa ser propietario?</h2>
    <p>Si quieres ser propietario de una mascota, por favor, acepta los terminos y condiciones:</p>
    <form action="/propietarios/add" method="POST">
        <label>
            <input type="checkbox" name="terminos" required>
            Acepto los términos y condiciones
        </label>
        <br>
        <button type="submit">Aceptar</button>
    </form>
    <!-- <p>Si ya eres propietario, puedes ver tus mascotas en el siguiente enlace:</p>
    <a href="/mascotas">Ver mis mascotas</a> -->
</body>
</html>