<?php
session_start();
error_reporting(E_ALL);
ini_set("display_errors",0);
require_once("../../cn/STARPERU/Modelo/ReservaModelo.php");
require_once("../../cn/STARPERU/Modelo/PersonalModelo.php");
include "../../cn/KIU/KIU_Controller_class.php";

$obj_personal=new PersonalModelo();
$obj_movimiento=new ReservaModelo();

if($_REQUEST['obtener_linea_credito']==1){ 

    $codigo_entidad=$_SESSION['s_entidad'];
    $linea_credito=$obj_personal->ObtenerLineaCredito($codigo_entidad);
    if($linea_credito!=""){
        echo trim($linea_credito);
    }
}

if($_REQUEST['movimientos']==1){
            // CONVIRTIENDO FECHAS
            $fecha_inicio=trim($_REQUEST['fecha_inicial']);
            $fecha_fin=trim($_REQUEST['fecha_final']);

            if($fecha_inicio!=''){
                $fecha_inicio = str_replace("/", "-", $fecha_inicio);
                $fecha_inicio= date('Y-m-d',strtotime($fecha_inicio));
            }
            if($fecha_fin!=''){
                    $fecha_fin = str_replace("/", "-", $fecha_fin);
                    $fecha_fin= date('Y-m-d',strtotime($fecha_fin));
            }

            $usuario=trim($_REQUEST['usuario']);
            $boleto=trim($_REQUEST['boleto']);
            $pnr=trim($_REQUEST['pnr']);
            $page = (int)(!isset($_POST['page']) ? 1 : $_POST['page']);
            $rp = (int)(!isset($_POST['rp']) ? 10 : $_POST['rp']);
            $start = (($page-1) * $rp);
            $limit = "LIMIT $start, $rp";
            $extra=1;
            $lista_movimientos=array();
            $lista_movimientos=$obj_movimiento->ListaMovimientos($_SESSION['s_entidad'],$fecha_inicio,$fecha_fin,$usuario,$boleto,$pnr ,$limit,$extra);

            $data = array();
            $data['page'] = $page;
            $data['rows'] = array();
            $cant=0;

                    foreach ($lista_movimientos as $movimiento){
                                    if($movimiento[8]->getEstadoRegistro()==1){
                                        $img_ticket="ticket.png";
                                        $metodo_click=' ';
                                    }else{
                                        $img_ticket="ticket_anulado.png";
                                        $metodo_click=" onClick='alert(\"Su boleto ha sido anulado\");return false;' ";
                                    }
                                    
                                    if($movimiento[8]->getTicket()!=''){
                                        $icono_ticket='<a '.$metodo_click.' target="_blank"  href="../pasarela/imprimir_ticket.php?ticket='.$movimiento[8]->getTicket().'" ><img width="16px;" src="../images/'.$img_ticket.'"/></a>';
                                        $total_pagar=$movimiento[8]->getTotalPagar();
                                    }else{
                                        $icono_ticket='';
                                        $total_pagar="0.00";
                                    }
                                   $cant++;

                                    $data['rows'][] = array(
                                      'view' => $movimiento[7]->getRegistro(),
                                      'cell' => array('<div class="Consulta" style="text-align: center;">
                                          <a href="javascript:void(0);" onClick=" Detalle_movimiento(\''.$movimiento[7]->getRegistro().'\',\''.$movimiento[8]->getDetalle().'\',\''.$movimiento[7]->getCodigoReserva().'\',\''.$movimiento[0]->getRUC().'\',\''
                                          .$movimiento[3].'\',\''.$movimiento[7]->getFechaRegistro().'\',\''.$movimiento[8]->getTicket().'\',\''.$movimiento[8]->getNombres().' '.$movimiento[8]->getApellidos().' '.trim($movimiento[8]->getApellidos2()).'\',\''.$movimiento[1].'\',\''.$movimiento[2].'\',\''.$movimiento[4].'\',\''.$movimiento[7]->getTipoVuelo().'\',\''.$movimiento[5].'\',\''.$movimiento[7]->getVueloSalida().'\',\''
                                          .$movimiento[7]->getOrigen().'\',\''.$movimiento[7]->getFechaSalida().'\',\''.$movimiento[7]->getDestino().'\',\''.$movimiento[7]->getHoraRetorno().'\',\''.$movimiento[6].'\',\''.$total_pagar.'\');"  
                                           ><img src="../images/icono_ver.png"/></a></div>',
                                          $icono_ticket,
                                          $movimiento[7]->getRegistro(),
                                          $movimiento[7]->getCodigoReserva(),
                                          $movimiento[0]->getRUC(),
                                          $movimiento[3],
                                          $movimiento[7]->getFechaRegistro(),
                                          $movimiento[8]->getTicket(),
                                          $movimiento[8]->getApellidos(),
                                          trim($movimiento[8]->getApellidos2()),
                                          $movimiento[8]->getNombres(),
                                          $movimiento[1],
                                          $movimiento[2],
                                          $movimiento[4],
                                          $movimiento[7]->getTipoVuelo(),
                                          $movimiento[5],
                                          $movimiento[7]->getVueloSalida(),
                                          $movimiento[7]->getOrigen(),
                                          $movimiento[7]->getFechaSalida(),
                                          $movimiento[7]->getDestino(),
                                          $movimiento[7]->getHoraRetorno(),
                                          $movimiento[6],
                                          $total_pagar,
                                          )
                                      ); 

                     }

                    $data['total'] =$obj_movimiento->TotalMovimientos($_SESSION['s_entidad'],$fecha_inicio,$fecha_fin,$usuario,$boleto,$pnr);
                    header("Content-type: text/x-json");
                    echo json_encode($data);
            }
                   
if($_REQUEST['listar']==1){
       
        $lista_delegados=array();
        $lista_delegados=$obj_personal->ListaDelegados($_SESSION['s_entidad']);

        if(count($lista_delegados)==0){
            echo '1';
        }else{
            $combo_delegados='<option value="">SELECCIONE</option>';    
            foreach ($lista_delegados as $delegado) {
                $combo_delegados.='<option value='.utf8_encode($delegado->getDNI()).'>'.utf8_encode($delegado->getNombres().' '.$delegado->getApellidoPaterno().' '.$delegado->getApellidoMaterno()).'</option>'."\n";
            }
            echo $combo_delegados;
        }

}
      
if($_REQUEST['excel']==1){
        // CONVIRTIENDO FECHAS
            $fecha_reporte=date('Y-m-d H:i:s');
            $fecha_inicio=trim($_REQUEST['fecha_inicial']);
            $fecha_fin=trim($_REQUEST['fecha_final']);

            if($fecha_inicio!=''){
                $fecha_inicio = str_replace("/", "-", $fecha_inicio);
                $fecha_inicio= date('Y-m-d',strtotime($fecha_inicio));
            }
            if($fecha_fin!=''){
                    $fecha_fin = str_replace("/", "-", $fecha_fin);
                    $fecha_fin= date('Y-m-d',strtotime($fecha_fin));
            }
            ////
            $extra=0;
            
            $lista_movimientos=array();
            $lista_movimientos=$obj_movimiento->ListaMovimientos($_SESSION['s_entidad'],$fecha_inicio,$fecha_fin,$usuario,$boleto,$pnr,$limit,$extra);
            
            header("Content-Type: application/vnd.ms-excel" );
            header("Expires: 0");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0" );
            header("content-disposition: attachment;filename=Reporte_Movimientos-$fecha_reporte.xls" );
             
            ?>
<HTML lang="es-PE"><HEAD>
                <TITLE>::. Exportacion de Datos .::</TITLE>
                <style type="text/css">
                    
                    .xl65
                     {
                     mso-style-parent:style0;
                     mso-number-format:"\@";
                     }

                    .excel{
                            background-color: #FF0000;
                            color:#FFFFFF;

                        }
                    </style>
                </head>
                <body>
                <TABLE BORDER=1 align="center" CELLPADDING=1 CELLSPACING=1>
                    <TR>
                        <TH colspan="18" class="excel">Reporte Movimientos del <?php echo $fecha_inicio; ?> hasta <?php echo $fecha_fin; ?></TH>  
                    </TR>
                <TR>
                <TH class="excel">ID. Mov</TH>  
                <TH class="excel" >RUC Entidad</TH>
                <TH class="excel">Gestor</TH>
                <TH class="excel">Delegado</TH>
                <TH class="excel">Tipo Oper.</TH>
                <TH class="excel">Cant. Boletos</TH>
                <TH class="excel">Tip. Serv.</TH>
                <TH class="excel">Fec. Hora Operacion</TH>
                <TH class="excel" style="width: 150px;">Boleto</TH>
                <TH class="excel">Tramo</TH>
                <TH class="excel">Nro Vuelo</TH>
                <TH class="excel">Origen</TH>
                <TH class="excel">Fec. Hora Origen</TH>
                <TH class="excel">Destino</TH>
                <TH class="excel">Fec. Hora Llegada</TH>
                <TH class="excel">Documento Pasajero</TH>
                <TH class="excel">Nombre Pasajero</TH>
                <TH class="excel">Importe</TH>
                </TR>
                <?php
//                if(){
//                   $color='style="color:red;"'; 
//                }
                foreach ($lista_movimientos as $movimiento){
                echo '<tr '.$color.'>
                <td>'.$movimiento[7]->getCodigoReserva()."</td>
                <td>".$movimiento[0]->getRUC()."</td>
                <td>".$movimiento[1]."</td>
                <td>".$movimiento[2]."</td>
                <td>".$movimiento[3]."</td>
                <td>".$movimiento[4]."</td>
                <td>".$movimiento[7]->getTipoVuelo()."</td>
                <td>".$movimiento[7]->getFechaRegistro()."</td>
                <td class='xl65'>".$movimiento[8]->getTicket()."</td>
                <td>".$movimiento[5]."</td>
                <td>".$movimiento[7]->getVueloSalida()."</td>
                <td>".$movimiento[7]->getOrigen()."</td>
                <td>".$movimiento[7]->getFechaSalida()."</td>
                <td>".$movimiento[7]->getDestino()."</td>
                <td>".$movimiento[7]->getHoraRetorno()."</td>
                <td>".$movimiento[6]."</td>
                <td>".$movimiento[8]->getNombres()."</td>
                <td>". number_format($movimiento[8]->getTotalPagar(),2)."</td>
                </tr>";
                }
                ?>
                </table>
                </body>
                </html>
                <?php
}

if($_REQUEST['movimiento_detalle']==1){
      
          $registro=trim($_REQUEST['registro']);
          $detalle=trim($_REQUEST['detalle']);
          $codigo_reserva=trim($_REQUEST['codigo_reserva']);
          $ruc_entidad=trim($_REQUEST['ruc_entidad']);
          $tipo_operacion=trim($_REQUEST['tipo_operacion']);
          $fecha_registro=trim($_REQUEST['fecha_registro']);
          $nombres_pasajero=trim($_REQUEST['nombres_pasajero']);
          $gestor=trim($_REQUEST['gestor']);
          $delegado=trim($_REQUEST['delegado']);
          $cantidad_boleto=trim($_REQUEST['cantidad_boleto']);
          $tipo_vuelo=trim($_REQUEST['tipo_vuelo']);
          $tramo=trim($_REQUEST['tramo']);
          $ticket=trim($_REQUEST['ticket']);
          $numero_vuelo=trim($_REQUEST['numero_vuelo']);
          $origen=trim($_REQUEST['origen']);
          $fecha_hora_salida=trim($_REQUEST['fecha_hora_salida']);
          $destino=trim($_REQUEST['destino']);
          $fecha_hora_retorno=trim($_REQUEST['fecha_hora_retorno']);
          $nro_documento=trim($_REQUEST['nro_documento']);
          $total_pagar=trim($_REQUEST['total_pagar']);
          
            $lista_movimientos=array();
            $lista_movimientos=$obj_movimiento->DetalleMovimiento($registro,$detalle);
            foreach ($lista_movimientos as $movimiento){
          ?>
 <table width="1503" border="0" cellspacing="6" cellpadding="6" class="reporte">
    <tr>
            <td width="205" align="right" class="lab_dmov"><strong>Id Movimiento :</strong></td>
            <td width="245"><?php echo $registro; ?></td>
            <td width="8"> </td>
            <td width="206" align="right" class="lab_dmov"><strong>Origen : </strong></td>
            <td width="232"><?php echo $origen; ?></td>
            <td width="8"> </td>
            <td width="187" align="right" class="lab_dmov"><strong>Tarifa : </strong></td>
            <td width="262"><?php echo number_format($movimiento[18]->getEQ(), 2);?></td>
        </tr>
        <tr>
            <td align="right" class="lab_dmov"><strong>RUC Proveedor :</strong></td>
            <td><?php echo $movimiento[1];?></td>
            <td></td>
            <td align="right" class="lab_dmov"><strong>Fecha / Hora Origen :</strong></td>
            <td><?php echo $fecha_hora_salida; ?></td>
            <td></td>
            <td align="right" class="lab_dmov"><strong>Tarifa Sobre Combustible :</strong></td>
            <td>0.00</td>
        </tr>
        <tr>
            <td align="right" class="lab_dmov"><strong>RUC Entidad :</strong></td>
            <td><?php echo $ruc_entidad; ?></td>
            <td></td>
            <td align="right" class="lab_dmov"><strong>Destino :</strong></td>
            <td><?php  echo $destino; ?></td>
            <td></td>
            <td align="right" class="lab_dmov"><strong>Tarifa Total :</strong></td>
            <td><?php echo number_format($movimiento[18]->getEQ(),2);?></td>
        </tr>
        <tr>
            <td align="right" class="lab_dmov"><strong>DNI Funcionario :</strong></td>
            <td><?php echo $movimiento[0]->getDNIFuncionario();?></td>
            <td></td>
            <td align="right" class="lab_dmov"><strong>Fecha / Hora Destino :</strong></td>
            <td><?php echo $fecha_hora_retorno; ?></td>
            <td></td>
            <td align="right" class="lab_dmov"><strong>IGV :</strong></td>
            <td><?php echo number_format($movimiento[18]->getPE(),2);?></td>
        </tr>
        <tr>
            <td align="right" class="lab_dmov"><strong>Usuario Gestor :</strong></td>
            <td><?php echo $gestor;?></td>
            <td></td>
            <td align="right" class="lab_dmov"><strong>Duración :</strong></td>
            <td><?php echo $movimiento[6];?></td>
            <td></td>
            <td align="right" class="lab_dmov"><strong>TUUA :</strong></td>
            <td><?php echo number_format($movimiento[18]->getHW(),2);?></td>
        </tr>
        <tr>
            <td align="right" class="lab_dmov"><strong>Usuario Delegado :</strong></td>
            <td><?php echo $delegado;?></td>
            <td></td>
            <td align="right" class="lab_dmov"><strong>Escala Tarifa :</strong></td>
            <td><?php echo $movimiento[17]->getClaseSalida();?></td>
            <td></td>
            <td align="right" class="lab_dmov"><strong>IGV TUUA :</strong></td>
            <td><?php echo number_format($movimiento[10],2);?></td>
        </tr>
        <tr>
            <td align="right" class="lab_dmov"><strong>Doc. Identidad Pasajero :</strong></td>
            <td><?php echo $nro_documento; ?></td>
            <td></td>
            <td align="right" class="lab_dmov"><strong>Precio Final :</strong></td>
            <td><?php echo number_format($total_pagar,2); ?></td>
        </tr>
        <tr>
            <td align="right" class="lab_dmov"><strong>Tipo Operación :</strong></td>
            <td><?php echo $tipo_operacion; ?></td>
            <td></td>
            <td align="right" class="lab_dmov"><strong>Categoría Pasajero :</strong></td>
            <td><?php echo $movimiento[18]->getTipoPax();?></td>
            <td></td>
            <td align="right" class="lab_dmov"><strong>Comisión Servicio :</strong></td>
            <td><?php echo number_format($movimiento[11],2);?></td>
        </tr>
        <tr>
            <td align="right" class="lab_dmov"><strong>Cantidad Boletos :</strong></td>
            <td><?php echo $cantidad_boleto; ?></td>
            <td></td>
            <td align="right" class="lab_dmov"><strong>Pasajero :</strong></td>
            <td><?php echo $nombres_pasajero;?></td>
            <td></td>
            <td align="right" class="lab_dmov"><strong>Penalidad :</strong></td>
            <td><?php echo number_format($movimiento[12],2);?></td>
        </tr>
        <tr>
            <td align="right" class="lab_dmov"><strong>Tipo Servicio :</strong></td>
            <td><?php echo $tipo_vuelo;?></td>
            <td></td>
            <td align="right" class="lab_dmov"><strong>E-mail Pasajero :</strong></td>
            <td><?php echo $movimiento[18]->getEmail();?></td>
            <td></td>
            <td align="right" class="lab_dmov"><strong>Diferencia Tarifa :</strong></td>
            <td><?php echo number_format($movimiento[13],2);?></td>
        </tr>
        <tr>
            <td align="right" class="lab_dmov"><strong>Fecha Operación :</strong></td>
            <td><?php echo $fecha_registro;?></td>
            <td></td>
            <td align="right" class="lab_dmov"><strong>Telf. Ofic. Pasajero :</strong></td>
            <td><?php echo $movimiento[18]->getTelefono();?></td>
            <td></td>
            <td align="right" class="lab_dmov"><strong>Tipo Moneda :</strong></td>
            <td><?php echo $movimiento[14];?></td>
        </tr>
        <tr>
            <td align="right" class="lab_dmov"><strong>Nº Boleto :</strong></td>
            <td><?php echo $ticket;?></td>
            <td></td>
            <td align="right" class="lab_dmov"><strong>Telf. Celular Pasajero :</strong></td>
            <td><?php echo $movimiento[18]->getCelular();?></td>
            <td></td>
            <td align="right" class="lab_dmov"><strong>Precio Final :</strong></td>
            <td><?php echo number_format($total_pagar,2);?></td>
        </tr>
        <tr>
            <td align="right" class="lab_dmov"><strong>Referencia Boleto :</strong></td>
            <td><?php echo $movimiento[18]->getReferencia();?></td>
            <td></td>
            <td align="right" class="lab_dmov"><strong>Telf. RPM Pasajero :</strong></td>
            <td><?php echo $movimiento[18]->getRPM();?></td>
            <td></td>
            <td align="right" class="lab_dmov"><strong>Descuento Tarifa :</strong></td>
            <td><?php echo number_format($movimiento[15],2);?></td>
        </tr>
        <tr>
            <td align="right" class="lab_dmov"><strong>Tramo :</strong></td>
            <td><?php echo $tramo; ?></td>
            <td></td>
            <td align="right" class="lab_dmov"><strong>Telf. RPC Pasajero :</strong></td>
            <td><?php echo $movimiento[18]->getRPC();?></td>
            <td></td>
            <td align="right" class="lab_dmov"><strong>Desc Acu. :</strong></td>
            <td><?php echo $movimiento[16];?></td>
        </tr>
        <tr>
            <td align="right" class="lab_dmov"><strong>Nº Vuelo :</strong></td>
            <td><?php echo $numero_vuelo;?></td>
            <td></td>
            <td align="right" class="lab_dmov"><strong>Telf. Nextel Pasajero :</strong></td>
            <td><?php echo $movimiento[18]->getNextel();?></td>
            <td></td>
            <td align="right" class="lab_dmov"><strong>Costo Tramo :</strong></td>
            <td><?php echo number_format($total_pagar,2); ?></td>
        </tr>
        <tr>
            <!--<td height="30" colspan="2"><img width="16" height="16" border="0" style="cursor: pointer" onclick="ExportarExcelDetalleMov('00064750')" src="../images/excel.png"> <a onclick="ExportarExcelDetalleMov('00064750')" href="javascript:void(0)">Exportar Detalle</a></td>-->
            <td> </td>
            <td> </td>
            <td> </td>
            <td> </td>
            <td> </td>
            <td> </td>
        </tr>
    </table>
   <?php
    }
    // TERMINA FOREACH
}
    

if( isset($_REQUEST["ticket"])){
       
        if($_REQUEST["ticket"]!=""){
                    $ticket = $_REQUEST["ticket"];
                    $KIU = new KIU_Controller();
                    $res_ticket=array();
                    $res_ticket = $KIU->TravelItineraryReadRQ(array('IdTicket'=>$ticket),$err);    
                    if($res_ticket['Error']['ErrorCode'] != 0){
                         /*MOSTRAR PANTALLA DE ERROR*/
                          echo $res_ticket['Error']['ErrorCode']." - ".$res_ticket['Error']['ErrorMsg'];
                          die;
                    }
                    $res_ticket["ItineraryInfo"]["Ticketing"]["TicketAdvisory"] = str_replace('cid:imagen', '../../cp/images/LogoStar.png', $res_ticket["ItineraryInfo"]["Ticketing"]["TicketAdvisory"]);

                    if(count($res_ticket["ItineraryInfo"]["Ticketing"]["TicketAdvisory"])==0){
                      $res_ticket["ItineraryInfo"]["Ticketing"]["TicketAdvisory"]='N&Uacute;MERO DE TICKET INV&Aacute;LIDO, EL TICKET HA SIDO ANULADO./ INVALID TICKET NUMBER';
                    }
              
            }else{
                    echo 'NO SE HA GENERADO EL TICKET';
                    die;
            }
       
}

?>
