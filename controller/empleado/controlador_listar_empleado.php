<?php
    require '../../model/model_empleado.php';
    $MU = new Modelo_Empleado(); // Instancia modelo de empleado
    $consulta = $MU->Listar_Empleado(); // Obtiene lista de empleados
    if($consulta){
        echo json_encode($consulta); // Retorna datos en JSON
    }else{
        // Retorna estructura vacía para DataTables
        echo '{
            "sEcho": 1,
            "iTotalRecords": "0",
            "iTotalDisplayRecords": "0",
            "aaData": []
        }';
    }
?>
