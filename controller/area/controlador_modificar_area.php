<?php
    require '../../model/model_area.php';
    $MU = new Modelo_Area(); // Instancia del modelo

    // Sanitización de inputs
    $id = htmlspecialchars($_POST['id'],ENT_QUOTES,'UTF-8');   
    $are = htmlspecialchars($_POST['are'],ENT_QUOTES,'UTF-8');   
    $esta = htmlspecialchars($_POST['esta'],ENT_QUOTES,'UTF-8');   
    $consulta = $MU->Modificar_Area($id,$are,$esta);
    echo $consulta; // Retorna resultado crudo (1/0)

?>