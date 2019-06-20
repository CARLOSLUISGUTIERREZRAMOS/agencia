<?php
session_start();
error_reporting(E_ALL);
ini_set("display_errors",0);
date_default_timezone_set('America/Lima');
require_once '../../cd/Controlador/MovimientoControl.php';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
            <title>Emision de Ticket - StarPer&uacute; - PER&uacute; COMPRAS</title>
            <link href="css/starperu.css" rel="stylesheet" type="text/css">
            <style type="text/css" media="print">
                @media print {
                    .no-print {display:none;}
                    
                    .print{
                        color: black !important;
                    }
                }
           </style>
    </head>
    <body>
            <table align="center" width="780" height="30" border="0" cellspacing="0" cellpadding="0" class="no-print" style="border-bottom: 1px solid">
                <tr>
                    <td valign="center" >
                        <div align="right">
                            <a href="Javascript:print();" style="text-decoration: none;cursor:pointer;">
                                   Imprimir <img src="images/icon-impresora.png" width="20" height="20" border="0" alt="Haga click para imprimir Ticket" title="Haga click para imprimir Ticket">	
                            </a>		
                        </div>
                  </td>
                </tr>
            </table>
            <div class="print" style="width: 780px;margin:0px auto;">
            <?php echo $res_ticket["ItineraryInfo"]["Ticketing"]["TicketAdvisory"]; ?>
            </div>
    </body>
</html>

