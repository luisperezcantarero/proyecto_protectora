<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios bloqueados</title>
</head>
<body>
    <h2>Usuarios bloqueados</h2>
    <form action="/admin/bloqueados" method="post">
        <button type="submit" name="marcar_todos">Marcar todos</button>
        <button type="submit" name="desmarcar_todos">Desmarcar todos</button>
    </form>
    <form action="/admin/desbloquear" method="post">
        <?php
        foreach ($data['bloqueados'] as $usuario) {
            echo '<div>';
            echo '<input type="checkbox" name="usuarios[]" value="' . $usuario['email'] . '" ' . $data['checked'] . '>';
            echo $usuario['nombre'] . ' - ' . $usuario['email'];
            echo '</div>';
        }
        ?>
        <button type="submit" name="desbloquear">Desbloquear</button>
    </form>
    <p><a href="/">Volver al inicio</a></p>
</body>
</html>