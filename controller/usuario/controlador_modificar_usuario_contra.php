<?php
    require '../../model/model_usuario.php';
    $MU = new Modelo_Usuario(); //Instanciar el modelo usuario
    // Sanitiza el ID del usuario recibido por POST
    $id = htmlspecialchars($_POST['id'],ENT_QUOTES,'UTF-8'); 
    // Hashea la contraseña con BCRYPT (coste 12) tras sanitizarla
    $con = password_hash( htmlspecialchars($_POST['con'],ENT_QUOTES,'UTF-8'),PASSWORD_DEFAULT,['cost'=>12]); 
    $consulta = $MU->Modificar_Usuario_Contra($id,$con); // Llama al método para actualizar la contraseña y devuelve la respuesta
    echo $consulta;

?>