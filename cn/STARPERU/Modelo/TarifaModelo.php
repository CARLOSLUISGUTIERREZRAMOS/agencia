<?php

require_once("../../cn/STARPERU/Conexion/ConexionBD.php");
require_once("../../cn/STARPERU/Entidades/TarifaEntidad.php");

class TarifaModelo{
    
    private $basedatos='db_agencia';
   
    public function FamiliasHabilitadas(){
        $obj_conexion=new ConexionBD();
        $conexion=$obj_conexion->CrearConexion();
        $consulta="SELECT NombreFamilia FROM pais p, pais_familia pf, familia f 
                   WHERE p.CodigoPais=pf.CodigoPais AND pf.CodigoFamilia=f.CodigoFamilia
                   AND p.Pais='PERU'";
            
        $resultado=$obj_conexion->ConsultarDatos($consulta,$this->basedatos,$conexion);
        $numero_filas=$obj_conexion->ContarFilas($resultado);
        
        if($numero_filas>0){
            $arrayF=array();
            $i=0;
            while($fila=  $obj_conexion->ObtenerDatos($resultado)){
                $arrayF[$i]=$fila['NombreFamilia'];
                $i++;
            }
            $obj_conexion->CerrarConexion($conexion);
            return $arrayF;
        }else{
           return '';
        }
    }
    /*
    public function ObtenerTarifaClase($fecha,$clase,$origen,$destino,$tipo_viaje){
        $obj_conexion=new ConexionBD();
        $conexion=$obj_conexion->CrearConexion();
        $filtro='';
        if($tipo_viaje=="O"){
            $filtro="AND FareBase.TipoViaje = 'O' ";
        }
        $consulta="SELECT NombreFamilia,NombreClase,Tarifa 
                   FROM FareBase_Ruta,FareBase,Ruta,Clase,Familia,Pais_Familia , Pais
                   WHERE FareBase_Ruta.CodigoFareBase=FareBase.CodigoFareBase AND 
                         FareBase_Ruta.CodigoRuta=Ruta.CodigoRuta AND 
                         Clase.CodigoClase='$clase' AND
                         FareBase.CodigoClase=Clase.CodigoClase AND 
                         Clase.CodigoFamilia=Familia.CodigoFamilia AND 
                         Familia.CodigoFamilia=Pais_Familia.CodigoFamilia AND 
                         Pais_Familia.CodigoPais = 44 AND Pais.CodigoPais = 44 $filtro AND 
                         Pais_Familia.EstadoRegistro = 1 AND 
                         Ruta.CodigoCiudadOrigen='$origen' AND 
                         Ruta.CodigoCiudadDestino='$destino' AND 
                         FareBase_Ruta.Tarifa>0 AND 
                         FareBase_Ruta.estado_web=1  AND 
                         Clase.TipoClase=1 AND    
                         ('$fecha' BETWEEN FareBase_Ruta.Inicio AND FareBase_Ruta.Final) ";

        $resultado=$obj_conexion->ConsultarDatos($consulta,$this->basedatos,$conexion);
        $numero_filas=$obj_conexion->ContarFilas($resultado);
        
        if($numero_filas>0){
            $fila=  $obj_conexion->ObtenerDatos($resultado);
            $obj_conexion->CerrarConexion($conexion);
            return $fila['Tarifa'].'|||'.$fila['NombreFamilia'];
        }else{
           return '';
        }
    } */
    
     public function ObtenerTarifaClaseFamilia($fecha,$origen,$destino,$tipo_viaje,$estadia){
        $obj_conexion=new ConexionBD();
        $conexion=$obj_conexion->CrearConexion();

        $filtro_tipo='';
        if($tipo_viaje=='O'){
            $filtro_tipo=" farebase.TipoViaje='O' AND ";
            $filtro_ruta.=" ruta.CodigoCiudadOrigen='$origen' AND  
                            ruta.CodigoCiudadDestino='$destino' AND ";
        }else if($tipo_viaje=='R'){
            $filtro_ruta.=" ruta.CodigoCiudadOrigen='$destino' AND  
                            ruta.CodigoCiudadDestino='$origen' AND ";
        }
        $fecha_emision=date('Y-m-d');
        /*QUITANDO BASICAS A LA OSCE + REGULAR Q*/
        $consulta="SELECT NombreClase,Tarifa, NombreFamilia
                FROM farebase_ruta,farebase,ruta,clase,pais_clase ,pais,familia
                WHERE farebase_ruta.CodigoFareBase=farebase.CodigoFareBase AND 
                      farebase_ruta.CodigoRuta=Ruta.CodigoRuta AND     
                      FareBase.CodigoClase=clase.CodigoClase AND 
                      clase.CodigoFamilia=familia.CodigoFamilia AND
                      clase.TipoClase=1 AND 
                      pais_clase.Clase=clase.CodigoClase AND
                      pais_clase.CodigoPais = pais.CodigoPais AND
                      pais_clase.EstadoRegistro = 1 AND
                      pais.Abreviatura='PE' AND                                     
                      farebase_ruta.estado_web=1 AND 
                      farebase_ruta.Tarifa>0 AND  
                      $filtro_ruta
                      $filtro_tipo     
                      EstadiaMin<=$estadia AND (EstadiaMax>=$estadia OR EstadiaMax=0) AND 
                      ('$fecha' BETWEEN farebase_ruta.Inicio AND farebase_ruta.Final) AND 
                      ('$fecha_emision' BETWEEN farebase_ruta.EmisionInicio AND farebase_ruta.EmisionFinal) 
                      ORDER BY 2 ASC";               
//        echo $consulta;
//        exit;
//        Clase.CodigoFamilia>1 AND
//         Clase.CodigoClase<>'Q' AND

        $resultado=$obj_conexion->ConsultarDatos($consulta,$this->basedatos,$conexion);
        $numero_filas=$obj_conexion->ContarFilas($resultado);
        
        if($numero_filas>0){

            $arrayT=array();

            while($fila=  $obj_conexion->ObtenerDatos($resultado)){
                $arrayC[]=$fila['NombreClase'];
                $arrayT[$fila['NombreClase']]=$fila['Tarifa'];
            }
            return $arrayF=array("Clases"=>$arrayC,"Tarifas"=>$arrayT);
        }else{
            $arrayF=array();
           return $arrayF;
        }
    } 
    
    public function ObtenerFamiliaCondiciones($clase){
        $obj_conexion=new ConexionBD();
        $conexion=$obj_conexion->CrearConexion();
        $consulta="SELECT familia.NombreFamilia,clase.CodigoClase FROM pais_familia, familia, clase WHERE  clase.CodigoClase='$clase' AND clase.CodigoFamilia=familia.CodigoFamilia AND pais_familia.CodigoFamilia = familia.CodigoFamilia AND EstadoRegistro = 1 AND CodigoPais = '44'";
            
        $resultado=$obj_conexion->ConsultarDatos($consulta,$this->basedatos,$conexion);
        $numero_filas=$obj_conexion->ContarFilas($resultado);
        
        if($numero_filas>0){
            $fila=  $obj_conexion->ObtenerDatos($resultado);
            $obj_conexion->CerrarConexion($conexion);
            return $fila['NombreFamilia'];
        }else{
           return '';
       }
    }
    
    public function IgvExonerado($codigo_ciudad){ 
        $obj_conexion=new ConexionBD();
        $conexion=$obj_conexion->CrearConexion(); 
        $consulta="SELECT exonerado FROM ciudad WHERE id_ciudad='$codigo_ciudad'";
        $resultado=$obj_conexion->ConsultarDatos($consulta,$this->basedatos,$conexion);
        $numero_filas=$obj_conexion->ContarFilas($resultado);
       
        if($numero_filas>0){
             $fila=  $obj_conexion->ObtenerDatos($resultado);
             $obj_conexion->CerrarConexion($conexion);
             return $fila['exonerado'];
        }else{
           return '';
        }
    }   

    public function ObtenerNombreCiudad($codigo_ciudad){
        $obj_conexion=new ConexionBD();
        $conexion=$obj_conexion->CrearConexion();
        $consulta="SELECT ciudad FROM ciudad WHERE id_ciudad='$codigo_ciudad'";
        $resultado=$obj_conexion->ConsultarDatos($consulta,$this->basedatos,$conexion);
        $numero_filas=$obj_conexion->ContarFilas($resultado);
       
        if($numero_filas>0){
             $fila=  $obj_conexion->ObtenerDatos($resultado);
             $obj_conexion->CerrarConexion($conexion);
             return $fila['ciudad'];
        }else{
           return '';
        }
    }   
     
}


?>

