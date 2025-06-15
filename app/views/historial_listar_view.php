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
        echo "<h3>Mascota ID: " . htmlspecialchars($adopcion['mascota_id']) . "</h3>";
        echo "<p>Trabajador ID: " . htmlspecialchars($adopcion['trabajador_id']) . "</p>";
        echo "<p>Fecha de adopción: " . htmlspecialchars($adopcion['fecha_adopcion']) . "</p>";
        echo "<p>Estado ID: " . htmlspecialchars($adopcion['estado_id']) . "</p>";
        echo "<p>Fecha de cancelación: " . htmlspecialchars($adopcion['fecha_cancelacion']) . "</p>";
        echo "<p>Cancelada por ID: " . htmlspecialchars($adopcion['cancelada_por_id']) . "</p>";
        echo "<p>Motivo de cancelación: " . htmlspecialchars($adopcion['motivo_cancelacion']) . "</p>";
        echo "</div>";
        echo "<div>";
        echo "<h3>Observaciones adjuntadas</h3>";
        $observacion = $data['observaciones'][$adopcion['id']];
        if ($observacion) {
            echo "<p><strong>Resultado:</strong> " . htmlspecialchars($observacion['resultado']) . "</p>";
            echo "<p><strong>Observaciones:</strong> " . htmlspecialchars($observacion['observaciones']) . "</p>";
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