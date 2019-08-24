<?php
if (!isset($url_proyecto)) {
    $URL_DEFINIDO='../..';
}
else{
    $URL_DEFINIDO=PATH_PROYECTO;
}
require_once($URL_DEFINIDO."/cn/STARPERU/Conexion/ConexionBD.php");
require_once($URL_DEFINIDO."/cn/STARPERU/Entidades/CiudadEntidad.php");

class CiudadModelo{
    
    private $basedatos='db_agencia';
   
    public function ObtenerCiudades($origen){
        
        $lista_ciudades=array();
        $obj_conexion=new ConexionBD();
        $conexion=$obj_conexion->CrearConexion();
        $consulta="SELECT * FROM ciudad WHERE vigente=1 AND osce=1";
        if($origen!=''){
            $consulta="SELECT * FROM ciudad, ruta WHERE ciudad.id_ciudad = ruta.CodigoCiudadDestino AND CodigoCiudadOrigen = '$origen' AND EstadoRegistro = 1 AND vigente = 1 AND ciudad.osce=1";
        }
        $resultado=$obj_conexion->ConsultarDatos($consulta,$this->basedatos,$conexion);
        $numero_filas=$obj_conexion->ContarFilas($resultado);
        // var_dump($numero_filas);die;
        if($numero_filas>0){
                while($fila=  $obj_conexion->ObtenerDatos($resultado)){
                    $ciudad = new CiudadEntidad();
                    $ciudad->setIdCiudad($fila['id_ciudad']);
                    $ciudad->setCiudad($fila['ciudad']);
                    $ciudad->setVigente($fila['vigente']);
                    $ciudad->setIdOperador($fila['id_operador']);
                    $ciudad->setEnviar($fila['enviar']);
                    $ciudad->setExonerado($fila['exonerado']);
                    $lista_ciudades[]=$ciudad;
                 }
               $obj_conexion->CerrarConexion($conexion);
            
        }
        return $lista_ciudades;
    }    
}


?>

