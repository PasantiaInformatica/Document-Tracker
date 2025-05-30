<?php
    require '../../model/model_usuario.php';
    $MU = new Modelo_Usuario(); //Instanciar el modelo usuario
    // Sanitiza el ID y el nuevo estado (ej: 1=activo, 0=inactivo)
    $id = htmlspecialchars($_POST['id'],ENT_QUOTES,'UTF-8'); 
    $status = htmlspecialchars($_POST['status'],ENT_QUOTES,'UTF-8'); 
    // Actualiza el estado y devuelve la respuesta del modelo
    $consulta = $MU->Modificar_Usuario_Status($id,$status);
    echo $consulta;

?>