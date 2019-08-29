<?php
if (!isset($url_proyecto)) {
    $URL_DEFINIDO='../..';
}
else{
    $URL_DEFINIDO=PATH_PROYECTO;
}
require_once($URL_DEFINIDO."/cn/STARPERU/Conexion/ConexionBD.php");

class VisaModelo{
    
    private $basedatos='db_agencia';
   
    public function InsertarRegistroVisa($query){
        $obj_conexion=new ConexionBD();
        $conexion=$obj_conexion->CrearConexion();
        $res_sql = $obj_conexion->ConsultarDatos($query,$this->basedatos,$conexion);
        return $res_sql;
    }

    public function AnularPago($reserva_id){
        $flag=0;
        $obj_conexion=new ConexionBD();
        $conexion=$obj_conexion->CrearConexion();
        $consulta="UPDATE visa SET anulado=0 WHERE  reserva_id=$reserva_id";
        $obj_conexion->ConsultarDatos($consulta,$this->basedatos,$conexion);
        $error=$obj_conexion->ErrorEjecucion($conexion);
        if($error==1){
            $flag=1;
        }
        $obj_conexion->CerrarConexion($conexion);
        return $flag;
    }
   
     
}
