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
    <h2>Adopciones en Curso:</h2>
    <?php
    foreach ($data['adopciones'] as $adopcion) {
        echo "<div>";
        echo "<h3>Adopción de " . $data['mascotas'][$adopcion['mascota_id']] . "</h3>";
        echo "<p>Fecha de adopción: " . $adopcion['fecha_adopcion'] . "</p>";
        echo "<p>Estado: " . $data['estados'][$adopcion['estado_id']] . "</p>";
        echo "<p>Adoptante: " . $data['adoptantes'][$adopcion['adoptante_id']] . "</p>";
        echo "<p>Trabajador: " . $data['trabajadores'][$adopcion['trabajador_id']] . "</p>";
        if ($profile === "adoptante") {
            echo '<a href="/adopciones/cancelar/?id=' . $adopcion['id'] . '">Cancelar adopción</a>';
        }
        echo "</div>";
    }
    ?>
    <h2>Adopciones Finalizadas:</h2>
    <?php
    foreach ($data['adopciones_finalizadas'] as $adopcion) {
        echo "<div>";
        echo "<h3>Adopción de " . $data['mascotas'][$adopcion['mascota_id']] . "</h3>";
        echo "<p>Fecha de adopción: " . $adopcion['fecha_adopcion'] . "</p>";
        echo "<p>Estado: " . $data['estados'][$adopcion['estado_id']] . "</p>";
        echo "<p>Adoptante: " . $data['adoptantes'][$adopcion['adoptante_id']] . "</p>";
        echo "<p>Trabajador: " . $data['trabajadores'][$adopcion['trabajador_id']] . "</p>";
        if ($adopcion['tiene_encuesta']) {
            echo "<p>Encuesta ya realizada</p>";
        } else {
            echo '<a href="/encuestas/encuesta/?id=' . $adopcion['id'] . '">Completar encuesta</a>';
        }
        echo "</div>";
    }
    ?>
    <h2>Adopciones Canceladas:</h2>
    <?php
    foreach ($data['adopciones_canceladas'] as $adopcion) {
        echo "<div>";
        echo "<h3>Adopción de " . $data['mascotas'][$adopcion['mascota_id']] . "</h3>";
        echo "<p>Fecha de adopción: " . $adopcion['fecha_adopcion'] . "</p>";
        echo "<p>Estado: " . $data['estados'][$adopcion['estado_id']] . "</p>";
        echo "<p>Adoptante: " . $data['adoptantes'][$adopcion['adoptante_id']] . "</p>";
        echo "<p>Trabajador: " . $data['trabajadores'][$adopcion['trabajador_id']] . "</p>";
        echo "<p>Motivo de cancelación: " . $adopcion['motivo_cancelacion'] . "</p>";
        echo "</div>";
    }
    ?>
</body>
</html>