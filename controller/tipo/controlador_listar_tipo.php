<?php
    require '../../model/model_tipo.php';
    $MU = new Modelo_Tipo(); //Instaciamos modelo tipo

    // Llama al método Listar_Tipo() para obtener los datos de los tipos
    $consulta = $MU->Listar_Tipo();
    // Verifica si la consulta retornó datos
    if($consulta){
        // Si hay datos, los convierte a formato JSON y los imprime
        echo json_encode($consulta);
    }else{
        // Si no hay datos, imprime un JSON vacío con estructura para DataTables
        echo '{
            "sEcho": 1,
            "iTotalRecords": "0",
            "iTotalDisplayRecords": "0",
            "aaData": []
        }';
    }
?>