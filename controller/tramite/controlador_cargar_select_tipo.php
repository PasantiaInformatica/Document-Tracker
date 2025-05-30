<?php
    require '../../model/model_tramite.php';
    $MU = new Modelo_Tramite(); //Instanciamos el modelo tramite
    $consulta = $MU->Cargar_Select_Tipo();
    echo json_encode($consulta); // Convierte el resultado de la consulta a formato JSON y lo imprime
?>