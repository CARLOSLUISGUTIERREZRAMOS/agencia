<?php

require_once("../../cn/STARPERU/Conexion/ConexionBD.php");

class VisaModelo{
    
    private $basedatos='db_agencia';
   
    public function InsertarRegistroVisa($query){
        $obj_conexion=new ConexionBD();
        $conexion=$obj_conexion->CrearConexion();
        $res_sql = $obj_conexion->ConsultarDatos($query,$this->basedatos,$conexion);
        return $res_sql;
    }
   
     
}
