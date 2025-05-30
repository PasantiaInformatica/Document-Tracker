<?php
    require_once 'model_conexion.php';

    class Modelo_TramiteArea extends conexionBD{

        public function Registrar_Tramite($iddo,$orig,$dest,$desc,$idusu,$rutas_json,$tipo){
            $c = conexionBD::conexionPDO();
            $sql = "CALL SP_REGISTRAR_TRAMITE_DERIVAR(?,?,?,?,?,?,?)";
            $query = $c->prepare($sql);

            $query = $c->prepare($sql);
            $query -> bindParam(1,$iddo);
            $query -> bindParam(2,$orig);
            $query -> bindParam(3,$dest);
            $query -> bindParam(4,$desc);
            $query -> bindParam(5,$idusu);
            $query -> bindParam(6,$rutas_json);
            $query -> bindParam(7,$tipo);
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

        public function Listar_Tramite($idusuario){
            $c = conexionBD::conexionPDO();
            $sql = "CALL SP_LISTAR_TRAMITE_AREA(?)";
            $arreglo = array();
            $query  = $c->prepare($sql);
            $query -> bindParam(1,$idusuario);
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

        public function Traer_Widget_Area($idusuario){
            $c = conexionBD::conexionPDO();
            $sql = "CALL SP_TRAER_WIDGET_AREA(?)";
            $query = $c->prepare($sql);
            $query->bindParam(1, $idusuario);
            $query->execute();
            $resultado = $query->fetchAll(PDO::FETCH_NUM);
            conexionBD::cerrar_conexion();
            return $resultado;
        }
    
    }

?>
