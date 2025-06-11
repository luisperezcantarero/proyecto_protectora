<?php
require_once "loged.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Principal</title>
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
    include_once 'search_view.php';
    ?>
    <p>Añadir mascota <a href="/mascotas/add">Agregar</a></p>
    <h2><?php echo $data['mensaje']; ?></h2>
    <?php
    foreach ($data['mascotas'] as $id => $mascota) {
        echo "<div>";
        echo "<h3>" . htmlspecialchars($mascota['nombre']) . "</h3>";
        echo "<p>Tipo animal: " . htmlspecialchars($mascota['tipoAnimal']) . "</p>";
        echo "<p>Raza: " . htmlspecialchars($mascota['raza']) . "</p>";
        echo "<p>Edad: " . htmlspecialchars($mascota['edad']) . "</p>";
        echo '<a href="/mascotas/edit/?id=' . $mascota['id'] . '">Editar</a>';
        echo ' <a href="/mascotas/delete/?id=' . $mascota['id'] . '">Borrar</a>';
        echo "</div>";
    }
    ?>
</body>
</html>