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
            if($_SESSION['s_tipo2']=='administrador'){
            $usuario_dni=trim($_REQUEST['usuario_dni']);
            }else {
            $usuario_dni=$_SESSION['s_dni'];    
            }
            
            $estado=$_REQUEST['estado'];
            $boleto=trim($_REQUEST['boleto']);
            $pnr=trim($_REQUEST['pnr']);
            $formaPago=$_REQUEST['formaPago'];
            $page = (int)(!isset($_POST['page']) ? 1 : $_POST['page']);
            $rp = (int)(!isset($_POST['rp']) ? 10 : $_POST['rp']);
            $start = (($page-1) * $rp);
            $limit = "LIMIT $start, $rp";
            $extra=1;
            $lista_movimientos=array();
            $lista_movimientos=$obj_movimiento->ListaMovimientos($_SESSION['s_entidad'],$fecha_inicio,$fecha_fin,$usuario_dni,$boleto,$pnr ,$limit,$extra,$formaPago,$estado);
            // var_dump($lista_movimientos);die;
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
                if($movimiento[9]=='visa'){
                        $tarjeta_imagen= "<img src='../../cp/images/met_pago/ico_vi.png' style='height:30px;'>";
                    }else if($movimiento[9]=='amex'){
                        $tarjeta_imagen= "<img src='../../cp/images/met_pago/ico_ax.png' style='height:30px;'>";
                    }else if($movimiento[9]=='dinersclub'){
                        $tarjeta_imagen= "<img src='../../cp/images/met_pago/ico_dc.jpg' style='height:30px;'>";
                    }else if($movimiento[9]=='mastercard'){
                        $tarjeta_imagen= "<img src='../../cp/images/met_pago/ico_mc.png' style='height:30px;'>";
                    }else{
                        $tarjeta_imagen="-";
                    }
                if($movimiento[8]->getTicket()!=''){
                    $icono_ticket='<a '.$metodo_click.' target="_blank"  href="../pasarela/imprimir_ticket.php?ticket='.$movimiento[8]->getTicket().'" ><img width="16px;" src="../images/'.$img_ticket.'"/></a>';
                    $comision_tarifa=number_format($movimiento[8]->getComisionTarifa(),2);
                    $porcentaje=$movimiento[7]->getPorcentaje()/100;
                    $total_pagar=$movimiento[8]->getTotalPagar();
                    $tarifa=$movimiento[8]->getEQ();
                    $igv=$movimiento[8]->getPE();
                    $tuua=$movimiento[8]->getHW();
                    $total_pagar_descuento=number_format(($tarifa-$comision_tarifa)+($igv-$igv*$porcentaje)+($tuua),2);
                    $comision=number_format($comision_tarifa,2);
                    if($movimiento[8]->getEstadoRegistro()==1){
                        $total_comision=number_format($total_comision+$comision/2,2);
                        $total_sin_descuento=$total_sin_descuento+$total_pagar/2;
                        $total=$total+$total_pagar_descuento/2;
                    }
                    
                }
                else{
                    $icono_ticket='';
                    $total_pagar="0.00";
                }
                $cant++;
                $data['rows'][] = array(
                    'view' => $movimiento[7]->getRegistro(),
                    'cell' => array('<div class="Consulta" style="text-align: center;">
                                <a href="javascript:void(0);" onClick=" Detalle_movimiento(
                                \''.$movimiento[7]->getRegistro().'\',  
                                \''.$movimiento[8]->getDetalle().'\',	
                                \''.$movimiento[7]->getCodigoReserva().'\',	
                                \''.$movimiento[0]->getRUC().'\',	
                                \''.$movimiento[3].'\',
                                \''.$movimiento[7]->getFechaRegistro().'\',
                                \''.$movimiento[8]->getTicket().'\',
                                \''.$movimiento[9].'\',
                                \''.$movimiento[10].'\',
                                \''.$movimiento[8]->getNombres().' '.$movimiento[8]->getApellidos().' '.trim($movimiento[8]->getApellidos2()).'\',
                                \''.$movimiento[1].'\',
                                \''.$movimiento[2].'\',
                                \''.$movimiento[11].'\',
                                \''.$movimiento[4].'\',
                                \''.$movimiento[7]->getTipoVuelo().'\',
                                \''.$movimiento[5].'\',
                                \''.$movimiento[7]->getVueloSalida().'\',
                                \''.$movimiento[7]->getOrigen().'\',
                                \''.$movimiento[7]->getFechaSalida().'\',
                                \''.$movimiento[7]->getDestino().'\',
                                \''.$movimiento[7]->getHoraRetorno().'\',
                                \''.$movimiento[6].'\',
                                \''.$porcentaje.'\',
                                \''.$comision_tarifa.'\',
                                \''.$total_pagar.'\');"  
                                ><img src="../images/icono_ver.png"/></a></div>',
                                $icono_ticket,
                                $movimiento[7]->getRegistro(),
                                $movimiento[7]->getCodigoReserva(),
                                $movimiento[7]->getRUCPasajero(),
                                $movimiento[3],
                                $movimiento[7]->getFechaRegistro(),
                                ($movimiento[8]->getEstadoRegistro()==1)?$movimiento[8]->getTicket():'<div style="text-align: center; width: 100px; color:red;"><del>'.$movimiento[8]->getTicket().'</del></div>',
                                ($movimiento[9]!==NULL)?'<a href="javascript:void(0);" onClick="Forma_pago(\''.$movimiento[7]->getRegistro().'\');">'.$tarjeta_imagen.'</a>':"-",
                                $movimiento[8]->getApellidos(),
                                trim($movimiento[8]->getApellidos2()),
                                $movimiento[8]->getNombres(),
                                $movimiento[1],
                                $movimiento[11],
                                $movimiento[4],
                                $movimiento[7]->getTipoVuelo(),
                                $movimiento[5],
                                $movimiento[7]->getVueloSalida(),
                                $movimiento[7]->getOrigen(),
                                $movimiento[7]->getFechaSalida(),
                                $movimiento[7]->getDestino(),
                                $movimiento[7]->getHoraRetorno(),
                                $movimiento[6],
                                ($movimiento[8]->getEstadoRegistro()==1 && $movimiento[8]->getTicket()<>"")?$total_pagar:'<div style="text-align: center; width: 100px; color:red;"><del>'.$total_pagar.'</del></div>',
                                ($movimiento[8]->getEstadoRegistro()==1 && $movimiento[8]->getTicket()<>"")?$total_pagar_descuento:'<div style="text-align: center; width: 100px; color:red;"><del>'.$total_pagar_descuento.'</del></div>',
                                ($movimiento[8]->getEstadoRegistro()==1 && $movimiento[8]->getTicket()<>"")?$comision:'<div style="text-align: center; width: 100px; color:red;"><del>'.$comision.'</del></div>',
                            )
                ); 
            }
            
            $data['total'] =$obj_movimiento->TotalMovimientos($_SESSION['s_entidad'],$fecha_inicio,$fecha_fin,$usuario,$boleto,$pnr);
            $data['rows'][] = array(
                                'cell' => array('','','','','','','','','','','','','','','','','','','',
                                    '','','','',
                                    '<div style="text-align: center; width: 100px; color:red;">'.$total_sin_descuento.'</div>',
                                    '<div style="text-align: center; width: 100px; color:red;">'.$total.'</div>',
                                    '<div style="text-align: center; width: 100px; color:red;">'.$total_comision.'</div>',
                                    )
                                ); 
            header("Content-type: text/x-json");
            echo json_encode($data);
}
                   
if($_REQUEST['listar']==1){
        $usuario_dni=trim($_REQUEST['usuario_dni']);
        $lista_delegados=array();
        $lista_delegados=$obj_personal->ListaDelegados($_SESSION['s_entidad']);

        if(count($lista_delegados)==0){
            echo '1';
        }else{
            $combo_delegados='<option value="">SELECCIONE</option>';    
            foreach ($lista_delegados as $delegado) {
                $combo_delegados.='<option '.(($usuario_dni==$delegado->getDNI()) ? 'selected': '' ).' value='.utf8_encode($delegado->getDNI()).'>'.utf8_encode($delegado->getNombres().' '.$delegado->getApellidoPaterno().' '.$delegado->getApellidoMaterno()).'</option>'."\n";
            }
            echo $combo_delegados;
        }

}
      
if($_REQUEST['excel']==1){
        // CONVIRTIENDO FECHAS
            $fecha_reporte=date('Y-m-d H:i:s');
            $fecha_inicio=trim($_REQUEST['fecha_inicial']);
            $fecha_fin=trim($_REQUEST['fecha_final']);
            $usuario_dni=trim($_REQUEST['usuario_dni']);
            $boleto=trim($_REQUEST['boleto']);
            $pnr=trim($_REQUEST['pnr']);
            $formaPago=$_REQUEST['formaPago'];
            $estado=$_REQUEST['estado'];
            
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
            $lista_movimientos=$obj_movimiento->ListaMovimientos($_SESSION['s_entidad'],$fecha_inicio,$fecha_fin,$usuario_dni,$boleto,$pnr,$limit,$extra,$formaPago,$estado);

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
                <TH class="excel" >RUC</TH>
                <TH class="excel">DNI Usuario</TH>
                <TH class="excel">Usuario</TH>
                <TH class="excel">Tipo Oper.</TH>
                <TH class="excel">Cant. Boletos</TH>
                <TH class="excel">Tip. Serv.</TH>
                <TH class="excel">Fec. Hora Operacion</TH>
                <TH class="excel" style="width: 150px;">Boleto</TH>
                <TH class="excel">Forma de Pago</TH>
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
                <td>".$movimiento[7]->getRUCPasajero()."</td>
                <td>".$movimiento[1]."</td>
                <td>".$movimiento[11]."</td>
                <td>".$movimiento[3]."</td>
                <td>".$movimiento[4]."</td>
                <td>".$movimiento[7]->getTipoVuelo()."</td>
                <td>".$movimiento[7]->getFechaRegistro()."</td>
                <td class='xl65'>".$movimiento[8]->getTicket()."</td>
                <td>".$movimiento[9]."</td>
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
if($_REQUEST['forma_pago']==1){
          $registro=trim($_REQUEST['registro']);
          $forma_pago=array();
          $forma_pago=$obj_movimiento->FormaPago($registro);
          foreach ($forma_pago as $fP){
          ?>
 <table width="2000" border="0" cellspacing="6" cellpadding="6" class="reporte">
        <tr>
            <td width="205" align="right" class="lab_dmov"><strong>Tarjeta :</strong></td>
            <td width="245"><?php echo $fP[0]; ?></td>
            <td width="8"></td>
            <td width="206" align="right" class="lab_dmov"><strong>Número de Tarjeta : </strong></td>
            <td width="232"><?php echo ($fP[1])?$fP[1]:'-'; ?></td>
        </tr>
        <tr>
            <td align="right" class="lab_dmov"><strong>Número de compra :</strong></td>
            <td><?php echo ($fP[2])?$fP[2]:'-'; ?></td>
            <td></td>
            <td align="right" class="lab_dmov"><strong>Fecha de transacción :</strong></td>
            <td><?php echo substr($fP[3], 0, 10); ?></td>
        </tr>
        <tr>
            <td align="right" class="lab_dmov"><strong>Hora de transacción :</strong></td>
            <td><?php echo date('h:i:s A', strtotime(substr($fP[3], 11, 20))); ?></td>
            <td></td>
            <?php if($fP[6]==1 && $fP[2]!==NULL){ ?>
            <td align="right" class="lab_dmov"><strong>Monto :</strong></td>
            <td><?php echo $fP[4]; ?></td>
            <?php }  else{?>
            <td align="right" class="lab_dmov"><strong>Monto :</strong></td>
            <td style="color:red;"><del><?php echo $fP[4]; ?></del></td>
            <?php }?>
        </tr>
        <tr>
            <td align="right" class="lab_dmov"><strong>Número de cuotas :</strong></td>
            <td><?php echo ($fP[5])?$fP[5]:'Sin cuotas';?></td>
            <td></td>
            <td align="right" class="lab_dmov"><strong>Estado :</strong></td>
            <?php if($fP[6]==1 && $fP[8]=="Authorized"){ ?>
            <td style="color:green;"><?php echo $fP[8]; ?></td>
            <?php } else if($fP[6]==0 && $fP[8]=="Authorized"){?>
            <td style="color:red;"><del><?php echo $fP[8]; ?></del></td>
            <?php }else{?>
            <td style="color:red;"><?php echo $fP[8]; ?></td>
            <?php }?>
        </tr>
        <tr>
           <?php if($fP[6]==1){ ?>
            <td></td>
            <?php } else{ ?>
            <td></td>
            <td><h5 style="color: red;"><strong>Boleto Anulado</strong></h5></td>
            <?php }?> 
        </tr>
        <tr>-----------------------------------------------------------------------------------------------------------------------</tr>
    </table>
   <?php
    }
    // TERMINA FOREACH
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
          $tarjeta=trim($_REQUEST['tarjeta']);
          $num_tarjeta=trim($_REQUEST['num_tarjeta']);
          $numero_vuelo=trim($_REQUEST['numero_vuelo']);
          $origen=trim($_REQUEST['origen']);
          $fecha_hora_salida=trim($_REQUEST['fecha_hora_salida']);
          $destino=trim($_REQUEST['destino']);
          $fecha_hora_retorno=trim($_REQUEST['fecha_hora_retorno']);
          $nro_documento=trim($_REQUEST['nro_documento']);
          $total_pagar=trim($_REQUEST['total_pagar']);
          $nom_usuario=trim($_REQUEST['nom_usuario']);
          $porcentaje=trim($_REQUEST['porcentaje']);
            
          $lista_movimientos=array();
          $lista_movimientos=$obj_movimiento->DetalleMovimiento($registro,$detalle);
            // var_dump($lista_movimientos);die;
            foreach ($lista_movimientos as $movimiento){
          ?>
 <table width="1500" border="0" cellspacing="6" cellpadding="6" class="reporte">
    <tr>
            <td width="400" colspan="2" align="center"><h5 style="text-transform: uppercase;"><strong>Agencia</strong></h5></td>
            <td width=""></td>
            <td width="400" colspan="2" align="center"><h5 style="text-transform: uppercase;"><strong>Vuelo</strong></h5></td>
            <td width=""></td>
            <td width="400" colspan="2" align="center"><h5 style="text-transform: uppercase;"><strong>Tarifa del pasajero</strong></h5></td>
        </tr>
        <tr>
            <td align="right" class="lab_dmov"><strong>RUC Proveedor :</strong></td>
            <td><?php echo $movimiento[1];?></td>
            <td></td>
            <td align="right" class="lab_dmov"><strong>Origen : </strong></td>
            <td><?php echo $origen; ?></td>
            <td></td>
            <td align="right" class="lab_dmov"><strong>Tarifa : </strong></td>
            <td><?php echo number_format($movimiento[18]->getEQ(), 2);?></td>
        </tr>
        <tr>
            <td align="right" class="lab_dmov"><strong>RUC Agencia :</strong></td>
            <td><?php echo $ruc_entidad; ?></td>
            <td></td>
            <td align="right" class="lab_dmov"><strong>Destino :</strong></td>
            <td><?php  echo $destino; ?></td>
            <td></td>
            <td align="right" class="lab_dmov"><strong>IGV :</strong></td>
            <td><?php echo number_format($movimiento[18]->getPE(),2);?></td>
        </tr>
        <tr>
            <td align="right" class="lab_dmov"><strong>DNI Funcionario :</strong></td>
            <td><?php echo $movimiento[0]->getDNIFuncionario();?></td>
            <td></td>
            <td align="right" class="lab_dmov"><strong>Fecha / Hora Origen :</strong></td>
            <td><?php echo $fecha_hora_salida; ?></td>
            <td></td>
            <td align="right" class="lab_dmov"><strong>TUUA :</strong></td>
            <td><?php echo number_format($movimiento[18]->getHW(),2);?></td>
        </tr>
        <tr>
            <td align="right" class="lab_dmov"><strong>Usuario :</strong></td>
            <td><?php echo $nom_usuario;?></td>
            <td></td>
            <td align="right" class="lab_dmov"><strong>Fecha / Hora Destino :</strong></td>
            <td><?php echo $fecha_hora_retorno; ?></td>
            <td></td>
            <td align="right" class="lab_dmov"><strong>Total :</strong></td>
            <td><?php echo $movimiento[18]->getTotalPagar();?></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td align="right" class="lab_dmov"><strong>Duración :</strong></td>
            <td><?php echo $movimiento[7];?></td>
        </tr>
        <tr>
            <td width="" colspan="2" align="center"><h5 style="text-transform: uppercase;"><strong>Pasajero</strong></h5></td>
            <td></td>
            <td align="right" class="lab_dmov"><strong>Escala Tarifa :</strong></td>
            <td><?php echo $movimiento[17]->getClaseSalida();?></td>
            <td></td>
            <td colspan="2" align="center"><h5  style="text-transform: uppercase;"><strong>Tarifa de la agencia</strong></h5></td>
        </tr>
        <tr>
            <td align="right" class="lab_dmov"><strong>Doc. Identidad :</strong></td>
            <td><?php echo $nro_documento; ?></td>
            <td></td>
            <td align="right" class="lab_dmov"><strong>Tipo Operación :</strong></td>
            <td><?php echo $tipo_operacion; ?></td>
            <td></td>
            <td align="right" class="lab_dmov" ><strong>Tarifa : </strong></td>
            <td><?php echo number_format($movimiento[18]->getEQ()-$movimiento[18]->getComisionTarifa(), 2);?></td>
        </tr>
        <tr>
            <td align="right" class="lab_dmov"><strong>Pasajero :</strong></td>
            <td><?php echo $nombres_pasajero;?></td>
            <td></td>
            <td align="right" class="lab_dmov"><strong>Cantidad Boletos :</strong></td>
            <td><?php echo $cantidad_boleto; ?></td>
            <td></td>
            <td align="right" class="lab_dmov"><strong>IGV :</strong></td>
            <td><?php echo number_format($movimiento[18]->getPE()-$movimiento[18]->getPE()*$porcentaje, 2);?></td>
        </tr>
        <tr>
            <td align="right" class="lab_dmov"><strong>E-mail :</strong></td>
            <td><?php echo $movimiento[18]->getEmail();?></td>
            <td></td>
            <td align="right" class="lab_dmov"><strong>Tipo Vuelo :</strong></td>
            <td><?php echo $tipo_vuelo;?></td>
            <td></td>
            <td align="right" class="lab_dmov"><strong>TUUA :</strong></td>
            <td><?php echo number_format($movimiento[18]->getHW(),2);?></td>
        </tr>
        <tr>
            <td align="right" class="lab_dmov"><strong>Telf. Ofic.:</strong></td>
            <td><?php echo $movimiento[18]->getTelefono();?></td>
            <td></td>
            <td align="right" class="lab_dmov"><strong>Fecha Operación :</strong></td>
            <td><?php echo $fecha_registro;?></td>
            <td></td>
            <td align="right" class="lab_dmov"><strong>Total :</strong></td>
            <td><?php echo number_format(($movimiento[18]->getEQ()-$movimiento[18]->getComisionTarifa())+($movimiento[18]->getPE()-$movimiento[18]->getPE()*$porcentaje)+($movimiento[18]->getHW()),2);?></td>
        </tr>
        <tr>
            <td align="right" class="lab_dmov"><strong>Telf. Celular:</strong></td>
            <td><?php echo $movimiento[18]->getCelular();?></td>
            <td></td>
            <td align="right" class="lab_dmov"><strong>Nº Boleto :</strong></td>
            <td><?php echo $ticket;?></td>
            <td></td>
            <td align="right" class="lab_dmov"><strong>Comisión :</strong></td>
            <td><?php echo number_format($movimiento[18]->getComisionTarifa(),2); ?></td>
        </tr>
        <tr>
            <td align="right" class="lab_dmov"><strong>Forma de pago :</strong></td>
            <td><?php echo $tarjeta;?></td>
            <td></td>
            <td align="right" class="lab_dmov"><strong>Nº Vuelo :</strong></td>
            <td><?php echo $numero_vuelo;?></td>
        </tr>
        <tr>
            <td align="right" class="lab_dmov"><strong>Número de tarjeta  :</strong></td>
            <td><?php echo $num_tarjeta;?></td>
            <td></td>
            <td align="right" class="lab_dmov"><strong>Tramo :</strong></td>
            <td><?php echo $tramo; ?></td>
        </tr>
        <tr>
            <td align="right" class="lab_dmov"><strong>Categoría Pasajero :</strong></td>
            <td><?php echo $movimiento[18]->getTipoPax();?></td>
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
