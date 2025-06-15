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
    <title>Register</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <div class="register-container">
        <?php
        // Mostrar mensaje de error si existe
        if (!empty($data['error'])) {
            echo "<p class='register-error'>{$data['error']}</p>";
        }
        ?>
        <h2 class="register-title">Crea tu cuenta:</h2>
        <form class="register-form" method="post">
            <label for="nombre">Nombre de usuario:</label>
            <input class="register-input" type="text" id="nombre" name="nombre" value="<?php echo $data['nombre']; ?>">
            <span class="register-error-msg"><?php echo $data['nombreError']; ?></span>

            <label for="email">Email:</label>
            <input class="register-input" type="email" id="email" name="email" value="<?php echo $data['email']; ?>">
            <span class="register-error-msg"><?php echo $data['emailError']; ?></span>

            <label for="password">Contraseña:</label>
            <input class="register-input" type="password" id="password" name="password">
            <span class="register-error-msg"><?php echo $data['passwordError']; ?></span>

            <label for="password2">Confirmar contraseña:</label>
            <input class="register-input" type="password" id="password2" name="password2">
            <span class="register-error-msg"><?php echo $data['password2Error']; ?></span>

            <button class="register-btn" type="submit">Registrar</button>
        </form>
        <div class="register-back-link">
            <a href="/">Volver a inicio</a>
        </div>
    </div>
</body>
</html>