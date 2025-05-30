<?php
    require '../../model/model_usuario.php';
    $MU = new Modelo_Usuario(); //Instanciar modelo usuario
    $consulta = $MU->Cargar_Select_Area(); // Consulta las áreas disponibles
    echo json_encode($consulta); // Devuelve los datos en formato JSON
?>