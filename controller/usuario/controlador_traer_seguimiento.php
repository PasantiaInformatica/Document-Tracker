<?php
    require '../../model/model_usuario.php';
    $MU = new Modelo_Usuario(); //Instanciar el modelo usuario
    $numero = htmlspecialchars($_POST['numero'],ENT_QUOTES,'UTF-8'); 
    $dni = htmlspecialchars($_POST['dni'],ENT_QUOTES,'UTF-8');
    // Consulta datos para poblar un select (combobox)
    $consulta = $MU->Cargar_Select_Datos_Seguimiento($numero,$dni);
    echo json_encode($consulta); // Devuelve los datos en JSON
?>