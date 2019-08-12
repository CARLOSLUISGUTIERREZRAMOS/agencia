<?php
session_start();
error_reporting(E_ALL);
ini_set("display_errors", 0);
date_default_timezone_set('America/Lima');
if ($_SESSION['s_entra'] == 0) {
    header('Location:../../index.php');
}



$Tipo = $_SESSION['s_tipo'];
$directorio = '../';
$directorio_imagen = '../';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <title>M&oacute;dulo Corporativo</title>
        <link href="../images/favicon_starperu.png" rel="shortcut icon" />
        <link href="../js/jqueryui/css/blitzer/jquery-ui-1.10.4.custom.css" rel="stylesheet" type="text/css" />
        <link href="../js/msgbox/css/jquery.msgbox.css" rel="stylesheet" type="text/css" />
        <link href="../css/modulo.css" rel="stylesheet" type="text/css" />
        <link href="../css/gestor.css" rel="stylesheet" type="text/css" />
        <script src="../js/jquery.js"></script>
        <script src="../js/jqueryui/js/jquery-ui-1.10.4.custom.js"></script>
        <script src="../js/msgbox/jquery.msgbox.i18n.js"></script>
        <script src="../js/msgbox/jquery.msgbox.js"></script>
        <script src="../js/fnMain.js"></script>
        <script src="../js/ajax/funcionesGestor.js"></script>
        <script type="text/javascript">
            function getLineaCredito() {

                var mensaje_linea_credito = 0;
                var codigo_entidad =<?php echo $_SESSION["s_entidad"]; ?>;

                $.ajax({
                    url: "../../cd/Controlador/MovimientoControl.php",
                    type: "POST",
                    data: "obtener_linea_credito=1&codigo_entidad" + codigo_entidad,

                    success: function (mensaje) {

                        mensaje_linea_credito = parseFloat($.trim(mensaje)).toFixed(2);
                        $("#loadLinea").html('USD ' + mensaje_linea_credito);
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
                <!-- Div Credito Personal -->
<!--                <div style="position: absolute; height: 60px; top: 0px; left: 42%; right: 42%">
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
                </div>-->
                <!-- fin div Credito Personal -->
                <br><br>
                <div style="width:900px; margin:0 auto;">
                    <form id="formRegistro" name="formRegistro" method="post" action="" autocomplete="off" style="width:900px">

                        <table width="900" border="0" cellpadding="0" cellspacing="0" style="background-color: #F0F0F0;">
                            <tr>
                                <td height="26" colspan="5"  class="gradiante" style="color:white;font-size: 13px;padding: 0px 5px;margin: 0px;font-weight: bold;">Registro de Usuario</td>
                            </tr>
                            <tr>
                                <td height="3" colspan="5"  style="background:#fdb813;"></td>
                            </tr>
                            <tr>
                                <td height="10" colspan="5"  ></td>
                            </tr>
                            <tr>
                                <td  class="label_info" style="padding: 10px 10px 7px 0;">DNI:</td><td ><input type="text" name="dni_d" id="dni_d" style="text-align: center;" maxlength="8" onKeyPress="javascript:return Numero(event);"/>
                                    <span class="span-requerido">*</span></td>
                                <td  class="label_info" style="padding: 10px 10px 7px 0;">anexo:</td><td >  <input type="text" name="anexo_d" id="anexo_d" style="text-align: center;" maxlength="6" onKeyPress="javascript:return Numero(event);"/></td>
                                <td  rowspan="1"> <button style="cursor:pointer;" id="guarda_delegado" onClick="event.preventDefault();" title="Guardar Delegado"><img src="../images/disk-black.png" /></button></td>
                            </tr>
                            <tr>
                                <td  class="label_info" style="padding: 10px 10px 7px 0;">apellido paterno:</td><td >
                                    <input type="text" name="apep_d" id="apep_d" style="text-transform:uppercase;"/>
                                    <span class="span-requerido">*</span>
                                </td>
                                <td  class="label_info" style="padding: 10px 10px 7px 0;">celular:</td><td > <input type="text" name="celu_d" id="celu_d" maxlength="9" onKeyPress="javascript:return Numero(event);" value="<?php echo $celular; ?>"/></td>
                                <td  rowspan="1"> <button style="cursor:pointer;" onClick="event.preventDefault();window.location.href = 'delegado_listado.php';" title="Volver al listado de Delegados" ><img src="../images/table.png" /></button></td>
                            </tr>
                            <tr>
                                <td  class="label_info" style="padding: 10px 10px 7px 0;">apellido materno:</td><td >
                                    <input type="text" name="apem_d" id="apem_d" style="text-transform:uppercase;"/>
                                    <span class="span-requerido">*</span>
                                </td>
                            </tr>
                            <tr>
                                <td  class="label_info" style="padding: 10px 10px 7px 0;">nombres:</td><td >
                                    <input type="text" name="nom_d" id="nom_d" style="text-transform:uppercase;"/>
                                    <span class="span-requerido">*</span>
                                </td>
                            </tr>
                            <tr>
                                <td  class="label_info" style="padding: 10px 10px 7px 0;">email:</td><td >
                                    <input type="hidden" id="email" value="<?php echo $email; ?>">
                                    <input type="text" name="email_d" id="email_d" value="<?php echo $email; ?>"/>
                                    <span class="span-requerido">*</span>
                                </td>
                            </tr>
                            <tr>
                                <td  class="label_info" style="padding: 10px 10px 7px 0;">tel&eacute;fono oficina:</td><td ><input type="text" name="ofic_d" id="ofic_d" maxlength="7" style="text-align: center;" onKeyPress="javascript:return Numero(event);"/>
                                    <span class="span-requerido">*</span></td>
                            </tr>
                            <tr>
                                <td height="10" colspan="5"  ></td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>