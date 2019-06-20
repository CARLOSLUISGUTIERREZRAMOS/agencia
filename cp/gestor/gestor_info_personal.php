<?php 
session_start();
error_reporting(E_ALL);
ini_set("display_errors",0);
date_default_timezone_set('America/Lima');
if($_SESSION['s_entra']==0){
    header('Location:../../index.php');
}
$Tipo=$_SESSION['s_tipo'];
$directorio='../';
$directorio_imagen='../';
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>M&oacute;dulo Corporativo</title>
<link href="../images/favicon_starperu.png" rel="shortcut icon" />
<link href="../css/modulo.css" rel="stylesheet" type="text/css" />
<link href="../css/gestor.css" rel="stylesheet" type="text/css" />
<script src="../js/jquery/jquery-1.8.0.min.js"></script>
<script type="text/javascript">
    
 function getLineaCredito(){   
                
                var mensaje_linea_credito=0;
                var codigo_entidad=<?php echo $_SESSION["s_entidad"];?>;

                $.ajax({
                        url:"../../cd/Controlador/MovimientoControl.php",
                        type: "POST", 
                        data:"obtener_linea_credito=1&codigo_entidad"+codigo_entidad,
                        
                        success: function(mensaje){
                                    
                                      mensaje_linea_credito=parseFloat($.trim(mensaje)).toFixed(2); 
                                      $("#loadLinea").html('USD '+mensaje_linea_credito);  
                                 },

                });
            }


function LineaCredito(){    
    getLineaCredito();
    setInterval("getLineaCredito()", 1000);   
}
</script>
</head>
<body onLoad=" LineaCredito();" >
<div id="div-main"> 
    <?php include('../includes/cabecera.php'); ?>
    <div id="div-contenido" style="background:none;">
    <?php include('../includes/menu.php'); ?>
	<div style="margin: 0px auto;width: 1000px;height: 350px;">
              <!-- Div Credito Personal -->
                        <div style="position: absolute; height: 60px; top: 0px; left: 42%; right: 42%">
                                <table width="160" cellpadding="0" cellspacing="0" border="0" style=" background-color: #F0F0F0;color: #dd1414">
                                    <tr style="">
                                        <td height="25" align="center" class="gradiante" style="color:white;font-family: Arial,Helvetica,sans-serif;font-weight: bold;font-size: 13px;"> 
                                            L&iacute;nea de cr&eacute;dito
                                        </td>
                                    </tr>
                                    <tr><td height="3"   style="background:#fdb813;"></td></tr>
                                    <tr><td id="loadLinea" height="35" align="center" style="font-size: 16px;font-weight: bold;"></td></tr>
                                </table>
                         </div>
             <!-- fin div Credito Personal -->
              <br>
              <br>
              <div id="div-gestor">
                <table  width="900" border="0" cellpadding="0" cellspacing="0" style="margin: 0px auto;background-color: #F0F0F0;">
                    <tr>
                        <td height="26" colspan="4" class="gradiante" style="color:white;font-size: 13px;padding: 0px 5px;margin: 0px;font-weight: bold;">Gestor - Datos Personales</td>
                    </tr>
                    <tr>
                        <td height="3" colspan="4"  style="background:#fdb813;"></td>
                    </tr>
                     <tr>
                        <td height="10" colspan="4"  ></td>
                    </tr>
                    <tr>
                    	<td  class="label_info">DNI:</td><td class="span_info"><?php if($_SESSION['s_dni']!=''){ echo $_SESSION['s_dni'];}else{ echo '<span style="font-style:italic;">[informaci&oacute;n no disponible]</span>';}?></td>
                    </tr>
                    <tr>
                            <td class="label_info">apellido paterno:</td><td class="span_info"><?php if($_SESSION['s_apellido_paterno']!=''){ echo utf8_encode($_SESSION['s_apellido_paterno']);}else{ echo '<span style="font-style:italic;">[informaci&oacute;n no disponible]</span>';}?></td>
                           
                    </tr>
                	<tr>
                    	<td class="label_info">apellido materno:</td><td class="span_info"><?php if($_SESSION['s_apellido_materno']!=''){ echo utf8_encode($_SESSION['s_apellido_materno']);}else{ echo '<span style="font-style:italic;">[informaci&oacute;n no disponible]</span>';}?></td>
                       
                    </tr>
	            <tr>
                    	<td class="label_info">nombre:</td><td class="span_info"><?php if($_SESSION['s_nombre']!=''){ echo utf8_encode($_SESSION['s_nombre']);}else{ echo '<span style="font-style:italic;">[informaci&oacute;n no disponible]</span>';}?></td>
                        
                    </tr>
                    <tr>
                    	<td class="label_info">email:</td><td class="span_info"><?php if($_SESSION['s_email']!=''){ echo $_SESSION['s_email'];}else{ echo '<span style="font-style:italic;">[informaci&oacute;n no disponible]</span>';}?></td>
                        
                    </tr>
                     <tr>
                        <td height="10" colspan="4"  ></td>
                    </tr>
                </table>
                  <br>
                  <table width="900" border="0" cellpadding="0" cellspacing="0" style="margin: 0px auto;background-color: #F0F0F0;">
                    <tr>
                        <td height="26" colspan="4" class="gradiante" style="color:white;font-size: 13px;padding: 0px 5px;margin: 0px;font-weight: bold;">Gestor - Datos Adicionales</td>
                    </tr>
                    <tr>
                        <td height="3" colspan="4"  style="background:#fdb813;"></td>
                    </tr>
                     <tr>
                        <td height="10" colspan="4"  ></td>
                    </tr>
                    <tr>
                    	<td class="label_info">tel&eacute;fono fijo:</td><td class="span_info"><?php if($_SESSION['s_telefono_fijo']!=''){ echo $_SESSION['s_telefono_fijo'];}else{ echo '<span style="font-style:italic;">[informaci&oacute;n no disponible]</span>';}?></td>
                    </tr>
                    <tr>
                    	<td class="label_info">anexo:</td><td class="span_info"><?php if($_SESSION['s_anexo']!=''){ echo $_SESSION['s_anexo'];}else{ echo '<span style="font-style:italic;">[informaci&oacute;n no disponible]</span>';}?></td>
                    </tr>
                    <tr>
                           <td class="label_info">celular:</td><td class="span_info"><?php if($_SESSION['s_celular']!=''){ echo $_SESSION['s_celular'];}else{ echo '<span style="font-style:italic;">[informaci&oacute;n no disponible]</span>';}?></td>
                    </tr>
                    <tr>
                    	<td class="label_info">RPM:</td><td class="span_info"><?php if($_SESSION['s_rpm']!=''){ echo $_SESSION['s_rpm'];}else{ echo '<span style="font-style:italic;">[informaci&oacute;n no disponible]</span>';}?></td>
                    </tr>
	            <tr>
                    	<td class="label_info">RPC:</td><td class="span_info"><?php if($_SESSION['s_rpc']!=''){ echo $_SESSION['s_rpc'];}else{ echo '<span style="font-style:italic;">[informaci&oacute;n no disponible]</span>';}?></td>
                    </tr>
                    <tr>
                    	<td class="label_info">nextel:</td><td class="span_info"><?php if($_SESSION['s_nextel']!=''){ echo $_SESSION['s_nextel'];}else{ echo '<span style="font-style:italic;">[informaci&oacute;n no disponible]</span>';}?></td>
                    </tr>
                     <tr>
                        <td height="10" colspan="4"  ></td>
                    </tr>
                </table>
              </div>
        </div>
    </div>
</div>
</body>
</html>