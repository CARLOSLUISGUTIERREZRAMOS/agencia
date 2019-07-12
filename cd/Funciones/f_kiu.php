<?php
function ArmarTramaTipoCredito_DemandTicket($miscellaneous, $PaymentType, $reserva_id, $pnr, $ruc, $cod_autcard, $card_number) {

$trama = array(
    'PaymentType' => "$PaymentType",
    'CreditCardCode' => "$miscellaneous",
    'CreditCardNumber' => str_replace('*', '0', $card_number),
    'CreditSeriesCode' => substr($cod_autcard, 0,6),
    'CreditExpireDate' => "9999",
    'Country' => "PE",
    'Currency' => "USD",
    'TourCode' => "",
    'BookingID' => trim($pnr),
    'InvoiceCode' => "ACME",
    'VAT' => ($ruc == 'NULL') ? '' : $ruc
);
return $trama;
}