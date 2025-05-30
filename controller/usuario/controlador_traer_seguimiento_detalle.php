<?php
    require '../../model/model_usuario.php';
    $MU = new Modelo_Usuario(); //Instanciar el modelo usuario
    // Sanitiza el código recibido por POST
    $codigo = htmlspecialchars($_POST['codigo'],ENT_QUOTES,'UTF-8'); 
    $consulta = $MU->Traer_Datos_Detalle_Seguimiento($codigo);
    // Devuelve los resultados en formato JSON
    echo json_encode($consulta);
?>