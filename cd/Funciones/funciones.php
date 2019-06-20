<?php
function array_envia($array) {

     $tmp = serialize($array);
     $tmp = urlencode($tmp);

     return $tmp;
} 
function array_recibe($url_array) {
     $tmp = stripslashes($url_array);
     $tmp = urldecode($tmp);
     $tmp = unserialize($tmp);

    return $tmp;
} 
function ValidarSesion(){
    if($_SESSION['entra']==0){
       header('Location:../../index.htm');
    }
}

function ObtenerFechaActual(){
    $fecha = date("Y-m-d");
    echo $fecha;
}

function strtoproper($string) {
	$words = explode(" ", $string);
	for ($i=0; $i<count($words); $i++) {
		$s = strtolower($words[$i]);
		$s = substr_replace($s, strtoupper(substr($s, 0, 1)), 0, 1);
		$result .= "$s ";
	}
	$string = trim($result);
	return $string;
}

function comprobar_clave($nombre_usuario){ 
   $n = 0;
   for ($b=0; $b<strlen($nombre_usuario); $b++){ 
   	$pos=substr($nombre_usuario,$b,1)	; 
	  if(is_numeric($pos)){	  	
	  $n++;		
	  }  
   }
   if ($n<2){
   return false;
   }
   return true; 
} 

function comprobar_clave1($nombre_usuario){ 
        if(is_numeric($nombre_usuario)){	
            return false;	
	} 
	return true; 
}

function ObtenerIP(){
    $ip =$_SERVER["REMOTE_ADDR"];
    echo $ip;
}

function encrypt($string, $key) {
   $result = '';
   for($i=0; $i<strlen($string); $i++) {
      $char = substr($string, $i, 1);
      $keychar = substr($key, ($i % strlen($key))-1, 1);
      $char = chr(ord($char)+ord($keychar));
      $result.=$char;
   }
   return base64_encode($result);
}

function decrypt($string, $key) {
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

function EnvioMailCreacionUser($userLogin,$email,$paterno,$materno,$nombres,$usuario,$clave)
	{
		$mail ="<html><body style='font-family:Trebuchet MS;font-size:13px'>";
		$mail.="<table width='700' border='0' align='center'>
				  <tr><td bgcolor='#666666' colspan='2'><font color='#FFFFFF'><strong>NOTIFICACION - SISTEMA CONVENIO MARCO</strong></font></td></tr>
		            <tr><td colspan='2'><p>Estimado Sr(a). $userLogin, envirtud de su acreditacion como GESTOR, se le informa que STARPERU ha generado el registro correcto del Usuario DELEGADO: $paterno $materno , $nombres, y el USUARIO: $usuario para el acceso al sistema de compra de pasajes - CONVENIO MARCO.</p></td></tr>
		            <tr><td colspan='2'></td></tr>
		            <tr><td colspan='2'>DELEGADO</td></tr>
		            <tr><td colspan='2' bgcolor='#666666'>&nbsp;</td></tr>
		            <tr><td width='178'>Entidad:</td><td width='512'>Convenio Marco</td></tr>
		            <tr><td>Delegado:</td><td>$paterno $materno, $nombres</td></tr>
		            <tr><td>Usuario de Acceso:</td><td>$usuario</td></tr>
		            <tr><td>Password Default:</td><td>$clave</td></tr>
	            </table>";
	    
	    $email.= ", "."ecel@starperu.com";
	    $remitente ="ecel@starperu.com";
		$to=$email;
		$subject='Convenio Marco - Notificacion de Registro';
		$mail.="</body></html>";
		$message=$mail;
		$cabeceras = "Content-type: text/html\r\n"; 
		$cabeceras.= "From: Convenio Marco <$remitente>\r\n";
		mail($to, $subject,$message,$cabeceras );
	}

 function generaPass()
{
	//Se define una cadena de caractares. Te recomiendo que uses esta.
	$cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
	//Obtenemos la longitud de la cadena de caracteres
	$longitudCadena=strlen($cadena);
	//Se define la variable que va a contener la contraseña
	$pass = "";
	//Se define la longitud de la contraseña, en mi caso 10, pero puedes poner la longitud que quieras
	$longitudPass=8;
	//Creamos la contraseña
	for($i=1 ; $i<=$longitudPass ; $i++){
	//Definimos numero aleatorio entre 0 y la longitud de la cadena de caracteres-1
	$pos=rand(0,$longitudCadena-1);
	//Vamos formando la contraseña en cada iteraccion del bucle, añadiendo a la cadena $pass la letra correspondiente a la posicion $pos en la cadena de caracteres definida.
	$pass .= substr($cadena,$pos,1);
	}
	return $pass;
}

function hoy() {
   $ames = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Setiembre","Octubre","Noviembre","Diciembre");
   $mes = date('m');
   $cmes = $ames[$mes-1]; 
   $dia = date('d');
   $anio = date('Y');
   $cfecha = "$dia, de $cmes del $anio";
   return $cfecha;
}

function meshoy($fecha) {
   $fecha = getdate(time());   
   $ames = array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SETIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
   $cmes = $ames[$fecha["mon"]-1];   
   $cfecha = "$cmes";
   return $cfecha;
}
function meses() {
     
   $ames = array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SETIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
   foreach($ames as $k=>$c){
   return $c."<br>";
   }
   /*$cmes = $ames[$fecha["mon"]-1];   
   $cfecha = "$cmes";
   return $cfecha;*/
}
function getNumCeros($nNum)
  {
    $Num="0000000".$nNum;
    $PosiIni=(strlen($Num)-7);
    return substr($Num,$PosiIni,7);
  }  
  function extaerfechanormal($fecha)
  {
  $fec=substr($fecha,8,2)."/".substr($fecha,5,2)."/".substr($fecha,0,4);
  return $fec;
  }
   function extaerfechamysql($fecha)
  {
  $fec=substr($fecha,6,4)."/".substr($fecha,3,2)."/".substr($fecha,0,2);
  return $fec;
  }
  
function FormatearFecha($dia,$mes) {
	$month = array(
		'1' => 'JAN',
		'2' => 'FEB',
		'3' => 'MAR',
		'4' => 'APR',
		'5' => 'MAY',
		'6' => 'JUN',
		'7' => 'JUL',
		'8' => 'AUG',
		'9' => 'SEP',
		'10' => 'OCT',
		'11' => 'NOV',
		'12' => 'DEC');
	return "$dia$month[$mes]";
}

function caracter_especial($string) {
$buscado = array('á', 'é', 'í', 'ó', 'ú','ñ');
$reemplazo = array('Á', 'É', 'Í', 'Ó', 'Ú','Ñ');
$string=strtoupper($string);
return str_replace($buscado, $reemplazo, $string);
}
function caracter_especial2($string) {
$buscado = array('á', 'é', 'í', 'ó', 'ú','ñ');
$reemplazo = array('A', 'E', 'I', 'O', 'U','N');
$string=strtoupper($string);
return str_replace($buscado, $reemplazo, $string);
}

function rellenar_ceros($string,$nroceros){
    $nuevo_string=str_pad($string, $nroceros, '0', STR_PAD_LEFT); 
    return $nuevo_string;
}


 function generaPass_gestor()
{
	//Se define una cadena de caractares. Te recomiendo que uses esta.
	$cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
	//Obtenemos la longitud de la cadena de caracteres
	$longitudCadena=strlen($cadena);
	//Se define la variable que va a contener la contraseña
	$pass = "";
	//Se define la longitud de la contraseña, en mi caso 10, pero puedes poner la longitud que quieras
	$longitudPass=4;
	//Creamos la contraseña
	for($i=1 ; $i<=$longitudPass ; $i++){
	//Definimos numero aleatorio entre 0 y la longitud de la cadena de caracteres-1
	$pos=rand(0,$longitudCadena-1);
	//Vamos formando la contraseña en cada iteraccion del bucle, añadiendo a la cadena $pass la letra correspondiente a la posicion $pos en la cadena de caracteres definida.
	$pass .= substr($cadena,$pos,1);
	}
	return $pass;
}


function resta_fechas($fecha){
    //defino fecha 1
$date = date_create($fecha);

$ano1=date_format($date, 'Y');
$mes1=date_format($date, 'm');
$dia1=date_format($date, 'd');
//defino fecha 2
$ano2=date('Y');
$mes2=date('m');
$dia2=date('d');
//calculo timestam de las dos fechas
$timestamp1 = mktime(0,0,0,$mes1,$dia1,$ano1);
$timestamp2 = mktime(4,12,0,$mes2,$dia2,$ano2);
//resto a una fecha la otra
$segundos_diferencia = $timestamp1 - $timestamp2;
//echo $segundos_diferencia;

//convierto segundos en días
$dias_diferencia = $segundos_diferencia / (60 * 60 * 24);

//obtengo el valor absoulto de los días (quito el posible signo negativo)
$dias_diferencia = abs($dias_diferencia);

//quito los decimales a los días de diferencia
$dias_diferencia = floor($dias_diferencia);

return $dias_diferencia;
}

function resta_fechas2($fecha_inicio,$fecha_fin){
    //defino fecha 1
$date = date_create($fecha_inicio);

$ano1=date_format($date, 'Y');
$mes1=date_format($date, 'm');
$dia1=date_format($date, 'd');

////defino fecha 2
$date1=date_create($fecha_fin);
$ano2=date_format($date1, 'Y');
$mes2=date_format($date1, 'm');
$dia2=date_format($date1, 'd');

//return $ano2.' '.$mes2.' '.$dia2;
////calculo timestam de las dos fechas
$timestamp1 = mktime(0,0,0,$mes1,$dia1,$ano1);
$timestamp2 = mktime(0,0,0,$mes2,$dia2,$ano2);
////resto a una fecha la otra
$segundos_diferencia = $timestamp1 - $timestamp2;
////echo $segundos_diferencia;
//
////convierto segundos en días
$dias_diferencia = $segundos_diferencia / (60 * 60 * 24);
//
////obtengo el valor absoulto de los días (quito el posible signo negativo)
$dias_diferencia = abs($dias_diferencia);
//
////quito los decimales a los días de diferencia
$dias_diferencia = floor($dias_diferencia);

return $dias_diferencia;
}
function generaClaveReporteSGSO($longitud)
{
	//Se define una cadena de caractares. Te recomiendo que uses esta.
	$cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	//Obtenemos la longitud de la cadena de caracteres
	$longitudCadena=strlen($cadena);
	//Se define la variable que va a contener la contraseña
	$clave = "";
	//Creamos la contraseña
	for($i=1 ; $i<=$longitud ; $i++){
	//Definimos numero aleatorio entre 0 y la longitud de la cadena de caracteres-1
	$pos=rand(0,$longitudCadena-1);
	//Vamos formando la contraseña en cada iteraccion del bucle, añadiendo a la cadena $pass la letra correspondiente a la posicion $pos en la cadena de caracteres definida.
	$clave .= substr($cadena,$pos,1);
	}
	return $clave;
}


function EnviarCorreoSGSO($codigoReporte){
                      $para    = 'gino.cavero@starperu.com'.',';
                      $para   .= 'eliseo.salcedo@starperu.com'.',';
                      $para   .= 'safety@starperu.com'; 
                   /* $para = 'ricardo.urbano@starperu.com';*/
                    $asunto = utf8_decode("REGISTRO DE REPORTE - SGSO");
                    $mensaje = '<html>
                                    <head>
                                      <title></title>
                                    </head>
                                    <body>
                                    <CENTER>
                                      <H2><B>' . utf8_decode("SE REGISTRÓ UN NUEVO REPORTE DE SEGURIDAD OPERACIONAL") . '</B></H2>
                                      <p><B>' . utf8_decode("CÓDIGO DE VERIFICACIÓN") . '</B></p>
                                      <p>' . utf8_decode($codigoReporte) . '</p>
                                    </CENTER>
                                    </body>
                                    </html>';

                    // Para enviar un correo HTML mail, la cabecera Content-type debe fijarse
                    $cabeceras = 'MIME-Version: 1.0' . "\r\n";
                    $cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                    // Cabeceras adicionales
                    $cabeceras .= 'From:' . utf8_decode("STARPANEL - SGSO") . ' <ecel@starperu.com>' . "\r\n";
                    $cabeceras .= 'Bcc: ecel@starperu.com' . "\r\n";
                    $cabeceras .= 'Reply-To: ecel@starperu.com' . "\r\n" .
                            'X-Mailer: PHP/' . phpversion();

                    mail($para, $asunto, $mensaje, $cabeceras);
}


function diferencia_horas_vuelo($fecha_salida_vuelo, $fecha_sistema){
        $fechaIni = $fecha_salida_vuelo;
        $fechaFin = $fecha_sistema;

        // separo las partes de cada fecha
        list($iniDia, $iniHora) = split(" ", $fechaIni);
        list($anyo, $mes, $dia) = split("-", $iniDia);
        list($hora, $min, $seg) = split(":", $iniHora);
        $tiempoIni = mktime($hora + 0, $min + 0, $seg + 0, $mes + 0, $dia + 0, $anyo);

        // hago lo mismo para obtener el $tiempoFin
        list($finDia, $finHora) = split(" ", $fechaFin);
        list($anyo, $mes, $dia) = split("-", $finDia);
        list($hora, $min, $seg) = split(":", $finHora);
        $tiempoFin = mktime($hora + 0, $min + 0, $seg + 0, $mes + 0, $dia + 0, $anyo);

        // al restar los valores, obtenemos los SEGUNDOS de diferencia
        $diferencia =$tiempoIni-$tiempoFin;

//        print "<br>Ini : ".$fechaIni;
//        print "<br>Fin : ".$fechaFin;
//        print "<br>Dif : ".$diferencia." segundos (".($diferencia / 60)." minutos)"; 
        $minutos = ($diferencia / 60);
        return $minutos;
}

function ordenar_tarifas_kiu($array,$campo, $inverse=false){
        $position = array();  
        $newRow = array();  
        foreach ($array as $key => $row) {  
            $position[$key]  = $row[$campo];  
            $newRow[$key] = $row;  
        }  
        if ($inverse) {  
            arsort($position);  
        }else{  
            asort($position);  
        }  
        $returnArray = array(); 
        
        $i=0;
        $c=0;
        foreach ($position as $key => $pos){  
                $returnArray[] = $newRow[$key];  
                if($i>0){
                    for($j=0;$j<count($returnArray);$j++){
                       if($returnArray[$i]['tarifa']==$returnArray[$j]['tarifa'] && $returnArray[$i]['clase']==$returnArray[$j]['clase']){
                        $c++;
                        if($c>1){
                            array_pop($returnArray);
                            $i--;
                        }
                    } 
                  }
                }
           $c=0;
          $i++;      
        }  
        return $returnArray;  
    }
?>
