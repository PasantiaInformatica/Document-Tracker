<?php
    // Inicia o reanuda la sesión
    session_start();

    // Sanitiza y guarda el ID de usuario desde POST
    $idusuario = htmlspecialchars($_POST['idusuario'],ENT_QUOTES,'UTF-8');   
    $usuario = htmlspecialchars($_POST['usuario'],ENT_QUOTES,'UTF-8');  
    $rol = htmlspecialchars($_POST['rol'],ENT_QUOTES,'UTF-8'); 

    // Almacena los datos en variables de sesión
    $_SESSION['S_ID']=$idusuario;
    $_SESSION['S_USU']=$usuario;
    $_SESSION['S_ROL']=$rol;
?>
