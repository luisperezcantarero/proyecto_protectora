<?php
require_once "../app/Config/conf.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Principal</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <?php
    if ($profile === "") {
        echo "<p>Bienvenido, visitante. Por favor, <a href='/usuarios/login'>inicia sesión</a> o <a href='/usuarios/register'>regístrate</a>.</p>";
    } else if ($profile === "adoptante") {
        echo "<p>Bienvenido Adoptante " . $_SESSION['nombre'] . " </p>";
        echo '<p><a href="/adopciones/mostrar">Mostrar adopciones</a></p>';
    } else if ($profile === "administrador"){
        echo "<p>Bienvenido administrador " . $_SESSION['nombre'] . " </p>";
        echo '<p><a href="/admin/bloqueados">Ver usuarios bloqueados</a></p>';
        echo '<p>Añadir mascota <a href="/mascotas/add">Agregar</a></p>';
        echo '<p><a href="/seguimientos/listar">Ver seguimientos</a></p>';
    } else if ($profile === "trabajador") {
        echo "<p>Bienvenido Trabajador " . $_SESSION['nombre'] . " </p>";
        echo '<p><a href="/adopciones/asignar">Asignar adoptante a mascota</a></p>';
        echo '<p><a href="/seguimientos/listar">Ver seguimientos</a></p>';
    }
    if ($isLogged) {
        echo "<p><a href='/usuarios/logout'>Cerrar sesión</a></p>";
    }
    echo "Perfil actual: " . $_SESSION['rol'];
    ?>
    <h2><?php echo $data['mensaje']; ?></h2>
    <?php
    include_once 'search_view.php';
    foreach ($data['mascotas'] as $id => $mascota) {
        echo "<div>";
        echo "<h3>" . $mascota['nombre'] . "</h3>";
        echo "<p>Especie: " . $mascota['especie'] . "</p>";
        echo "<p>Raza: " . $mascota['raza'] . "</p>";
        echo "<p>Edad: " . $mascota['edad'] . "</p>";
        echo "<p>Historial médico: " . $mascota['historial_medico'] . "</p>";
        echo "<img src='/imagenes/" . $mascota['foto'] . "' alt='mascota' >";
        if ($profile === "administrador") {
            echo '<a href="/mascotas/edit/?id=' . $mascota['id'] . '">Editar</a>';
            echo ' <a href="/mascotas/delete/?id=' . $mascota['id'] . '">Borrar</a>';
        }
        echo "</div>";
    }
    ?>
</body>
</html>