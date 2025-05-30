<?php
    require '../../model/model_usuario.php';
    $MU = new Modelo_Usuario(); //Instanciar el modelo usuario
    // Sanitiza y hashea la contraseña con BCRYPT (coste 12)
    $usu = htmlspecialchars($_POST['usu'],ENT_QUOTES,'UTF-8'); 
    $con = password_hash( htmlspecialchars($_POST['con'],ENT_QUOTES,'UTF-8'),PASSWORD_DEFAULT,['cost'=>12]);
    // Sanitiza los demás campos
    $ide = htmlspecialchars($_POST['ide'],ENT_QUOTES,'UTF-8'); 
    $ida = htmlspecialchars($_POST['ida'],ENT_QUOTES,'UTF-8'); 
    $rol = htmlspecialchars($_POST['rol'],ENT_QUOTES,'UTF-8');   
    // Registra al usuario y devuelve la respuesta (ej: 1=éxito, 0=fallo)
    $consulta = $MU->Registrar_Usuario($usu,$con,$ide,$ida,$rol);
    echo $consulta;

?>