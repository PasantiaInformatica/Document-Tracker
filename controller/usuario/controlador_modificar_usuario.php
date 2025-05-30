<?php
    require '../../model/model_usuario.php';
    $MU = new Modelo_Usuario(); //Instanciar el modelo usuario
    // Sanitiza todos los campos recibidos por POST
    $id = htmlspecialchars($_POST['id'],ENT_QUOTES,'UTF-8'); 
    $ide = htmlspecialchars($_POST['ide'],ENT_QUOTES,'UTF-8'); 
    $ida = htmlspecialchars($_POST['ida'],ENT_QUOTES,'UTF-8'); 
    $rol = htmlspecialchars($_POST['rol'],ENT_QUOTES,'UTF-8'); 
    // Llama al método de actualización y devuelve la respuesta  
    $consulta = $MU->Modificar_Usuario($id,$ide,$ida,$rol);
    echo $consulta;

?>