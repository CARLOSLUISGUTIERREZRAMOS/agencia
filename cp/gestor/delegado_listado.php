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
<link href="../js/jqueryui/css/blitzer/jquery-ui-1.10.4.custom.css" rel="stylesheet" type="text/css" />
<link href="../js/msgbox/css/jquery.msgbox.css" rel="stylesheet" type="text/css" />
<script src="../js/jquery/jquery-1.8.0.min.js"></script>
<script src="../js/jqueryui/js/jquery-ui-1.10.4.custom.js"></script>
<script src="../js/msgbox/jquery.msgbox.i18n.js"></script>
<script src="../js/msgbox/jquery.msgbox.js"></script>
<script src="../js/fnMain.js"></script>
<!--<script src="../js/ajax/MBAjax.js"></script>-->
<script src="../js/ajax/funcionesGestorDelegado.js"></script>
<script type="text/javascript">
    $(window).load(function(){
            
        $("#btnbusqueda1").click(function(){   
            var dni=$.trim($("#dni").val());
            var apellido=$.trim($("#apellido").val().toUpperCase());
            
            if(dni=="" &&  apellido==""){
                 $.msgbox({
                    open:true,type:'alert',title:'Alerta',content: 'Debe llenar al menos un campo.', overlay:true
                 });
//                $.msgbox().open();
                return false;
            }
            
//            var data = new FormData();
//            data.append('filtrar',1);
//            data.append('dni',dni);
//            data.append('apellido',apellido);

            $.ajax({
                    url:"../../cd/Controlador/DelegadoControl.php",
                    type: "POST", 
//                    contentType:false,
                    data:"filtrar=1&dni="+dni+"&apellido="+apellido,
//                    processData:false,
                    success: function(mensaje){
                             if($.trim(mensaje)==''){
                                 $("#listaResultado").html('<p style="text-align:center;color:red;margin-top:20px;">No existen datos para visualizar. Por favor registre nuevos delegados.</p><br><p style="text-align:center;"><a href="javascript:void(0);"><img src="../images/reload.png"  title="Recargar Listado..." onclick="javascript:$(window).load();"></a></p>');
                             }else{
                                 $("#listaResultado").html(mensaje);
                             }
                        },
                   error: function(obj,mensaje,e) { 
                                       if(e=='Internal Server Error'){
                                           alert('Se ha producido un error interno. Consulte con el �rea de Sistemas de StarPer�');
                                       }else{
                                           alert('Por favor revise su conexi�n a Internet y vuelva a intertarlo.');
                                       }
                                   }
                   });
          });    
   
//            var data = new FormData();
//            data.append('listar',1);

            $.ajax({
                    url:"../../cd/Controlador/DelegadoControl.php",
                    type: "POST", 
//                    contentType:false,
                    data:"listar=1",
//                    processData:false,
                    success: function(mensaje){
                             if($.trim(mensaje)==''){
                                 $("#listaResultado").html('<p style="text-align:center;color:red;margin-top:20px;">No existen datos para visualizar. Por favor registre nuevos delegados.</p><br><p style="text-align:center;"><a href="javascript:void(0);"><img src="../images/reload.png"  title="Recargar Listado..." onclick="javascript:$(window).load();"></a></p>');
                             }else{
                                 $("#listaResultado").html(mensaje);
                             }
                        },
                   error: function(obj,mensaje,e) { 
                                       if(e=='Internal Server Error'){
                                           alert('Se ha producido un error interno. Consulte con el �rea de Sistemas de StarPer�');
                                       }else{
                                           alert('Por favor revise su conexi�n a Internet y vuelva a intertarlo.');
                                       }
                                   }
                   });     
    });
    
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
//                        error: function(obj,mensaje,e) { 
//                                    if(e=='Internal Server Error'){
//                                        alert('Se ha producido un error interno. Consulte con el �rea de Sistemas de StarPer�');
//                                    }else{
//                                        alert('Por favor revise su conexi�n a Internet y vuelva a intertarlo.');
//                                    }
//                               }
                });
            }


            function LineaCredito()
            {    
                getLineaCredito();
                setInterval("getLineaCredito()", 1000);   
            }
</script>
</head>

<body onLoad=" LineaCredito();">
<div id="div-main">
    <?php include('../includes/cabecera.php'); ?>
    <div id="div-contenido" style="background:none;">
    <?php include('../includes/menu.php'); ?>
        <div id="div-menu-opciones">
            <ul>
                <li><div><a href="delegado_registro.php">Registrar Delegado</a></div></li>
            </ul>
        </div>
        <div style="width:1000px; margin:0px auto;">
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
            <div style="width:auto;">
                <div id="div-busqueda">
                    <form id="formBusqueda" name="formBusqueda" method="post" action="../../cd/Controlador/DelegadoControl.php" autocomplete="off">
                        <table width="1000" border="0" cellpadding="0" cellspacing="0" style="background-color: #F0F0F0">
                            <tr>
                                <td height="26" colspan="5" align="left" class="titleTable gradiante" style="color:white;padding: 0px 5px;margin: 0px;font-weight: bold;">Opciones de B&uacute;squeda</td>
                            </tr>
                            <tr>
                                 <td height="3" colspan="5"  style="background:#fdb813;"></td>
                            </tr>
                             <tr>
                                 <td height="20" colspan="5"  ></td>
                            </tr>
                            <tr>
                                <td align="right">DNI:</td>
                                <td > <input type="text" style="text-align: center;" name="dni" id="dni" maxlength="8" onKeyPress="javascript:return Numero(event);"/></td>
                                <td align="right">Apellidos</td>
                                <td><input type="text" style="text-align: center;" name="apellido" id="apellido" style="text-transform:uppercase;"/></td>
                                <td align="center"><input type="button" class="btn-red" name="btnbusqueda" id="btnbusqueda1" value="Consultar" title="Presionar para ver resultados ..." /></td>
                            </tr>
                             <tr>
                                 <td height="20" colspan="5"  ></td>
                            </tr>
                        </table>
                    </form>
                </div>
                    <br>
                    <br>
                <div id="div-listado">
                    <div id="listaResultado" >
                    </div>
                </div>
           </div>                
        </div>
    </div>
</div>
</body>
</html>