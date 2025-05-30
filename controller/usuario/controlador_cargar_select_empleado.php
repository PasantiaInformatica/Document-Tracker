<?php
    require '../../model/model_usuario.php';
    $MU = new Modelo_Usuario(); //Instanciar modelo usuario
    $consulta = $MU->Cargar_Select_Empleado(); //Consultar los empleados disponibles
    echo json_encode($consulta); // Devuelve los datos en formato JSON
?>