<!-- <?php
    // require '../../model/model_tramite.php';
    // $MU = new Modelo_Tramite();//Instaciamos
    
    // //DATOS DEL REMIENTE
    // $dni = (htmlspecialchars($_POST['dni'],ENT_QUOTES,'UTF-8'));
    // $nom = (htmlspecialchars($_POST['nom'],ENT_QUOTES,'UTF-8'));
    // $apt = (htmlspecialchars($_POST['apt'],ENT_QUOTES,'UTF-8'));
    // $apm = (htmlspecialchars($_POST['apm'],ENT_QUOTES,'UTF-8'));
    // $cel = (htmlspecialchars($_POST['cel'],ENT_QUOTES,'UTF-8'));
    // $ema = (htmlspecialchars($_POST['ema'],ENT_QUOTES,'UTF-8'));

    // //DATOS DEL DOCUMENTO 
    // $arp = (htmlspecialchars($_POST['arp'],ENT_QUOTES,'UTF-8'));
    // $ard = (htmlspecialchars($_POST['ard'],ENT_QUOTES,'UTF-8'));
    // $tip = (htmlspecialchars($_POST['tip'],ENT_QUOTES,'UTF-8'));
    // $ndo = (htmlspecialchars($_POST['ndo'],ENT_QUOTES,'UTF-8'));
    // $asu = (htmlspecialchars($_POST['asu'],ENT_QUOTES,'UTF-8'));
    // $nombrearchivo = (htmlspecialchars($_POST['nombrearchivo'],ENT_QUOTES,'UTF-8'));
    // $desc = (htmlspecialchars($_POST['desc'],ENT_QUOTES,'UTF-8'));
    // $idusu = (htmlspecialchars($_POST['idusu'],ENT_QUOTES,'UTF-8'));

    // $ruta='controller/tramite/documentos/'.$nombrearchivo;
    // $consulta = $MU->Registrar_Tramite($dni,$nom,$apt,$apm,$cel,$ema,$arp,$ard,$tip,$ndo,$asu,$ruta,$desc,$idusu);
    // echo $consulta;
    // if($consulta==1){
    //     move_uploaded_file($_FILES['archivoobj']['tmp_name'], "documentos/".$nombrearchivo);
    // }

?>  -->

<?php
require '../../model/model_tramite.php';
$MU = new Modelo_Tramite();

// DATOS DEL REMITENTE
$dni = htmlspecialchars($_POST['dni'], ENT_QUOTES, 'UTF-8');
$nom = htmlspecialchars($_POST['nom'], ENT_QUOTES, 'UTF-8');
$apt = htmlspecialchars($_POST['apt'], ENT_QUOTES, 'UTF-8');
$apm = htmlspecialchars($_POST['apm'], ENT_QUOTES, 'UTF-8');
$cel = htmlspecialchars($_POST['cel'], ENT_QUOTES, 'UTF-8');
$ema = htmlspecialchars($_POST['ema'], ENT_QUOTES, 'UTF-8');

// DATOS DEL DOCUMENTO 
$arp = htmlspecialchars($_POST['arp'], ENT_QUOTES, 'UTF-8');
$ard = htmlspecialchars($_POST['ard'], ENT_QUOTES, 'UTF-8');
$tip = htmlspecialchars($_POST['tip'], ENT_QUOTES, 'UTF-8');
$ndo = htmlspecialchars($_POST['ndo'], ENT_QUOTES, 'UTF-8');
$asu = htmlspecialchars($_POST['asu'], ENT_QUOTES, 'UTF-8');
$desc = htmlspecialchars($_POST['desc'], ENT_QUOTES, 'UTF-8');
$idusu = htmlspecialchars($_POST['idusu'], ENT_QUOTES, 'UTF-8');

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
        $rutas_archivos[] = 'controller/tramite/' . $ruta_destino;
    } else {
        echo "Error al subir el archivo: " . $archivos['name'][$i];
        exit;
    }
}

// Convertir rutas a JSON
$rutas_json = json_encode($rutas_archivos);

// Registrar el trámite
$consulta = $MU->Registrar_Tramite($dni, $nom, $apt, $apm, $cel, $ema, $arp, $ard, $tip, $ndo, $asu, $rutas_json, $desc, $idusu);
echo $consulta;
?>