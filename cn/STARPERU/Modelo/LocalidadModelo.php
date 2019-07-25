<?php

require_once(PATH_PROYECTO."/cn/STARPERU/Conexion/ConexionBD.php");

class LocalidadModelo{
    
    private $basedatos='db_agencia';

    public function ObtenerPaises(){
        $obj_conexion=new ConexionBD();
        $conexion=$obj_conexion->CrearConexion();
        $consulta="SELECT Code_Pais, Pais FROM localidades GROUP BY Pais";
        $resultado=$obj_conexion->ConsultarDatos($consulta,$this->basedatos,$conexion);
        $numero_filas=$obj_conexion->ContarFilas($resultado);
        $lista_paises=array();
        if($numero_filas>0){
            while($fila = $obj_conexion->ObtenerDatos($resultado)){
                $obj = new stdClass();
                foreach ($fila as $name => $value) {
                    $obj->{$name}=$value;
                }
                $lista_paises[]=$obj;
            }
            $obj_conexion->CerrarConexion($conexion);
        }
        return $lista_paises;
    }

    public function ObtenerLocalidades($Code_Pais){
        $obj_conexion=new ConexionBD();
        $conexion=$obj_conexion->CrearConexion();
        $consulta="SELECT Codigo,Nombre FROM localidades WHERE Nombre<>'' AND Code_Pais='".$Code_Pais."'";
        $resultado=$obj_conexion->ConsultarDatos($consulta,$this->basedatos,$conexion);
        $numero_filas=$obj_conexion->ContarFilas($resultado);
        $lista_paises=array();
        if($numero_filas>0){
            while($fila = $obj_conexion->ObtenerDatos($resultado)){
                $obj = new stdClass();
                foreach ($fila as $name => $value) {
                    $obj->{$name}=$value;
                }
                $lista_paises[]=$obj;
            }
            $obj_conexion->CerrarConexion($conexion);
        }
        return $lista_paises;
    }
     
}


?>
