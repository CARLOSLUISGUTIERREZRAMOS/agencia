<?php 
session_start();
error_reporting(E_ALL);
ini_set("display_errors",0);
date_default_timezone_set('America/Lima');
if($_SESSION['s_entra']==0){
    header('Location:../../index.php');
}
require_once("../../cd/Controlador/DelegadoControl.php");
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
<script src="../js/ajax/funcionesGestorDelegado.js"></script>
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
                            }
           });
}


function LineaCredito(){    
    getLineaCredito();
    setInterval("getLineaCredito()", 1000);   
}
</script>
</head>
<body onLoad=" LineaCredito();">
<div id="div-main">
    <?php include('../includes/cabecera.php'); ?>
    
    <div id="div-contenido" style="background:none;">
       <?php  include('../includes/menu.php'); ?>
         <!-- Div Credito Personal -->
                <div style="position: absolute; height: 60px; top: 0px; left: 42%; right: 42%">
                        <table width="160" cellpadding="0" cellspacing="0" border="0" style=" background-color: #F0F0F0;color: #dd1414">
                            <tr style="">
                                <td height="25" align="center" class="gradiante" style="color:white;font-family: Arial,Helvetica,sans-serif;font-weight: bold;font-size: 13px;"> 
                                    L&iacute;nea de cr&eacute;dito
                                </td>
                            </tr>
                            <tr>
                                <td height="3"   style="background:#fdb813;"></td>
                           </tr>
                            <tr>
                                <td id="loadLinea" height="35" align="center" style="font-size: 16px;font-weight: bold;"></td>
                            </tr>
                        </table>
                 </div>
             <!-- fin div Credito Personal -->
       <div id="div-menu-opciones">
            <ul>
                <li><div><a href="delegado_registro.php">Registrar Usuario</a></div></li>
            </ul>
        </div>        
        <div style="margin:0px auto; width:1000px;">
              <br>
              <div id="div-delegado" style="width:1000px;">
                <?php echo $tabla_info_delegado;?>
              </div>
        </div>
    </div>
</div>
</body>
</html>