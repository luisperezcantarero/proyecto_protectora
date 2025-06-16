<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de adopciones</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <div class="add-mascota-back-link">
        <a href="/">Volver al inicio</a>
    </div>
    <div class="historial-container">
        <h2 class="historial-title">Historial de adopciones</h2>
        <div class="historial-grid">
        <?php
        foreach ($data['adopciones'] as $adopcion) {
            echo "<div class='historial-card'>";
            echo "<div class='historial-info'>";
            echo "<h3 class='historial-mascota'>Mascota: " . $data['mascotas'][$adopcion['mascota_id']] . "</h3>";
            echo "<p><strong>Trabajador:</strong> " . $data['trabajadores'][$adopcion['trabajador_id']] . "</p>";
            echo "<p><strong>Adoptante:</strong> " . $data['adoptantes'][$adopcion['adoptante_id']] . "</p>";
            echo "<p><strong>Fecha de adopción:</strong> " . $adopcion['fecha_adopcion'] . "</p>";
            echo "<p><strong>Estado:</strong> " . $data['estados'][$adopcion['estado_id']] . "</p>";
            if (!empty($adopcion['mostrar_cancelacion'])) {
                echo "<p><strong>Fecha de cancelación:</strong> " . $adopcion['fecha_cancelacion'] . "</p>";
                echo "<p><strong>Cancelada por:</strong> " . $data['canceladores'][$adopcion['cancelada_por_id']] . "</p>";
                echo "<p><strong>Motivo de cancelación:</strong> " . $adopcion['motivo_cancelacion'] . "</p>";
            }
            echo "</div>";
            echo "<div class='historial-observaciones'>";
            echo "<h4>Observaciones adjuntadas</h4>";
            $observacion = $data['observaciones'][$adopcion['id']];
            if ($observacion) {
                echo "<p><strong>Resultado:</strong> " . $observacion['resultado'] . "</p>";
                echo "<p><strong>Observaciones:</strong> " . $observacion['observaciones'] . "</p>";
            } else if (in_array($_SESSION['rol'], ['trabajador', 'administrador'])) {
                if ($adopcion['estado_id'] == 1) {
                    echo "<p>No se puede añadir observaciones aún, adopción en curso.</p>";
                } else {
                    echo '<a class="historial-add-link" href="/seguimientos/add/?adopcion_id=' . $adopcion['id'] . '">Añadir observación</a>';
                }
            }
            echo "</div>";
            echo "</div>";
        }
        ?>
        </div>
    </div>
</body>
</html>