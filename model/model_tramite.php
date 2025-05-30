<?php
    require_once 'model_conexion.php';

    class Modelo_Tramite extends conexionBD{

        // public function Registrar_Tramite($dni,$nom,$apt,$apm,$cel,$ema,$arp,$ard,$tip,$ndo,$asu,$ruta,$desc,$idusu){
        //     $c = conexionBD::conexionPDO();
        //     $sql = "CALL SP_REGISTRAR_TRAMITE(?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        //     $arreglo = array();
        //     $query = $c->prepare($sql);
        //     $query -> bindParam(1,$dni);
        //     $query -> bindParam(2,$nom);
        //     $query -> bindParam(3,$apt);
        //     $query -> bindParam(4,$apm);
        //     $query -> bindParam(5,$cel);
        //     $query -> bindParam(6,$ema);
        //     $query -> bindParam(7,$arp);
        //     $query -> bindParam(8,$ard);
        //     $query -> bindParam(9,$tip);
        //     $query -> bindParam(10,$ndo);
        //     $query -> bindParam(11,$asu);
        //     $query -> bindParam(12,$ruta);
        //     $query -> bindParam(13,$desc);
        //     $query -> bindParam(14,$idusu);
        //     $result = $query->execute();
        //     if($result){
        //         return 1;
        //     }else{
        //         return 0;
        //     }
        //     conexionBD::cerrar_conexion();
        // }

        public function Registrar_Tramite($dni, $nom, $apt, $apm, $cel, $ema, $arp, $ard, $tip, $ndo, $asu, $rutas_json, $desc, $idusu) {
            $c = conexionBD::conexionPDO();
            $sql = "CALL SP_REGISTRAR_TRAMITE(?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $query = $c->prepare($sql);
            
            $query->bindParam(1, $dni);
            $query->bindParam(2, $nom);
            $query->bindParam(3, $apt);
            $query->bindParam(4, $apm);
            $query->bindParam(5, $cel);
            $query->bindParam(6, $ema);
            $query->bindParam(7, $arp);
            $query->bindParam(8, $ard);
            $query->bindParam(9, $tip);
            $query->bindParam(10, $ndo);
            $query->bindParam(11, $asu);
            $query->bindParam(12, $rutas_json); // JSON con las rutas de los archivos
            $query->bindParam(13, $desc);
            $query->bindParam(14, $idusu);
            
            try {
                $result = $query->execute();
                return $result ? "1" : "0";
            } catch (PDOException $e) {
                error_log("Error en Registrar_Tramite: " . $e->getMessage());
                return "Error: " . $e->getMessage();
            } finally {
                conexionBD::cerrar_conexion();
            }
        }
        
        public function Modificar_Usuario($id,$ide,$ida,$rol){
            $c = conexionBD::conexionPDO();
            $sql = "CALL SP_MODIFICAR_USUARIO(?,?,?,?)";
            $arreglo = array();
            $query  = $c->prepare($sql);
            $query -> bindParam(1,$id);
            $query -> bindParam(2,$ide);
            $query -> bindParam(3,$ida);
            $query -> bindParam(4,$rol);
            $result = $query->execute();
            if($result){
                return 1;
            }else{
                return 0;
            }
            conexionBD::cerrar_conexion();
        }

        public function Listar_Tramite(){
            $c = conexionBD::conexionPDO();
            $sql = "CALL SP_LISTAR_TRAMITE()";
            $arreglo = array();
            $query  = $c->prepare($sql);
            $query->execute();
            $resultado = $query->fetchAll(PDO::FETCH_ASSOC);
            foreach($resultado as $resp){
                $arreglo["data"][]=$resp;
            }
            return $arreglo;
            conexionBD::cerrar_conexion();
        }

        public function Listar_Tramite_Seguimiento($id){
            $c = conexionBD::conexionPDO();
            $sql = "CALL SP_LISTAR_TRAMITE_SEGUIMIENTO(?)";
            $arreglo = array();
            $query  = $c->prepare($sql);
            $query -> bindParam(1,$id);
            $query->execute();
            $resultado = $query->fetchAll(PDO::FETCH_ASSOC);
            foreach($resultado as $resp){
                $arreglo["data"][]=$resp;
            }
            return $arreglo;
            conexionBD::cerrar_conexion();
        }

        public function Cargar_Select_Tipo(){
            $c = conexionBD::conexionPDO();
            $sql = "CALL SP_CARGAR_SELECT_TIPO()";
            $arreglo = array();
            $query  = $c->prepare($sql);
            $query->execute();
            $resultado = $query->fetchAll();
            foreach($resultado as $resp){
                $arreglo[]=$resp;
            }
            return $arreglo;
            conexionBD::cerrar_conexion();
        }
    
    }

?>
