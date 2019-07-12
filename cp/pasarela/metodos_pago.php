<?php

session_start();

include '../../cn/METODOS_PAGO/Connection_visa.php';
require_once("../../cn/STARPERU/Modelo/ReservaModelo.php");
require_once("../../cn/STARPERU/Modelo/VisaModelo.php");
require_once '../../cd/Funciones/f_metodos_pagos.php';
require_once '../../cd/Funciones/f_kiu.php';
require_once '../../cd/Funciones/DB_driver.php';
include "../../cn/KIU/KIU_Controller_class.php";


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

  while ($fila = mysqli_fetch_assoc($data_reserva)) {
    $tipo_documento = $fila["Tipo_Doc"];
    $num_documento = $fila["Documento"];
    $total_pagar = $fila["Total"];
    $pnr = $fila["CodigoReserva"];
    $ruc = $fila["RUC"];
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

      $data_vista_error['cod_error_visa'] = $DataJsonVisa->errorCode;
      $data_vista_error['dataVisa'] = $DataJsonVisa;
      $data_vista_error['dataVisa_reserva'] = $data_reserva;
      var_dump($data_vista_error);
      // $this->load->view('templates/v_error_proceso_pago', $data_vista_error);
    } else {
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
        $trama_enviar_metodo_demandKiu = ArmarTramaTipoCredito_DemandTicket($miscellaneous, $PaymentType, $id_registro, $pnr, $ruc, $DataJsonVisa->order->transactionId, $DataJsonVisa->dataMap->CARD);

        $ResDemandTicket['dataVisa'] = $DataJsonVisa;
        $ResDemandTicket['data'] = $kiu->AirDemandTicketRQ($trama_enviar_metodo_demandKiu, $err)[3];
        $ResDemandTicket['data_reserva'] = $data_reserva;
        // var_dump($ResDemandTicket['data']);die;
        $j=1;
        foreach ($ResDemandTicket['data']->TicketItemInfo as $row) {
          $ticket_number = $row->attributes()->TicketNumber;
          $res = $obj_reserva->UpdateReservaDetalleTicket($ticket_number,$j,$id_registro);
          var_dump($res);


          // $email_upper = strtoupper($data_reserva->email);
          // $trama = array('IdTicket' => "$ticket_number", 'Email' => "$email_upper");
          // $kiu->TravelItineraryReadRQ($trama, $err);
          // $nombres_pax = $row->PassengerName->GivenName;
          // $res_update_tbl_reserva_detalle = $this->Reserva_model->RegistrarTicket($sess_id_reserva, $nombres_pax, $ticket_number);
          // if ($res_update_tbl_reserva_detalle) {
          //   $miscellaneous = ($miscellaneous === 'CA') ? 'MC' : $miscellaneous;
          //   $this->Reserva_model->ActualizarEstadoReserva(1, $sess_id_reserva, $miscellaneous);
          // }
          $j++;
        }
       

        // $this->template->add_js_analitics('js/web/exito.js');
        
      
    }
  }


  unset($_SESSION['registro_id']);
  unset($_SESSION['token_seguridad_visa']);
}
