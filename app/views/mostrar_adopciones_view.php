<?php
require_once "../app/Config/conf.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mostrar adopciones</title>
</head>
<body>
    <h2>Adopciones:</h2>
    <?php
    foreach ($data['adopciones'] as $adopcion) {
        echo "<div>";
        echo "<h3>Adopción ID: " . htmlspecialchars($adopcion['id']) . "</h3>";
        echo "<p>Fecha de adopción: " . htmlspecialchars($adopcion['fecha_adopcion']) . "</p>";
        echo "<p>Estado: " . htmlspecialchars($adopcion['estado_id']) . "</p>";
        echo "<p>Adoptante ID: " . htmlspecialchars($adopcion['adoptante_id']) . "</p>";
        echo "<p>Trabajador ID: " . htmlspecialchars($adopcion['trabajador_id']) . "</p>";
        if ($profile === "adoptante") {
            echo '<a href="/adopciones/cancelar/?id=' . $adopcion['id'] . '">Cancelar adopción</a>';
        }
        echo "</div>";
    }
    ?>
</body>
</html>