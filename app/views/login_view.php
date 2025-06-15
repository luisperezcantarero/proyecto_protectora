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
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <div class="login-container">
        <?php
        if (!empty($data['error'])) {
            echo "<p class='login-error'>{$data['error']}</p>";
        }
        ?>
        <h2 class="login-title">Iniciar sesión</h2>
        <form class="login-form" action="" method="post">
            <label for="email">Email:</label>
            <input class="login-input" type="email" id="email" name="email">
            <span class="login-error-msg"><?php echo $data['emailError']; ?></span>

            <label for="password">Contraseña</label>
            <input class="login-input" type="password" id="password" name="password">
            <span class="login-error-msg"><?php echo $data['passwordError']; ?></span>

            <label for="captcha">Indique el mayor de estos números:</label>
            <div class="login-captcha-numbers"><?php echo implode(" ", $nums); ?></div>
            <input class="login-input" type="number" id="captcha" name="captcha">

            <button class="login-btn" type="submit">Iniciar sesión</button>
        </form>
        <div class="login-back-link">
            <a href="/">Volver a inicio</a>
        </div>
    </div>
</body>
</html>