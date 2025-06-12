<?php
$isLogged = false;
$profile = "";

if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['email'])) {
    $isLogged = true;
    if ($_SESSION['rol'] == 'administrador') {
        $profile = 'administrador';
    } else if ($_SESSION['rol'] == 'adoptante') {
        $profile = 'adoptante';
    } else if ($_SESSION['rol'] == 'trabajador') {
        $profile = 'trabajador';
    }
}
?>