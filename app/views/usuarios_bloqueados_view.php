<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios bloqueados</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <div class="bloqueados-container">
        <h2 class="bloqueados-title">Usuarios bloqueados</h2>
        <form class="bloqueados-form" action="/admin/bloqueados" method="post">
            <button class="bloqueados-btn" type="submit" name="marcar_todos">Marcar todos</button>
            <button class="bloqueados-btn" type="submit" name="desmarcar_todos">Desmarcar todos</button>
        </form>
        <form class="bloqueados-form" action="/admin/desbloquear" method="post">
            <div class="bloqueados-list">
            <?php
            foreach ($data['bloqueados'] as $usuario) {
                echo '<div class="bloqueado-item">';
                echo '<input class="bloqueado-checkbox" type="checkbox" name="usuarios[]" value="' . $usuario['email'] . '" ' . $data['checked'] . '>';
                echo '<span class="bloqueado-nombre">' . $usuario['nombre'] . '</span> - <span class="bloqueado-email">' . $usuario['email'] . '</span>';
                echo '</div>';
            }
            ?>
            </div>
            <button class="bloqueados-btn desbloquear-btn" type="submit" name="desbloquear">Desbloquear</button>
        </form>
        <div class="bloqueados-back-link">
            <a href="/">Volver al inicio</a>
        </div>
    </div>
</body>
</html>