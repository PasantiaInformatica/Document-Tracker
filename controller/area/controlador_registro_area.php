<?php
    require '../../model/model_area.php';
    $MU = new Modelo_Area(); // Instancia del modelo

    // Sanitiza y registra nueva área
    $area = htmlspecialchars($_POST['a'],ENT_QUOTES,'UTF-8');   
    $consulta = $MU->Registrar_Area($area);
    echo $consulta; // Retorna 1 (éxito) o 0 (error)

?>