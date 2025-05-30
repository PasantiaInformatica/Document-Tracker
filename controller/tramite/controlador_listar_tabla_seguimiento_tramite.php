<?php
    require '../../model/model_tramite.php';
    $MU = new Modelo_Tramite(); //Instanciamos el modelo tramite

    // Obtiene y sanitiza el ID recibido por POST
    $id = (htmlspecialchars($_POST['id'],ENT_QUOTES,'UTF-8'));
    // Llama al método Listar_Tramite_Seguimiento() pasando el ID sanitizado
    $consulta = $MU->Listar_Tramite_Seguimiento($id);

    // Verifica si la consulta retornó datos
    if($consulta){
        echo json_encode($consulta);
    }else{
        // Si no hay datos, retorna un objeto JSON vacío con estructura para DataTables
        echo '{
            "sEcho": 1,
            "iTotalRecords": "0",
            "iTotalDisplayRecords": "0",
            "aaData": []
        }';
    }
?>
