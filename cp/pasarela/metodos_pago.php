<?php
use ___PHPSTORM_HELPERS\object;
if (!isset($url_proyecto)) {
    session_start();
    $URL_DEFINIDO='../..';
    $URL_PATH='..';
}
else{
    $URL_DEFINIDO=PATH_PROYECTO;
    $URL_PATH=$url_proyecto.'/cp';
}

include $URL_DEFINIDO.'/cn/METODOS_PAGO/Connection_visa.php';
require_once($URL_DEFINIDO."/cn/STARPERU/Modelo/ReservaModelo.php");
require_once($URL_DEFINIDO."/cn/STARPERU/Modelo/VisaModelo.php");
require_once $URL_DEFINIDO.'/cd/Funciones/f_metodos_pagos.php';
require_once $URL_DEFINIDO.'/cd/Funciones/f_kiu.php';
require_once $URL_DEFINIDO.'/cd/Funciones/DB_driver.php';
include $URL_DEFINIDO."/cn/KIU/KIU_Controller_class.php";


if (isset($_POST['transactionToken']) && isset($_SESSION['registro_id'])) {
    $id_registro = $_SESSION['registro_id'];
    $sess_token_seguridad_visa = $_SESSION['token_seguridad_visa'];
    $visa_proceso = new Connection_visa();

    $obj_reserva = new ReservaModelo();
    $obj_visa = new VisaModelo();
    $obj_db_driver = new DB_driver();
    $tokenFormulario = $_POST['transactionToken'];
    $campos = 'Tipo_Doc,Documento,Total,CodigoReserva,RUC,FechaRegistro,Nombres,Apellidos,Email';
    $data_reserva = $obj_reserva->ObtenerDataRerservaVisa($id_registro);
    // var_dump($sess_token_seguridad_visa);
    while ($fila = mysqli_fetch_object($data_reserva)) {
        $tipo_documento = $fila->Tipo_Doc;
        $num_documento = $fila->Documento;
        $total_pagar = $fila->Total;
        $pnr = $fila->CodigoReserva;
        $ruc = $fila->RUC;
        $tipo_viaje_cc = $fila->TipoVuelo;
        $fecha_salida_ida_cc = $fila->Fecha_Salida;
        $hora_salida_ida_cc = $fila->Hora_Salida;
        $fecha_salida_vuelta_cc = $fila->Fecha_Retorno;
        $hora_llegada_vuelta_cc = $fila->Hora_Retorno;
        $numero_vuelo_ida_cc = $fila->Vuelo_Salida;
        $numero_vuelo_vuelta_cc = $fila->Vuelo_Retorno;
        $clase_ida_cc = $fila->Clase_Salida;
		$clase_vuelta_cc = $fila->Clase_Retorno;
		$apellidos=$fila->Apellidos;
		$nombres=$fila->Nombres;
    }
  
    $body = $visa_proceso->GenerarBody_AutorizacionTransaccion($num_documento, 0, $total_pagar, $id_registro, $tokenFormulario);
    $DataJsonVisa = $visa_proceso->SolicitarAutorizacionTransaccion($sess_token_seguridad_visa, $body);
    $DataJsonVisa = json_decode($DataJsonVisa, false);
    if (isset($DataJsonVisa)) {
        //ASOCIA DATA DE VISANET CON LOS CAMPOS DE LA TABLA VISANET
        $res = ArmarDataParaInsertar($DataJsonVisa, $id_registro);
        //FORMANDO SQL 
        $query_sql = $obj_db_driver->insert('visa', $res);
        $obj_visa->InsertarRegistroVisa($query_sql);

        if (isset($DataJsonVisa->errorCode) && $DataJsonVisa->errorCode === 400) {
            $res = ArmarDataInsertarReservaNuevo($obj_reserva->ObtenerDataReserva($id_registro));
            $query_sql_reserva = $obj_db_driver->insert('reserva', $res);
            $id=$obj_reserva->GuardarReservaCabeceraNueva($query_sql_reserva);
            $obj_reserva->UpdateReservaDetalleId($id_registro,$id);
            $obj_visa->UpdateVisaId($id_registro,$id);
            $obj_reserva->EliminarReserva($id_registro);
            $data_vista_error['cod_error_visa'] = $DataJsonVisa->errorCode;
            $data_vista_error['dataVisa'] = $DataJsonVisa->data;
			$data_vista_error['pnr_reserva'] = $pnr;
			$data_vista_error['TarjetaHabiente'] = $nombres.' '.$apellidos;
			$_SESSION['error_visa']=(object)$data_vista_error;
			include $URL_DEFINIDO.'/cp/bloques/views/block_confirmation/error_metodo_pago.php';
        }
        else {
            //TODO OK
            $kiu = new KIU_Controller();
            $PaymentType = 5;
            switch ($DataJsonVisa->dataMap->BRAND) {
                case 'visa':
                    $miscellaneous = 'VI';
                    break;
                case 'amex':
                    $miscellaneous = 'AX';
                    break;
                case 'mastercard':
                    $miscellaneous = 'CA';
                    break;
                case 'dinersclub':
                    $miscellaneous = 'DC';
                    break;
                default:
                    header("Location: " . base_url());
            }
            $ruc_agencia=$_SESSION["s_agencia"]->RUC;
            $porcentaje=(double)$_SESSION["s_agencia"]->PorcentajeComision;
            $trama_enviar_metodo_demandKiu = ArmarTramaTipoCredito_DemandTicket($miscellaneous, $PaymentType, $id_registro, $pnr, $ruc, $DataJsonVisa->order->transactionId, $DataJsonVisa->dataMap->CARD,$ruc_agencia,$porcentaje);

            $ResDemandTicket['dataVisa'] = $DataJsonVisa;
            $ResDemandTicket['data'] = $kiu->AirDemandTicketRQ($trama_enviar_metodo_demandKiu, $err)[3];
            $ResDemandTicket['data_reserva'] = $data_reserva;
            // echo "<pre>";
            // var_dump($ResDemandTicket['data']);die;
            // echo "</pre>";
            $j = 1;
            $tickets = [];
            $campos_consulta = '';
            foreach ($ResDemandTicket['data']->TicketItemInfo as $row) {
                $ticket_number = $row->attributes()->TicketNumber;
                $ComisionTarifa= (double)$row->attributes()->CommissionAmount;
                $tickets[$j-1] =  $ticket_number;
                $res_update_tbl_reserva_detalle = $obj_reserva->UpdateReservaDetalleTicket($ticket_number, $j, $id_registro,$ComisionTarifa);
                $campos_consulta .= " Ticket0" . $j . "='$ticket_number', ";
                $j++;
            }
            if ($res_update_tbl_reserva_detalle) {
                $miscellaneous = ($miscellaneous === 'CA') ? 'MC' : $miscellaneous;
                $consulta = $obj_reserva->UpdateReservaTicket($pnr, $campos_consulta,$porcentaje,$miscellaneous);
                include $URL_DEFINIDO.'/cp/bloques/views/block_confirmation/plantilla.php';
            }
            
            // $this->template->add_js_analitics('js/web/exito.js');
		}
    }

    unset($_SESSION['registro_id']);
    unset($_SESSION['token_seguridad_visa']);
}
