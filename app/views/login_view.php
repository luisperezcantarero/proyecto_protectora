<?php
require_once "../app/Config/conf.php";
if ($isLogged) {
    header("Location: /");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <?php
    if (!empty($data['error'])) {
        echo "<p style='color: red;'>{$data['error']}</p>";
    }
    ?>
    <h2>Inciar sesión</h2>
    <form action="" method="post">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email"><br>
        <label for="password">Contraseña</label>
        <input type="password" id="password" name="password"><br>
        <button type="submit">Iniciar sesión</button>
    </form>
</body>
</html>