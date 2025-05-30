<?php
    require '../../model/model_area.php';
    $MU = new Modelo_Area(); // Instancia del modelo
    $consulta = $MU->Listar_Area(); // Ejecuta consulta
    if($consulta){
        echo json_encode($consulta); // Datos encontrados
    }else{
        echo '{
            "sEcho": 1,
            "iTotalRecords": "0",
            "iTotalDisplayRecords": "0",
            "aaData": []
        }';
    }
?>
