<?php 
session_start();
error_reporting(E_ALL);
ini_set("display_errors",0);
date_default_timezone_set('America/Lima');
if($_SESSION['s_entra']==0){
    header('Location:../../index.php');
}
require_once '../../cd/Controlador/PasarelaControl.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!--<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">-->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
<title></title>
<link href="css/style.css" rel="stylesheet" type="text/css" media="all">
<!--[if lt IE 9]><link rel="stylesheet" href="css/ie.css" type="text/css" media="screen, projection"><![endif]-->
<link type="text/css" href="css/jquery/jquery.ui.all.css" rel="stylesheet" />
<script type="text/javascript" language="javascript1.2" src="js/funciones.js"></script>
<script language="javascript1.2" type="text/javascript">
<!--
function EnviaValores()
{	
	var v_tarifa_adulto=trim(dgEBI('tarifa_adulto'));	
	var v_tarifa_tuua=trim(dgEBI('tarifa_tuua'));
	var v_tarifa_igv=trim(dgEBI('tarifa_igv'));
	
	document.getElementById("btnAceptar").style.display="none";
	document.getElementById("div_aviso_show").style.display="inline";

	if(v_tarifa_adulto.length>0 && v_tarifa_tuua.length>0 && v_tarifa_igv.length>0 )
	{
		document.form1.submit();
	}
	else
	{
		document.getElementById('resultado').innerHTML='* Ocurri&oacute; un error al generar las tarifas, no puede seguir con su reserva.';
	}
}
-->
</script>
<link href="css/estilos.css" rel="stylesheet" type="text/css" />
<style>
.gradiante{
    background: linear-gradient(#f01515, darkred) !important;
    background: -webkit-linear-gradient(#f01515, darkred) !important;
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#f01515', endColorstr='darkred');
}
</style>
</head>
<body class="waiting"> 
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" style="background-color: #FFFFFF">
        <tr>
             <td>&nbsp;</td>
        </tr>
        <tr>
              <td height="50" align="center">
                <table id="menu_vuelo" cellpadding="0" cellspacing="0" border="0">
                      <tr>
                              <td height="19"><a style="color:#323131;"  href="paso1.php" title="Ir al Paso 1">1. FECHA</a></td>
                              <td width="4"></td>
                              <td width="89" style="background-image: url(images/line_off.png); background-repeat: repeat-x"></td>
                              <td width="30"></td>
                              <td><a style="color:#323131;" href="paso2.php" title="Volver al Paso 2">2. VUELOS</a></td>
                              <td width="4"></td>
                              <td width="89" style="background-image: url(images/line_off.png); background-repeat: repeat-x"></td>
                              <td width="30"></td>
                              <td class="activo">3. PRECIO</td>
                              <td width="4"></td>
                              <td width="89" style="background-image: url(images/line_off.png); background-repeat: repeat-x"></td>
                              <td width="30"></td>
                              <td>4. PASAJEROS</td>
                              <td width="4"></td>
                              <td width="89" style="background-image: url(images/line_off.png); background-repeat: repeat-x"></td>
                              <td width="30"></td>
                              <td>5. CONFIRMACI&Oacute;N</td>
                      </tr>
               </table>
             </td>
        </tr>
	<tr>
	      <td height="320" align="center" style="background-color: #FFFFFF">
                <form id="form1" name="form1" method="post" action="paso4.php" autocomplete="off" >
                    
                     <?php 
                     if($tipo_viaje_3==1){
                         if($fecha_hora_salida_vuelta <= $fecha_hora_salida_ida){
                       
                               echo '<span style="color:red; text-align:left; font-size:16px;">'
                                . '         La Fecha y Hora de Retorno no debe ser menor a la Fecha y Hora de Ida.<br/>'
                                . '         Por favor regrese al paso anterior y seleccione otro vuelo.'
                                . '</span>';
                               die;
                         }
                     }
//                     else{
                     if($_SESSION['total_pagar']>0){ ?>
                    <table width="900" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                                <td colspan="7"  height="1"  style="background: #323131;"></td>
                          </tr> 
                           <tr>
                                <td colspan="7" align="left" height="30" class="titleTable" style="color:#323131;font-size: 24px;background: #f0f0f0;font-family:Tahoma, Geneva, sans-serif; ">Paso 3</td>
                          </tr>
                           <tr>
                                <td colspan="7"  height="1"  style="background: #323131;"></td>
                          </tr>  
                        <tr>
                            <td height="10" >&nbsp;</td>
                        </tr>
                      <tr>
                          <td colspan="2">
                               <?php echo $_SESSION['table_cabecera'];?>   
                            </td>
                      </tr>
                      <tr>
                        <td height="30"  colspan="2"></td>
                      </tr>
                      <tr>
                        <td  colspan="2">
                            <?php echo $_SESSION['table_precio'];?>
                        </td>
                      </tr>
                        <tr>
                        <td  height="20" colspan="2"></td>
                      </tr>
                     
                        <tr>
                        <td height="70" width="600"  align="left">
                            <table width="600" height="70" border="0" cellpadding="0" cellspacing="0" style="border: 1px solid #DCE0EE; background-color: #F0F0F0">
                                <tr>
                                    <td  width="600"  align="left"  style="padding-left: 10px;">
                                        El TUUA es la tasa de uso de aeropuerto y es incluido en el boleto s&oacute;lo de algunos destinos. Los impuestos son determinados por el gobierno peruano y est&aacute;n sujetos a cambio sin previo aviso.
                                    </td>
                                </tr>
                            </table>
                        </td>
                          <td align="right" > <?php echo $_SESSION['mensaje'];
                         ?>
                            <input <?php echo $_SESSION['puede'];?> name="btnAceptar" id="btnAceptar" value="Continuar" class="btn-red" type="submit" />
                        
                        </td>
                      </tr>
                       
                      <tr>
                        <td height="10"  colspan="2"></td>
                      </tr>
                      <tr>
                        <td align="right"  colspan="2">
                         <?php echo $_SESSION['hide_paso3']; ?>
                        </td>
                      </tr>
                    </table>
                     <?php }else{
                                echo '<span style="color:red; text-align:left; font-size:16px;">'
                                . '         Sugió un problema con la disponibilidad de tarifas.<br/>'
                                . '         Por favor regrese al paso anterior y seleccione otro vuelo.'
                                . '</span>';
                        }
//                     }
                     ?>
                  </form>
	      </td>
        </tr>
</table>
</body>
</html>