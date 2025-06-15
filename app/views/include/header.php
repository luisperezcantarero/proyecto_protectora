<header>
    <h1>PROTECTORA DE ANIMALES</h1>
    <nav>
        <ul class="nav-links">
            <?php
            if ($profile === "") {
                echo "<li>Bienvenido, visitante. Por favor, <a href='/usuarios/login'>inicia sesión</a> o <a href='/usuarios/register'>regístrate</a>.</li>";
            } else if ($profile === "adoptante") {
                echo "<li>Bienvenido Adoptante " . $_SESSION['nombre'] . "</li>";
                echo '<li><a href="/adopciones/mostrar">Mostrar adopciones</a></li>';
            } else if ($profile === "administrador"){
                echo "<li>Bienvenido administrador " . $_SESSION['nombre'] . "</li>";
                echo '<li><a href="/admin/bloqueados">Ver usuarios bloqueados</a></li>';
                echo '<li><a href="/mascotas/add">Agregar mascota</a></li>';
                echo '<li><a href="/seguimientos/listar">Ver historial</a></li>';
            } else if ($profile === "trabajador") {
                echo "<li>Bienvenido Trabajador " . $_SESSION['nombre'] . "</li>";
                echo '<li><a href="/adopciones/asignar">Asignar adoptante a mascota</a></li>';
                echo '<li><a href="/seguimientos/listar">Ver seguimientos</a></li>';
            }
            if ($isLogged) {
                echo "<li><a href='/usuarios/logout'>Cerrar sesión</a></li>";
            }
            ?>
        </ul>
    </nav>
</header>