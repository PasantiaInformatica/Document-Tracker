<?php
    session_start(); // Inicia la sesión (necesario para destruirla)
    session_destroy(); // Elimina todos los datos de la sesión actual
    header('Location: ../../index.php'); // Redirecciona al usuario a la página principal
?>
