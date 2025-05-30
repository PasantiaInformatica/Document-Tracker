<?php
    require '../../model/model_tipo.php';
    $MU = new Modelo_Tipo(); //Instaciamos el modelo tipo

    // Obtiene el valor 'tipo' enviado por POST y lo sanitiza para seguridad
    $tipo = htmlspecialchars($_POST['tipo'],ENT_QUOTES,'UTF-8');  
    // Llama al método Registrar_Tipo del modelo pasándole el tipo sanitizado 
    $consulta = $MU->Registrar_Tipo($tipo);
    echo $consulta; // Imprime el resultado de la consulta (probablemente un éxito/error)

?>