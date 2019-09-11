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
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <title></title>
        <link href="css/style.css" rel="stylesheet" type="text/css" media="all">
        <link type="text/css" href="css/jquery/blitzer/jquery-ui-1.10.4.custom.css" rel="stylesheet" />
        <script type="text/javascript" src="js/jquery-1.7.min.js"></script>
        <script type="text/javascript" src="js/jquery/jquery-ui-1.10.4.custom.js"></script>
        <script type="text/javascript" language="javascript1.2" src="js/funciones.js?v1.0"></script>
        <!--<script type="text/javascript" src="js/metodos_pago.js"></script>-->
        <script type="text/javascript" src="js/metodos_pago.js?v=<?= time()?>"></script>
        <!-- 
        <script>
        function EnviaValores()
        {
          if(document.getElementById('terms').checked==true)
          {		
            document.getElementById("btnAceptar").style.display="none";
            document.getElementById("div_aviso_show").style.display="inline";
            
            document.getElementById('confirma').value='1';
            document.form1.submit();
          }
          else
          {
            document.getElementById('resultado').innerHTML='* Tiene que aceptar los condiciones para seguir con su reserva.';
          }
          return false;
        }
        </script>
        -->
        <script language="javascript">
            function VerCondicion(){	
                $("#MostrarCondicion").dialog({
                    resizable: false,
                    title:"Condiciones relacionadas a la Compra",				
                    modal: true,	
                    width: 740,
                    height: $(window).height()-110,
                    show: "fold",
                    hide: "fade", 
                });	
                $("#MostrarCondicion").load('condiciones/condiciones.html');
                $('#MostrarCondicion').dialog('open');
            }
        </script>

        <link href="css/estilos.css" rel="stylesheet" type="text/css" />
        <style type="text/css">
            .gradiante{
                background: linear-gradient(#f01515, darkred) !important;
                background: -webkit-linear-gradient(#f01515, darkred) !important;
                filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#f01515', endColorstr='darkred');
            }
        </style>
    </head>
    <body>
        <center>
            <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" style="background-color: #FFFFFF">
                <tr>
                    <td height="20" align="center" style="background-color: #FFFFFF">&nbsp;</td>
                </tr>
                <tr>
                    <td height="50" align="center">
                        <table id="menu_vuelo" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td height="19"><a style="color:#323131;" href="paso1.php" title="Ir al Paso 1">1. FECHA</a></td>
                                <td width="4"></td>
                                <td width="89" style="background-image: url(images/line_off.png); background-repeat: repeat-x"></td>
                                <td width="30"></td>
                                <td >2. VUELOS</td>
                                <td width="4"></td>
                                <td width="89" style="background-image: url(images/line_off.png); background-repeat: repeat-x"></td>
                                <td width="30"></td>
                                <td >3. PRECIO</td>
                                <td width="4"></td>
                                <td width="89" style="background-image: url(images/line_off.png); background-repeat: repeat-x"></td>
                                <td width="30"></td>
                                <td >4. PASAJEROS</td>
                                <td width="4"></td>
                                <td width="89" style="background-image: url(images/line_off.png); background-repeat: repeat-x"></td>
                                <td width="30"></td>
                                <td class="activo">5. CONFIRMACI&Oacute;N</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td height="340" align="center" style="background-color: #FFFFFF">
                        <form id="form1" name="form1" method="post" action="confirmacion.php" autocomplete="off" onSubmit="EnviaValores(); return false;">
                            <table width="900" border="0" cellspacing="0" cellpadding="0">
                              	<tr>
                                    <td colspan="7"  height="1"  style="background: #323131;"></td>
                              	</tr> 
                              	<tr>
                                    <td colspan="7" align="left" height="30" class="titleTable" style="color:#323131;font-size: 24px;background: #f0f0f0;font-family:Tahoma, Geneva, sans-serif; ">Paso 5</td>
                              	</tr>
                              	<tr>
                                    <td colspan="7"  height="1"  style="background: #323131;"></td>
                              	</tr>  
                                <tr>
                                  	<td height="10" >&nbsp;</td>
                              	</tr>  
                              	<tr>
                                  	<td height="40" align="left"><h2 >C&oacute;digo de Reserva: <b><?php echo $codigo_reserva; ?></b></h2></td>
                              	</tr>
                              	<tr>
									<td colspan="2">
										<?php echo $table_cabecera_5;?>
									</td>
                              	</tr>
                              	<tr>
                                	<td height="30" colspan="2"></td>
                              	</tr>
                              	<tr>
									<td colspan="2">
										<?php echo $table_precio_5;?>
									</td>
                              	</tr>
                              	<tr>
                                	<td height="10"><input type="hidden" name="confirma" id="confirma" /></td>
                              	</tr>
                              	<tr>
                                  	<td height="30" align="left">
                                        <label>
                                            <input type="checkbox" id="terms" name="terms" value="1" onclick="Change()" /> He le&iacute;do y estoy de acuerdo con las <a id="checkthickbox" onclick="VerCondicion();" class="thickbox" style="color:#0266CC;cursor:pointer;">condiciones</a> relacionadas a la compra.<br>
                                            <input type="checkbox" id="terms2" name="terms2" value="1" onclick="Change()" /> La agencia se hace 100% responsable de cualquier tipo de fraude que se haga vía el portal agencias. 
                                        </label>
                                    </td>
                              	</tr>
                              	<tr>
                                    <?php if ($codigo_reserva!=''): ?>
                                        <td align="right">
                                            <input style="display: none;" name="btnAceptar" id="btnAceptar" value="Emisión" class="btn-red" type="submit"/>
                                            <input type="hidden" name="confirmacion" id="confirmacion" value="1"/>
                                            <input type="hidden" name="codigo_reserva" id="codigo_reserva" value="<?php echo $codigo_reserva;?>"/>
                                            <input type="hidden" name="adultos_confirmacion" id="adultos_confirmacion" value="<?php echo $adultos_5;?>"/>
                                            <input type="hidden" name="menores_confirmacion" id="menores_confirmacion" value="<?php echo $menores_5;?>"/>
                                            <input type="hidden" name="infantes_confirmacion" id="infantes_confirmacion" value="<?php echo $infantes_5;?>"/>
                                            <input type="hidden" name="registro" id="registro" value="<?php echo $registro;?>"/>
                                            <input type="hidden" name="total_pagar_cc" id="total_pagar_cc" value="<?php echo $total_pagar_5;?>"/>
                                            <input type="hidden" name="tipo_moneda_cc" id="tipo_moneda_cc" value="<?php echo $tipo_moneda_5;?>"/>
                                            <input type="hidden" name="tipo_viaje_cc" id="tipo_viaje_cc" value="<?php echo $tipo_viaje_5;?>"/>
                                            <!-- DATOS DE IDA -->
                                            
                                            <input type="hidden" name="numero_vuelo_ida_cc" id="numero_vuelo_ida_cc" value="<?php echo $numero_vuelo_ida_5;?>"/>
                                            <input type="hidden" name="fecha_hora_salida_ida_cc" id="fecha_hora_salida_ida_cc" value="<?php echo $fecha_hora_salida_ida_5;?>"/>
                                            <input type="hidden" name="fecha_hora_llegada_ida_cc" id="fecha_hora_llegada_ida_cc" value="<?php echo $fecha_hora_llegada_ida_5;?>"/>
                                            <input type="hidden" name="clase_ida_cc" id="clase_ida_cc" value="<?php echo $clase_ida_5;?>"/>
                                            <input type="hidden" name="origen_ida_cc" id="origen_ida_cc" value="<?php echo $origen_ida_5;?>"/>
                                            <input type="hidden" name="destino_ida_cc" id="destino_ida_cc" value="<?php echo $destino_ida_5;?>"/>
                                            <!-- DATOS DE VUELTA -->
                                            <input type="hidden" name="numero_vuelo_vuelta_cc" id="numero_vuelo_vuelta_cc" value="<?php echo $numero_vuelo_vuelta_5;?>"/>
                                            <input type="hidden" name="fecha_hora_salida_vuelta_cc" id="fecha_hora_salida_vuelta_cc" value="<?php echo $fecha_hora_salida_vuelta_5;?>"/>
                                            <input type="hidden" name="fecha_hora_llegada_vuelta_cc" id="fecha_hora_llegada_vuelta_cc" value="<?php echo $fecha_hora_llegada_vuelta_5;?>"/>
                                            <input type="hidden" name="clase_vuelta_cc" id="clase_vuelta_cc" value="<?php echo $clase_vuelta_5;?>"/>
                                            <input type="hidden" name="origen_vuelta_cc" id="origen_vuelta_cc" value="<?php echo $origen_vuelta_5;?>"/>
                                            <input type="hidden" name="destino_vuelta_cc" id="destino_vuelta_cc" value="<?php echo $destino_vuelta_5;?>"/>
                                            <input type="hidden" name="total_pagar_tabla_5" id="total_pagar_tabla_5" value="<?php echo $total_pagar_tabla_5;?>"/>
                                        </td>
                                    <?php else: ?>
                                        <td height="1" width="950" style="background-color: #CCCCCC;color: red;">
                                            No se pudo generar la reserva:<BR/>
                                            -Por falta de disponibilidad en uno de los tramos seleccionados.<BR/><BR/>
                                            POR FAVOR GENERAR NUEVAMENTE LA RESERVA.
                                        </td>
                                    <?php endif ?>
                              	</tr>
                                <tr>
                                    <td height="30" align="left" id="resultado" style="color: #CC0033"></td>
                                </tr>
                            </table>
                            <br>
                        </form>
                        <script type="text/javascript" src="js/jquery-1.7.min.js"></script>      
                        <?php
                            $_SESSION['registro_id'] = $registro;
                            $_SESSION['token_seguridad_visa'] = $token;
                            require_once("../../config.php");
                        ?>
                        <form  action="<?=$url?>/cp/pasarela/metodos_pago.php" id="form_visa" method='post' style="display: none">
                            <script src='<?=$libreriaJsVisa?>'
                                data-sessiontoken='<?= $objSessionVisa->sessionKey ?>'
                                data-channel='web'
                                data-merchantid='<?= $visa->getCodigo_comercio() ?>'
                                data-merchantlogo= 'https://www.starperu.com/es/img/Logotipo.png'
                                data-formbuttoncolor='#D80000'
                                data-purchasenumber= <?=$registro?>
                                data-amount=<?=$total_pagar_tabla_5?>
                                data-expirationminutes= 5
                                data-timeouturl = '<?= $url?>/cp/pasarela/html/tiempo_limite.php'></script>
                        </form>
                    </td>
                </tr>
            </table>
        </center>
        <script>
            // $(document).on('click','.start-js-btn',function(){
            //     this.id=1;
            // });
            // setInterval(function(){
            //     var btn_modal=$(".start-js-btn");
            //     if (btn_modal) {
            //         var val=btn_modal.attr('id')
            //         if (val) {
            //             if(val==1){
            //                 var _modal=$(".modal-backdrop").hasClass('show');
            //                 if(!_modal){
            //                     $('body').append('<div class="modal-backdrop fade show"></div>').addClass('modal-open').css({'padding-right': '17px'});
            //                 }
            //             }
            //         }
            //     }
            // }, 1000);
        </script>
        <div id="MostrarCondicion" style="display: none"></div>
    </body>
</html>
