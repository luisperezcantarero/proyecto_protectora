<?php
require_once "loged.php";
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
</head>
<body>
    <?php
    // Mostrar mensaje de error si existe
    if (!empty($data['error'])) {
        echo "<p style='color: red;'>{$data['error']}</p>";
    }
    ?>
    <h2>Crea tu cuenta:</h2>
    <form method="post">
        <label for="user">Nombre de usuario:</label>
        <input type="text" id="user" name="user" value="<?php echo htmlspecialchars($data['user']); ?>">
        <span style="color: red;"><?php echo $data['userError'] ?? ''; ?></span>
        <br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($data['email']); ?>">
        <span style="color: red;"><?php echo $data['emailError'] ?? ''; ?></span>
        <br>
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password">
        <span style="color: red;"><?php echo $data['passwordError'] ?? ''; ?></span>
        <br>
        <label for="password2">Confirmar contraseña:</label>
        <input type="password" id="password2" name="password2">
        <span style="color: red;"><?php echo $data['password2Error'] ?? ''; ?></span>
        <br>

        <button type="submit">Registrar</button>
    </form>
</body>
</html>