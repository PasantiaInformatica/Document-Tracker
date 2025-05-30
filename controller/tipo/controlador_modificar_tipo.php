<?php
    require '../../model/model_tipo.php';
    $MU = new Modelo_Tipo(); //Instaciamos modelo tipo

    // Obtiene y sanitiza los datos enviados por POST para evitar inyección de código
    $id = htmlspecialchars($_POST['id'],ENT_QUOTES,'UTF-8');   
    $tipo = htmlspecialchars($_POST['tipo'],ENT_QUOTES,'UTF-8');   
    $esta = htmlspecialchars($_POST['esta'],ENT_QUOTES,'UTF-8');   

    // Llama al método Modificar_Tipo() con los datos sanitizados y guarda el resultado
    $consulta = $MU->Modificar_Tipo($id,$tipo,$esta);
    echo $consulta; // Imprime el resultado de la operación (éxito o error)

?>
