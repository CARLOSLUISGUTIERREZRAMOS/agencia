<?php
    function EnvioMailCreacionUserEjecutivos($paterno,$materno,$nombres,$usuario,$tipo,$razon_social,$ruc){
        $mail ="<!DOCTYPE html>
                <html lang='es'>
                    <head>
                        <meta charset='UTF-8'>
                        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                        <meta http-equiv='X-UA-Compatible' content='ie=edge'>                    
                    </head>
                    <body style='font-family:Trebuchet MS;font-size:13px'>
                        <table width='700' border='0' align='center'>
                            <tr>
                                <td bgcolor='#fce8e6' colspan='2'>
                                    <font color='#e46b63'><strong>NOTIFICACION - SISTEMA WEB AGENCIAS</strong></font>
                                </td>
                            </tr>
                            <tr>
                                <td colspan='2'>
                                    <p>Estimado Sr(a). Ejecutivo, se le informa que STARPERU ha generado el registro correcto del $tipo: $paterno $materno , $nombres, para el acceso al sistema de compra de pasajes - WEB AGENCIAS.</p>
                                </td>
                            </tr>
                            <tr><td colspan='2'></td></tr>
                            <tr><td colspan='2'>INFORMACIÓN DE LA CUENTA :</td></tr>
                            <tr><td colspan='2' bgcolor='#fce8e6'>&nbsp;</td></tr>
                            <tr>
                                <td width='178'>WEB AGENCIAS:</td>
                                <td width='512'>$razon_social</td>
                            </tr>
                            <tr>
                                <td width='178'>RUC:</td>
                                <td width='512'>$ruc</td>
                            </tr>
                            <tr>
                                <td>Usuario:</td>
                                <td>$paterno $materno, $nombres</td>
                            </tr>
                            <tr>
                                <td>Usuario de Acceso:</td>
                                <td>$usuario</td>
                            </tr>
                        </table>
                    </body>
                </html>";

        // $email= "ecel@starperu.com,grupos@starperu.com,maria.marrou@starperu.com,carlos.flores@starperu.com,jhonatta.bernal@starperu.com,karinna.ruiz@starperu.com,henrry.cachicatari@starperu.com,carlos.gutierrez@starperu.com";
        // $remitente ="ecel@starperu.com";
        // $to=$email;
        // $subject='WEB AGENCIAS - Notificacion de Registro - Ejecutivos';
        // $message=$mail;
        // $cabeceras = "Content-type: text/html\r\n"; 
        // $cabeceras.= "From: WEB AGENCIAS <$remitente>\r\n";
        // mail($to, $subject,$message,$cabeceras );
        
        $subject='WEB AGENCIAS - Notificacion de Registro - Ejecutivos';
        $responder='no-responder@starperu.com';
        $para='grupos@starperu.com';
        $copias='maria.marrou@starperu.com,carlos.flores@starperu.com,jhonatta.bernal@starperu.com,karinna.ruiz@starperu.com,henrry.cachicatari@starperu.com,carlos.gutierrez@starperu.com';
        sendemail($responder,'WEB AGENCIAS',$para,$mail,$subject,$copias);
    }

    function EnvioCreacionMailUsuarios($email,$paterno,$materno,$nombres,$usuario,$clave,$tipo,$razon_social,$ruc,$token){
        $mail ="<!DOCTYPE html>
                <html lang='es'>
                    <head>
                        <meta charset='UTF-8'>
                        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                        <meta http-equiv='X-UA-Compatible' content='ie=edge'>                    
                    </head>
                    <body style='font-family:Trebuchet MS;font-size:13px'>
                        <center>
                            <div style='border: 1px solid #69778d;width:720px;padding-bottom: 10px;'>
                                <table width='700' border='0' align='center'>
                                    <tr>
                                        <td colspan='2'></td>
                                    </tr>
                                    <tr>
                                        <td  colspan='2' align='center' style='font-size: 18px;'>
                                            <font color='#e46b63'><strong>NOTIFICACI&Oacute;N - SISTEMA Web Agencias</strong></font>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan='2'></td>
                                    </tr>
                                    <tr>
                                        <td colspan='2' bgcolor='#e46b63'></td>
                                    </tr>
                                    <tr>
                                        <td colspan='2' style='font-family: sans-serif;font-size: 15px;line-height: 20px;color: #555555;padding: 10px 10px 0 0;text-align: left;'>
                                            <h2 style='margin:0;font-family:sans-serif;font-size:18px;line-height:22px;color:#333333;font-weight:bold;'>¡Gracias por registrarte!</h2>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan='2'></td>
                                    </tr>
                                    <tr>
                                        <td colspan='2'></td>
                                    </tr>
                                    <tr>
                                        <td colspan='2'>
                                            <p>
                                                Estimado Sr(a). <font color='#080897'><strong>$paterno $materno, $nombres</strong></font>, en virtud de su acreditaci&oacute;n como <font color='#080897'><strong>$tipo</strong></font>, se le informa que <font color='#080897'><strong>STARPERU</strong></font> ha generado el registro correcto del Usuario <font color='#080897'><strong>$tipo: $paterno $materno , $nombres</strong></font>, y el <font color='#080897'><strong>USUARIO: ".$usuario."</strong></font>"." <font color='#000000'>para el acceso al</font> "."<font color='#000000'><strong>SISTEMA DE COMPRA DE PASAJES - Web Agencias</strong></font>.
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan='2'></td>
                                    </tr>
                                    <tr>
                                        <td colspan='2'></td>
                                    </tr>
                                    <tr>
                                        <td colspan='2'>
                                            <p>Antes de iniciar sesión debes activar tu cuenta haciendo click en el siguiente enlace:</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan='2'>
                                        <a href='".URL_PROYECTO."/verificar.php?token=$token' target='_blank' style='background:#f7b543; border:1px solid #d29428; font-family:sans-serif; font-size:15px; line-height:15px; text-decoration:none; padding:13px 17px; color:#000000; display:block; border-radius:4px;width: 20%; max-width: 20%;'>Verificar ahora</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan='2'></td>
                                    </tr>
                                    <tr>
                                        <td colspan='2'></td>
                                    </tr>
                                    <tr>
                                        <td colspan='2'></td>
                                    </tr>
                                    <tr>
                                        <td colspan='2'>
                                            <p>Si el enlace no funciona copia y pega manualmente en tu navegador:</p>".URL_PROYECTO."/verificar.php?token=$token
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan='2'></td>
                                    </tr>
                                    <tr>
                                        <td colspan='2'></td>
                                    </tr>
                                    <tr>
                                        <td colspan='2'><font color='#080897'><strong style='text-transform: uppercase;'>Información de tu cuenta :</strong></font></td>
                                    </tr>
                                    <tr>
                                        <td colspan='2' bgcolor='#e46b63'></td>
                                    </tr>
                                    <tr>
                                        <td width='178'><font color='#33333'><strong>Web Agencias:</strong></font></td>
                                        <td width='512'><font color='#33333'><strong>$razon_social</strong></font></td>
                                    </tr>
                                    <tr>
                                        <td width='178'><font color='#33333'><strong>RUC:</strong></font></td>
                                        <td width='512'><font color='#33333'><strong>$ruc</strong></font></td>
                                    </tr>
                                    <tr>
                                        <td><font color='#33333'><strong>Usuario:</strong></font></td>
                                        <td><font color='#33333'><strong>$paterno $materno, $nombres</strong></font></td>
                                    </tr>
                                    <tr>
                                        <td><font color='#33333'><strong>Usuario de Acceso:</strong></font></td>
                                        <td><font color='#080897'><strong>$usuario</strong></font></td>
                                    </tr>
                                    <tr>
                                        <td><font color='#33333'><strong>Password:</strong></font></td>
                                        <td><font color='#080897'><strong>$clave</strong></font></td>
                                    </tr>
                                    <tr>
                                        <td colspan='2' bgcolor='#e46b63'></td>
                                    </tr>
                                    <tr>
                                        <td colspan='2'></td>
                                    </tr>
                                    <tr>
                                        <td colspan='2'></td>
                                    </tr>
                                    <tr>
                                        <td colspan='2' style='font-size: 14px;'><font color='#000000'><strong>Se le recuerda que al ingresar por primera vez al SISTEMA se le solicitar&aacute; el cambio de su password.</strong></font></td>
                                    </tr>
                                </table>
                            </div>
                        </center>
                    </body>
                </html>";
        
        // $email.= ",henrry.cachicatari@starperu.com";
        // $remitente ="ecel@starperu.com";
        // $to=$email;
        // $subject='Web Agencias - Notificacion de Registro';
        // $message=$mail;
        // $cabeceras = "Content-type: text/html; charset=UTF-8\r\n"; 
        // $cabeceras.= "From: Web Agencias <$remitente>\r\n";

        $subject='Web Agencias - Notificacion de Registro';
        $responder='no-responder@starperu.com';
        $para=$email;
        $copias='henrry.cachicatari@starperu.com';
        sendemail($responder,'WEB AGENCIAS',$para,$mail,$subject,$copias);
        // mail($to, $subject,$message,$cabeceras ); 
    }
?>