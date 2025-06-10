<?php
require_once "loged.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
</head>
<body>
    <?php
    if ($profile === "") {
        echo "<p>Bienvenido, visitante. Por favor, <a href='/usuarios/login'>inicia sesión</a> o <a href='/usuarios/register'>regístrate</a>.</p>";
    } else if ($profile === "user") {
        echo "<p>Bienvenido " . $_SESSION['user'] . " </p>";
    } else {
        echo "<p>Bienvenido administrador " . $_SESSION['user'] . " </p>";
    }
    if ($isLogged) {
        echo "<p><a href='/usuarios/logout'>Cerrar sesión</a></p>";
    }
    ?>
    <h1>Hola mundo</h1>
</body>
</html>