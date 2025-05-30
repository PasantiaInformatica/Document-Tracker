<?php
    require '../../model/model_tramite_area.php';
    $MU = new Modelo_TramiteArea(); //Instaciamos el modelo tramite
    $idusuario = (htmlspecialchars($_POST['idusuario'],ENT_QUOTES,'UTF-8'));
    // Consulta los trámites asociados al ID de usuario
    $consulta = $MU->Listar_Tramite($idusuario);

    // Si hay resultados, los devuelve en JSON
    if($consulta){
        echo json_encode($consulta);
    }else{
        // Si no hay datos, retorna un JSON vacío para DataTables
        echo '{
            "sEcho": 1,
            "iTotalRecords": "0",
            "iTotalDisplayRecords": "0",
            "aaData": []
        }';
    }
?>
