<?php
    // Inicia/reanuda la sesión (necesario para acceder a $_SESSION)
    session_start();
    // Incluye los modelos necesarios (con require_once para evitar duplicados)
    require_once '../../model/model_tramite_area.php';
    require_once '../../model/model_usuario.php';

    // Obtiene el ID y rol del usuario desde la sesión 
    $idusuario = $_SESSION['S_ID'];
    $rol = $_SESSION['S_ROL'];

    // Instancia los modelos
    $MU = new Modelo_Usuario();
    $MT = new Modelo_TramiteArea();

    // Si el rol es ADMIN, usa un método general; si no, usa uno específico por área
    if($rol == 'ADMIN'){
        $consulta = $MU->Traer_Widget();            // SP_TRAER_WIDGET
    }else{
        $consulta = $MT->Traer_Widget_Area($idusuario);  // SP_TRAER_WIDGET_AREA con parámetro idusuario
    }

    // Devuelve los datos en JSON
    echo json_encode($consulta);
?>
