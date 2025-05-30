<?php
    require '../../model/model_usuario.php';
    $MU = new Modelo_Usuario(); //Instanciar el modelo usuario
    $consulta = $MU->Listar_Usuario(); // Consulta todos los usuarios

    // Si hay datos, los devuelve en JSON
    if($consulta){
        echo json_encode($consulta);
    }else{
        // Si no hay datos, devuelve un JSON vacío para DataTables
        echo '{
            "sEcho": 1,
            "iTotalRecords": "0",
            "iTotalDisplayRecords": "0",
            "aaData": []
        }';
    }
?>
