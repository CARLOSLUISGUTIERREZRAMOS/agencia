<?php
session_start();
error_reporting(E_ALL);
ini_set("display_errors",0);
date_default_timezone_set('America/Lima');
require_once("../../cn/STARPERU/Modelo/PersonalModelo.php");
require_once("../../cn/STARPERU/Modelo/ReservaModelo.php");
require_once("../../cn/KIU/KIU_Controller_class.php");
$KIU = new KIU_Controller(array());
$obj_personal=new PersonalModelo();
$obj_reserva=new ReservaModelo();


if($_POST['obtener_datos_pasajero']==1){
    $tipo_doc=trim($_POST['tipo']);
    $num_doc=trim($_POST['numero']);
    echo trim($obj_reserva->ObtenerDatosPasajero($tipo_doc,$num_doc));
}

$tabla_boletos_reserva='';
if($_POST['buscar_reserva']==1){ 
    $codigo_reserva=trim($_POST['reserva']);
    $codigo_entidad=$_SESSION['s_entidad'];
    if ($codigo_reserva==''){
        $tabla_boletos_reserva= '<p style="color:red;">Ud. debe ingresar un C&oacute;digo de Reserva</p>';
    }else{
        $lista_boletos=array();
        $lista_boletos=$obj_reserva->ListaBoletosPorReserva($codigo_reserva,$codigo_entidad);
        $boleto = array();
        $boleto = $lista_boletos[0];
        if($boleto[2]==''){
            $tabla_boletos_reserva= '<p style="color:red;">No se encontraron boletos para esta reserva.</p>';
        }else{
            $tabla_boletos_reserva='<form id="form2" name="form2" method="post" action="anular_boleto.php" autocomplete="off" onSubmit="return EnviarValoresCheck();">' . "\n";
            $tabla_boletos_reserva.='<table width="1200" border="0" cellspacing="0" cellpadding="0" >' . "\n";
            $tabla_boletos_reserva.='<tr>'."\n";
            $tabla_boletos_reserva.='<td colspan="3" width="1200" class="gradiante" style="color:white;padding: 5px 5px;margin: 0px;font-weight: bold;font-size: 13px;">Listado de Boletos de la Reserva: '.strtoupper($codigo_reserva).'</td>' . "\n";
            $tabla_boletos_reserva.='</tr>'."\n";
            $tabla_boletos_reserva.='<tr>'."\n";
            $tabla_boletos_reserva.='<td colspan="3" border="0" cellpadding="0" cellspacing="0" height="3" width="1200" style="background:#fdb813;"></td>' . "\n";
            $tabla_boletos_reserva.='</tr>'."\n";
            $tabla_boletos_reserva.='<tr>'."\n";
            $tabla_boletos_reserva.='<td></td>'."\n";
            $tabla_boletos_reserva.='<td>'."\n";
            $tabla_boletos_reserva.='<table width="1200" border="0" cellpadding="0" cellspacing="0" style=" background-color: #F0F0F0">'."\n";
            $tabla_boletos_reserva.='<tr>'."\n";
            $tabla_boletos_reserva.='<td align="center" width="20" height="50" align="center" class="cabecera_listado"></td>'."\n";
            $tabla_boletos_reserva.='<td align="center" width="150" class="cabecera_listado">N° de Boleto</td>'."\n";
            $tabla_boletos_reserva.='<td align="center" width="34" class="cabecera_listado">Tipo<br>Serv.</td>'."\n";
            $tabla_boletos_reserva.='<td align="center" width="180" class="cabecera_listado">Fecha / Hora<br>Operaci&oacute;n</td>'."\n";
            $tabla_boletos_reserva.='<td align="center" width="100" class="cabecera_listado">Tramo</td>'."\n";
            $tabla_boletos_reserva.='<td align="center" width="100" class="cabecera_listado">Nro. Vuelo</td>'."\n";
            $tabla_boletos_reserva.='<td align="center" width="100" class="cabecera_listado">Ciudad Origen</td>'."\n";
            $tabla_boletos_reserva.='<td align="center" width="180" class="cabecera_listado">Fecha / Hora<br>Origen</td>'."\n";
            $tabla_boletos_reserva.='<td align="center" width="100" class="cabecera_listado">Ciudad Destino</td>'."\n";
            $tabla_boletos_reserva.='<td align="center" width="180" class="cabecera_listado">Fecha / Hora<br>Destino</td>'."\n";
            $tabla_boletos_reserva.='<td align="center" width="100" class="cabecera_listado">Duraci&oacute;n</td>'."\n";
            $tabla_boletos_reserva.='<td align="center" width="32" class="cabecera_listado">Clase</td>'."\n";
            $tabla_boletos_reserva.='<td align="center" width="250" class="cabecera_listado">Pasajero</td>'."\n";
            $tabla_boletos_reserva.='<td align="center" width="64" class="cabecera_listado">Costo Tramo</td>'."\n";
            $tabla_boletos_reserva.='</tr>'."\n";  
            
            $codigo_ticket_temporal='';
            $cantidad_lista=0;
            $cantidad_anulados=0;
            $monto_total=0;
            $fecha_hora_registro='';
        foreach ($lista_boletos as $boleto) {
                        
                        $reserva=$boleto[0];
                        $reserva_detalle=$boleto[1];
                        $tramo=$boleto[2];
                        $duracion=$boleto[3];

                        if($tramo==2){
                             //Segundo tramo 
                            if($reserva_detalle->getEstadoRegistro()==0){
                                $color=' style="color:red;" ';
                                $etiqueta='<strike>';
                                $etiqueta2='</strike>';
                            }
                            
                            
                            $tabla_boletos_reserva.='<tr class="contenido_listado" '.$color.' >'."\n";
                            $tabla_boletos_reserva.='<td height="45" style="background-color: #E4F1F3;border: 1px solid #FFFFFF;"> </td>'."\n";
                            $tabla_boletos_reserva.='<td align="center" style="border: 1px solid #FFFFFF;background-color: #E4F1F3">'.$etiqueta.$reserva_detalle->getTicket().$etiqueta2.'</td>'."\n";
                            $tabla_boletos_reserva.='<td align="center" style="border: 1px solid #FFFFFF;background-color: #E4F1F3">'.$etiqueta.$reserva->getTipoVuelo().$etiqueta2.'</td>'."\n";

                            $fecha_hora_registro=explode(' ', $reserva->getFechaRegistro());

                            $tabla_boletos_reserva.='<td align="center" style="border: 1px solid #FFFFFF;background-color: #E4F1F3">'.$etiqueta.$fecha_hora_registro[0].'<br>'.$fecha_hora_registro[1].$etiqueta2.'</td>'."\n";
                            $tabla_boletos_reserva.='<td align="center" style="border: 1px solid #FFFFFF;background-color: #E4F1F3">'.$etiqueta.$tramo.$etiqueta2.'</td>'."\n";
                            $tabla_boletos_reserva.='<td align="center" style="border: 1px solid #FFFFFF;background-color: #E4F1F3">'.$etiqueta.$reserva->getVueloSalida().$etiqueta2.'</td>'."\n";
                            $tabla_boletos_reserva.='<td align="center" style="border: 1px solid #FFFFFF;background-color: #E4F1F3">'.$etiqueta.$reserva->getOrigen().$etiqueta2.'</td>'."\n";

                            $fecha_hora_salida=explode(' ', $reserva->getFechaSalida());

                            $tabla_boletos_reserva.='<td align="center" style="border: 1px solid #FFFFFF;background-color: #E4F1F3">'.$etiqueta.$fecha_hora_salida[0].'<br>'.$fecha_hora_salida[1].$etiqueta2.'</td>'."\n";
                            $tabla_boletos_reserva.='<td align="center" style="border: 1px solid #FFFFFF;background-color: #E4F1F3">'.$etiqueta.$reserva->getDestino().$etiqueta2.'</td>'."\n";

                            $fecha_hora_llegada=explode(' ', $reserva->getFechaSalida());

                            $tabla_boletos_reserva.='<td align="center" style="border: 1px solid #FFFFFF;background-color: #E4F1F3">'.$etiqueta.$fecha_hora_llegada[0].'<br>'.$fecha_hora_llegada[1].$etiqueta2.'</td>'."\n";
                            $tabla_boletos_reserva.='<td align="center" style="border: 1px solid #FFFFFF;background-color: #E4F1F3">'.$etiqueta.$duracion.$etiqueta2.'</td>'."\n";
                            $tabla_boletos_reserva.='<td align="center" style="border: 1px solid #FFFFFF;background-color: #E4F1F3">'.$etiqueta.$reserva->getClaseSalida().$etiqueta2.'</td>'."\n";
                            $tabla_boletos_reserva.='<td style="border: 1px solid #FFFFFF;background-color: #E4F1F3">'.$etiqueta.$reserva_detalle->getApellidos().', '.$reserva_detalle->getNombres().$etiqueta2.'</td>'."\n";
                            $tabla_boletos_reserva.='<td align="center" style="border: 1px solid #FFFFFF;background-color: #E4F1F3">'.$etiqueta.$reserva_detalle->getTotalPagar().$etiqueta2.'</td>'."\n";
                            $tabla_boletos_reserva.=$etiqueta2.'</tr>'."\n";
                        }else{
                             $cantidad_lista++;
                            //Primer tramo
                            if($reserva_detalle->getEstadoRegistro()==0){
                                $etiqueta='<strike>';
                                $etiqueta2='</strike>';
                                $color=' style="color:red;" ';
                                $display=' style="display:none;" ';
                                $checked=' disabled ';
                                $cantidad_anulados++;
                            }  
                            
                           $tabla_boletos_reserva.='<tr class="contenido_listado" '.$color.' >'."\n";
                           $tabla_boletos_reserva.='<td height="45" style="border: 1px solid #FFFFFF;" height="30" align="center">
                           <input '.$display.$checked.' type="checkbox" name="checkboxpnr[]" value="'.strtoupper($codigo_reserva).'/'.$reserva_detalle->getTicket().'" />    </td>'."\n";
                           $tabla_boletos_reserva.='<td align="center" style="border: 1px solid #FFFFFF;">'.$etiqueta.$reserva_detalle->getTicket().$etiqueta2.'</td>'."\n";
                           $tabla_boletos_reserva.='<td align="center" style="border: 1px solid #FFFFFF;">'.$etiqueta.$reserva->getTipoVuelo().$etiqueta2.'</td>'."\n";

                           $fecha_hora_registro=explode(' ', $reserva->getFechaRegistro());

                           $tabla_boletos_reserva.='<td align="center" style="border: 1px solid #FFFFFF;">'.$etiqueta.$fecha_hora_registro[0].'<br>'.$fecha_hora_registro[1].$etiqueta2.'</td>'."\n";
                           $tabla_boletos_reserva.='<td align="center" style="border: 1px solid #FFFFFF;">'.$etiqueta.$tramo.$etiqueta2.'</td>'."\n";
                           $tabla_boletos_reserva.='<td align="center" style="border: 1px solid #FFFFFF;">'.$etiqueta.$reserva->getVueloSalida().$etiqueta2.'</td>'."\n";
                           $tabla_boletos_reserva.='<td align="center" style="border: 1px solid #FFFFFF;">'.$etiqueta.$reserva->getOrigen().$etiqueta2.'</td>'."\n";

                           $fecha_hora_salida=explode(' ', $reserva->getFechaSalida());

                           $tabla_boletos_reserva.='<td align="center" style="border: 1px solid #FFFFFF;">'.$etiqueta.$fecha_hora_salida[0].'<br>'.$fecha_hora_salida[1].$etiqueta2.'</td>'."\n";
                           $tabla_boletos_reserva.='<td align="center" style="border: 1px solid #FFFFFF;">'.$etiqueta.$reserva->getDestino().$etiqueta2.'</td>'."\n";

                           $fecha_hora_llegada=explode(' ', $reserva->getFechaSalida());

                           $tabla_boletos_reserva.='<td align="center" style="border: 1px solid #FFFFFF;">'.$etiqueta.$fecha_hora_llegada[0].'<br>'.$fecha_hora_llegada[1].$etiqueta2.'</td>'."\n";
                           $tabla_boletos_reserva.='<td align="center" style="border: 1px solid #FFFFFF;">'.$etiqueta.$duracion.$etiqueta2.'</td>'."\n";
                           $tabla_boletos_reserva.='<td align="center" style="border: 1px solid #FFFFFF;">'.$etiqueta.$reserva->getClaseSalida().$etiqueta2.'</td>'."\n";
                           $tabla_boletos_reserva.='<td style="border: 1px solid #FFFFFF;">'.$etiqueta.$reserva_detalle->getApellidos().', '.$reserva_detalle->getNombres().$etiqueta2.'</td>'."\n";
                           $tabla_boletos_reserva.='<td align="center" style="border: 1px solid #FFFFFF;">'.$etiqueta.$reserva_detalle->getTotalPagar().$etiqueta2.'</td>'."\n";
                           $tabla_boletos_reserva.=$etiqueta2.'</tr>'."\n";

                           $monto_total=$monto_total+$reserva_detalle->getTotalPagar();
                        }
            } 

            if($cantidad_lista==$cantidad_anulados){
                $disabled_boton='display:none;';
            }
            $tabla_boletos_reserva.='</table>' . "\n";
            $tabla_boletos_reserva.='</td>' . "\n";
            $tabla_boletos_reserva.='<td></td>' . "\n";
            $tabla_boletos_reserva.='</tr>' . "\n";
            $tabla_boletos_reserva.='<tr>' . "\n";
            $tabla_boletos_reserva.='<td ><input type="hidden" name="total_recuperar" value="'.$monto_total.'" ></td>' . "\n";
            $tabla_boletos_reserva.='<td><input type="hidden" name="fecha_emision" value="'.$fecha_hora_registro[0]." ".$fecha_hora_registro[1].'" ></td>' . "\n";
            $tabla_boletos_reserva.='<td></td>' . "\n";
            $tabla_boletos_reserva.='</tr>' . "\n";
            $tabla_boletos_reserva.='<tr>' . "\n";
            $tabla_boletos_reserva.='<td></td>' . "\n";
            $tabla_boletos_reserva.='<td>' . "\n";
            $tabla_boletos_reserva.='<table width="1000" border="0" cellpadding="0" cellspacing="0">' . "\n";
            $tabla_boletos_reserva.='<tr>' . "\n";
            $tabla_boletos_reserva.='<td width="20"> <div style="'.$disabled_boton.'"><input  type="checkbox" name="marca_todos" id="marca_todos" onClick="MarcarTodos()" /> </div> </td>' . "\n";
            $tabla_boletos_reserva.='<td width="560"><div style="'.$disabled_boton.'" ><span style="text-decoration: underline;" onClick="document.getElementById(\'marca_todos\').click()">Marcar todos</span> (NOTA: Al anular todos los boletos, automáticamente anular&aacute; la reserva).</div></td>' . "\n";
            $tabla_boletos_reserva.='<td width="20">' . "\n";
            $tabla_boletos_reserva.='<input type="hidden" name="anular" id="anular" value="1" />' . "\n";
            $tabla_boletos_reserva.='<td width="260" id="resultado_chk" class="resultado"></td>' . "\n";
            $tabla_boletos_reserva.='<td width="140" align="right"><input type="submit" name="btnanular" id="btnanular" class="btn-red" value="Anular" style="'.$disabled_boton.'"/></td>' . "\n";
            $tabla_boletos_reserva.='</tr>' . "\n";
            $tabla_boletos_reserva.='</table>' . "\n";
            $tabla_boletos_reserva.='</td>' . "\n";
            $tabla_boletos_reserva.='<td></td>' . "\n";
            $tabla_boletos_reserva.='</tr>' . "\n";
            $tabla_boletos_reserva.='<tr>' . "\n";
            $tabla_boletos_reserva.='<td height="20"></td>' . "\n";
            $tabla_boletos_reserva.='<td></td>' . "\n";
            $tabla_boletos_reserva.='<td></td>' . "\n";
            $tabla_boletos_reserva.='</tr>' . "\n";
            $tabla_boletos_reserva.='</table>' . "\n";
            $tabla_boletos_reserva.='</form>' . "\n";
        }
    }
}

if($_REQUEST['anular']==1){
    if($_SESSION['s_entidad']!=''){
        $codigo_entidad=$_SESSION['s_entidad'];
        $array_anular=$_POST['checkboxpnr']; 
        $credito_recuperado=$_POST['total_recuperar']; 
        $fecha_emision=$_POST['fecha_emision']; 
        $partes_fecha_emision=explode(" ",$fecha_emision);
        $fecha_actual=date("Y-m-d");
        $resultado='';
        $tabla_boletos_reserva='';
        if($partes_fecha_emision[0]==$fecha_actual){

                $cantidad=count($array_anular);
                $pnr='';
                $lista_boletos='';
                for ($i=0; $i <$cantidad ; $i++) { 
                       $parametros_anular=explode("/", $array_anular[$i]);
                       $pnr =$parametros_anular[0];
                       $ticket= $parametros_anular[1];
                       
                       $res = $KIU->AirCancelRQ(array('IdReserva'=> $pnr, 'IdTicket' => $ticket),$err);
//                       echo "<pre>";
//                       print_r($res);
//                       echo "</pre>";
//                       $data = json_encode($res);
//                       echo "<script>console.log('$data')</script>";
                       if(isset($res["Error"])) {
                           if($res["Error"]["ErrorMsg"]!=''){
                             $tabla_boletos_reserva.='<p style="color:red;">No se pudo anular el boleto: '.$ticket.'.</p><br>';
                             $lista_boletos.=($i+1).") ".$ticket."  /  No se pudo anular. Error KIU: ".$res["Error"]["ErrorMsg"]."<br>";
                             $anulado = 0;
                             
                           }
                           $msj_anulacion = "<strong>Error al anular el (los) ticket(s).</strong>";
                       }else{
                           $res1 = $KIU->TravelItineraryReadRQ(array('IdReserva'=> $pnr, 'IdTicket' => $ticket),$err);
//                           $data = json_encode($res);
//                           echo "<script>console.log('$data')</script>";
                           if(isset($res1["Error"])) {
                                $msj_anulacion = "<strong>Anulacion exitosa.</strong>";
                                $lista_boletos.=($i+1).") ".$ticket."  /  Anulado<br>";
                                $anulado=1;
                                $obj_reserva->AnularTicket($ticket);
                           }
                           else{
                                $anulado=0;
                                $msj_anulacion = "<strong>Error al anular el (los) ticket(s).</strong>";
                                $tabla_boletos_reserva='<p style="color:red;">El boleto no pudo ser anulado por encontrarse Chequeado, favor siga los siguientes pasos:<br><br>
                                                            1.- Anule el Check In v&iacute;a <strong>www.starperu.com</strong> , opción ANULACI&Oacute;N DE CHECK IN.<br>
                                                            2.- Proceda a anular el boleto a trav&eacute;s de su portal.
                                                        </p>';
                           }
                       }
                       
                }

               
               if($anulado!=0){
                   $recupero=$obj_personal->ActualizarLineaCredito($codigo_entidad,$credito_recuperado,2);
                   $resultado=$obj_reserva->AnularReserva($pnr);
                    if($recupero==1){
                        $tabla_boletos_reserva='<p style="color:red;">Todos los boletos fueron anulados con éxito. Verique en la opción de "Movimientos" que el boleto esté resaltado de colo rojo.</p>';
                    }else{
                         $tabla_boletos_reserva='<p style="color:red;">Los boletos fueron anulados pero no se pudo recuperar el crédito. Comuníquese con StarPerú para solucionar el problema.</p>'; 
                    }
           $remitente = "ecel@starperu.com";
           $mail="perucompras@starperu.com,ricardo.jaramillo@starperu.com";
           $cabeceras = "Content-type: text/html\r\n";
           $cabeceras.= "From: ALERTA ".utf8_decode("ANULACIÓN")." TICKETS - PERU COMPRAS <$remitente>\r\n";
           $mensaje="La Entidad: ".$obj_personal->ObtenerNombreEntidad($codigo_entidad)."<br> RUC: ".$obj_personal->ObtenerRUCEntidad($codigo_entidad)." <br><br> ".utf8_decode("Intentó")." anular la Reserva: ".$pnr." y los siguientes boletos: <br><br> ";
           $mensaje.=$lista_boletos;
           $mensaje.="<br><br>Resultado: $msj_anulacion";
           $mensaje.="<br><br><b>Fecha/Hora (Emisi&oacute;n):</b> ".$partes_fecha_emision[0]." ".$partes_fecha_emision[1]."<br><br><b>Fecha/Hora (Intento):</b> ".date("Y-m-d H:i:s")." <br><br> Monto recuperado (&oacute; a recuperar): USD ".number_format($credito_recuperado, 2, '.', ',')."<br><br><br> <b>NOTA: Pasada la 23h 59m 59s del d&iacute;a de emisi&oacute;n, la Entidad se hace responsable del pago de los tickets emitidos.";
           mail($mail, utf8_decode("Anulación")." Tickets - PERU COMPRAS", $mensaje , $cabeceras);
               }

        }else{

            $tabla_boletos_reserva='<p style="color:red;">Ud. no puede realizar esta operación por haber excedido el tiempo límite de anulación.</p>'; 
        }    
        
           

        
    }else{
        $tabla_boletos_reserva='<p style="color:red;">La sesión ha termiando. Por favor ingrese nuevamente al Portal para realizar esta operación. Gracias.</p>';
    }
}
?>
