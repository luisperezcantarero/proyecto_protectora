<?php
require_once "../app/Config/conf.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Principal</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <?php
    include 'include/header.php';
    ?>
    <main class="main-content">
        <h2 class="titulo-listado"><?php echo $data['mensaje']; ?></h2>
        <?php include_once 'search_view.php'; ?>
        <div class="mascotas-grid">
        <?php
        foreach ($data['mascotas'] as $id => $mascota) {
            echo "<div class='mascota-card'>";
            echo "<img class='mascota-foto' src='/imagenes/" . $mascota['foto'] . "' alt='mascota'>";
            echo "<div class='mascota-info'>";
            echo "<h3 class='mascota-nombre'>" . $mascota['nombre'] . "</h3>";
            echo "<p><strong>Especie:</strong> " . $mascota['especie'] . "</p>";
            echo "<p><strong>Raza:</strong> " . $mascota['raza'] . "</p>";
            echo "<p><strong>Edad:</strong> " . $mascota['edad'] . "</p>";
            echo "<p><strong>Historial médico:</strong> " . $mascota['historial_medico'] . "</p>";
            if ($profile === "administrador") {
            echo '<div class="mascota-acciones">';
            echo '<a class="btn-editar" href="/mascotas/edit/?id=' . $mascota['id'] . '">Editar</a>';
            echo ' <a class="btn-borrar" href="/mascotas/delete/?id=' . $mascota['id'] . '">Borrar</a>';
            echo '</div>';
            }
            echo "</div></div>";
        }
        ?>
        </div>
    </main>
</body>
</html>