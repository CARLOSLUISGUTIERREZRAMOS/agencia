<?php
error_reporting(E_ALL);
ini_set("display_errors",0);
date_default_timezone_set('America/Lima');
if($_SESSION['s_entra']==0){
    header('Location:../../index.php');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title></title>
        <link href="css/style.css" rel="stylesheet" type="text/css" media="all">
        <link type="text/css" href="css/jquery/jquery.ui.all.css" rel="stylesheet" />
        <link rel="stylesheet" type="text/css" href="js/thickbox/thickbox.css"/>
        <script type="text/javascript" src="js/jquery-1.7.min.js"></script>
        <script language="javascript" src="js/thickbox/thickbox-compressed.js"></script>
        <script language="javascript">
            function show(){
                $("#checkthickbox").click();
            }
        </script>
        <script type="text/javascript" language="javascript1.2" src="js/funciones.js"></script>
        <script type="text/javascript" language="javascript1.2">
        
        function EnviaValores()
        {
            if(document.getElementById('terms').checked==true){
                document.getElementById('confirma').value='1';
                document.form1.submit();
            }
            else{
                document.getElementById('resultado').innerHTML='* Tiene que aceptar los condiciones para seguir con su reserva.';
            }
            return false;
        }
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
                                <td height="19" style="color:#323131;" style="text-decoration: underline">1. FECHA</td>
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
                                <td >5. CONFIRMACI&Oacute;N</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td height="340" align="center" style="background-color: #FFFFFF">
                        <form id="form1" name="form1" method="post" action="" autocomplete="off" onSubmit="EnviaValores(); return false;">
                            <table width="900" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td height="10"></td>
                                </tr>
                                <tr>
                                    <td align="center">
                                        <table class="table_font" width="800">
                                            <tr>
                                                <th class="table_th" style="background-color: #F0F0F0 !important;"><h2 align="center" valign="center">RESERVACI&Oacute;N: BOLETO(S) ELECTR&Oacute;NICOS EMITIDO(S) SATISFACTORIAMENTE</h2></th>
                                            </tr>
                                            <tr>
                                                <td height="10"></td>
                                            </tr>
                                            <tr>
                                                <td height="24" align="center">N&uacute;mero de Orden: <strong><?php echo $registro;?></strong></td>
                                            </tr>
                                            <tr>
                                                <td height="24" align="center">Moneda: <strong>D&oacute;lares Americanos</strong></td>
                                            </tr>
                                            <tr>
                                                <td height="24" align="center">Monto: <strong>USD <?=$total_pagar?></strong></td>
                                            </tr>
                                            <tr>
                                                <td height="44" align="center">Si desea realizar otra compra haga <a href="paso1.php" style="color: #F31300; text-decoration: underline">click aqu&iacute;</a></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td height="10"></td>
                                </tr>
                                <tr>
                                    <td>
                                        <?php include 'header.php'?>
                                    </td>
                                </tr>
                                <tr>
                                    <td height="30"></td>
                                </tr>
                                <tr>
                                  <td>
                                      <?php include 'pasajeros.php'?>
                                  </td>
                                </tr>
                                <tr>
                                    <td height="30"></td>
                                </tr>
                                <tr>
                                    <td align="right"><input name="button2" id="button2" value="Imprimir" class="btn-red" type="button" onclick="javascript:print()" /></td>
                                </tr>
                                <tr>
                                    <td height="30"></td>
                                </tr>
                            </table>
                            <br>
                            <br>
                      </form>
                    </td>
                </tr>
            </table>
        </center>
    </body>
</html>
