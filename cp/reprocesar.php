<?php
session_start();
error_reporting(E_ALL);
ini_set("display_errors", 0);
date_default_timezone_set('America/Lima');

if ($_SESSION['s_entra'] == 0) {
    header('Location:../index.php');
}
$Tipo = $_SESSION['s_tipo'];
if ($Tipo == 'G') {
    $directorio_personal = 'gestor/';
} else {
    $directorio_personal = 'delegado/';
}
$directorio = '';
$directorio_imagen = '';
require_once("../config.php");
require_once PATH_PROYECTO . '/cd/Controlador/PasarelaControl.php';
?>
<?php ob_start(); ?>
<link href="<?= $url ?>/cp/css/pago_reserva.css" rel="stylesheet" type="text/css" />
<script>
    $(document).on("change", "#select_cards", function () {
        var tarjeta_set = $(this).val();
        switch (tarjeta_set) {
            case 'TC': //VISA
                cc_code = 'VI';
                $("#pagoefectivo").html('');
                $("#img_cards").attr("src", "http://www.starperu.com/PasarelaWeb/img/metodos_pagos/t_credito_debito.png");
                break;
            case 'SP_C':
                cc_code = 'SP';
                $("#pagoefectivo").html('');
                $("#img_cards").attr("src", "http://www.starperu.com/PasarelaWeb/img/metodos_pagos/logo_pagos_en_efectivo.png");
                break;
            case 'SP_I':
                cc_code = 'SP';
                $("#pagoefectivo").html('');
                $("#img_cards").attr("src", "http://www.starperu.com/PasarelaWeb/img/metodos_pagos/logo_banca_por_internet.png");
                break;
            case 'SP_E':
                cc_code = 'SP';
                $("#pagoefectivo").html('');
                $("#img_cards").attr("src", "http://www.starperu.com/PasarelaWeb/img/metodos_pagos/logo_pagos_internacionales.png");
                break;
            case 'PE':
                cc_code = 'PE';
                $("#pagoefectivo").html('');
                $("#pagoefectivo").append("<b>Depósitos en efectivo</b>-En Cualquier agente o agencia autorizada a nivel nacional a la cuenta de Pago efectivo <a href='https://cip.pagoefectivo.pe/CNT/QueEsPagoEfectivo.aspx' target='blank'>¿Como Funciona?</a>");
                $("#img_cards").attr("src", "http://www.starperu.com/PasarelaWeb/img/metodos_pagos/logo_pe_de.png");
                break;
            case 'PEB':
                cc_code = 'PE';
                $("#pagoefectivo").html('');
                $("#pagoefectivo").append("<b>Paga en BBVA, BCP, Interbank, Scotiabank, BanBif, Caja Arequipa, a través de la banca por internet o banca móvil en la opción de pago de servicios. <a href='https://www.youtube.com/watch?v=oRbpV9mbSuc' target='blank'>¿Como Funciona?</a>");
                $("#img_cards").attr("src", "http://www.starperu.com/PasarelaWeb/img/metodos_pagos/logo_pe_tb.png");
                break;
        }
    });
//    $('#validacion_v').click(function (event) {
//            var bool2 = $('.vacios_radio').toArray().some(function (el) {
//                return !($(el).is(':checked'));
//            });
//            if (bool2) {
//                Mensaje = 'Debe Aceptar las condicciones ';
//                // $('#TxtMsg').html(Mensaje);
//                // $('#v_modal_error').modal('show');
//                console.log(Mensaje);
//                event.preventDefault();
//            }
//        });
        
//    function Change() {
//        $('#terms_rep , #terms2_rep').click(function () {
//
//            var terms_chequeado_1 = $('#terms_rep').prop('checked');
//            var terms_chequeado_2 = $('#terms2_rep').prop('checked');
//
//            if ((terms_chequeado_1 === false && terms_chequeado_2 === false) || (terms_chequeado_1 === false && terms_chequeado_2 === true) || (terms_chequeado_1 === true && terms_chequeado_2 === false)) {
//                $('#validacion_v').prop('disabled', true);
//            }
//            if (terms_chequeado_1 === true && terms_chequeado_2 === true) {
//                $('#validacion_v').prop('disabled', false);
//            }
//        })
    }
</script>
<?php $style_script_contenido = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php require_once(HTML_RECURSO_PATH); ?>
<table width="100%" cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td>
            <table width="1000" align="center" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td>
                        <br>
                        <form action="<?= $url ?>/cp/ReprocesarTransaccion.php" method="GET">
                            <div class="row">
                                <div class="col-sm-12 col-md-9">
                                    <div class="accordion destinos--2" id="accordionStar">
                                        <div class="card">
                                            <div class="card-header bg-danger" id="headingOne">
                                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#collapseOne" href="#collapseOne" aria-controls="collapseOne" aria-expanded="true">
                                                    <h3>Información del Vuelo:</h3>
                                                </a>
                                            </div>
                                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionStar" style="">
                                                <div class="card-body table-responsive">
                                                    <div class="row">
                                                        <div class="col-11">
                                                            <table class="table resumen">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Día</th>
                                                                        <th>Salida / Llegada</th>
                                                                        <th>Origen</th>
                                                                        <th>Destino</th>
                                                                        <th>Vuelo</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php foreach ($data['Itinerarios'] as $Itinerario): ?>
                                                                        <tr>
                                                                            <td><?= (new DateTime(($Itinerario->Air->Reservation->attributes()->DepartureDateTime)))->format('d/M') ?></td>
                                                                            <td><?= (new DateTime(($Itinerario->Air->Reservation->attributes()->DepartureDateTime)))->format('H:i') ?>/<?= (new DateTime(($Itinerario->Air->Reservation->attributes()->ArrivalDateTime)))->format('H:i') ?></td>
                                                                            <td><?= $Itinerario->Air->Reservation->DepartureAirport->attributes()->LocationCode ?></td>
                                                                            <td><?= $Itinerario->Air->Reservation->ArrivalAirport->attributes()->LocationCode ?></td>
                                                                            <td><?= $Itinerario->Air->Reservation->attributes()->FlightNumber ?> <?= (strlen($Itinerario->Air->Reservation->attributes()->FlightNumber) == 3) ? ' | Operado por Peruavian' : ' | Operado por Star Perú' ?></td>
                                                                        </tr>
                                                                    <?php endforeach ?>
                                                                </tbody>
                                                            </table>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card" id="accordionStar">
                                            <div class="card-header bg-danger" id="headingTwo">
                                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#collapseTwo" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                                    <h3>Datos de Pasajeros:</h3>
                                                </a>
                                            </div>
                                            <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordionStar" style="">
                                                <div class="card-body table-responsive">
                                                    <div class="row">
                                                        <div class="col-11">
                                                            <table class="table resumen">
                                                                <thead>
                                                                    <tr>
                                                                        <th>&nbsp;</th>
                                                                        <th>Tipo</th>
                                                                        <th>Apellidos / Nombres</th>
                                                                        <th>Documento</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php $i = 0 ?>
                                                                    <?php foreach ($data['Pasajeros'] as $Pasajero): ?>
                                                                        <tr>
                                                                            <td>
                                                                                <?php $i = $i + 1; ?>
                                                                                Pasajero <?= $i ?>
                                                                            </td>
                                                                            <td><?= $Pasajero->Customer->attributes()->PassengerTypeCode ?></td>
                                                                            <td><?= $Pasajero->Customer->PersonName->Surname ?>/<?= $Pasajero->Customer->PersonName->GivenName ?></td>
                                                                            <td><?= $Pasajero->Customer->Document->attributes()->DocType ?> : <?= $Pasajero->Customer->Document->attributes()->DocID ?></td>
                                                                        </tr>
                                                                    <?php endforeach ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card" id="accordionStar">
                                            <div class="card-header bg-danger" id="headingThree">
                                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#collapseThree" href="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                                                    <h3>Información de Contacto:</h3>
                                                </a>
                                            </div>
                                            <div id="collapseThree" class="collapse show" aria-labelledby="headingThree" data-parent="#accordionStar" style="">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-sm-12 col-md-6">
                                                            <div class="form-group">
                                                                <label for="contacto">Contacto:</label>
                                                                <input type="text" class="form-control vacios" id="contacto" name="contacto" value="<?= strtoupper($data['Pasajeros'][0]->Customer->PersonName->Surname) ?>/<?= strtoupper($data['Pasajeros'][0]->Customer->PersonName->GivenName) ?>" disabled="">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-6">
                                                            <div class="form-group">
                                                                <label for="email">Correo electrónico:</label>
                                                                <input type="text" class="form-control vacios " id="email" name="email" value="<?= strtoupper($data['Pasajeros'][0]->Customer->ContactPerson->Email[0]) ?>" disabled="">
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12 col-md-6">
                                                            <?php
                                                            $tlfn_contacto = substr($data['Pasajeros']->Customer->ContactPerson->Telephone[0], 4);
                                                            ?>
                                                            <div class="form-group">
                                                                <label for="num-loc">Número de contacto:</label>
                                                                <input type="text" class="form-control" aria-describedby="num-loc" id="num-loc" name="num_tlfn" value="<?= $tlfn_contacto ?>" disabled="">
                                                            </div>
                                                        </div>    
                                                        <div class="col-sm-12 col-md-6">
                                                            <div class="form-group">
                                                                <label for="num-loc">RUC:</label>
                                                                <input type="text" class="form-control" aria-describedby="num-loc" id="num-loc" name="num_tlfn" value="<?= $data['ruc'] ?>" disabled="">
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card" id="accordionStar">
                                            <div class="card-header bg-danger" id="headingFour">
                                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#collapseFour" href="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
                                                    <h3>Forma de pago:</h3>
                                                </a>
                                            </div>
                                            <div id="collapseFour" class="collapse show" aria-labelledby="headingFour" data-parent="#accordionStar" style="">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-sm-12 col-md-6">
                                                            <label for="pre-loc">Forma de pago:</label>
                                                            <div class="select">
                                                                <select id="select_cards" name="cc_code">
                                                                    <option value="TC">Tarjeta (Crédito o Débito)</option>
                                                                    <!--Bloque safetypay-->
                                                                    <!-- <option value="SP_C">Pago en Efectivo</option>
                                                                    <option value="SP_I">Banca por Internet</option>
                                                                    <option value="SP_E">Pagos Internacionales</option> -->
                                                                    <!--Bloque safetypay-->
                                                                    <!-- <option value="PE">Depósitos en efectivo</option>
                                                                    <option value="PEB">Transferencias Bancarias</option> -->
                                                                </select>
                                                                <div class="select__arrow"></div>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12 col-md-6">
                                                            <div class="logo-medio-pago">
                                                                <!--<img class="d-block w-70" id="img_cards" src="https://www.starperu.com/PasarelaWeb/img/metodos_pagos/logo_pp.png" alt="First slide">-->
                                                                <img class="d-block w-100" id="img_cards" src="https://www.starperu.com/PasarelaWeb/img/metodos_pagos/t_credito_debito.png" alt="First slide">
                                                            </div>
                                                        </div>
                                                        <label id="pagoefectivo"></label>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="form-check">
                                                                <!--<input class="form-check-input vacios_radio" type="checkbox" value="" id="defaultCheck1">-->
                                                                <!--                                                                <label class="form-check-label" for="defaultCheck1">
                                                                                                                                    He leído y estoy de acuerdo con las <a id="checkthickbox" onclick="VerCondicion();" class="thickbox" style="color:#0266CC;cursor:pointer;">condiciones</a> relacionadas a la compra.
                                                                                                                                </label>-->
                                                                <label class="form-check-label" for="defaultCheck1">
                                                                    <input type="checkbox" id="terms_rep" name="terms_rep" value="1" onclick="Change()" required /> He le&iacute;do y estoy de acuerdo con las <a data-toggle="modal" data-target="#miModal" style="color:#0266CC;cursor:pointer;">condiciones</a> relacionadas a la compra.<br>
                                                                    <input type="checkbox" id="terms2_rep" name="terms2_rep" value="1" onclick="Change()" required /> La agencia se hace 100% responsable de cualquier tipo de fraude que se haga vía el portal agencias. 
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <div class="card border-danger resumen destinos-2" id="accordionStar">
                                        <div id="collapseThree" class="collapse show" aria-labelledby="headingThree" data-parent="#accordionStar" style="">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label for="contacto">Código de Reserva:</label>
                                                            <input type="text" class="form-control vacios" id="codres" value="<?= $data['TravelItinerary']->ItineraryRef->attributes()->ID ?>" disabled="">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label for="email">Monto de la transacción:</label>
                                                            <input type="text" class="form-control vacios " id="montotrans" value=" USD <?= $data['TotalPagar'] ?>" disabled="">
                                                            <input type="hidden" value="<?= $data['reserva_id'] ?>" name="reserva_id">
                                                            <input type="hidden" value="1" name="transaccion">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <button type="submit" id="validacion_v" class="btn btn-danger btn-lg btn-block" >Continuar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <br>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<div class="modal fade" id="miModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Condiciones Tarifarias</h3>
            </div>                                              
            <div class="modal-body">
                <div class="container">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active " data-toggle="tab" href="#promo" style="color: darkred;">PROMO</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " data-toggle="tab" href="#simple" style="color: darkred;">SIMPLE</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link  " data-toggle="tab" href="#extra" style="color: darkred;">EXTRA</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " data-toggle="tab" href="#full" style="color: darkred;">FULL</a>
                        </li>                                                       
                    </ul>
                    <div class="tab-content">
                        <div id="promo" class="container tab-pane active"><br>
                            <h5>PROMO(H, S y T)</h5>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th><strong>IDA</strong></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            • Totalmente gratis: Una (1) pieza de equipaje chequeado de 23Kgs y una (1) de mano de 8Kgs.<br>
                                            • Máximo de estadía 180 días.<br>
                                            • Tarifa combinable con todas las clases.<br>
                                            • Niños (2-11 años) pagan el 100% de la tarifa. Infantes (0-2 años) pagan el 100% de la tarifa.<br>
                                            • Cambio de vuelo, fecha, ruta o nombre: Sin cargo antes de las 24hrs.a la salida del vuelo. Corresponde diferencia tarifaria de darse el caso.<br>
                                            • Cambio de vuelo, fecha, ruta o nombre: Dentro de las 24hrs.a la salida del vuelo, cargo de $17.70 por transacción . Corresponde diferencia tarifaria de presentarse el caso.<br>
                                            • Reembolsos permitidos sólo para futura transportación con cargo de $23.60.
                                        </td>
                                    </tr>
                                </tbody>
                                <thead>
                                    <tr>
                                        <th><strong>VUELTA</strong></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            • Totalmente gratis: Una (1) pieza de equipaje chequeado de 23Kgs y una (1) de mano de 8Kgs.<br>
                                            • Máximo de estadía 180 días.<br>
                                            • Tarifa combinable con todas las clases.<br>
                                            • Niños (2-11 años) pagan el 100% de la tarifa. Infantes (0-2 años) pagan el 100% de la tarifa.<br>
                                            • Cambio de vuelo, fecha, ruta o nombre: Sin cargo antes de las 24hrs.a la salida del vuelo. Corresponde diferencia tarifaria de darse el caso.<br>
                                            • Cambio de vuelo, fecha, ruta o nombre: Dentro de las 24hrs.a la salida del vuelo, cargo de $17.70 por transacción . Corresponde diferencia tarifaria de presentarse el caso.<br>
                                            • Reembolsos permitidos sólo para futura transportación con cargo de $23.60.<br>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div id="simple" class="container tab-pane fade"><br> 
                            <h5>SIMPLE(A, B, D, E, O, P, R y Z)</h5>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th><strong>IDA</strong></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            • Totalmente gratis: Una (1) pieza de equipaje chequeado de 23Kgs y una (1) de mano de 8Kgs.<br> 
                                            • Máximo de estadía 180 días.<br> 
                                            • Tarifa combinable con todas las clases.<br> 
                                            • Niños (2-11 años) pagan el 100% de la tarifa. Infantes (0-2 años) pagan el 10% de la tarifa. <br> 
                                            • Cambio de vuelo, fecha, ruta o nombre: Sin cargo antes de las 24hrs.a la salida del vuelo. Corresponde diferencia tarifaria de darse el caso.<br> 
                                            • Cambio de vuelo, fecha, ruta o nombre: Dentro de las 24hrs.a la salida del vuelo, cargo de $17.70 por transacción . Corresponde diferencia tarifaria de presentarse el caso.<br> 
                                            • Reembolsos permitidos sólo para futura transportación con cargo de $23.60. 
                                        </td>
                                    </tr>
                                </tbody>
                                <thead>
                                    <tr>
                                        <th><strong>VUELTA</strong></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            • Totalmente gratis: Una (1) pieza de equipaje chequeado de 23Kgs y una (1) de mano de 8Kgs.<br>
                                            • Máximo de estadía 180 días.<br>
                                            • Tarifa combinable con todas las clases.<br>
                                            • Niños (2-11 años) pagan el 100% de la tarifa. Infantes (0-2 años) pagan el 10% de la tarifa.<br>
                                            • Cambio de vuelo, fecha, ruta o nombre: Sin cargo antes de las 24hrs.a la salida del vuelo. Corresponde diferencia tarifaria de darse el caso.<br>
                                            • Cambio de vuelo, fecha, ruta o nombre: Dentro de las 24hrs.a la salida del vuelo, cargo de $17.70 por transacción . Corresponde diferencia tarifaria de presentarse el caso.<br>
                                            • Reembolsos permitidos sólo para futura transportación con cargo de $23.60.<br>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div id="extra" class="container tab-pane fade"><br>
                            <h5>EXTRA(J, M, N, Q, V, W y X)</h5>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th><strong>IDA</strong></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            • Totalmente gratis: Una (1) pieza de equipaje chequeado de 23Kgs y una (1) de mano de 8Kgs.<br>
                                            • Máximo de estadía 180 días.<br>
                                            • Tarifa combinable con todas las clases.<br>
                                            • Niños (2-11 años) pagan el 75% de la tarifa. Infantes (0-2 años) pagan el 10% de la tarifa.<br>
                                            • Cambio de vuelo, fecha, ruta o nombre: Sin cargo antes de las 24hrs.a la salida del vuelo. Corresponde diferencia tarifaria de darse el caso.<br>
                                            • Cambio de vuelo, fecha, ruta o nombre: Dentro de las 24hrs.a la salida del vuelo, cargo de $17.70 por transacción . Corresponde diferencia tarifaria de presentarse el caso.<br>
                                            • Reembolsos permitidos sólo para futura transportación con cargo de $23.60.
                                        </td>
                                    </tr>
                                </tbody>
                                <thead>
                                    <tr>
                                        <th><strong>VUELTA</strong></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            • Totalmente gratis: Una (1) pieza de equipaje chequeado de 23Kgs y una (1) de mano de 8Kgs.<br>
                                            • Máximo de estadía 180 días.<br>
                                            • Tarifa combinable con todas las clases.<br>
                                            • Niños (2-11 años) pagan el 75% de la tarifa. Infantes (0-2 años) pagan el 10% de la tarifa.<br>
                                            • Cambio de vuelo, fecha, ruta o nombre: Sin cargo antes de las 24hrs.a la salida del vuelo. Corresponde diferencia tarifaria de darse el caso.<br>
                                            • Cambio de vuelo, fecha, ruta o nombre: Dentro de las 24hrs.a la salida del vuelo, cargo de $17.70 por transacción . Corresponde diferencia tarifaria de presentarse el caso.<br>
                                            • Reembolsos permitidos sólo para futura transportación con cargo de $23.60.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div id="full" class="container tab-pane fade"><br>
                            <h5>FULL(K, L y Y)</h5>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th><strong>IDA</strong></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            • Totalmente gratis: Dos (2) piezas de equipaje chequeado de 23Kgs y una (1) de mano de 8Kgs.<br>
                                            • Máximo de estadía 180 días.<br>
                                            • Tarifa combinable con todas las clases.<br>
                                            • Niños (2-11 años) pagan el 50% de la tarifa. Infantes (0-2 años) pagan el 10% de la tarifa.<br>
                                            • Cambio de vuelo, fecha, ruta o nombre sin cargo. Corresponde diferencia tarifaria de darse el caso.<br>
                                            • Reembolsos permitidos sin cargo
                                        </td>
                                    </tr>
                                </tbody>
                                <thead>
                                    <tr>
                                        <th><strong>VUELTA</strong></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            • Totalmente gratis: Dos (2) piezas de equipaje chequeado de 23Kgs y una (1) de mano de 8Kgs.<br>
                                            • Máximo de estadía 180 días.<br>
                                            • Tarifa combinable con todas las clases.<br>
                                            • Niños (2-11 años) pagan el 50% de la tarifa. Infantes (0-2 años) pagan el 10% de la tarifa.<br>
                                            • Cambio de vuelo, fecha, ruta o nombre sin cargo. Corresponde diferencia tarifaria de darse el caso.<br>
                                            • Reembolsos permitidos sin cargo.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-danger btn-rounded btn-md ml-4" data-dismiss="modal" style="background: -webkit-linear-gradient(#f01515, darkred) !important;color:white;">Cerrar</button>
            </div>          
        </div>           
    </div>           
</div>
<?php include(FOOTER_PATH); ?>