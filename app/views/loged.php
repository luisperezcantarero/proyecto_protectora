<?php
$isLogged = false;
$profile = "";

if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['email'])) {
    $isLogged = true;
    if ($_SESSION['user_profile'] == 'admin') {
        $profile = 'admin';
    } else {
        $profile = 'user';
    }
}
?>