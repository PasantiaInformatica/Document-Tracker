<?php
    require '../../model/model_empleado.php';
    $MU = new Modelo_Empleado(); // Instancia del modelo

    // Sanitización de todos los campos recibidos por POST
    $nro = htmlspecialchars($_POST['nro'],ENT_QUOTES,'UTF-8');
    $nom = htmlspecialchars($_POST['nom'],ENT_QUOTES,'UTF-8');
    $apepa = htmlspecialchars($_POST['apepa'],ENT_QUOTES,'UTF-8');
    $apema = htmlspecialchars($_POST['apema'],ENT_QUOTES,'UTF-8');
    $fnac = htmlspecialchars($_POST['fnac'],ENT_QUOTES,'UTF-8');
    $cel = htmlspecialchars($_POST['cel'],ENT_QUOTES,'UTF-8');
    $dire = htmlspecialchars($_POST['dire'],ENT_QUOTES,'UTF-8');
    $email = htmlspecialchars($_POST['email'],ENT_QUOTES,'UTF-8');  
    
    // Registra nuevo empleado
    $consulta = $MU->Registrar_Empleado($nro,$nom,$apepa,$apema,$fnac,$cel,$dire,$email);
    echo $consulta;

?>
