<?php
session_start();
error_reporting(E_ALL);
ini_set("display_errors", 0);
date_default_timezone_set('America/Lima');

include '../cd/Navegador/index.php';
if ($_SESSION['s_entra'] == 0) {
    header('Location:../index.php');
}
$Tipo = $_SESSION['s_tipo'];
if ($Tipo == 'G') {
    $directorio_personal = 'gestor/';
} else {
    $directorio_personal = 'delegado/';
}
$directorio = '';
$directorio_imagen = '';
$display = 'none';
$contra = 'none';

if ($_SESSION['s_cambio_clave'] == 1) {
    $contra = 'block';
} elseif ($_SESSION['s_presentacion'] == 1) {
    $display = 'block';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//PE" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es-PE" lang="es-PE"> 
    <!--<html>-->
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
            <title>Web Agencias - StarPeru</title>
            <link href="images/favicon_starperu.png" rel="shortcut icon" />
            <link href="css/modulo.css" rel="stylesheet" type="text/css" />
            <script src="js/jquery.js"></script>
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
            <style type="text/css">

                body {
                    /*                overflow: auto;*/
                }
                #div-alerta{
                    height:10px;
                    margin:5px 0 10px 210px;
                    color:#900;
                    font-size:12px;
                    font-weight:bold;
                    clear:both;
                    float:left;
                }
                .btn_cerrar{
                    /*                    height:40px;
                                        width:40px;*/
                    position: absolute;



                }

            </style>

            <script type="text/javascript" >
                $(document).ready(function () {

                    var alto_pantalla = $(window).height();
                    $("#frame_principal").attr('height', alto_pantalla - 124);
                    //               alert(alto_pantalla);
                    $("#btn_cerrar").click(function () {
                        cerrarAvisoIngreso();
                    })
                });
                function getLineaCredito() {

                    var mensaje_linea_credito = 0;
                    var codigo_entidad =<?php echo $_SESSION["s_entidad"]; ?>;

                    $.ajax({
                        url: "../cd/Controlador/PasarelaControl.php",
                        type: "POST",
                        data: "obtener_linea_credito=1&codigo_entidad=" + codigo_entidad,

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

                function enviaFormSeguridad()
                {
                    var msg;
                    if ((document.form1.txtseguridad.value != '' && document.form1.txtconfirma.value != '') && document.form1.txtseguridad.value == document.form1.txtconfirma.value)
                    {
                        document.forms["form1"].submit();
                    } else {
                        if (document.form1.txtseguridad.value == '' || document.form1.txtconfirma.value == '')
                        {
                            msg = 'Por favor, ingrese el nuevo password y la confirmaci&oacute;n.';
                        } else if (document.form1.txtseguridad.value != document.form1.txtconfirma.value)
                        {
                            msg = 'El password y la confirmaci&oacute;n no son iguales.';
                        }
                        document.getElementById('div-alerta').innerHTML = '';
                        document.getElementById('div-alerta').innerHTML = msg;
                        document.getElementById('txtseguridad').focus();
                        return false;
                    }
                }

                function limpiaAlerta()
                {
                    document.getElementById('div-alerta').innerHTML = '';
                }

                function cerrarAvisoIngreso()
                {
                    document.getElementById('div-ingreso-usuario').style.display = 'none';
//                    document.forms["frmIngreso"].submit();

                    var iframe = document.getElementById('frame_principal');
                    //                iframe.src = 'pasarela/paso1.php';
                }

                function cerrarAvisoAdvertencia()
                {
                    window.location = "logout.php";
                }



            </script>
    </head>
    <body onLoad=" LineaCredito();">

        <div style="position:absolute; width:100%; height:100%;">
            <div id="div-main">

                <?php include('includes/cabecera.php'); ?>

                <div id="div-contenido">

                    <!-- Menu principal -->
                    <?php include('includes/menu.php'); ?>
                    <!-- fin menu principal -->

                    <div>

                        <!-- Div Credito Personal -->
                        <div style="position: absolute; height: 60px; top: 0px; left: 42%; right: 42%">
                            <table width="160" cellpadding="0" cellspacing="0" border="0" style=" background-color: #F0F0F0;/*font-family: Arial, Helvetica, sans-serif; */color: #dd1414">
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
                        <div class="contenedor-modal">
                            <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#miModal" style="background: -webkit-linear-gradient(#f01515, darkred) !important;">Condiciones Tarifarias</button>
                        </div>
                        <div class="modal fade" id="miModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                             <div class="modal-dialog" role="document">
                                 <div class="modal-content">
                                    <div class="modal-header">
                                        <h3>Condiciones Tarifarias</h3>
                                    </div>                                              
                                    <div class="modal-body">
                                        <div class="container">
                                            <!-- Nav tabs -->
                                            <ul class="nav nav-tabs" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active " data-toggle="tab" href="#promo" style="color: darkred;">PROMO</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link " data-toggle="tab" href="#simple" style="color: darkred;">SIMPLE</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link  " data-toggle="tab" href="#extra" style="color: darkred;">EXTRA</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link " data-toggle="tab" href="#full" style="color: darkred;">FULL</a>
                                                </li>                                                       
                                            </ul>
                                            <div class="tab-content">
                                                <div id="promo" class="container tab-pane active"><br>
                                                    <h5>PROMO(H, S y T)</h5>
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th><strong>IDA</strong></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    • Totalmente gratis: Una (1) pieza de equipaje chequeado de 23Kgs y una (1) de mano de 8Kgs.<br>
                                                                    • Máximo de estadía 180 días.<br>
                                                                    • Tarifa combinable con todas las clases.<br>
                                                                    • Niños (2-11 años) pagan el 100% de la tarifa. Infantes (0-2 años) pagan el 100% de la tarifa.<br>
                                                                    • Cambio de vuelo, fecha, ruta o nombre: Sin cargo antes de las 24hrs.a la salida del vuelo. Corresponde diferencia tarifaria de darse el caso.<br>
                                                                    • Cambio de vuelo, fecha, ruta o nombre: Dentro de las 24hrs.a la salida del vuelo, cargo de $17.70 por transacción . Corresponde diferencia tarifaria de presentarse el caso.<br>
                                                                    • Reembolsos permitidos sólo para futura transportación con cargo de $23.60.
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                        <thead>
                                                            <tr>
                                                                <th><strong>VUELTA</strong></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    • Totalmente gratis: Una (1) pieza de equipaje chequeado de 23Kgs y una (1) de mano de 8Kgs.<br>
                                                                    • Máximo de estadía 180 días.<br>
                                                                    • Tarifa combinable con todas las clases.<br>
                                                                    • Niños (2-11 años) pagan el 100% de la tarifa. Infantes (0-2 años) pagan el 100% de la tarifa.<br>
                                                                    • Cambio de vuelo, fecha, ruta o nombre: Sin cargo antes de las 24hrs.a la salida del vuelo. Corresponde diferencia tarifaria de darse el caso.<br>
                                                                    • Cambio de vuelo, fecha, ruta o nombre: Dentro de las 24hrs.a la salida del vuelo, cargo de $17.70 por transacción . Corresponde diferencia tarifaria de presentarse el caso.<br>
                                                                    • Reembolsos permitidos sólo para futura transportación con cargo de $23.60.<br>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div id="simple" class="container tab-pane fade"><br> 
                                                        <h5>SIMPLE(A, B, D, E, O, P, R y Z)</h5>
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th><strong>IDA</strong></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>
                                                                        • Totalmente gratis: Una (1) pieza de equipaje chequeado de 23Kgs y una (1) de mano de 8Kgs.<br> 
                                                                        • Máximo de estadía 180 días.<br> 
                                                                        • Tarifa combinable con todas las clases.<br> 
                                                                        • Niños (2-11 años) pagan el 100% de la tarifa. Infantes (0-2 años) pagan el 10% de la tarifa. <br> 
                                                                        • Cambio de vuelo, fecha, ruta o nombre: Sin cargo antes de las 24hrs.a la salida del vuelo. Corresponde diferencia tarifaria de darse el caso.<br> 
                                                                        • Cambio de vuelo, fecha, ruta o nombre: Dentro de las 24hrs.a la salida del vuelo, cargo de $17.70 por transacción . Corresponde diferencia tarifaria de presentarse el caso.<br> 
                                                                        • Reembolsos permitidos sólo para futura transportación con cargo de $23.60. 
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                            <thead>
                                                                <tr>
                                                                    <th><strong>VUELTA</strong></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>
                                                                        • Totalmente gratis: Una (1) pieza de equipaje chequeado de 23Kgs y una (1) de mano de 8Kgs.<br>
                                                                        • Máximo de estadía 180 días.<br>
                                                                        • Tarifa combinable con todas las clases.<br>
                                                                        • Niños (2-11 años) pagan el 100% de la tarifa. Infantes (0-2 años) pagan el 10% de la tarifa.<br>
                                                                        • Cambio de vuelo, fecha, ruta o nombre: Sin cargo antes de las 24hrs.a la salida del vuelo. Corresponde diferencia tarifaria de darse el caso.<br>
                                                                        • Cambio de vuelo, fecha, ruta o nombre: Dentro de las 24hrs.a la salida del vuelo, cargo de $17.70 por transacción . Corresponde diferencia tarifaria de presentarse el caso.<br>
                                                                        • Reembolsos permitidos sólo para futura transportación con cargo de $23.60.<br>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                </div>
                                                <div id="extra" class="container tab-pane fade"><br>
                                                        <h5>EXTRA(J, M, N, Q, V, W y X)</h5>
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th><strong>IDA</strong></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>
                                                                        • Totalmente gratis: Una (1) pieza de equipaje chequeado de 23Kgs y una (1) de mano de 8Kgs.<br>
                                                                        • Máximo de estadía 180 días.<br>
                                                                        • Tarifa combinable con todas las clases.<br>
                                                                        • Niños (2-11 años) pagan el 75% de la tarifa. Infantes (0-2 años) pagan el 10% de la tarifa.<br>
                                                                        • Cambio de vuelo, fecha, ruta o nombre: Sin cargo antes de las 24hrs.a la salida del vuelo. Corresponde diferencia tarifaria de darse el caso.<br>
                                                                        • Cambio de vuelo, fecha, ruta o nombre: Dentro de las 24hrs.a la salida del vuelo, cargo de $17.70 por transacción . Corresponde diferencia tarifaria de presentarse el caso.<br>
                                                                        • Reembolsos permitidos sólo para futura transportación con cargo de $23.60.
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                            <thead>
                                                                <tr>
                                                                    <th><strong>VUELTA</strong></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>
                                                                        • Totalmente gratis: Una (1) pieza de equipaje chequeado de 23Kgs y una (1) de mano de 8Kgs.<br>
                                                                        • Máximo de estadía 180 días.<br>
                                                                        • Tarifa combinable con todas las clases.<br>
                                                                        • Niños (2-11 años) pagan el 75% de la tarifa. Infantes (0-2 años) pagan el 10% de la tarifa.<br>
                                                                        • Cambio de vuelo, fecha, ruta o nombre: Sin cargo antes de las 24hrs.a la salida del vuelo. Corresponde diferencia tarifaria de darse el caso.<br>
                                                                        • Cambio de vuelo, fecha, ruta o nombre: Dentro de las 24hrs.a la salida del vuelo, cargo de $17.70 por transacción . Corresponde diferencia tarifaria de presentarse el caso.<br>
                                                                        • Reembolsos permitidos sólo para futura transportación con cargo de $23.60.
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                </div>
                                                <div id="full" class="container tab-pane fade"><br>
                                                        <h5>FULL(K, L y Y)</h5>
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th><strong>IDA</strong></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>
                                                                        • Totalmente gratis: Dos (2) piezas de equipaje chequeado de 23Kgs y una (1) de mano de 8Kgs.<br>
                                                                        • Máximo de estadía 180 días.<br>
                                                                        • Tarifa combinable con todas las clases.<br>
                                                                        • Niños (2-11 años) pagan el 50% de la tarifa. Infantes (0-2 años) pagan el 10% de la tarifa.<br>
                                                                        • Cambio de vuelo, fecha, ruta o nombre sin cargo. Corresponde diferencia tarifaria de darse el caso.<br>
                                                                        • Reembolsos permitidos sin cargo
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                            <thead>
                                                                <tr>
                                                                    <th><strong>VUELTA</strong></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>
                                                                        • Totalmente gratis: Dos (2) piezas de equipaje chequeado de 23Kgs y una (1) de mano de 8Kgs.<br>
                                                                        • Máximo de estadía 180 días.<br>
                                                                        • Tarifa combinable con todas las clases.<br>
                                                                        • Niños (2-11 años) pagan el 50% de la tarifa. Infantes (0-2 años) pagan el 10% de la tarifa.<br>
                                                                        • Cambio de vuelo, fecha, ruta o nombre sin cargo. Corresponde diferencia tarifaria de darse el caso.<br>
                                                                        • Reembolsos permitidos sin cargo.
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                     <div class="modal-footer">
                                         <button type="button" class="btn btn-danger" data-dismiss="modal" style="background: -webkit-linear-gradient(#f01515, darkred) !important;">Cerrar</button>
                                     </div>          
                                 </div>           
                             </div>           
                        </div>            

                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td id="secciones">
                                    <iframe id="frame_principal" width="100%"  src="pasarela/paso1.php" allowtransparency="true" frameborder="0" scrolling="auto"></iframe>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>    
        
        <!-- Mensaje de bienvenida -->
      
        <!-- fin mensaje de bienvenida -->

        <!-- Mensaje de cambio de contrasena -->
        <div id="div-seguridad" style="display:<?php echo $contra; ?>" >
            <div id="div-panel-cambio-password">
                <div style="margin:20px">
                    <form id="form1_cambio" name="form1" autocomplete="off" action="../cd/Controlador/BienvenidaControl.php" method="post">
                        <h3 style="width:210px;">Medida de Seguridad:</h3>
                        <label style="text-align:right; width:205px; display:block; float:left; margin:0 10px 20px 0;">Nuevo password (máx 8):</label>
                        <input id="txtseguridad" name="txtseguridad" type="password" maxlength="8" style="width:200px; float:left; margin:0 10px 20px 0;" onKeyPress="limpiaAlerta();"/>
                        <br>
                            <label style="text-align:right; width:200px;display:block; float:left; margin:0 10px 0 0;">Confirme su password:</label>
                            <input id="txtconfirma" name="txtconfirma" type="password" maxlength="8" style="width:200px; float:left;"  onKeyPress="limpiaAlerta();"/>
                            <input type="hidden" name="cambio" value="1" />
                            <input type="submit" style="float:left; margin:0 0 0 10px;" name="cambio_btn" 
                                   value="Aceptar"/>
                            <div id="div-alerta"></div>
                            <div style="clear:both; margin:20px; padding:10px; font-style:italic; font-weight:bold; font-size:12px; text-align:justify; line-height:18px; background:#FFC; border:#FC0 1px solid;">
                                Este proceso s&oacute;lo es para Usuarios Nuevos y/o Usuarios que <br>
                                    hayan solicitado el RESET de su PASSWORD.<br>
                                        Recuerde, su PASSWORD es personal e intransferible.
                                        </div>
                                        </form>
                                        </div>
                                        </div>
                                        </div>
                                        <!-- fin mensaje de cambio de contrasena -->
                                        </body>
                                        </html>