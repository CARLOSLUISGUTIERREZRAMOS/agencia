<?php

require_once("../../cn/STARPERU/Conexion/ConexionBD.php");
require_once("../../cn/STARPERU/Entidades/PersonalEntidad.php");

class PersonalModelo{
    
    private $basedatos='db_agencia';
    
    
    public function AutentificarPersonal($usuario, $password){

        $obj_conexion=new ConexionBD();
        $conexion=$obj_conexion->CrearConexion();
        
        $consulta="SELECT p.CodigoPersonal, p.Nombres, p.ApellidoPaterno, p.ApellidoMaterno, p.CodigoEntidad, p.CambioClave,p.CodigoTipo,p.DNI,p.Email,p.TelefonoOficina,p.Anexo,p.Celular,p.RPC,p.RPM,p.Nextel 
                   FROM Personal p, Entidad e 
                   WHERE p.CodigoUsuario='$usuario' AND p.Password='$password' AND p.EstadoRegistro=1 AND e.EstadoRegistro=1 AND p.CodigoEntidad=e.CodigoEntidad";//e.EstadoRegistro=1 AND
        
        $resultado=$obj_conexion->ConsultarDatos($consulta,$this->basedatos,$conexion);
        $numero_filas=$obj_conexion->ContarFilas($resultado);

        if($numero_filas==1){
            
            $fila=  $obj_conexion->ObtenerDatos($resultado);
            $personal = new PersonalEntidad();
            $personal->setCodigoPersonal($fila['CodigoPersonal']);
            $personal->setNombres($fila['Nombres']);
            $personal->setApellidoPaterno($fila['ApellidoPaterno']);
            $personal->setApellidoMaterno($fila['ApellidoMaterno']);
            $personal->setCodigoEntidad($fila['CodigoEntidad']);
            $personal->setCambioClave($fila['CambioClave']);
            $personal->setCodigoTipo($fila['CodigoTipo']);
            $personal->setDNI($fila['DNI']);
            $personal->setEmail($fila['Email']);
            $personal->setTelefonoOficina($fila['TelefonoOficina']);
            $personal->setAnexo($fila['Anexo']);
            $personal->setCelular($fila['Celular']);
            $personal->setRPC($fila['RPC']);
            $personal->setRPM($fila['RPM']);
            $personal->setNextel($fila['Nextel']);
            $obj_conexion->CerrarConexion($conexion);
            
           return $personal;
        }else{
           return "";
        }
        
    }
    public function ListaDelegados($codigo_entidad, $dni,$apellido){
        $lista_personal=array();
        $obj_conexion=new ConexionBD();
        $conexion=$obj_conexion->CrearConexion();
        $consulta="SELECT *
                   FROM Personal 
                   WHERE CodigoEntidad=$codigo_entidad AND CodigoTipo='D'";
             if($dni!=''){
                  $consulta.=" AND DNI='$dni'";
             }      
             if($apellido!=''){
                  $consulta.=" AND CONCAT(ApellidoPaterno,' ',ApellidoMaterno) LIKE '%$apellido%' ";
             }      
            
        $resultado=$obj_conexion->ConsultarDatos($consulta,$this->basedatos,$conexion);
        $numero_filas=$obj_conexion->ContarFilas($resultado);
        if($numero_filas>0){
            
            while($fila=  $obj_conexion->ObtenerDatos($resultado)){
                    $personal = new PersonalEntidad();
                    $personal->setCodigoPersonal($fila['CodigoPersonal']);
                    $personal->setNombres($fila['Nombres']);
                    $personal->setApellidoPaterno($fila['ApellidoPaterno']);
                    $personal->setApellidoMaterno($fila['ApellidoMaterno']);
                    $personal->setCodigoEntidad($fila['CodigoEntidad']);
                    $personal->setCambioClave($fila['CambioClave']);
                    $personal->setCodigoTipo($fila['CodigoTipo']);
                    $personal->setDNI($fila['DNI']);
                    $personal->setEmail($fila['Email']);
                    $personal->setTelefonoOficina($fila['TelefonoOficina']);
                    $personal->setAnexo($fila['Anexo']);
                    $personal->setCelular($fila['Celular']);
                    $personal->setRPC($fila['RPC']);
                    $personal->setRPM($fila['RPM']);
                    $personal->setNextel($fila['Nextel']);
                    $personal->setEstadoRegistro($fila['EstadoRegistro']);
                    $lista_personal[]=$personal;
            }
            $obj_conexion->CerrarConexion($conexion);
            
          
        }
           return $lista_personal;
    }
    public function DNIValidar($dni,$codigo_entidad){
        $obj_conexion=new ConexionBD();
        $conexion=$obj_conexion->CrearConexion();
        $consulta="SELECT *
                   FROM Personal 
                   WHERE DNI='$dni' AND CodigoEntidad='$codigo_entidad' AND EstadoRegistro=1";
                 
       $resultado=$obj_conexion->ConsultarDatos($consulta,$this->basedatos,$conexion);
       $numero_filas=$obj_conexion->ContarFilas($resultado);
       return $numero_filas;
    }
    
     public function ObtenerNombreEntidad($codigo_entidad){
        $obj_conexion=new ConexionBD();
        $conexion=$obj_conexion->CrearConexion();
        $consulta="SELECT RazonSocial FROM Entidad WHERE CodigoEntidad='$codigo_entidad'";
                 
       $resultado=$obj_conexion->ConsultarDatos($consulta,$this->basedatos,$conexion);
       $numero_filas=$obj_conexion->ContarFilas($resultado);
        if($numero_filas==1){
            $fila=  $obj_conexion->ObtenerDatos($resultado);
            $nombre_entidad = "";
            $nombre_entidad=$fila['RazonSocial'];
            $obj_conexion->CerrarConexion($conexion);
            return $nombre_entidad;
        }else{
            $obj_conexion->CerrarConexion($conexion);
            return "";
        }
    }
    
    public function ObtenerRUCEntidad($codigo_entidad){
        $obj_conexion=new ConexionBD();
        $conexion=$obj_conexion->CrearConexion();
        $consulta="SELECT RUC FROM Entidad WHERE CodigoEntidad='$codigo_entidad'";
                 
       $resultado=$obj_conexion->ConsultarDatos($consulta,$this->basedatos,$conexion);
       $numero_filas=$obj_conexion->ContarFilas($resultado);
        if($numero_filas==1){
            $fila=  $obj_conexion->ObtenerDatos($resultado);
            $nombre_entidad = "";
            $nombre_entidad=$fila['RUC'];
            $obj_conexion->CerrarConexion($conexion);
            return $nombre_entidad;
        }else{
            $obj_conexion->CerrarConexion($conexion);
            return "";
        }
    }
    
    public function ObtenerLineaCredito($codigo_entidad){
       $linea_credito_final = "";
       $obj_conexion=new ConexionBD();
       $conexion=$obj_conexion->CrearConexion();
       $consulta="SELECT (Linea-Acumulado) AS LineaCredito FROM Entidad WHERE CodigoEntidad='$codigo_entidad'"; 
       $resultado=$obj_conexion->ConsultarDatos($consulta,$this->basedatos,$conexion);
       $numero_filas=$obj_conexion->ContarFilas($resultado);
        if($numero_filas>0){
            $fila=$obj_conexion->ObtenerDatos($resultado);
            
            $linea_credito_final=$fila['LineaCredito'];
            if($linea_credito_final<="0.00"){
                return "0.00";
            }else{
                return $linea_credito_final;
            }
        }else{
            $obj_conexion->CerrarConexion($conexion);
            return $linea_credito_final;
        }

    }
    
    public function ActualizarLineaCredito($codigo_entidad,$monto_recuperado,$tipo){
       $flag=0;
       $obj_conexion=new ConexionBD();
       $conexion=$obj_conexion->CrearConexion();
       if($tipo==1){
           $consulta="UPDATE Entidad SET Acumulado=(Acumulado+$monto_recuperado) WHERE CodigoEntidad='$codigo_entidad'";        
       }elseif($tipo==2){
           $consulta="UPDATE Entidad SET Acumulado=(Acumulado-$monto_recuperado) WHERE CodigoEntidad='$codigo_entidad'";        
       }
       
       $obj_conexion->ConsultarDatos($consulta,$this->basedatos,$conexion);
       $error=$obj_conexion->ErrorEjecucion($conexion);
        if($error==1){
            $flag=1;
        }
        $obj_conexion->CerrarConexion($conexion);
        return $flag;
    }
    
    public function CambioContrasena($usuario,$contrasena){
        $flag=0;
        $obj_conexion=new ConexionBD();
        $conexion=$obj_conexion->CrearConexion();
        $consulta="UPDATE Personal SET Password='$contrasena', CambioClave=0 WHERE CodigoPersonal=$usuario";
        $obj_conexion->ConsultarDatos($consulta,$this->basedatos,$conexion);
        $error=$obj_conexion->ErrorEjecucion($conexion);
        if($error==1){
            $flag=1;
        }
        $obj_conexion->CerrarConexion($conexion);
        return $flag;
    }
    public function GuardaDelegado($codigo_entidad,$dni,$apep,$apem,$nom,$email,$ofic,$anexo,$celular,$rpm,$depa,$prov,$dist,$password){
        $flag=0;
        $obj_conexion=new ConexionBD();
        $conexion=$obj_conexion->CrearConexion();
        $consulta="INSERT INTO Personal (CodigoEntidad,DNI,ApellidoPaterno,ApellidoMaterno,Nombres,Email,TelefonoOficina,Anexo,Celular,RPC,RPM,Nextel,CodigoTipo,CambioClave,CodigoUsuario,Password,EstadoRegistro,IdDepartamento, IdProvincia, IdDistrito)
                   VALUES ($codigo_entidad,'$dni','$apep','$apem','$nom','$email','$ofic','$anexo','$celular','','$rpm','','D',1,'$dni','$password',1,'$depa','$prov','$dist')";
        $obj_conexion->ConsultarDatos($consulta,$this->basedatos,$conexion);
        $error=$obj_conexion->ErrorEjecucion($conexion);
        if($error==1){
            $flag=1;
        }
        $obj_conexion->CerrarConexion($conexion);
        return $flag;
    }

    public function GuardaGestor($CodigoEntidad,$DNI,$ApellidoPaterno,$ApellidoMaterno,$Nombres,$Email,$Celular,$Password){
        $flag=0;
        $obj_conexion=new ConexionBD();
        $conexion=$obj_conexion->CrearConexion();
        $consulta="INSERT INTO Personal (CodigoEntidad,DNI,ApellidoPaterno,ApellidoMaterno,Nombres,Email,Celular,CodigoTipo,CodigoUsuario,Password,EstadoRegistro)
                   VALUES ($CodigoEntidad,'$DNI','$ApellidoPaterno','$ApellidoMaterno','$Nombres','$Email','$Celular','G','$DNI','$Password',0)";
        $obj_conexion->ConsultarDatos($consulta,$this->basedatos,$conexion);
        $error=$obj_conexion->ErrorEjecucion($conexion);
        if($error==1){
            $flag=1;
        }
        $obj_conexion->CerrarConexion($conexion);
        return $flag;
    }
    
    public function EditarDelegado($codigo_entidad,$dni,$apep,$apem,$nom,$email,$ofic,$anexo,$celular,$rpm,$rpc,$nextel,$estado,$cambio_contrasena,$contrasena){
        $flag=0; 
        $obj_conexion=new ConexionBD();
        $conexion=$obj_conexion->CrearConexion();
        
        $nuevo_password=""; 
        if($contrasena!=''){
            $nuevo_password=",Password='$contrasena'";
        }
        
        $datos_actualizar="";
        $estado_registro="";
        if($apep!=''){
            $datos_actualizar="ApellidoPaterno='$apep' ,ApellidoMaterno='$apem' ,Nombres='$nom' ,Email='$email' ,TelefonoOficina='$ofic' ,Anexo='$anexo' ,Celular='$celular' ,RPC='$rpc' ,RPM='$rpm' ,Nextel='$nextel' , ";
            $estado_registro=", EstadoRegistro=$estado";
            
        }
        $consulta="UPDATE Personal SET $datos_actualizar CambioClave=$cambio_contrasena $nuevo_password $estado_registro
                   WHERE CodigoEntidad=$codigo_entidad AND DNI='$dni' AND CodigoTipo='D'";

        $obj_conexion->ConsultarDatos($consulta,$this->basedatos,$conexion);
        $error=$obj_conexion->ErrorEjecucion($conexion);
        if($error==1){
            $flag=1;
        }
        $obj_conexion->CerrarConexion($conexion);
        return $flag;
    }
    
    public function ConsultarDelegadoDNI($dni,$codigo_entidad){
        $obj_conexion=new ConexionBD();
        $conexion=$obj_conexion->CrearConexion();
        $consulta="SELECT *
                   FROM Personal 
                   WHERE CodigoEntidad=$codigo_entidad AND DNI='$dni' AND CodigoTipo='D'";

        $resultado=$obj_conexion->ConsultarDatos($consulta,$this->basedatos,$conexion);
        $numero_filas=$obj_conexion->ContarFilas($resultado);
        if($numero_filas>0){
            
            $fila=  $obj_conexion->ObtenerDatos($resultado);
            
            $personal = new PersonalEntidad();
            $personal->setCodigoPersonal($fila['CodigoPersonal']);
            $personal->setNombres($fila['Nombres']);
            $personal->setApellidoPaterno($fila['ApellidoPaterno']);
            $personal->setApellidoMaterno($fila['ApellidoMaterno']);
            $personal->setCodigoEntidad($fila['CodigoEntidad']);
            $personal->setCambioClave($fila['CambioClave']);
            $personal->setCodigoTipo($fila['CodigoTipo']);
            $personal->setDNI($fila['DNI']);
            $personal->setEmail($fila['Email']);
            $personal->setTelefonoOficina($fila['TelefonoOficina']);
            $personal->setAnexo($fila['Anexo']);
            $personal->setCelular($fila['Celular']);
            $personal->setRPC($fila['RPC']);
            $personal->setRPM($fila['RPM']);
            $personal->setNextel($fila['Nextel']);
            $personal->setEstadoRegistro($fila['EstadoRegistro']);
            
            $obj_conexion->CerrarConexion($conexion);
            
          return $personal;
        }else{
          return "";
        }
           
    }
    
    public function ObtenerEmailGestor($codigo_entidad){
        $obj_conexion=new ConexionBD();
        $conexion=$obj_conexion->CrearConexion();
        $consulta="SELECT Email
                   FROM Personal 
                   WHERE CodigoEntidad=$codigo_entidad AND CodigoTipo='G' AND EstadoRegistro=1";

        $resultado=$obj_conexion->ConsultarDatos($consulta,$this->basedatos,$conexion);
        $numero_filas=$obj_conexion->ContarFilas($resultado);
        if($numero_filas==1){
            $fila=  $obj_conexion->ObtenerDatos($resultado);
            $email_personal=$fila['Email'];
            $obj_conexion->CerrarConexion($conexion);
          return strtoupper($email_personal);
        }else{
          return "";
        }
           
    }
    
    public function ActivarDesactivarDelegado($dni,$estado){
        $flag=0;
        $obj_conexion=new ConexionBD();
        $conexion=$obj_conexion->CrearConexion();
        $consulta="UPDATE Personal SET EstadoRegistro='$estado' WHERE DNI='$dni' AND CodigoTipo='D'" ;
        $obj_conexion->ConsultarDatos($consulta,$this->basedatos,$conexion);
        $error=$obj_conexion->ErrorEjecucion($conexion);
        if($error==1){
            $flag=1;
        }
        $obj_conexion->CerrarConexion($conexion);
        return $flag;
    }
    
    public function EnvioMailCreacionUser($email,$paterno,$materno,$nombres,$usuario,$clave){
        $mail ="<html>";
        $mail .="<body style='font-family:Trebuchet MS;font-size:13px'>";
        $mail .="<center>";
        $mail .='<div style="border: 1px solid #69778d;width:720px;padding-bottom: 10px;">';
        $mail .="<table width='700' border='0' align='center'>";
        $mail .="<tr><td colspan='2'></td></tr>";
        $mail .="<tr><td  colspan='2' align='center' style='font-size: 18px;'><font color='#4e99bf'><strong>NOTIFICACI&Oacute;N - SISTEMA Web Agencias</strong></font></td></tr>";
        $mail .="<tr><td colspan='2'></td></tr>";
        $mail .="<tr><td colspan='2' bgcolor='#4e99bf'></td></tr>";
        $mail .="<tr><td colspan='2'></td></tr>";
        $mail .="<tr><td colspan='2'></td></tr>";
        $mail .="<tr><td colspan='2'><p>Estimado Sr(a). <font color='#080897'><strong>$paterno $materno, $nombres</strong></font>, en virtud de su acreditaci&oacute;n como <font color='#080897'><strong>DELEGADO</strong></font>, se le informa que <font color='#080897'><strong>STARPERU</strong></font> ha generado el registro correcto del Usuario <font color='#080897'><strong>DELEGADO: $paterno $materno , $nombres</strong></font>, y el <font color='#080897'><strong>USUARIO: ".$usuario."</strong></font>"." <font color='#000000'>para el acceso al</font> "."<font color='#000000'><strong>SISTEMA DE COMPRA DE PASAJES - Web Agencias</strong></font>.</p></td></tr>";
        $mail .="<tr><td colspan='2'></td></tr>";
        $mail .="<tr><td colspan='2'></td></tr>";
        $mail .="<tr><td colspan='2'><font color='#080897'><strong>DELEGADO :</strong></font></td></tr>";
        $mail .=" <tr><td colspan='2' bgcolor='#4e99bf'></td></tr>";
        $mail .="<tr><td width='178'><font color='#33333'><strong>Entidad:</strong></font></td><td width='512'><font color='#33333'><strong>Web Agencias</strong></font></td></tr>";
        $mail .="<tr><td><font color='#33333'><strong>Delegado:</strong></font></td><td><font color='#33333'><strong>$paterno $materno, $nombres</strong></font></td></tr>";
        $mail .="<tr><td><font color='#33333'><strong>Usuario de Acceso:</strong></font></td><td><font color='#080897'><strong>$usuario</strong></font></td></tr>";
        $mail .="<tr><td><font color='#33333'><strong>Password:</strong></font></td><td><font color='#080897'><strong>$clave</strong></font></td></tr>";
        $mail .="<tr><td colspan='2' bgcolor='#4e99bf'></td></tr>";
        $mail .="<tr><td colspan='2'></td></tr>";
        $mail .="<tr><td colspan='2'></td></tr>";
        $mail .="<tr><td colspan='2' style='font-size: 14px;'><font color='#000000'><strong>Se le recuerda que al ingresar por primera vez al SISTEMA se le solicitar&aacute; el cambio de su password.</strong></font></td></tr>";
        $mail .="</table>";
        $mail .="</div>";
        $mail .="</center>";
        $mail .="</body>";
        $mail .="</html>";
        
        $email.= ", ".$_SESSION['s_email'].",carlos.gutierrez@starperu.com";
        $remitente ="ecel@starperu.com";
        $to=$email;
        $subject='Web Agencias - Notificacion de Registro';
        $message=$mail;
        $cabeceras = "Content-type: text/html; charset=UTF-8\r\n"; 
        $cabeceras.= "From: Web Agencias <$remitente>\r\n";
        mail($to, $subject,$message,$cabeceras ); 
   }
   
   
    public function EnvioMailResetPassword($email,$paterno,$materno,$nombres,$usuario,$clave){
        $mail ="<html>";
        $mail .="<body style='font-family:Trebuchet MS;font-size:13px'>";
        $mail .="<center>";
        $mail .='<div style="border: 1px solid #69778d;width:720px;padding-bottom: 10px;">';
        $mail .="<table width='700' border='0' align='center'>";
        $mail .="<tr><td colspan='2'></td></tr>";
        $mail .="<tr><td  colspan='2' align='center' style='font-size: 18px;'><font color='#4e99bf'><strong>NOTIFICACI&Oacute;N - SISTEMA Web Agencias</strong></font></td></tr>";
        $mail .="<tr><td colspan='2'></td></tr>";
        $mail .="<tr><td colspan='2' bgcolor='#4e99bf'></td></tr>";
        $mail .="<tr><td colspan='2'></td></tr>";
        $mail .="<tr><td colspan='2'></td></tr>";
        $mail .="<tr><td colspan='2'><p>Estimado Sr(a). <font color='#080897'><strong>$paterno $materno, $nombres</strong></font>, en virtud de su acreditaci&oacute;n como <font color='#080897'><strong>DELEGADO</strong></font>, se le informa que <font color='#080897'><strong>STARPERU</strong></font> ha realizado correctamente el cambio de clave del Usuario <font color='#080897'><strong>DELEGADO: $paterno $materno , $nombres</strong></font>, y el <font color='#080897'><strong>USUARIO: ".$usuario."</strong></font>"." <font color='#000000'>para el acceso al</font> "."<font color='#000000'><strong>SISTEMA DE COMPRA DE PASAJES - Web Agencias</strong></font>.</p></td></tr>";
        $mail .="<tr><td colspan='2'></td></tr>";
        $mail .="<tr><td colspan='2'></td></tr>";
        $mail .="<tr><td colspan='2'><font color='#080897'><strong>DELEGADO :</strong></font></td></tr>";
        $mail .=" <tr><td colspan='2' bgcolor='#4e99bf'></td></tr>";
        $mail .="<tr><td width='178'><font color='#33333'><strong>Entidad:</strong></font></td><td width='512'><font color='#33333'><strong>Web Agencias</strong></font></td></tr>";
        $mail .="<tr><td><font color='#33333'><strong>Delegado:</strong></font></td><td><font color='#33333'><strong>$paterno $materno, $nombres</strong></font></td></tr>";
        $mail .="<tr><td><font color='#33333'><strong>Usuario de Acceso:</strong></font></td><td><font color='#080897'><strong>$usuario</strong></font></td></tr>";
        $mail .="<tr><td><font color='#33333'><strong>Password:</strong></font></td><td><font color='#080897'><strong>$clave</strong></font></td></tr>";
        $mail .="<tr><td colspan='2' bgcolor='#4e99bf'></td></tr>";
        $mail .="<tr><td colspan='2'></td></tr>";
        $mail .="<tr><td colspan='2'></td></tr>";
        $mail .="<tr><td colspan='2' style='font-size: 14px;'><font color='#000000'><strong>Se le recuerda que al ingresar por primera vez al SISTEMA se le solicitar&aacute; el cambio de su password.</strong></font></td></tr>";
        $mail .="</table>";
        $mail .="</div>";
        $mail .="</center>";
        $mail .="</body>";
        $mail .="</html>";

        $email.= ", "."carlos.gutierrez@starperu.com";
        $remitente ="ecel@starperu.com";
        $to=$email;
        $subject='Web Agencias - Notificacion de Cambio de Clave';
        $message=$mail;
        $cabeceras = "Content-type: text/html; charset=UTF-8\r\n"; 
        $cabeceras.= "From: Web Agencias <$remitente>\r\n";
        mail($to, $subject,$message,$cabeceras ); 
   }
   

   public function encrypt($string, $key) {
           $result = '';
           for($i=0; $i<strlen($string); $i++) {
              $char = substr($string, $i, 1);
              $keychar = substr($key, ($i % strlen($key))-1, 1);
              $char = chr(ord($char)+ord($keychar));
              $result.=$char;
           }
           return base64_encode($result);
   }

   public function decrypt($string, $key) {
            $result = '';
            $string = base64_decode($string);
            for($i=0; $i<strlen($string); $i++) {
               $char = substr($string, $i, 1);
               $keychar = substr($key, ($i % strlen($key))-1, 1);
               $char = chr(ord($char)-ord($keychar));
               $result.=$char;
            }
            return $result;
     }
    
     public function obtenerDepartamentos(){
        $obj_conexion=new ConexionBD();
        $conexion=$obj_conexion->CrearConexion();
        $consulta="SELECT id,name FROM regions";
        $resultado=$obj_conexion->ConsultarDatos($consulta,$this->basedatos,$conexion);
        return $resultado;
     }
     
     public function obtenerProvincias($id_depa){
        $obj_conexion=new ConexionBD();
        $conexion=$obj_conexion->CrearConexion();
        $consulta="SELECT id,name FROM provinces WHERE region_id='$id_depa'";
        $resultado=$obj_conexion->ConsultarDatos($consulta,$this->basedatos,$conexion);
        return $resultado;
     }
     
     public function obtenerDistritos($id_prov){
        $obj_conexion=new ConexionBD();
        $conexion=$obj_conexion->CrearConexion();
        $consulta="SELECT id,name FROM districts WHERE province_id='$id_prov'";
        $resultado=$obj_conexion->ConsultarDatos($consulta,$this->basedatos,$conexion);
        return $resultado;
     }

    public function generaPassword()
    {
        //Se define una cadena de caractares. Te recomiendo que uses esta.
        $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
        //Obtenemos la longitud de la cadena de caracteres
        $longitudCadena=strlen($cadena);
        //Se define la variable que va a contener la contraseña
        $pass = "";
        //Se define la longitud de la contraseña, en mi caso 10, pero puedes poner la longitud que quieras
        $longitudPass=6;
        //Creamos la contraseña
        for($i=1 ; $i<=$longitudPass ; $i++){
            //Definimos numero aleatorio entre 0 y la longitud de la cadena de caracteres-1
            $pos=rand(0,$longitudCadena-1);
            //Vamos formando la contraseña en cada iteraccion del bucle, añadiendo a la cadena $pass la letra correspondiente a la posicion $pos en la cadena de caracteres definida.
            $pass .= substr($cadena,$pos,1);
        }
        return $pass;
    }
     
}


?>

