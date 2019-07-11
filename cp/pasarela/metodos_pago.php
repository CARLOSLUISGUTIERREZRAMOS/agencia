<?php

session_start();

include '../../cn/METODOS_PAGO/Connection_visa.php';
require_once("../../cn/STARPERU/Modelo/ReservaModelo.php");


if (isset($_POST['transactionToken']) && isset($_SESSION['registro_id'])) {
  $id_registro = $_SESSION['registro_id'];
  $sess_token_seguridad_visa = $_SESSION['token_seguridad_visa'];
  var_dump($sess_token_seguridad_visa);
  $visa_proceso = new Connection_visa();
  /* $data_one = $visa_proceso->GetLibreriaJSVisa(); */
  

  $obj_reserva = new ReservaModelo();
  $tokenFormulario = $_POST['transactionToken'];
  $campos = 'Tipo_Doc,Documento,Total,CodigoReserva,RUC,FechaRegistro,Nombres,Apellidos,Email';
  $data_reserva = $obj_reserva->ObtenerDataRerservaVisa($id_registro);
  // var_dump($sess_token_seguridad_visa);

  while ($fila = mysqli_fetch_assoc($data_reserva)) {
    $tipo_documento = $fila["Tipo_Doc"];
    $num_documento = $fila["Documento"];
    $total_pagar = $fila["Total"];
    $pnr = $fila["CodigoReserva"];
  }
  $body = $visa_proceso->GenerarBody_AutorizacionTransaccion($num_documento, 0, $total_pagar, $id_registro, $tokenFormulario);
  var_dump($body);
  $res_ws_visa = $visa_proceso->SolicitarAutorizacionTransaccion($sess_token_seguridad_visa, $body);
  
  var_dump($res_ws_visa);
  
  unset($_SESSION['registro_id']);
  unset($_SESSION['token_seguridad_visa']);

  // $visa = new Connection_visa();
  // $token = $visa_proceso->Connection();


}
