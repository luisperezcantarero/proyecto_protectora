<?php
require_once "../app/Config/conf.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mostrar adopciones</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <?php
    include 'include/header.php';
    ?>
    <div class="main-content">
        <div class="add-mascota-back-link">
            <a href="/">Volver al inicio</a>
        </div>
        <h2 class="titulo-listado">Adopciones en Curso:</h2>
        <div class="mascotas-grid">
        <?php
        if (empty($data['adopciones'])) {
            echo "<p>No hay adopciones en curso.</p>";
        }
        foreach ($data['adopciones'] as $adopcion) {
            echo "<div class='mascota-card'>";
            echo "<div class='mascota-info'>";
            echo "<h3 class='mascota-nombre'>Adopción de " . $data['mascotas'][$adopcion['mascota_id']] . "</h3>";
            echo "<p><strong>Fecha de adopción:</strong> " . $adopcion['fecha_adopcion'] . "</p>";
            echo "<p><strong>Estado:</strong> " . $data['estados'][$adopcion['estado_id']] . "</p>";
            echo "<p><strong>Adoptante:</strong> " . $data['adoptantes'][$adopcion['adoptante_id']] . "</p>";
            echo "<p><strong>Trabajador:</strong> " . $data['trabajadores'][$adopcion['trabajador_id']] . "</p>";
            if ($profile === "adoptante") {
                echo '<div class="mascota-acciones"><a class="btn-borrar" href="/adopciones/cancelar/?id=' . $adopcion['id'] . '">Cancelar adopción</a></div>';
            }
            echo "</div></div>";
        }
        ?>
        </div>

        <h2 class="titulo-listado">Adopciones Finalizadas:</h2>
        <div class="mascotas-grid">
        <?php
        if (empty($data['adopciones_finalizadas'])) {
            echo "<p>No hay adopciones finalizadas.</p>";
        }
        foreach ($data['adopciones_finalizadas'] as $adopcion) {
            echo "<div class='mascota-card'>";
            echo "<div class='mascota-info'>";
            echo "<h3 class='mascota-nombre'>Adopción de " . $data['mascotas'][$adopcion['mascota_id']] . "</h3>";
            echo "<p><strong>Fecha de adopción:</strong> " . $adopcion['fecha_adopcion'] . "</p>";
            echo "<p><strong>Estado:</strong> " . $data['estados'][$adopcion['estado_id']] . "</p>";
            echo "<p><strong>Adoptante:</strong> " . $data['adoptantes'][$adopcion['adoptante_id']] . "</p>";
            echo "<p><strong>Trabajador:</strong> " . $data['trabajadores'][$adopcion['trabajador_id']] . "</p>";
            if ($adopcion['tiene_encuesta']) {
                echo "<p>Encuesta ya realizada</p>";
            } else {
                echo '<div class="mascota-acciones"><a class="btn-editar" href="/encuestas/encuesta/?id=' . $adopcion['id'] . '">Completar encuesta</a></div>';
            }
            echo "</div></div>";
        }
        ?>
        </div>

        <h2 class="titulo-listado">Adopciones Canceladas:</h2>
        <div class="mascotas-grid">
        <?php
        if (empty($data['adopciones_canceladas'])) {
            echo "<p>No hay adopciones canceladas.</p>";
        }
        foreach ($data['adopciones_canceladas'] as $adopcion) {
            echo "<div class='mascota-card'>";
            echo "<div class='mascota-info'>";
            echo "<h3 class='mascota-nombre'>Adopción de " . $data['mascotas'][$adopcion['mascota_id']] . "</h3>";
            echo "<p><strong>Fecha de adopción:</strong> " . $adopcion['fecha_adopcion'] . "</p>";
            echo "<p><strong>Estado:</strong> " . $data['estados'][$adopcion['estado_id']] . "</p>";
            echo "<p><strong>Adoptante:</strong> " . $data['adoptantes'][$adopcion['adoptante_id']] . "</p>";
            echo "<p><strong>Trabajador:</strong> " . $data['trabajadores'][$adopcion['trabajador_id']] . "</p>";
            echo "<p><strong>Motivo de cancelación:</strong> " . $adopcion['motivo_cancelacion'] . "</p>";
            echo "</div></div>";
        }
        ?>
        </div>
    </div>
</body>
</html>