<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de adopciones</title>
</head>
<body>
    <h2>Historial de adopciones</h2>
    <?php
    foreach ($data['adopciones'] as $adopcion) {
        echo "<div>";
        echo "<h3>Mascota: " . $data['mascotas'][$adopcion['mascota_id']] . "</h3>";
        echo "<p>Trabajador: " . $data['trabajadores'][$adopcion['trabajador_id']] . "</p>";
        echo "<p>Adoptante: " . $data['adoptantes'][$adopcion['adoptante_id']] . "</p>";
        echo "<p>Fecha de adopción: " . $adopcion['fecha_adopcion'] . "</p>";
        echo "<p>Estado: " . $data['estados'][$adopcion['estado_id']] . "</p>";
        if (!empty($adopcion['mostrar_cancelacion'])) {
            echo "<p>Fecha de cancelación: " . $adopcion['fecha_cancelacion'] . "</p>";
            echo "<p>Cancelada por: " . $data['canceladores'][$adopcion['cancelada_por_id']] . "</p>";
            echo "<p>Motivo de cancelación: " . $adopcion['motivo_cancelacion'] . "</p>";
        }
        echo "</div>";
        echo "<div>";
        echo "<h3>Observaciones adjuntadas</h3>";
        $observacion = $data['observaciones'][$adopcion['id']];
        if ($observacion) {
            echo "<p><strong>Resultado:</strong> " . $observacion['resultado'] . "</p>";
            echo "<p><strong>Observaciones:</strong> " . $observacion['observaciones'] . "</p>";
        } else if (in_array($_SESSION['rol'], ['trabajador', 'administrador'])) {
            echo '<a href="/seguimientos/add/?adopcion_id=' . $adopcion['id'] . '">Añadir observación</a>';
        } else {
            echo "<p>No hay observaciones.</p>";
        }
        echo "</div>";
    }
    ?>
</body>
</html>