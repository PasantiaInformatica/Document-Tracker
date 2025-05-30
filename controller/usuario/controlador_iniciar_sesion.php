<?php
    require '../../model/model_usuario.php';
    $MU = new Modelo_Usuario(); //Instanciar el modelo usuario

    // Sanitiza el usuario y contraseña recibidos por POST
    $usu = htmlspecialchars($_POST['u'],ENT_QUOTES,'UTF-8');   
    $con = htmlspecialchars($_POST['c'],ENT_QUOTES,'UTF-8');  
    
    // Consulta la base de datos para verificar credenciales
    $consulta = $MU->Verificar_Usuario($usu,$con);
    // Si hay resultados (count > 0), devuelve los datos en JSON
    if(count($consulta)>0){
        echo json_encode($consulta);
    }else{
        // Si no hay coincidencias, devuelve 0 (fallo de autenticación)
        echo 0;
    }

?>
