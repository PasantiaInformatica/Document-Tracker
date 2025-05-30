<?php
    require '../../model/model_empleado.php';
    $MU = new Modelo_Empleado(); // Instancia modelo

    // Sanitiza inputs y modifica empleado
    $id = htmlspecialchars($_POST['id'],ENT_QUOTES,'UTF-8');
    $nro = htmlspecialchars($_POST['nro'],ENT_QUOTES,'UTF-8');
    $nom = htmlspecialchars($_POST['nom'],ENT_QUOTES,'UTF-8');
    $apepa = htmlspecialchars($_POST['apepa'],ENT_QUOTES,'UTF-8');
    $apema = htmlspecialchars($_POST['apema'],ENT_QUOTES,'UTF-8');
    $fnac = htmlspecialchars($_POST['fnac'],ENT_QUOTES,'UTF-8');
    $cel = htmlspecialchars($_POST['cel'],ENT_QUOTES,'UTF-8');
    $dire = htmlspecialchars($_POST['dire'],ENT_QUOTES,'UTF-8');
    $email = htmlspecialchars($_POST['email'],ENT_QUOTES,'UTF-8');   
    $esta = htmlspecialchars($_POST['esta'],ENT_QUOTES,'UTF-8');

    // Ejecuta modificación y devuelve resultado (1: éxito, 0: error)
    $consulta = $MU->Modificar_Empleado($id,$nro,$nom,$apepa,$apema,$fnac,$cel,$dire,$email,$esta);
    echo $consulta;

?>
