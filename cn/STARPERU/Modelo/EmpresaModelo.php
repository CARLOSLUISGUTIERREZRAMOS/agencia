<?php

require_once("../../cn/STARPERU/Conexion/ConexionBD.php");
require_once("../../cn/STARPERU/Entidades/EmpresaEntidad.php");

class EmpresaModelo{
    
    private $basedatos='db_agencia';
   
    public function ObtenerNombreEntidad($codigo_entidad){
        
        $obj_conexion=new ConexionBD();
        $conexion=$obj_conexion->CrearConexion();
        $consulta="SELECT RazonSocial FROM Entidad WHERE CodigoEntidad=$codigo_entidad";
            
        $resultado=$obj_conexion->ConsultarDatos($consulta,$this->basedatos,$conexion);
        $numero_filas=$obj_conexion->ContarFilas($resultado);
        $fila=  $obj_conexion->ObtenerDatos($resultado);
        if($numero_filas>0){
                    $empresa = new EmpresaEntidad();
                    $empresa->setRazonSocial($fila['RazonSocial']);
             $obj_conexion->CerrarConexion($conexion);
            
           return $empresa;
        }else{
           return "";
        }
        
    }
    public function ObtenerRucEmpresa($codigo_entidad){
        
        $obj_conexion=new ConexionBD();
        $conexion=$obj_conexion->CrearConexion();
        $consulta="SELECT RUC FROM Entidad WHERE CodigoEntidad=$codigo_entidad";
            
        $resultado=$obj_conexion->ConsultarDatos($consulta,$this->basedatos,$conexion);
        $numero_filas=$obj_conexion->ContarFilas($resultado);
        $fila=  $obj_conexion->ObtenerDatos($resultado);
        if($numero_filas>0){
                    $empresa = new EmpresaEntidad();
                    $empresa->setRUC($fila['RUC']);
             $obj_conexion->CerrarConexion($conexion);
            
           return $empresa;
        }else{
           return "";
        }
        
    }
 
    public function ObtenerEmpresaPermitida($dni_personal){
        
        $obj_conexion=new ConexionBD();
        $conexion=$obj_conexion->CrearConexion();
        $consulta="SELECT e.EstadoRegistro FROM Entidad e, Personal p "
                . "WHERE e.CodigoEntidad=p.CodigoEntidad AND p.CodigoUsuario = '$dni_personal' AND p.EstadoRegistro=1";
            
        $resultado=$obj_conexion->ConsultarDatos($consulta,$this->basedatos,$conexion);
        $fila=  $obj_conexion->ObtenerDatos($resultado);
        if($fila['EstadoRegistro']==0){
            return 1;
        }
        else{
            return 0;
        }
        
    }

    public function RegistarEmpresa($RUC,$RazonSocial,$NombreComercial,$Direccion,$CodigoCiudad,$DNIFuncionario,$ApellidoPaterno,$ApellidoMaterno,$Nombres,$Email,$TelefoniaOficina,$Celular){
        $flag=0;
        $obj_conexion=new ConexionBD();
        $conexion=$obj_conexion->CrearConexion();
        $consulta="INSERT INTO entidad (RUC,RazonSocial,NombreComercial,Direccion,CodigoCiudad,DNIFuncionario,ApellidoPaterno,ApellidoMaterno,Nombres,Email,TelefoniaOficina,Celular,EstadoRegistro)
                   VALUES ('$RUC','$RazonSocial','$NombreComercial','$Direccion','$CodigoCiudad','$DNIFuncionario','$ApellidoPaterno','$ApellidoMaterno','$Nombres','$Email','$TelefoniaOficina','$Celular',0)";
        $obj_conexion->ConsultarDatos($consulta,$this->basedatos,$conexion);
        $error=$obj_conexion->ErrorEjecucion($conexion);
        if($error==1){
            $flag=1;
        }
        $obj_conexion->CerrarConexion($conexion);
        return $flag;
    }

    public function UltimaEmpresa()
    {
        $flag=0;
        $obj_conexion=new ConexionBD();
        $conexion=$obj_conexion->CrearConexion();
        $consulta="SELECT CodigoEntidad FROM entidad ORDER BY CodigoEntidad DESC LIMIT 1";
        $resultado=$obj_conexion->ConsultarDatos($consulta,$this->basedatos,$conexion);
        $numero_filas=$obj_conexion->ContarFilas($resultado);
        $fila=  $obj_conexion->ObtenerDatos($resultado);
        if($numero_filas>0){
            return $fila['CodigoEntidad'];
            $obj_conexion->CerrarConexion($conexion);
        }else{
           return "";
        }
    }

    public function ActualizarLogoEmpresa($CodigoEntidad,$LogoEntidad)
    {
        $flag=0;
        $obj_conexion=new ConexionBD();
        $conexion=$obj_conexion->CrearConexion();
        $consulta="UPDATE entidad SET LogoEntidad='$LogoEntidad' WHERE CodigoEntidad=$CodigoEntidad";
        $obj_conexion->ConsultarDatos($consulta,$this->basedatos,$conexion);
        $error=$obj_conexion->ErrorEjecucion($conexion);
        if($error==1){
            $flag=1;
        }
        $obj_conexion->CerrarConexion($conexion);
        return $flag;
    }

    public function ObtenerEmpresa($Limit=null)
    {
        $flag=0;
        $obj_conexion=new ConexionBD();
        $conexion=$obj_conexion->CrearConexion();
        $consulta="SELECT * FROM entidad ORDER BY CodigoEntidad ASC ";
        if ($Limit) {
            $consulta.=" LIMIT  $Limit";
        }
        $resultado=$obj_conexion->ConsultarDatos($consulta,$this->basedatos,$conexion);
        $numero_filas=$obj_conexion->ContarFilas($resultado);
        if($numero_filas>0){
            $dato=array();
            while($fila = $obj_conexion->ObtenerDatos($resultado)){
                $obj = new stdClass();
                foreach ($fila as $name => $value) {
                    $obj->{$name}=$value;
                }
                $dato[]=$obj;
            }
            $obj_conexion->CerrarConexion($conexion);
            return $dato;
        }else{
           return 'Sin datos';
        }
    }

    public function ObtenerEmpresaFindID($CodigoEntidad)
    {
        $flag=0;
        $obj_conexion=new ConexionBD();
        $conexion=$obj_conexion->CrearConexion();
        $consulta="SELECT * FROM entidad WHERE CodigoEntidad=$CodigoEntidad";
        $resultado=$obj_conexion->ConsultarDatos($consulta,$this->basedatos,$conexion);
        $numero_filas=$obj_conexion->ContarFilas($resultado);
        $filas=$obj_conexion->ObtenerDatos($resultado);
        if($numero_filas>0){
            $obj = new stdClass();
            foreach ($filas as $name => $value) {
                $obj->{$name}=$value;
            }
            $obj_conexion->CerrarConexion($conexion);
            return $obj;
        }else{
           return 'Sin datos';
        }
    }



    public function VerificarRucEmpresa($ruc){
        
        $obj_conexion=new ConexionBD();
        $conexion=$obj_conexion->CrearConexion();
        $consulta="SELECT RUC,RazonSocial FROM entidad WHERE RUC=$ruc";
            
        $resultado=$obj_conexion->ConsultarDatos($consulta,$this->basedatos,$conexion);
        $numero_filas=$obj_conexion->ContarFilas($resultado);
        $fila=  $obj_conexion->ObtenerDatos($resultado);

        if($numero_filas>0){
            return $fila;
            $obj_conexion->CerrarConexion($conexion);
        }else{
           return ['data'=>'vacio'];
        }
        
    }
     
}


?>

