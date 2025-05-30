<?php
    require '../../model/model_tramite.php';
    $MU = new Modelo_Tramite();//Instanciamos el modelo tramite
    $consulta = $MU->Listar_Tramite(); // Llama al método Listar_Tramite() para obtener los datos

    // Verifica si la consulta devolvió resultados
    if($consulta){
        // Si hay datos, los convierte a JSON y los envía como respuesta
        echo json_encode($consulta);
    }else{
        // Si no hay datos, devuelve un JSON vacío compatible con DataTables
        echo '{
            "sEcho": 1,
            "iTotalRecords": "0",
            "iTotalDisplayRecords": "0",
            "aaData": []
        }';
    }
?>
