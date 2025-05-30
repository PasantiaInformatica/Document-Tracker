<?php
    require '../../model/model_tramite_area.php';
    $MU = new Modelo_TramiteArea();//Instaciamos
    
    //DATOS DEL REMIENTE
    $iddo = (htmlspecialchars($_POST['iddo'],ENT_QUOTES,'UTF-8'));
    $orig = (htmlspecialchars($_POST['orig'],ENT_QUOTES,'UTF-8'));
    $dest = (htmlspecialchars($_POST['dest'],ENT_QUOTES,'UTF-8'));
    $desc = (htmlspecialchars($_POST['desc'],ENT_QUOTES,'UTF-8'));
    $idusu = (htmlspecialchars($_POST['idusu'],ENT_QUOTES,'UTF-8'));
    $tipo = (htmlspecialchars($_POST['tipo'],ENT_QUOTES,'UTF-8'));
    //$nombrearchivo = (htmlspecialchars($_POST['nombrearchivo'],ENT_QUOTES,'UTF-8'));

    // Procesar archivos
    $archivos = $_FILES['archivos'];
    $rutas_archivos = array();

    // // Crear directorio si no existe
    $directorio = "documentos/";
    if (!file_exists($directorio)) {
        mkdir($directorio, 0777, true);
        }

    // Guardar cada archivo
    for ($i = 0; $i < count($archivos['name']); $i++) {
        // Generar nombre único para el archivo
        $extension = pathinfo($archivos['name'][$i], PATHINFO_EXTENSION);
        $nombre_archivo = uniqid() . '_' . date('YmdHis') . '.' . $extension;
        $ruta_temp = $archivos['tmp_name'][$i];
        $ruta_destino = $directorio . $nombre_archivo;
        
        // Mover archivo al directorio
        if (move_uploaded_file($ruta_temp, $ruta_destino)) {
            $rutas_archivos[] = 'controller/tramite_area/' . $ruta_destino;
        } else {
            echo "Error al subir el archivo: " . $archivos['name'][$i];
            exit;
        }
    }

    // Convertir rutas a JSON
    $rutas_json = json_encode($rutas_archivos);

    // Registrar el trámite
    $consulta = $MU->Registrar_Tramite($iddo, $orig, $dest, $desc, $idusu, $rutas_json, $tipo);
    echo $consulta;

?>