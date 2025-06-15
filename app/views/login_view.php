<?php
require_once "../app/Config/conf.php";
if ($isLogged) {
    header("Location: /");
    exit;
}
$nums = $_SESSION['captcha_nums'];
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
        <span style="color: red;"><?php echo $data['emailError']; ?></span><br>
        <label for="password">Contraseña</label>
        <input type="password" id="password" name="password"><br>
        <span style="color: red;"><?php echo $data['passwordError']; ?></span><br>
        <label for="captcha">Indique el mayor de estos números:</label>
        <?php
        echo implode(" ", $nums);
        ?>
        <input type="number" id="captcha" name="captcha"><br>
        <button type="submit">Iniciar sesión</button>
    </form>
    <p style="color: orange;">Intentos fallidos: <?php echo $data['intentos']; ?> / 3</p>
</body>
</html>