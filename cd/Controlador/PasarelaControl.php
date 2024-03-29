<?php
if (!isset($url_proyecto)) {
    session_start();
    $URL_DEFINIDO = '../..';
    $p_ = empty($_SERVER['HTTPS']) ? 'http' : 'https';
    $d_ = $_SERVER['SERVER_NAME'];
    $port_ = $_SERVER['SERVER_PORT'];
    $disp_port_ = ($p_ == 'http' && $port_ == 80 || $p_ == 'https' && $port_ == 443) ? '' : ":$port_";
    $project_name_ = basename(dirname(dirname(dirname(__FILE__))));
    $URL_BASE = "${p_}://${d_}${disp_port_}/${project_name_}";
} else {
    $URL_DEFINIDO = PATH_PROYECTO;
    $URL_BASE = $url_proyecto;
}
// error_reporting(E_ALL);
// ini_set("display_errors", 0);
date_default_timezone_set('America/Lima');
//include '../Navegador/inex.php';
require_once($URL_DEFINIDO . "/cn/STARPERU/Modelo/PersonalModelo.php");
require_once($URL_DEFINIDO . "/cn/STARPERU/Modelo/CiudadModelo.php");
require_once($URL_DEFINIDO . "/cn/STARPERU/Modelo/TarifaModelo.php");
require_once($URL_DEFINIDO . "/cn/STARPERU/Modelo/ReservaModelo.php");
require_once($URL_DEFINIDO . "/cn/STARPERU/Modelo/EmpresaModelo.php");
include $URL_DEFINIDO . "/cn/KIU/KIU_Controller_class.php";
//include "../Funciones/funciones.php";
$KIU = new KIU_Controller();

$obj_persona = new PersonalModelo();
$obj_ciudad = new CiudadModelo();
$obj_tarifa = new TarifaModelo();
$obj_reserva = new ReservaModelo();
$obj_empresa = new EmpresaModelo();

if (isset($_POST['obtener_linea_credito'])) {
    if ($_POST['obtener_linea_credito'] == 1) {
//    $codigo_entidad=$_POST['obtener_linea_credito'];
        $codigo_entidad = $_POST['codigo_entidad'];

        $linea_credito = $obj_reserva->ObtenerLineaCredito($codigo_entidad);
        if ($linea_credito != "") {
            echo trim($linea_credito);
        }
    }
}

if (isset($_REQUEST['obtener_pnr'])) {
    if ($_REQUEST['obtener_pnr'] == 1) {
        $codigo_reserva = $_REQUEST['codigo_reserva'];
        if ($codigo_reserva) {
            $pnr = $obj_reserva->ObtenerPnr($codigo_reserva, $_SESSION['s_entidad']);
            if ($pnr == 1) {
                $xml = $KIU->TravelItineraryReadRQPnr($codigo_reserva, $err);
                if ($err['ErrorCode'] != 0) {
                    echo $err['ErrorMsg'];
                    die;
                } else {
                    // echo '<pre>';
                    // var_dump($xml[2]);
                    // echo '</pre>';die;
                    $json = $xml[3];
                    $tkt_estado = (int) $json->TravelItinerary->ItineraryInfo->Ticketing->attributes()->TicketingStatus;
                    if ($tkt_estado == 1) { //Pendiente de emisión
                        $id_reserva = $obj_reserva->BuscarIdReservaPorPnr($codigo_reserva);
                        if ($id_reserva) {
                            // echo "<pre>";
                            // var_dump($json->TravelItinerary->ItineraryInfo->ItineraryPricing->Cost->attributes());
                            // echo "</pre>";die;
                            $data['Pasajeros'] = $json->TravelItinerary->CustomerInfos->CustomerInfo;
                            $data['Itinerarios'] = $json->TravelItinerary->ItineraryInfo->ReservationItems->Item;
                            $data['TravelItinerary'] = $json->TravelItinerary;
                            $data['ruc'] = (isset($json->TravelItinerary->Remarks)) ? (strlen((string) $json->TravelItinerary->Remarks->Remark) == 11) ? $json->TravelItinerary->Remarks->Remark : '' : "";
                            $data['TotalPagar'] = $json->TravelItinerary->ItineraryInfo->ItineraryPricing->Cost->attributes()->AmountAfterTax;
                            $data['reserva_id'] = $id_reserva;
                        } else {
                            header('Location: ' . $url . '/cp/panel.php');
                        }
                    } elseif ($tkt_estado == 3) { //Ticket emitido
                        header('Location: ' . $url . '/cp/pasarela/html/reserva_pagada.php');
                    } elseif ($tkt_estado == 5) { //Ticket Cancelado
                        header('Location: ' . $url . '/cp/pasarela/html/tiempo_limite_reserva.php');
                    }
                }
            } else {
                header('Location: ' . $url . '/cp/pasarela/html/tiempo_limite_reserva.php?404');
            }
        } else {
            header('Location: ' . $url . '/cp/panel.php');
        }
    } else {
        header('Location: ' . $url . '/cp/panel.php');
    }
}

if (isset($_REQUEST['transaccion'])) {
    if ($_REQUEST['transaccion'] == 1) {
        if (isset($_REQUEST['cc_code']) && isset($_REQUEST['reserva_id'])) {
            $cc_code = $_REQUEST['cc_code'];
            $reserva_id = $_REQUEST['reserva_id'];
            if ($reserva_id != '' && $cc_code != '') {
                $res_datareserva = $obj_reserva->BuscarReservaPorId($reserva_id);
                $xml = $KIU->TravelItineraryReadRQPnr($res_datareserva->CodigoReserva, $err);
                if ($err['ErrorCode'] != 0) {
                    echo $err['ErrorMsg'];
                    die;
                } else {
                    $json = $xml[3];
                    $tkt_estado = (int) $json->TravelItinerary->ItineraryInfo->Ticketing->attributes()->TicketingStatus;
                    if ($tkt_estado == 1) { //Pendiente de emisión
                        $total_kiu = floatval($json->TravelItinerary->ItineraryInfo->ItineraryPricing->Cost->attributes()->AmountAfterTax);
                        $total_local = floatval($res_datareserva->Total);
                        // echo '<pre>';
                        // var_dump($xml[2]);
                        // var_dump($total_kiu);
                        // echo '</pre>';
                        // die;
                        // if ($total_kiu===$total_local) {
                        //     $total_pagar=$res_datareserva->Total;
                        // } else {
                        //     $total_pagar=$total_kiu;
                        //     $d=$KIU->AirPriceRQ_Reprice([
                        //         'City' => 'LIM'
                        //         , 'Country' => 'PE'
                        //         , 'Currency' => 'USD'
                        //         ,'Pnr'=>$res_datareserva->CodigoReserva
                        //     ],$err);
                        //     echo '<pre>';
                        //     var_dump($d[2]);
                        //     echo '</pre>';die;
                        // }

                        $data_reprocesa['fecha_limite'] = $res_datareserva->FechaLimite;
                        $data_reprocesa['cc_code'] = $cc_code;
                        $data_reprocesa['num_cel'] = $res_datareserva->Celular;
                        $data_reprocesa['pnr'] = $res_datareserva->CodigoReserva;
                        // $data_reprocesa['total_pagar'] = $total_pagar;
                        $data_reprocesa['total_pagar'] = $res_datareserva->Total;
                        $data_reprocesa['reserva_id'] = $reserva_id;
                        $data_reprocesa['email'] = $res_datareserva->Email;
                        $data_reprocesa['nombres_adl_1'] = $res_datareserva->Nombres;
                        $data_reprocesa['apellidos_adl_1'] = $res_datareserva->Apellidos;
                        $data_reprocesa['tipo_documento_adl_1'] = $res_datareserva->Tipo_Doc;
                        $data_reprocesa['numdoc_adl_1'] = $res_datareserva->Documento;
                        $data_reprocesa['ruc'] = (empty($res_datareserva->RUC) || $res_datareserva->RUC === "NULL") ? '' : $res_datareserva->RUC;
                        $obj_reserva->ActualizarMetodoPagoTransaccion($cc_code, $reserva_id);
                        switch ($data_reprocesa['cc_code']) {
                            case 'TC': // Visa
                                if (isset($_SESSION['registro_id'])) {
                                    unset($_SESSION['registro_id']);
                                }
                                if (isset($_SESSION['token_seguridad_visa'])) {
                                    unset($_SESSION['token_seguridad_visa']);
                                }
                                // echo $URL_BASE;die;
                                include $URL_DEFINIDO . '/cn/METODOS_PAGO/Connection_visa.php';
                                //include "../Funciones/funciones.php";
                                $visa = new Connection_visa();

                                $token = $visa->Connection();
                                $IP = $_SERVER['REMOTE_ADDR'];
                                $request_body = $visa->GenerarBody($res_datareserva->Total, $IP);
                                $visa_res = $visa->GenerarSesion($token, $request_body);
                                $objSessionVisa = json_decode($visa_res);
                                $libreriaJsVisa = $visa->GetLibreriaJSVisa();
                                // var_dump($libreriaJsVisa);die;
                                // $forma_pago = 'TC';
                                // var_dump($forma_pago);die;
                                // ProcesarConVisa($total_pagar, $data_reprocesa, $reserva_id, $pnr,$URL_BASE);
                                break;
                            case 'SP_C': // SAFETYPAY
                            case 'SP_I': // SAFETYPAY
                            case 'SP_E': // SAFETYPAY
                                ProcesarConSafetyPay($total_pagar, $pnr, $reserva_id, $data_reprocesa);
                                break;
                            case 'PE':  // PAGO EFECTIVO
                            case 'PEB':  // PAGO EFECTIVO 
                                $this->ProcesarConPagoEfectivo($data_reprocesa, $total_pagar, $reserva_id);
                                break;
                        }
                    } elseif ($tkt_estado == 3) { //Ticket emitido
                        header('Location: ' . $url . '/cp/pasarela/html/reserva_pagada.php');
                    } elseif ($tkt_estado == 5) { //Ticket Cancelado
                        header('Location: ' . $url . '/cp/pasarela/html/tiempo_limite_reserva.php');
                    }
                }
            } else {
                header('Location: ' . $url . '/cp/panel.php');
            }
        } else {
            header('Location: ' . $url . '/cp/panel.php');
        }
    } else {
        header('Location: ' . $url . '/cp/panel.php');
    }
}

function ProcesarConVisa($total_pagar, $xss_post, $reserva_id, $pnr, $URL_BASE) {
    
}

if (isset($_POST['ver_condiciones'])) {
    if ($_POST['ver_condiciones'] == 1) {

        $clase = $_POST['clase'];
        $familia_condiciones = $obj_tarifa->ObtenerFamiliaCondiciones($clase);
        if ($familia_condiciones != "") {
            echo $familia_condiciones;
        }
    }
}

if (isset($_POST['obtener_ciudades'])) {
    if ($_POST['obtener_ciudades'] == 1) {
        $origen = '';
        if (isset($_POST['origen'])) {
            if ($_POST['origen'] != '') {
                $origen = $_POST['origen'];
            }
        }
        $lista_ciudades = array();
        // var_dump($lista_ciudades);die;
        $lista_ciudades = $obj_ciudad->ObtenerCiudades($origen);
        if (count($lista_ciudades) == 0) {
            $options_ciudad = '<option value="" selected>- No hay datos -</option>' . "\n";
        } else {
            $options_ciudad = '<option value="" selected>- ';
            if ($origen != '') {
                $options_ciudad .= 'Hacia';
            } else {
                $options_ciudad .= 'Desde';
            }
            $options_ciudad .= ' -</option>' . "\n";
            foreach ($lista_ciudades as $ciudad) {
                $options_ciudad .= '<option value="' . $ciudad->getIdCiudad() . '" >' . ucwords(strtolower(utf8_encode($ciudad->getCiudad()))) . '</option>' . "\n";
            }
        }

        echo $options_ciudad;
    }
}

if (isset($_POST['paso2'])) {
    if ($_POST['paso2'] == 1) {
        if ($_SESSION['s_idusuario'] == '' || $_SESSION['s_entidad'] == '') {
            $tabla_error .= '<center >' . "\n";
            $tabla_error .= '<table >' . "\n";
            $tabla_error .= '<tr><td height="50"></td></tr>' . "\n";
            $tabla_error .= '<tr>' . "\n";
            $tabla_error .= '<td class="subtitleTable"  style="color:red !important;text-align:center;">El tiempo de espera ha termiando. Por favor cierre sesión y vuelva a ingresar.<br/>¡Gracias!</td>' . "\n";
            $tabla_error .= '</tr>' . "\n";
            $tabla_error .= '</table>' . "\n";
            $tabla_error .= '</center >' . "\n";
            echo $tabla_error;
            die;
        }

        $origen = $_POST['origen'];
        $fecha_ida = $_POST['fecha0'];
        $destino = $_POST['destino'];
        $fecha_retorno = $_POST['fecha1'];
        $tipo_viaje = $_POST['rbt_tipo_viaje'];
        $adultos = $_POST['adultos'];
        $menores = $_POST['menores'];
        $infantes = $_POST['infantes'];
        if ($tipo_viaje == '0') {
            $tipo_vuelo = 'O';
        } else if ($tipo_viaje == '1') {
            $tipo_vuelo = 'R';
        }
        $cantidad_adultos = '';
        $cantidad_menores = '';
        $cantidad_infantes = '';
        if ($adultos > 1) {
            $cantidad_adultos = $adultos . ' Adultos';
        } else {
            $cantidad_adultos = $adultos . ' Adulto';
        }
        if ($menores > 1) {
            $cantidad_menores = $menores . ' Niños';
        } elseif ($menores == 1) {
            $cantidad_menores = $menores . ' Niño';
        }
        if ($infantes > 1) {
            $cantidad_infantes = $infantes . ' Bebés';
        } elseif ($infantes == 1) {
            $cantidad_infantes = $infantes . ' Bebé';
        }
        $cantidad_total_pasajeros = $adultos + $menores + $infantes;
        $nombre_origen = $obj_tarifa->ObtenerNombreCiudad($origen);
        $nombre_destino = $obj_tarifa->ObtenerNombreCiudad($destino);


        // FORMATEANDO FECHA DE SALIDA
        $fechas_ida = explode('/', $fecha_ida);
        $nueva_fecha_ida = $fechas_ida[0] . '/' . $fechas_ida[1] . '/' . substr($fechas_ida[2], 2, 4);
        $fecha_salida = $fechas_ida[2] . '-' . $fechas_ida[1] . '-' . $fechas_ida[0];
        //FORMATEANDO FECHA RETORNO
        $fechas_retorno = explode('/', $fecha_retorno);
        $fecha_vuelta = $fechas_retorno[2] . '-' . $fechas_retorno[1] . '-' . $fechas_retorno[0];

        //CALCULO DE LA ESTADIA
        $estadia = 0;
        if ($tipo_viaje == '1') { //SOLO ROUND TRIP SE CALCULA LA ESTADIA
            $dias = (strtotime($fecha_vuelta) - strtotime($fecha_salida)) / 86400;
            $estadia = abs($dias);
        }


        $res = $KIU->AirAvailRQ(array(
            'Direct' => 'true'
            , 'Date' => $fecha_salida
            , 'Source' => $origen
            , 'Dest' => $destino
            , 'Cabin' => 'Economy'
            , 'QuantityADT' => $adultos
            , 'QuantityCNN' => $menores
            , 'QuantityINF' => $infantes
                ), $err);

        /* var_dump($res);die; */
        if ($err['ErrorCode'] != 0)
            echo $err['ErrorMsg'];


        $vuelos = $res['OriginDestinationInformation']['OriginDestinationOptions']['OriginDestinationOption'];
        $cantidad_vuelos = count($vuelos);
        require_once '../../cd/Funciones/funciones.php';
        if ($cantidad_vuelos > 0) {
            $vuelos_disponibles = array();

            for ($i = 0; $i < $cantidad_vuelos; $i++) {
                if ($cantidad_vuelos > 1) {
                    $datos_vuelo = $vuelos[$i]['FlightSegment'];
                } else {
                    $datos_vuelo = $vuelos['FlightSegment'];
                }
                $fecha_hora_salida = $datos_vuelo['@attributes']['DepartureDateTime'];
                $fehca_hora_sistema = date("Y-m-d H:i:s");
                $minutos_diferencia = diferencia_horas_vuelo($fecha_hora_salida, $fehca_hora_sistema);
                if ($minutos_diferencia >= 180) {
                    $fecha_hora_llegada = $datos_vuelo['@attributes']['ArrivalDateTime'];
                    $numero_vuelo = $datos_vuelo['@attributes']['FlightNumber'];
                    $numero_escalas = $datos_vuelo['@attributes']['StopQuantity'];
                    $stop_vuelo = 'No';
                    if ($numero_escalas > 0) {
                        $stop_vuelo = 'Si';
                    }
                    $duracion_vuelo = $datos_vuelo['@attributes']['JourneyDuration'];
                    $vuelos_disponibles[$i] = array("Vuelo" => $datos_vuelo['@attributes']['FlightNumber'],
                        "Salida" => $datos_vuelo['@attributes']['DepartureDateTime'],
                        "Llegada" => $datos_vuelo['@attributes']['ArrivalDateTime'],
                        "Escala" => $stop_vuelo,
                        "Duracion" => $datos_vuelo['@attributes']['JourneyDuration'],
                        "Clases" => array()
                    );
                    $markeing_cabin = $datos_vuelo['MarketingCabin']['@attributes'];
                    $tipo_cabina = $markeing_cabin['CabinType'];
                    $clases = $datos_vuelo['BookingClassAvail'];
                    $numeros_clases = count($clases);
                    if ($numeros_clases > 0) {
                        $disponibilidad_tarifa = 0;
                        for ($k = 0; $k < $numeros_clases; $k++) {
                            if ($numeros_clases > 1) {
                                $asientos_disponibles = $clases[$k]['@attributes']['ResBookDesigQuantity'];
                                if ($asientos_disponibles >= $cantidad_total_pasajeros) {
                                    $clase = $clases[$k]['@attributes']['ResBookDesigCode'];
                                    $vuelos_disponibles[$i]["Clases"][] = $clase;
                                }
                            } else {
                                $asientos_disponibles = $clases['@attributes']['ResBookDesigQuantity'];
                                if ($asientos_disponibles >= $cantidad_total_pasajeros) {
                                    $clase = $clases['@attributes']['ResBookDesigCode'];
                                    $vuelos_disponibles[$i]["Clases"][] = $clase;
                                }
                            }
                        }
                    }
                }
            }

            // echo "<pre>";
            // print_r($vuelos_disponibles);
            // echo "</pre>";

            $clases_tarifas_disponibles = $obj_tarifa->ObtenerTarifaClaseFamilia($fecha_salida, $origen, $destino, $tipo_vuelo, $estadia);
            // echo "<pre>";
            // var_dump($clases_tarifas_disponibles["Clases"]);
            // echo "</pre>";die;
            $tabla_disponibilidades = '<table class="tabla_vuelos_de_ida">' . "\n";
            $tabla_disponibilidades .= '<tr><td width="50" class="subtitleTable">Vuelo</td>' . "\n";
            $tabla_disponibilidades .= '<td width="50" class="subtitleTable">Salida</td>' . "\n";
            $tabla_disponibilidades .= '<td width="50" class="subtitleTable">Llegada</td>' . "\n";
            $tabla_disponibilidades .= '<td width="50" class="subtitleTable">Duracion</td>' . "\n";
            $tabla_disponibilidades .= '<td width="50" class="subtitleTable">Escala</td>' . "\n";
            $tabla_disponibilidades .= '<td class="subtitleTable" colspan="9"><b>Tarifa</b></td>' . "\n";
            $tabla_disponibilidades .= '</tr>' . "\n";
            $filas .= '';
                
            for ($w = 0; $w < count($vuelos_disponibles); $w++) {
                $disponibles = array_reverse(array_intersect($vuelos_disponibles[$w]["Clases"], $clases_tarifas_disponibles["Clases"]));
                // echo '<pre>';
                // var_dump($vuelos_disponibles[$w]);
                // var_dump($vuelos_disponibles[$w]["Clases"]);
                // var_dump($clases_tarifas_disponibles["Clases"]);
                // var_dump($clases_tarifas_disponibles);
                // var_dump($disponibles);
                // echo '</pre>';
                // die;

                $clases_vector = array();

                foreach ($disponibles as $indice => $class) {
                    $vector = array("clase" => $class, "tarifa" => number_format($clases_tarifas_disponibles["Tarifas"][$class], 2, '.', ''));
                    $clases_vector[] = $vector;
                }

                $clases_vector = ordenar_tarifas_kiu($clases_vector, "tarifa", true);

                if (count($disponibles) > 0) {
                    $filas .= '<tr>' . "\n";
                    $filas .= '<td td height="40" class="bgTable-data" align="center"><strong>' . $vuelos_disponibles[$w]["Vuelo"] . "\n" . (strlen($vuelos_disponibles[$w]["Vuelo"]) == 3 ? 'Peruvian' : 'StarPerú') . '</strong></td>' . "\n";
                    $filas .= '<td class="bgTable-data" align="center">' . substr($vuelos_disponibles[$w]["Salida"], 11, 17) . '</td>' . "\n";
                    $filas .= '<td class="bgTable-data" align="center">' . substr($vuelos_disponibles[$w]["Llegada"], 11, 17) . '</td>' . "\n";
                    $filas .= '<td class="bgTable-data" align="center">' . $vuelos_disponibles[$w]["Duracion"] . '</td>' . "\n";
                    $filas .= '<td class="bgTable-data" align="center">' . $vuelos_disponibles[$w]["Escala"] . '</td>' . "\n";
                        
                    for ($p = 0; $p < count($clases_vector); $p++) {
                        $clase = $clases_vector[$p]["clase"];

                        if ($clase == 'A' || $clase == 'B' || $clase == 'D' || $clase == 'E' || $clase == 'O' || $clase == 'P' || $clase == 'R' || $clase == 'Z') {
                            $tipo = "simple";
                        } else if ($clase == 'H' || $clase == 'S' || $clase == 'T') {
                            $tipo = "promo";
                        } else if ($clase == 'J' || $clase == 'M' || $clase == 'N' || $clase == 'Q' || $clase == 'V' || $clase == 'W' || $clase == 'X') {
                            $tipo = "extra";
                        } else {
                            $tipo = "full";
                        }
                        $filas .= '<td><table><tr><td width="70" class="subtitleTableSFlexi td_clase_B" align="center" style="background-color: #DEC8BF; color: #5A3F2F">' . "\n";
                        $filas .= '<label><input type="radio" id="vuelo_ida" name="vuelo_ida" value="' . $clases_vector[$p]["tarifa"] . '#' . $vuelos_disponibles[$w]["Vuelo"] . '#' . $vuelos_disponibles[$w]["Salida"] . '#' . $vuelos_disponibles[$w]["Llegada"] . '#' . $clases_vector[$p]["clase"] . '#' . $origen . '#' . $destino . '" onclick="EnviaImporteD()"><br/>Clase ' . $clases_vector[$p]["clase"] . "\n";
                        $filas .= '<br><font color="#004000">$' . number_format($clases_vector[$p]["tarifa"], 2) . '</font>' . "\n";
                        $filas .= '<br><i style="font-size:9px;color: #883320;cursor: pointer;"><strong><a data-toggle="modal" data-target="#modal-condiciones-' . $tipo . '-ida">Condiciones</a></strong></i>' . "\n";
                        $filas .= '</label></td></tr></table></td>' . "\n";
                        // $filas.='<a title="Click para ver las condiciones" class="clase" onClick="VerCondicion(\''.trim(strtoupper($clase)).'\')">Condición</a>'."\n";       
                  
                        }
                    $filas .= '</tr>' . "\n";
                }
            }

            #PROMO(H, S y T) 
            #SIMPLE(A, B, D, E, O, P, R y Z)
            #EXTRA(J, M, N, Q, V, W y X)
            #FULL(K, L y Y)

            $tabla_disponibilidades .= $filas . "\n";
            $tabla_disponibilidades .= '</table>' . "\n";
        } else {
            $tabla_disponibilidades = '<table class="tabla_vuelos_de_ida">' . "\n";
            $tabla_disponibilidades .= '<tr>' . "\n";
            $tabla_disponibilidades .= '<td  colspan="25" style="color:red !important;"><b>No existen vuelos disponibles para esta fecha.</b></td>' . "\n";
            $tabla_disponibilidades .= '</tr>' . "\n";
            $tabla_disponibilidades .= '</table>' . "\n";
        }
        
        if ($tipo_viaje == 1) {

            $res1 = $KIU->AirAvailRQ(array(
                'Direct' => 'true'
                , 'Date' => $fecha_vuelta
                , 'Source' => $destino
                , 'Dest' => $origen
                , 'Cabin' => 'Economy'
                , 'QuantityADT' => $adultos
                , 'QuantityCNN' => $menores
                , 'QuantityINF' => $infantes
                    ), $err);
            if ($err['ErrorCode'] != 0)
                echo $err['ErrorMsg'];

            $vuelos = $res1['OriginDestinationInformation']['OriginDestinationOptions']['OriginDestinationOption'];

            $cantidad_vuelos = count($vuelos);
            if ($cantidad_vuelos > 0) {
                $vuelos_disponibles = array();
                for ($i = 0; $i < $cantidad_vuelos; $i++) {
                    if ($cantidad_vuelos > 1) {
                        $datos_vuelo = $vuelos[$i]['FlightSegment'];
                    } else {
                        $datos_vuelo = $vuelos['FlightSegment'];
                    }
                    $fecha_hora_salida = $datos_vuelo['@attributes']['DepartureDateTime'];
                    $fehca_hora_sistema = date("Y-m-d H:i:s");
                    $minutos_diferencia = diferencia_horas_vuelo($fecha_hora_salida, $fehca_hora_sistema);
                    if ($minutos_diferencia >= 180) {
                        $fecha_hora_llegada = $datos_vuelo['@attributes']['ArrivalDateTime'];
                        $numero_vuelo = $datos_vuelo['@attributes']['FlightNumber'];
                        $numero_escalas = $datos_vuelo['@attributes']['StopQuantity'];
                        $stop_vuelo = 'No';
                        if ($numero_escalas > 0) {
                            $stop_vuelo = 'Si';
                        }
                        $duracion_vuelo = $datos_vuelo['@attributes']['JourneyDuration'];
                        $vuelos_disponibles[$i] = array("Vuelo" => $datos_vuelo['@attributes']['FlightNumber'],
                            "Salida" => $datos_vuelo['@attributes']['DepartureDateTime'],
                            "Llegada" => $datos_vuelo['@attributes']['ArrivalDateTime'],
                            "Escala" => $stop_vuelo,
                            "Duracion" => $datos_vuelo['@attributes']['JourneyDuration'],
                            "Clases" => array()
                        );
                        $markeing_cabin = $datos_vuelo['MarketingCabin']['@attributes'];
                        $tipo_cabina = $markeing_cabin['CabinType'];
                        $clases = $datos_vuelo['BookingClassAvail'];
                        $numeros_clases = count($clases);
                        if ($numeros_clases > 0) {
                            $disponibilidad_tarifa = 0;
                            for ($k = 0; $k < $numeros_clases; $k++) {
                                if ($numeros_clases > 1) {
                                    $asientos_disponibles = $clases[$k]['@attributes']['ResBookDesigQuantity'];
                                    if ($asientos_disponibles >= $cantidad_total_pasajeros) {
                                        $clase = $clases[$k]['@attributes']['ResBookDesigCode'];
                                        $vuelos_disponibles[$i]["Clases"][] = $clase;
                                    }
                                } else {
                                    $asientos_disponibles = $clases['@attributes']['ResBookDesigQuantity'];
                                    if ($asientos_disponibles >= $cantidad_total_pasajeros) {
                                        $clase = $clases['@attributes']['ResBookDesigCode'];
                                        $vuelos_disponibles[$i]["Clases"][] = $clase;
                                    }
                                }
                            }
                        }
                    }
                }
                $clases_tarifas_disponibles = $obj_tarifa->ObtenerTarifaClaseFamilia($fecha_vuelta, $destino, $origen, $tipo_vuelo, $estadia);

                $tabla_disponibilidades1 = '<table class="tabla_vuelos_de_retorno">' . "\n";
                $tabla_disponibilidades1 .= '<tr><td width="50" class="subtitleTable">Vuelo</td>' . "\n";
                $tabla_disponibilidades1 .= '<td width="50" class="subtitleTable">Salida</td>' . "\n";
                $tabla_disponibilidades1 .= '<td width="50" class="subtitleTable">Llegada</td>' . "\n";
                $tabla_disponibilidades1 .= '<td width="50" class="subtitleTable">Duracion</td>' . "\n";
                $tabla_disponibilidades1 .= '<td width="50" class="subtitleTable">Escala</td>' . "\n";
                $tabla_disponibilidades1 .= '<td class="subtitleTable" colspan="9"><b>Tarifa</b></td>' . "\n";
                $tabla_disponibilidades1 .= '</tr>' . "\n";
                $filas1 .= '';

                for ($w = 0; $w < count($vuelos_disponibles); $w++) {
                    $disponibles = array_reverse(array_intersect($vuelos_disponibles[$w]["Clases"], $clases_tarifas_disponibles["Clases"]));

                    $clases_vector = array();

                    foreach ($disponibles as $indice => $class) {
                        $vector = array("clase" => $class, "tarifa" => number_format($clases_tarifas_disponibles["Tarifas"][$class], 2, '.', ''));
                        $clases_vector[] = $vector;
                    }

                    $clases_vector = ordenar_tarifas_kiu($clases_vector, "tarifa", true);

                    if (count($disponibles) > 0) {

                        $filas1 .= '<tr>' . "\n";
                        $filas1 .= '<td height="40" class="bgTable-data" align="center"><strong>' . $vuelos_disponibles[$w]["Vuelo"] . "\n" . (strlen($vuelos_disponibles[$w]["Vuelo"]) == 3 ? 'Peruvian' : 'StarPerú') . '</strong></td>' . "\n";
                        $filas1 .= '<td class="bgTable-data" align="center">' . substr($vuelos_disponibles[$w]["Salida"], 11, 17) . '</td>' . "\n";
                        $filas1 .= '<td class="bgTable-data" align="center">' . substr($vuelos_disponibles[$w]["Llegada"], 11, 17) . '</td>' . "\n";
                        $filas1 .= '<td class="bgTable-data" align="center">' . $vuelos_disponibles[$w]["Duracion"] . '</td>' . "\n";
                        $filas1 .= '<td class="bgTable-data" align="center">' . $vuelos_disponibles[$w]["Escala"] . '</td>' . "\n";

                        for ($p = 0; $p < count($clases_vector); $p++) {
                            $clase = $clases_vector[$p]["clase"];

                            if ($clase == 'A' || $clase == 'B' || $clase == 'D' || $clase == 'E' || $clase == 'O' || $clase == 'P' || $clase == 'R' || $clase == 'Z') {
                                $tipo = "simple";
                            } else if ($clase == 'H' || $clase == 'S' || $clase == 'T') {
                                $tipo = "promo";
                            } else if ($clase == 'J' || $clase == 'M' || $clase == 'N' || $clase == 'Q' || $clase == 'V' || $clase == 'W' || $clase == 'X') {
                                $tipo = "extra";
                            } else {
                                $tipo = "full";
                            }
                            $filas1 .= '<td><table><tr><td width="70" class="subtitleTableSFlexi td_clase_B" align="center" style="background-color: #DEC8BF; color: #5A3F2F">' . "\n";
                            $filas1 .= '<label><input type="radio" id="vuelo_vuelta" name="vuelo_vuelta" value="' . $clases_vector[$p]["tarifa"] . '#' . $vuelos_disponibles[$w]["Vuelo"] . '#' . $vuelos_disponibles[$w]["Salida"] . '#' . $vuelos_disponibles[$w]["Llegada"] . '#' . $clases_vector[$p]["clase"] . '#' . $origen . '#' . $destino . '" onclick="EnviaImporteR()"><br/>Clase ' . $clases_vector[$p]["clase"] . "\n";
                            $filas1 .= '<br><font color="#004000">$' . number_format($clases_vector[$p]["tarifa"], 2) . '</font><br>' . "\n";
                            $filas1 .= '<br><i style="font-size:9px;color: #883320;cursor: pointer;"><strong><a data-toggle="modal" data-target="#modal-condiciones-' . $tipo . '-vuelta">Condiciones</a></strong></i>' . "\n";
                            $filas1 .= '</label></td></tr></table></td>' . "\n";
                            // $tabla_disponibilidades1.='<a title="Click para ver las condiciones" class="clase" onClick="VerCondicion(\''.trim(strtoupper($clase)).'\')">Condición</a>'."\n";       
                        }

                        $filas1 .= '</tr>' . "\n";
                    }
                }
                $tabla_disponibilidades1 .= $filas1 . "\n";
                $tabla_disponibilidades1 .= '</table>' . "\n";
            } else {
                $tabla_disponibilidades1 = '<table class="tabla_vuelos_de_retorno">' . "\n";
                $tabla_disponibilidades1 .= '<tr>' . "\n";
                $tabla_disponibilidades1 .= '<td  colspan="25" style="color:red !important;"><b>No existen vuelos disponibles para esta fecha.</b></td>' . "\n";
                $tabla_disponibilidades1 .= '</tr>' . "\n";
                $tabla_disponibilidades1 .= '</table>' . "\n";
            }
        }

        /* CALCULO DE LA FECHA DE IDA */

        $nueva_fecha_ida = $fechas_ida[1] . '/' . $fechas_ida[0] . '/' . substr($fechas_ida[2], 2, 4);

        $fecha1 = date('m/d/Y', strtotime($nueva_fecha_ida));
        $fecha_ida_anterior = strtotime('-1 day', strtotime($fecha1));
        $fecha_ida_anterior = date('m/d/Y', $fecha_ida_anterior);
        $fecha_dividida_anterior_ida = explode("/", $fecha_ida_anterior);
        $fecha_ida_anterior = $fecha_dividida_anterior_ida[1] . "/" . $fecha_dividida_anterior_ida[0] . "/" . $fecha_dividida_anterior_ida[2];

        $fecha2 = date('m/d/Y', strtotime($nueva_fecha_ida));
        $fecha_ida_posterior = strtotime('+1 day', strtotime($fecha2));
        $fecha_ida_posterior = date('m/d/Y', $fecha_ida_posterior);
        $fecha_dividida_posterior_ida = explode("/", $fecha_ida_posterior);
        $fecha_ida_posterior = $fecha_dividida_posterior_ida[1] . "/" . $fecha_dividida_posterior_ida[0] . "/" . $fecha_dividida_posterior_ida[2];



        /* CALCULO DE LA FECHA DE RETORNO */
        $nueva_fecha_vuelta = $fechas_retorno[1] . '/' . $fechas_retorno[0] . '/' . substr($fechas_retorno[2], 2, 4);

        $fecha3 = date('d/m/Y', strtotime($nueva_fecha_vuelta));
        $fecha_retorno_anterior = strtotime('-1 day', strtotime($nueva_fecha_vuelta));
        $fecha_retorno_anterior = date('d/m/Y', $fecha_retorno_anterior);
        $fecha_dividida_anterior_retorno = explode("/", $fecha_retorno_anterior);
        $fecha_retorno_anterior = $fecha_dividida_anterior_retorno[0] . "/" . $fecha_dividida_anterior_retorno[1] . "/" . $fecha_dividida_anterior_retorno[2];

        $fecha4 = date('d/m/Y', strtotime($nueva_fecha_vuelta));
        $fecha_retorno_posterior = strtotime('+1 day', strtotime($nueva_fecha_vuelta));
        $fecha_retorno_posterior = date('d/m/Y', $fecha_retorno_posterior);
        $fecha_dividida_posterior_retorno = explode("/", $fecha_retorno_posterior);
        $fecha_retorno_posterior = $fecha_dividida_posterior_retorno[0] . "/" . $fecha_dividida_posterior_retorno[1] . "/" . $fecha_dividida_posterior_retorno[2];

        /* DIFERENCIA FECHA SE IDA CON LA FECHA DE HOY */
        $fecha_dividida_hoy = explode("/", date('d/m/Y'));
        $fecha_dividida_ida = explode("/", $fecha_ida);
        $timestamp1 = mktime(0, 0, 0, $fecha_dividida_ida[1], $fecha_dividida_ida[0], $fecha_dividida_ida[2]);
        $timestamp2 = mktime(0, 0, 0, $fecha_dividida_hoy[1], $fecha_dividida_hoy[0], $fecha_dividida_hoy[2]);
        $segundos_diferencia = $timestamp1 - $timestamp2;
        $dias_diferencia1 = $segundos_diferencia / (60 * 60 * 24);


        /* DIFERENCIA FECHA SE IDA CON LA FECHA DE RETORNO */
        $fecha_dividida_retorno = explode("/", $fecha_retorno);
        $fecha_dividida_ida = explode("/", $fecha_ida);
        $timestamp1 = mktime(0, 0, 0, $fecha_dividida_retorno[1], $fecha_dividida_retorno[0], $fecha_dividida_retorno[2]);
        $timestamp2 = mktime(0, 0, 0, $fecha_dividida_ida[1], $fecha_dividida_ida[0], $fecha_dividida_ida[2]);
        $segundos_diferencia = $timestamp1 - $timestamp2;
        $dias_diferencia = $segundos_diferencia / (60 * 60 * 24);

        $_SESSION['tabla_vuelos_ida'] = $tabla_disponibilidades;
        $_SESSION['tabla_vuelos_retorno'] = $tabla_disponibilidades1;
        $_SESSION['tipo_viaje'] = $tipo_viaje;
        $_SESSION['fecha_ida'] = $fecha_ida;
        $_SESSION['fecha_retorno'] = $fecha_retorno;
        $_SESSION['origen'] = $origen;
        $_SESSION['destino'] = $destino;
        $_SESSION['adultos'] = $adultos;
        $_SESSION['menores'] = $menores;
        $_SESSION['infantes'] = $infantes;
        $_SESSION['nombre_origen'] = $nombre_origen;
        $_SESSION['nombre_destino'] = $nombre_destino;
        $_SESSION['dias_diferencia1'] = $dias_diferencia1;
        $_SESSION['dias_diferencia'] = $dias_diferencia;
        $_SESSION['cantidad_adultos'] = $cantidad_adultos;
        $_SESSION['cantidad_menores'] = $cantidad_menores;
        $_SESSION['cantidad_infantes'] = $cantidad_infantes;

        $_SESSION['fecha_dividida_anterior_ida_2'] = $fecha_dividida_anterior_ida[2];
        $_SESSION['fecha_dividida_anterior_ida_0'] = $fecha_dividida_anterior_ida[0];
        $_SESSION['fecha_dividida_anterior_ida_1'] = $fecha_dividida_anterior_ida[1];
        $_SESSION['fecha_ida_anterior'] = $fecha_ida_anterior;

        $_SESSION['fecha_dividida_posterior_ida_2'] = $fecha_dividida_posterior_ida[2];
        $_SESSION['fecha_dividida_posterior_ida_0'] = $fecha_dividida_posterior_ida[0];
        $_SESSION['fecha_dividida_posterior_ida_1'] = $fecha_dividida_posterior_ida[1];
        $_SESSION['fecha_ida_posterior'] = $fecha_ida_posterior;

        $_SESSION['fecha_dividida_anterior_retorno_2'] = $fecha_dividida_anterior_retorno[2];
        $_SESSION['fecha_dividida_anterior_retorno_0'] = $fecha_dividida_anterior_retorno[0];
        $_SESSION['fecha_dividida_anterior_retorno_1'] = $fecha_dividida_anterior_retorno[1];
        $_SESSION['fecha_retorno_anterior'] = $fecha_retorno_anterior;

        $_SESSION['fecha_dividida_posterior_retorno_2'] = $fecha_dividida_posterior_retorno[2];
        $_SESSION['fecha_dividida_posterior_retorno_0'] = $fecha_dividida_posterior_retorno[0];
        $_SESSION['fecha_dividida_posterior_retorno_1'] = $fecha_dividida_posterior_retorno[1];
        $_SESSION['fecha_retorno_posterior'] = $fecha_retorno_posterior;

        $_SESSION['hide_paso2'] = ' <input name="precio_ida" type="hidden" id="precio_ida" value="0" />
                            <input name="clase_ida" type="hidden" id="clase_ida" value="" />
                            <input name="precio_vuelta" type="hidden" id="precio_vuelta" value="0" />
                            <input name="clase_vuelta" type="hidden" id="clase_vuelta" value="" />         
                            <input name="navegador_vuelo" type="hidden" id="navegador_vuelo" value="0" />
                            <input type="hidden" id="importe_depart" value="0">
		                    <input type="hidden"  id="importe_return" value="0">
                            <input type="hidden" name="paso3" value="1"/>
                            <input type="hidden" name="fecha0" value="' . $fecha_ida . '" />
                            <input type="hidden" name="fecha1" value="' . $fecha_retorno . '" />
                            <input type="hidden" name="origen" value="' . $origen . '" />
                            <input type="hidden" name="destino" value="' . $destino . '" />
                            <input type="hidden" name="viaje_tipo" id="viaje_tipo" value=" ' . $tipo_viaje . '" />
                            <input type="hidden" name="adultos" id="adultos" value="' . $adultos . '" />
                            <input type="hidden" name="menores" id="menores" value="' . $menores . '" />
                            <input type="hidden" name="infantes" id="infantes" value="' . $infantes . '" />';
    }
}

if (isset($_POST['paso3'])) {
    if ($_POST['paso3'] == 1) {

        if ($_SESSION['s_idusuario'] == '' || $_SESSION['s_entidad'] == '') {
            $tabla_error = '<center >' . "\n";
            $tabla_error .= '<table >' . "\n";
            $tabla_error .= '<tr><td height="50"></td></tr>' . "\n";
            $tabla_error .= '<tr>' . "\n";
            $tabla_error .= '<td class="subtitleTable"  style="color:red !important;text-align:center;">El tiempo de espera ha termiando. Por favor cierre sesión y vuelva a ingresar.<br/>¡Gracias!</td>' . "\n";
            $tabla_error .= '</tr>' . "\n";
            $tabla_error .= '</table>' . "\n";
            $tabla_error .= '</center >' . "\n";
            echo $tabla_error;
            die;
        }

        $adultos = 0;
        $menores = 0;
        $infantes = 0;
        $tarifa_ida = 0;
        $numero_vuelo_ida = '';
        $fecha_hora_salida_ida = '';
        $fecha_hora_llegada_ida = '';
        $clase_ida = '';
        $origen_ida = '';
        $destino_ida = '';


        $tipo_viaje_3 = $_POST['viaje_tipo'];
        $adultos = $_POST['adultos'];
        $menores = $_POST['menores'];
        $infantes = $_POST['infantes'];
        $vuelo_ida = explode('#', $_POST['vuelo_ida']);
        $tarifa_ida = $vuelo_ida[0];
        $numero_vuelo_ida = $vuelo_ida[1];
        $fecha_hora_salida_ida = $vuelo_ida[2];
        $fecha_hora_llegada_ida = $vuelo_ida[3];
        $clase_ida = $vuelo_ida[4];
        $origen_ida = $vuelo_ida[5];
        $destino_ida = $vuelo_ida[6];

        if ($tipo_viaje_3 == 1) {

            $tarifa_vuelta = 0;
            $numero_vuelo_vuelta = '';
            $fecha_hora_salida_vuelta = '';
            $fecha_hora_llegada_vuelta = '';
            $clase_vuelta = '';
            $destino_vuelta = '';
            $origen_vuelta = '';

            $vuelo_vuelta = explode('#', $_POST['vuelo_vuelta']);
            $tarifa_vuelta = $vuelo_vuelta[0];
            $numero_vuelo_vuelta = $vuelo_vuelta[1];
            $fecha_hora_salida_vuelta = $vuelo_vuelta[2];
            $fecha_hora_llegada_vuelta = $vuelo_vuelta[3];
            $clase_vuelta = $vuelo_vuelta[4];
            $destino_vuelta = $vuelo_vuelta[5];
            $origen_vuelta = $vuelo_vuelta[6];
            $res_price = $KIU->AirPriceRQ(array(
                'City' => 'LIM'
                , 'Country' => 'PE'
                , 'Currency' => 'USD'
                , 'FlightSegment' => array(
                    array('DepartureDateTime' => "$fecha_hora_salida_ida", 'ArrivalDateTime' => "$fecha_hora_llegada_ida", 'FlightNumber' => "$numero_vuelo_ida", 'ResBookDesigCode' => "$clase_ida", 'DepartureAirport' => "$origen_ida", 'ArrivalAirport' => "$destino_ida", 'MarketingAirline' => "2I")
                    , array("DepartureDateTime" => "$fecha_hora_salida_vuelta", "ArrivalDateTime" => "$fecha_hora_llegada_vuelta", "FlightNumber" => "$numero_vuelo_vuelta", "ResBookDesigCode" => "$clase_vuelta", "DepartureAirport" => "$origen_vuelta", "ArrivalAirport" => "$destino_vuelta", "MarketingAirline" => "2I")
                )
                , 'PassengerQuantityADT' => "$adultos"
                , 'PassengerQuantityCNN' => "$menores"
                , 'PassengerQuantityINF' => "$infantes"
                , 'GivenName' => 'JUAN'
                , 'Surname' => 'PEREZ'
                , 'PhoneNumber' => '123456789'
                , 'Email' => 'juan@perez.com'
                , 'DocID' => '87654321'
                , 'DocType' => 'DNI'
                , 'Remark' => 'Pasajero necesita silla de ruedas'
                    ), $err);

            $cabecera = $res_price['PricedItineraries']['PricedItinerary']['AirItinerary'];
            $ida_vuelta = $cabecera['OriginDestinationOptions']['OriginDestinationOption']['FlightSegment'];

            // DATOS DE IDA
            $fecha_salida_price_ida = $ida_vuelta[0]['@attributes']['DepartureDateTime'];
            $fecha_salida_ida = substr($fecha_salida_price_ida, 0, 10);
            $hora_salida_ida = substr($fecha_salida_price_ida, 11, 13);
            $fecha_llegada_price_ida = $ida_vuelta[0]['@attributes']['ArrivalDateTime'];
            $hora_llegada_ida = substr($fecha_llegada_price_ida, 11, 13);
            $numero_vuelo_price_ida = $ida_vuelta[0]['@attributes']['FlightNumber'];
            $clase_price_ida = $ida_vuelta[0]['@attributes']['ResBookDesigCode'];
            $origen_price_ida = $ida_vuelta[0]['DepartureAirport']['@attributes']['LocationCode'];
            $nombre_origen_price_ida = $obj_tarifa->ObtenerNombreCiudad($origen_ida);
            $destino_price_ida = $ida_vuelta[0]['ArrivalAirport']['@attributes']['LocationCode'];
            $nombre_destino_price_ida = $obj_tarifa->ObtenerNombreCiudad($destino_ida);

            // DATOS DE VUELTA
            $fecha_salida_price_vuelta = $ida_vuelta[1]['@attributes']['DepartureDateTime'];
            $fecha_salida_vuelta = substr($fecha_salida_price_vuelta, 0, 10);
            $hora_salida_vuelta = substr($fecha_salida_price_vuelta, 11, 13);
            $fecha_llegada_price_vuelta = $ida_vuelta[1]['@attributes']['ArrivalDateTime'];
            $hora_llegada_vuelta = substr($fecha_llegada_price_vuelta, 11, 13);
            $numero_vuelo_price_vuelta = $ida_vuelta[1]['@attributes']['FlightNumber'];
            $clase_price_vuelta = $ida_vuelta[1]['@attributes']['ResBookDesigCode'];
            $origen_price_vuelta = $ida_vuelta[1]['DepartureAirport']['@attributes']['LocationCode'];
            $nombre_origen_price_vuelta = $obj_tarifa->ObtenerNombreCiudad($origen_vuelta);
            $destino_price_vuelta = $ida_vuelta[1]['ArrivalAirport']['@attributes']['LocationCode'];
            $nombre_destino_price_vuelta = $obj_tarifa->ObtenerNombreCiudad($destino_vuelta);

            //PINTANDO LA TABLA DE COTIZACION
            $table_cabecera = '';
            $table_cabecera .= '<table width="900" border="0" cellpadding="0" cellspacing="0">
                         <tr>
                           <td colspan="7" align="left" class="titleTable gradiante" style="color:white;">Itinerario</td>
                         </tr>
                         <tr>
                             <td height="3" colspan="7"  style="background:#fdb813;"></td>
                        </tr>
                         <tr>
                           <td width="170" align="left" class="subtitleTabla">Fecha de Ida</td>
                           <td width="172" align="left" class="subtitleTabla">Hora de Salida</td>
                           <td width="172" align="left" class="subtitleTabla">Hora de Llegada</td>
                           <td width="132" align="left" class="subtitleTabla">N° de Vuelo</td>
                           <td width="104" align="left" class="subtitleTabla">Clase</td>
                           <td width="104" align="left" class="subtitleTabla">Equipaje</td>
                         </tr>
                         <tr style="background: #F0F0F0">
                           <td align="left" class="bgTable_data">' . date("d/m/Y", strtotime($fecha_salida_ida)) . '</td>
                           <td align="left" class="bgTable_data"><strong>' . $hora_salida_ida . '</strong> ' . $nombre_origen_price_ida . ' (' . $origen_price_ida . ')</td>
                           <td align="left" class="bgTable_data"><strong>' . $hora_llegada_ida . '</strong> ' . $nombre_destino_price_ida . ' (' . $destino_price_ida . ')</td>
                           <td align="left" class="bgTable_data">' . $numero_vuelo_price_ida . '</td>
                           <td align="left" class="bgTable_data">' . $clase_price_ida . '</td>
                           <td align="left" class="bgTable_data">23 KG</td>
                         </tr>
                         <tr>
                           <td align="left" class="subtitleTabla">Fecha de Regreso</td>
                           <td align="left" class="subtitleTabla">Hora de Salida</td>
                           <td align="left" class="subtitleTabla">Hora de Llegada</td>
                           <td align="left" class="subtitleTabla">N° de Vuelo</td>
                           <td align="left" class="subtitleTabla">Clase</td>
                           <td align="left" class="subtitleTabla">Equipaje</td>
                         </tr>
                         <tr style="background: #F0F0F0">
                           <td align="left" class="bgTable_data">' . date("d/m/Y", strtotime($fecha_salida_vuelta)) . '</td>
                           <td align="left" class="bgTable_data"><strong>' . $hora_salida_vuelta . '</strong> ' . $nombre_origen_price_vuelta . ' (' . $origen_price_vuelta . ')</td>
                           <td align="left" class="bgTable_data"><strong>' . $hora_llegada_vuelta . '</strong> ' . $nombre_destino_price_vuelta . ' (' . $destino_price_vuelta . ')</td>
                           <td align="left" class="bgTable_data">' . $numero_vuelo_price_vuelta . '</td>
                           <td align="left" class="bgTable_data">' . $clase_price_vuelta . '</td>
                            <td align="left" class="bgTable_data">23 KG</td>
                         </tr>
                 </table>';
        } elseif ($tipo_viaje_3 == 0) {
            $res_price = $KIU->AirPriceRQ(array(
                'City' => 'LIM'
                , 'Country' => 'PE'
                , 'Currency' => 'USD'
                , 'FlightSegment' => array(
                    array('DepartureDateTime' => "$fecha_hora_salida_ida", 'ArrivalDateTime' => "$fecha_hora_llegada_ida", 'FlightNumber' => "$numero_vuelo_ida", 'ResBookDesigCode' => "$clase_ida", 'DepartureAirport' => "$origen_ida", 'ArrivalAirport' => "$destino_ida", 'MarketingAirline' => "2I")
                )
                , 'PassengerQuantityADT' => "$adultos"
                , 'PassengerQuantityCNN' => "$menores"
                , 'PassengerQuantityINF' => "$infantes"
                , 'GivenName' => 'JUAN'
                , 'Surname' => 'PEREZ'
                , 'PhoneNumber' => '123456789'
                , 'Email' => 'juan@perez.com'
                , 'DocID' => '87654321'
                , 'DocType' => 'DNI'
                , 'Remark' => 'Pasajero necesita silla de ruedas'
                    ), $err);
            // var_dump($res_price);die;
            $cabecera = $res_price['PricedItineraries']['PricedItinerary']['AirItinerary'];
            $ida_vuelta = $cabecera['OriginDestinationOptions']['OriginDestinationOption']['FlightSegment'];


            // DATOS DE IDA
            $fecha_salida_price_ida = $ida_vuelta['@attributes']['DepartureDateTime'];
            $fecha_salida_ida = substr($fecha_salida_price_ida, 0, 10);
            $hora_salida_ida = substr($fecha_salida_price_ida, 11, 13);
            $fecha_llegada_price_ida = $ida_vuelta['@attributes']['ArrivalDateTime'];
            $hora_llegada_ida = substr($fecha_llegada_price_ida, 11, 13);
            $numero_vuelo_price_ida = $ida_vuelta['@attributes']['FlightNumber'];
            $clase_price_ida = $ida_vuelta['@attributes']['ResBookDesigCode'];
            $origen_price_ida = $ida_vuelta['DepartureAirport']['@attributes']['LocationCode'];
            $nombre_origen_price_ida = $obj_tarifa->ObtenerNombreCiudad($origen_ida);
            $destino_price_ida = $ida_vuelta['ArrivalAirport']['@attributes']['LocationCode'];
            $nombre_destino_price_ida = $obj_tarifa->ObtenerNombreCiudad($destino_ida);

            $table_cabecera = '';
            $table_cabecera .= '<table width="900" border="0" cellpadding="0" cellspacing="0">
                         <tr>
                           <td colspan="7" align="left" class="titleTable gradiante" style="color:white;">Itinerario</td>
                         </tr>
                         <tr>
                             <td height="3" colspan="7"  style="background:#fdb813;"></td>
                        </tr>
                         <tr>
                           <td width="170" align="left" class="subtitleTabla">Fecha de Ida</td>
                           <td width="172" align="left" class="subtitleTabla">Hora de Salida</td>
                           <td width="172" align="left" class="subtitleTabla">Hora de Llegada</td>
                           <td width="132" align="left" class="subtitleTabla">N° de Vuelo</td>
                           <td width="104" align="left" class="subtitleTabla">Clase</td>
                           <td width="104" align="left" class="subtitleTabla">Equipaje</td>
                         </tr>
                         <tr style="background: #F0F0F0">
                           <td align="left" class="bgTable_data">' . date("d/m/Y", strtotime($fecha_salida_ida)) . '</td>
                           <td align="left" class="bgTable_data"><strong>' . $hora_salida_ida . '</strong> ' . $nombre_origen_price_ida . ' (' . $origen_price_ida . ')</td>
                           <td align="left" class="bgTable_data"><strong>' . $hora_llegada_ida . '</strong> ' . $nombre_destino_price_ida . ' (' . $destino_price_ida . ')</td>
                           <td align="left" class="bgTable_data">' . $numero_vuelo_price_ida . '</td>
                           <td align="left" class="bgTable_data">' . $clase_price_ida . '</td>
                           <td align="left" class="bgTable_data">23 KG</td>
                         </tr>

                 </table>';
        }

        $table_precio = '';
        $total_pagar = 0;
        $tipo_moneda = '';
        $tarifa = 0;
        $tuua = 0;
        $igv = 0;

        // adultos
        $tarifa_adulto = 0;
        $tuua_adulto = 0;
        $igv_adulto = 0;
        $subtotal_adulto = 0;

        //menores
        $tarifa_chil = 0;
        $tuua_chil = 0;
        $igv_chil = 0;
        $subtotal_chil = 0;

        // infantes
        $tarifa_bb = 0;
        $tuua_bb = 0;
        $igv_bb = 0;
        $subtotal_bb = 0;

        // echo "<pre>";
        // var_dump($res_price);
        // echo "</pre>";die;
        $detalle = $res_price['PricedItineraries']['PricedItinerary']['AirItineraryPricingInfo'];
        $total_pagar = $detalle['ItinTotalFare']['TotalFare']['@attributes']['Amount'];
        $tipo_moneda = $detalle['ItinTotalFare']['TotalFare']['@attributes']['CurrencyCode'];
        $tarifa = $detalle['ItinTotalFare']['BaseFare']['@attributes']['Amount'];
        $tipo_moneda_tarifa = $detalle['ItinTotalFare']['BaseFare']['@attributes']['CurrencyCode'];
        $cantidad_impuestos = count($detalle['ItinTotalFare']['Taxes']['Tax']);
        if ($cantidad_impuestos == 2) {
            $tuua = $detalle['ItinTotalFare']['Taxes']['Tax'][0]['@attributes']['Amount'];
            $igv = $detalle['ItinTotalFare']['Taxes']['Tax'][1]['@attributes']['Amount'];
        }
        if ($cantidad_impuestos == 1) {
            $tipo_impuesto = $detalle['ItinTotalFare']['Taxes']['Tax']['@attributes']['TaxCode'];
            if ($tipo_impuesto == 'PE') {
                $igv = $detalle['ItinTotalFare']['Taxes']['Tax']['@attributes']['Amount'];
            } else {
                $tuua = $detalle['ItinTotalFare']['Taxes']['Tax']['@attributes']['Amount'];
            }
        }

        $table_precio .= '<table width="900" border="0" cellpadding="0" cellspacing="0" class="bgTable_data">
                <tr>
                  <td colspan="5" align="left" class="titleTable gradiante" style="color:white;">Tarifa en D&oacute;lares Americanos</td>
                </tr>
                <tr>
                    <td height="3" colspan="7"  style="background:#fdb813;"></td>
               </tr>
                <tr>
                  <td width="171" class="subtitleTabla">Cantidad de Pasajeros</td>
                  <td width="191" align="center" class="subtitleTabla">Tarifa</td>
                  <td width="173" align="center" class="subtitleTabla">Impuesto</td>
                  <td width="161" align="center" class="subtitleTabla">TUUA</td>
                  <td width="202" align="center" class="subtitleTabla">Sub Total</td>
                 
                </tr>';



        if (($adultos > 0 and $menores == 0 and $infantes == 0)) {

            $cant_adult = $detalle['PTC_FareBreakdowns']['PTC_FareBreakdown']['PassengerTypeQuantity']['@attributes']['Quantity'];
            $tarifa_adulto = $detalle['PTC_FareBreakdowns']['PTC_FareBreakdown']['PassengerFare']['BaseFare']['@attributes']['Amount'];
            $cantidad_impuestos_adultos = count($detalle['PTC_FareBreakdowns']['PTC_FareBreakdown']['PassengerFare']['Taxes']['Tax']);
            if ($cantidad_impuestos_adultos == 2) {
                $tuua_adulto = $detalle['PTC_FareBreakdowns']['PTC_FareBreakdown']['PassengerFare']['Taxes']['Tax'][0]['@attributes']['Amount'];
                $igv_adulto = $detalle['PTC_FareBreakdowns']['PTC_FareBreakdown']['PassengerFare']['Taxes']['Tax'][1]['@attributes']['Amount'];
            }

            if ($cantidad_impuestos_adultos == 1) {
                $tipo_impuesto_adulto = $detalle['PTC_FareBreakdowns']['PTC_FareBreakdown']['PassengerFare']['Taxes']['Tax']['@attributes']['TaxCode'];
                if ($tipo_impuesto_adulto == 'PE') {
                    $igv_adulto = $detalle['PTC_FareBreakdowns']['PTC_FareBreakdown']['PassengerFare']['Taxes']['Tax']['@attributes']['Amount'];
                } else {
                    $tuua_adulto = $detalle['PTC_FareBreakdowns']['PTC_FareBreakdown']['PassengerFare']['Taxes']['Tax']['@attributes']['Amount'];
                }
            }


            $subtotal_adulto = $igv_adulto + $tuua_adulto + $tarifa_adulto; //VALOR REAL SE GUARDA EN AL BASE DE DATOS
            $subtotal_tabla_adl = $igv_adulto + $tarifa_adulto + $tuua_adulto; //VALOR MOSTRADO AL USUARIO
            $table_precio .= '<tr style="background: #F0F0F0">
                        <td height="18" align="left" class="bgTable_data">(' . $cant_adult . ') Pasajeros Adultos </td>
                        <td align="center" class="bgTable_data">' . number_format($tarifa_adulto, 2, '.', ',') . '</td>
                        <td align="center" class="bgTable_data">' . number_format($igv_adulto, 2, '.', ',') . '</td>
                        <td align="center" class="bgTable_data">' . number_format($tuua_adulto, 2, '.', ',') . '</td>
                        <td align="center" class="bgTable_data">' . number_format($subtotal_tabla_adl, 2, '.', ',') . '</td>
                    </tr>';
        } else {

            $cant_adult = $detalle['PTC_FareBreakdowns']['PTC_FareBreakdown'][0]['PassengerTypeQuantity']['@attributes']['Quantity'];
            $tarifa_adulto = $detalle['PTC_FareBreakdowns']['PTC_FareBreakdown'][0]['PassengerFare']['BaseFare']['@attributes']['Amount'];
            $cantidad_impuestos_adultos = count($detalle['PTC_FareBreakdowns']['PTC_FareBreakdown'][0]['PassengerFare']['Taxes']['Tax']);
            if ($cantidad_impuestos_adultos == 2) {
                $tuua_adulto = $detalle['PTC_FareBreakdowns']['PTC_FareBreakdown'][0]['PassengerFare']['Taxes']['Tax'][0]['@attributes']['Amount'];
                $igv_adulto = $detalle['PTC_FareBreakdowns']['PTC_FareBreakdown'][0]['PassengerFare']['Taxes']['Tax'][1]['@attributes']['Amount'];
            }



            $subtotal_adulto = $igv_adulto + $tuua_adulto + $tarifa_adulto; //VALOR REAL SE GUARDA EN AL BASE DE DATOS
            $subtotal_tabla_adl = $igv_adulto + $tarifa_adulto + $tuua_adulto; //VALOR MOSTRADO AL USUARIO
            $table_precio .= '<tr style="background: #F0F0F0">
                        <td height="18" align="left" class="bgTable_data">(' . $cant_adult . ') Pasajeros Adultos</td>
                        <td align="center" class="bgTable_data">' . number_format($tarifa_adulto, 2, '.', ',') . '</td>
                        <td align="center" class="bgTable_data">' . number_format($igv_adulto, 2, '.', ',') . '</td>
                        <td align="center" class="bgTable_data">' . number_format($tuua_adulto, 2, '.', ',') . '</td>
                        <td align="center" class="bgTable_data">' . number_format($subtotal_tabla_adl, 2, '.', ',') . '</td>
                    </tr>';
        }
        if ($menores > 0) {
            $cant_chil = $detalle['PTC_FareBreakdowns']['PTC_FareBreakdown'][1]['PassengerTypeQuantity']['@attributes']['Quantity'];
            $tarifa_chil = $detalle['PTC_FareBreakdowns']['PTC_FareBreakdown'][1]['PassengerFare']['BaseFare']['@attributes']['Amount'];
            $cantidad_impuesto_ninos = count($detalle['PTC_FareBreakdowns']['PTC_FareBreakdown'][1]['PassengerFare']['Taxes']['Tax']);
            if ($cantidad_impuesto_ninos == 2) {
                $tuua_chil = $detalle['PTC_FareBreakdowns']['PTC_FareBreakdown'][1]['PassengerFare']['Taxes']['Tax'][0]['@attributes']['Amount'];
                $igv_chil = $detalle['PTC_FareBreakdowns']['PTC_FareBreakdown'][1]['PassengerFare']['Taxes']['Tax'][1]['@attributes']['Amount'];
            }
            if ($cantidad_impuesto_ninos == 1) {
                $tipo_impuesto_nino = $detalle['PTC_FareBreakdowns']['PTC_FareBreakdown'][1]['PassengerFare']['Taxes']['Tax']['@attributes']['TaxCode'];
                if ($tipo_impuesto_nino == 'PE') {
                    $igv_chil = $detalle['PTC_FareBreakdowns']['PTC_FareBreakdown'][1]['PassengerFare']['Taxes']['Tax']['@attributes']['Amount'];
                } else {
                    $tuua_chil = $detalle['PTC_FareBreakdowns']['PTC_FareBreakdown'][1]['PassengerFare']['Taxes']['Tax']['@attributes']['Amount'];
                }
            }

            $subtotal_chil = $igv_chil + $tuua_chil + $tarifa_chil; //VALOR REAL SE GUARDA EN AL BASE DE DATOS
            $subtotal_tabla_ch = $igv_chil + $tarifa_chil + $tuua_chil; //VALOR MOSTRADO AL USUARIO
            $table_precio .= '<tr style="background: #F0F0F0">
                        <td height="18" align="left" class="bgTable_data">(' . $cant_chil . ') Pasajeros Niños</td>
                        <td align="center" class="bgTable_data">' . number_format($tarifa_chil, 2, '.', ',') . '</td>
                        <td align="center" class="bgTable_data">' . number_format($igv_chil, 2, '.', ',') . '</td>
                        <td align="center" class="bgTable_data">' . number_format($tuua_chil, 2, '.', ',') . '</td>
                        <td align="center" class="bgTable_data">' . number_format($subtotal_tabla_ch, 2, '.', ',') . '</td>
                    </tr>';
            if ($infantes > 0) {
                $cant_bb = $detalle['PTC_FareBreakdowns']['PTC_FareBreakdown'][2]['PassengerTypeQuantity']['@attributes']['Quantity'];
                $tarifa_bb = $detalle['PTC_FareBreakdowns']['PTC_FareBreakdown'][2]['PassengerFare']['BaseFare']['@attributes']['Amount'];
                $cantidad_impuesto_bb = count($detalle['PTC_FareBreakdowns']['PTC_FareBreakdown'][2]['PassengerFare']['Taxes']['Tax']);
                if ($cantidad_impuesto_bb == 2) {
                    $tuua_bb = $detalle['PTC_FareBreakdowns']['PTC_FareBreakdown'][2]['PassengerFare']['Taxes']['Tax'][0]['@attributes']['Amount'];
                    $igv_bb = $detalle['PTC_FareBreakdowns']['PTC_FareBreakdown'][2]['PassengerFare']['Taxes']['Tax'][1]['@attributes']['Amount'];
                }
                if ($cantidad_impuesto_bb == 1) {
                    $tipo_impuesto_bb = $detalle['PTC_FareBreakdowns']['PTC_FareBreakdown'][2]['PassengerFare']['Taxes']['Tax']['@attributes']['TaxCode'];
                    if ($tipo_impuesto_bb == 'PE') {
                        $igv_bb = $detalle['PTC_FareBreakdowns']['PTC_FareBreakdown'][2]['PassengerFare']['Taxes']['Tax']['@attributes']['Amount'];
                    } else {
                        $tuua_bb = $detalle['PTC_FareBreakdowns']['PTC_FareBreakdown'][2]['PassengerFare']['Taxes']['Tax']['@attributes']['Amount'];
                    }
                }

                $subtotal_bb = $igv_bb + $tuua_bb + $tarifa_bb; //VALOR REAL SE GUARDA EN AL BASE DE DATOS
                $igv_bb = $detalle['PTC_FareBreakdowns']['PTC_FareBreakdown'][2]['PassengerFare']['Taxes']['Tax'][1]['@attributes']['Amount'];
                $subtotal_tabla_i = $igv_bb + $tarifa_bb + $tuua_bb; //VALOR MOSTRADO AL USUARIO
                $table_precio .= '<tr style="background: #F0F0F0">
                            <td height="18" align="left" class="bgTable_data">(' . $cant_bb . ') Pasajeros Infantes</td>
                            <td align="center" class="bgTable_data">' . number_format($tarifa_bb, 2, '.', ',') . '</td>
                             <td align="center" class="bgTable_data">' . number_format($igv_bb, 2, '.', ',') . '</td>
                             <td align="center" class="bgTable_data">' . number_format($tuua_bb, 2, '.', ',') . '</td>    
                            <td align="center" class="bgTable_data">' . number_format($subtotal_tabla_i, 2, '.', ',') . '</td>
                        </tr>';
            }
        } else {
            if ($infantes > 0) {
                $cant_bb = $detalle['PTC_FareBreakdowns']['PTC_FareBreakdown'][1]['PassengerTypeQuantity']['@attributes']['Quantity'];
                $tarifa_bb = $detalle['PTC_FareBreakdowns']['PTC_FareBreakdown'][1]['PassengerFare']['BaseFare']['@attributes']['Amount'];
                $cantidad_impuesto_bb = count($detalle['PTC_FareBreakdowns']['PTC_FareBreakdown'][1]['PassengerFare']['Taxes']['Tax']);
                if ($cantidad_impuesto_bb == 2) {
                    $tuua_bb = $detalle['PTC_FareBreakdowns']['PTC_FareBreakdown'][1]['PassengerFare']['Taxes']['Tax'][0]['@attributes']['Amount'];
                    $igv_bb = $detalle['PTC_FareBreakdowns']['PTC_FareBreakdown'][1]['PassengerFare']['Taxes']['Tax'][1]['@attributes']['Amount'];
                }
                if ($cantidad_impuesto_bb == 1) {
                    $tipo_impuesto_bb = $detalle['PTC_FareBreakdowns']['PTC_FareBreakdown'][1]['PassengerFare']['Taxes']['Tax']['@attributes']['TaxCode'];
                    if ($tipo_impuesto_bb == 'PE') {
                        $igv_bb = $detalle['PTC_FareBreakdowns']['PTC_FareBreakdown'][1]['PassengerFare']['Taxes']['Tax']['@attributes']['Amount'];
                    } else {
                        $tuua_bb = $detalle['PTC_FareBreakdowns']['PTC_FareBreakdown'][1]['PassengerFare']['Taxes']['Tax']['@attributes']['Amount'];
                    }
                }

                $subtotal_bb = $igv_bb + $tuua_bb + $tarifa_bb; //VALOR REAL SE GUARDA EN AL BASE DE DATOS
                $subtotal_tabla_i = $igv_bb + $tarifa_bb + $tuua_bb; //VALOR MOSTRADO AL USUARIO
                $table_precio .= '<tr style="background: #F0F0F0">
                        <td height="18" align="left" class="bgTable_data">(' . $cant_bb . ') Pasajeros Infantes</td>
                        <td align="center" class="bgTable_data">' . number_format($tarifa_bb, 2, '.', ',') . '</td>
                        <td align="center" class="bgTable_data">' . number_format($igv_bb, 2, '.', ',') . '</td>
                        <td align="center" class="bgTable_data">' . number_format($tuua_bb, 2, '.', ',') . '</td>    
                        <td align="center" class="bgTable_data">' . number_format($subtotal_tabla_i, 2, '.', ',') . '</td>
                    </tr>';
            }
        }
    }
}
$total_pagar_tabla = $subtotal_tabla_adl + $subtotal_tabla_ch + $subtotal_tabla_i;
$table_precio .= '<tr>
                  <td colspan="4" align="left" class="subtitleTabla">Total a pagar:</td>
                  <td align="center" class="subtitleTabla gradiante" style="color:white;">' . $tipo_moneda . ' ' . number_format($total_pagar_tabla, 2, '.', ',') . '</td>
                </tr>
              </table>';

$codigo_entidad = $_SESSION["s_entidad"];
$credito = $obj_persona->ObtenerLineaCredito($codigo_entidad);

if ($total_pagar > $credito) {
    $puede = 'style="display:none;"';
    $mensaje = '<p style="color:red !important;text-align:right !important;font-size:12px !importan;">El total a pagar Excede al Credito Disponible.<p/>';
} else {
    $puede = 0;
    $mensaje_precio = '';
}

$_SESSION['table_cabecera'] = $table_cabecera;
$_SESSION['table_precio'] = $table_precio;
$_SESSION['mensaje'] = $mensaje;
$_SESSION['puede'] = $puede;
$_SESSION['total_pagar'] = $total_pagar;

$_SESSION['hide_paso3'] = '<input type="hidden" name="paso4" value="1"/>
                            <input type="hidden" name="tipo_viaje_4" id="tipo_viaje_4" value="' . $tipo_viaje_3 . '"/>
                            <input type="hidden" name="adultos4" id="adultos4" value="' . $adultos . '"/>
                            <input type="hidden" name="menores4" id="menores4" value="' . $menores . '"/>
                            <input type="hidden" name="infantes4" id="infantes4" value="' . $infantes . '"/>
                            <input type="hidden" name="total_pagar" id="total_pagar" value="' . $total_pagar . '"/>
                            <input type="hidden" name="tuua" id="tuua" value="' . $tuua . '"/>
                            <input type="hidden" name="igv" id="igv" value="' . $igv . '"/>
                            <input type="hidden" name="tipo_moneda_4" id="tipo_moneda_4" value="' . $tipo_moneda . '"/>
                            <!--datos de vuelo ida-->
                            <input type="hidden" name="tarifa_ida" id="tarifa_ida" value="' . $tarifa_ida . '"/>
                            <input type="hidden" name="numero_vuelo_ida" id="numero_vuelo_ida" value="' . $numero_vuelo_ida . '"/>
                            <input type="hidden" name="fecha_hora_salida_ida" id="fecha_hora_salida_ida" value="' . $fecha_hora_salida_ida . '"/>
                            <input type="hidden" name="fecha_hora_llegada_ida" id="fecha_hora_llegada_ida" value="' . $fecha_hora_llegada_ida . '"/>
                            <input type="hidden" name="clase_ida" id="clase_ida" value="' . $clase_ida . '"/>
                            <input type="hidden" name="origen_ida" id="origen_ida" value="' . $origen_ida . '"/>
                            <input type="hidden" name="destino_ida" id="destino_ida" value="' . $destino_ida . '"/>
                             <!--datos de vuelo ida-->
                            <input type="hidden" name="tarifa_vuelta" id="tarifa_vuelta" value="' . $tarifa_vuelta . '"/>
                            <input type="hidden" name="numero_vuelo_vuelta" id="numero_vuelo_vuelta" value="' . $numero_vuelo_vuelta . '"/>
                            <input type="hidden" name="fecha_hora_salida_vuelta" id="fecha_hora_salida_vuelta" value="' . $fecha_hora_salida_vuelta . '"/>
                            <input type="hidden" name="fecha_hora_llegada_vuelta" id="fecha_hora_llegada_vuelta" value="' . $fecha_hora_llegada_vuelta . '"/>
                            <input type="hidden" name="clase_vuelta" id="clase_vuelta" value="' . $clase_vuelta . '"/>
                            <input type="hidden" name="origen_vuelta" id="origen_vuelta" value="' . $origen_vuelta . '"/>
                            <input type="hidden" name="destino_vuelta" id="destino_vuelta" value="' . $destino_vuelta . '"/>
                             <!--precios de adultos-->
                            <input type="hidden" name="tarifa_adulto" id="tarifa_adulto" value="' . $tarifa_adulto . '"/>
                            <input type="hidden" name="tuua_adulto" id="tuua_adulto" value="' . $tuua_adulto . '"/>
                            <input type="hidden" name="igv_adulto" id="igv_adulto" value="' . $igv_adulto . '"/>
                            <input type="hidden" name="subtotal_adulto" id="subtotal_adulto" value="' . $subtotal_adulto . '"/>
                             <!--precios de menores-->
                            <input type="hidden" name="tarifa_chil" id="tarifa_chil" value="' . $tarifa_chil . '"/>
                            <input type="hidden" name="tuua_chil" id="tuua_chil" value="' . $tuua_chil . '"/>
                            <input type="hidden" name="igv_chil" id="igv_chil" value="' . $igv_chil . '"/>
                            <input type="hidden" name="subtotal_chil" id="subtotal_chil" value="' . $subtotal_chil . '"/>
                             <!--precios de infantes-->
                            <input type="hidden" name="tarifa_bb" id="tarifa_bb" value="' . $tarifa_bb . '"/>
                            <input type="hidden" name="tuua_bb" id="tuua_bb" value="' . $tuua_bb . '"/>
                            <input type="hidden" name="igv_bb" id="igv_bb" value="' . $igv_bb . '"/>
                            <input type="hidden" name="subtotal_bb" id="subtotal_bb" value="' . $subtotal_bb . '"/>';



if (isset($_POST['paso4'])) {
    if ($_POST['paso4'] == 1) {
        if ($_SESSION['s_idusuario'] == '' || $_SESSION['s_entidad'] == '') {
            $tabla_error .= '<center >' . "\n";
            $tabla_error .= '<table >' . "\n";
            $tabla_error .= '<tr><td height="50"></td></tr>' . "\n";
            $tabla_error .= '<tr>' . "\n";
            $tabla_error .= '<td class="subtitleTable"  style="color:red !important;text-align:center;">El tiempo de espera ha termiando. Por favor cierre sesión y vuelva a ingresar.<br/>¡Gracias!</td>' . "\n";
            $tabla_error .= '</tr>' . "\n";
            $tabla_error .= '</table>' . "\n";
            $tabla_error .= '</center >' . "\n";
            echo $tabla_error;
            die;
        }
        $table_cabecera_4 = '';
        $table_precio_4 = '';

        $tipo_moneda_4 = $_POST['tipo_moneda_4'];
        $tipo_viaje_4 = $_POST['tipo_viaje_4'];
        $adultos_4 = $_POST['adultos4'];
        $menores_4 = $_POST['menores4'];
        $infantes_4 = $_POST['infantes4'];
        $total_pagar_4 = $_POST['total_pagar'];
        $tuua_4 = $_POST['tuua'];
        $igv_4 = $_POST['igv'];

        // datos del vuelo ida
        $tarifa_ida_4 = $_POST['tarifa_ida'];
        $numero_vuelo_ida_4 = $_POST['numero_vuelo_ida'];
        $fecha_hora_salida_ida_4 = $_POST['fecha_hora_salida_ida'];

        $fecha_salida_ida_4 = substr($fecha_hora_salida_ida_4, 0, 10);
        $hora_salida_ida_4 = substr($fecha_hora_salida_ida_4, 11, 13);

        $fecha_hora_llegada_ida_4 = $_POST['fecha_hora_llegada_ida'];
        $hora_llegada_ida_4 = substr($fecha_hora_llegada_ida_4, 11);

        $clase_ida_4 = $_POST['clase_ida'];
        $origen_ida_4 = $_POST['origen_ida'];
        $nombre_origen_4 = $obj_tarifa->ObtenerNombreCiudad($origen_ida_4);
        $destino_ida_4 = $_POST['destino_ida'];
        $nombre_destino_4 = $obj_tarifa->ObtenerNombreCiudad($destino_ida_4);

        // datos del vuelo vuelta
        $tarifa_vuelta_4 = $_POST['tarifa_vuelta'];
        $numero_vuelo_vuelta_4 = $_POST['numero_vuelo_vuelta'];
        $fecha_hora_salida_vuelta_4 = $_POST['fecha_hora_salida_vuelta'];

        $fecha_salida_vuelta_4 = substr($fecha_hora_salida_vuelta_4, 0, 10);
        $hora_salida_vuelta_4 = substr($fecha_hora_salida_vuelta_4, 11, 13);

        $fecha_hora_llegada_vuelta_4 = $_POST['fecha_hora_llegada_vuelta'];
        $hora_llegada_vuelta_4 = substr($fecha_hora_llegada_vuelta_4, 11, 13);
        $clase_vuelta_4 = $_POST['clase_vuelta'];
        $origen_vuelta_4 = $_POST['origen_vuelta'];
        $nombre_origen_vuelta_4 = $obj_tarifa->ObtenerNombreCiudad($origen_vuelta_4);
        $destino_vuelta_4 = $_POST['destino_vuelta'];
        $nombre_destino_vuelta_4 = $obj_tarifa->ObtenerNombreCiudad($destino_vuelta_4);


        // calculo de adultos
        $tarifa_adulto_4 = $_POST['tarifa_adulto'];
        $tuua_adulto_4 = $_POST['tuua_adulto'];
        $igv_adulto_4 = $_POST['igv_adulto'];
        $subtotal_adulto_4 = $_POST['subtotal_adulto'];

        // calculo de menores
        $tarifa_chil_4 = $_POST['tarifa_chil'];
        $tuua_chil_4 = $_POST['tuua_chil'];
        $igv_chil_4 = $_POST['igv_chil'];
        $subtotal_chil_4 = $_POST['subtotal_chil'];

        // calculo de infantes
        $tarifa_bb_4 = $_POST['tarifa_bb'];
        $tuua_bb_4 = $_POST['tuua_bb'];
        $igv_bb_4 = $_POST['igv_bb'];
        $subtotal_bb_4 = $_POST['subtotal_bb'];

        if ($tipo_viaje_4 == 1) {

            $table_cabecera_4 .= '<table width="900" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td colspan="7" align="left" class="titleTable gradiante" style="color:white;">Itinerario</td>
                </tr>
                <tr>
                    <td height="3" colspan="7"  style="background:#fdb813;"></td>
               </tr>
                <tr>
                  <td width="170" align="left" class="subtitleTabla">Fecha de Ida</td>
                  <td width="172" align="left" class="subtitleTabla">Hora de Salida</td>
                  <td width="172" align="left" class="subtitleTabla">Hora de Llegada</td>
                  <td width="132" align="left" class="subtitleTabla">N° de Vuelo</td>
                  <td width="104" align="left" class="subtitleTabla">Clase</td>
                  <td width="104" align="left" class="subtitleTabla">Equipaje</td>
                </tr>
                <tr style="background: #F0F0F0">
                  <td align="left" class="bgTable_data">' . date("d/m/Y", strtotime($fecha_salida_ida_4)) . '</td>
                  <td align="left" class="bgTable_data"><strong>' . $hora_salida_ida_4 . '</strong> ' . $nombre_origen_4 . ' (' . $origen_ida_4 . ')</td>
                  <td align="left" class="bgTable_data"><strong>' . $hora_llegada_ida_4 . '</strong> ' . $nombre_destino_4 . ' (' . $destino_ida_4 . ')</td>
                  <td align="left" class="bgTable_data">' . $numero_vuelo_ida_4 . '</td>
                  <td align="left" class="bgTable_data">' . $clase_ida_4 . '</td>
                  <td align="left" class="bgTable_data">23 KG</td>
                </tr>
                <tr>
                  <td align="left" class="subtitleTabla">Fecha de Regreso</td>
                  <td align="left" class="subtitleTabla">Hora de Salida</td>
                  <td align="left" class="subtitleTabla">Hora de Llegada</td>
                  <td align="left" class="subtitleTabla">N° de Vuelo</td>
                  <td align="left" class="subtitleTabla">Clase</td>
                  <td align="left" class="subtitleTabla">Equipaje</td>
                </tr>
                <tr style="background: #F0F0F0">
                  <td align="left" class="bgTable_data">' . date("d/m/Y", strtotime($fecha_salida_vuelta_4)) . '</td>
                  <td align="left" class="bgTable_data"><strong>' . $hora_salida_vuelta_4 . '</strong> ' . $nombre_origen_vuelta_4 . ' (' . $origen_vuelta_4 . ')</td>
                  <td align="left" class="bgTable_data"><strong>' . $hora_llegada_vuelta_4 . '</strong> ' . $nombre_destino_vuelta_4 . ' (' . $destino_vuelta_4 . ')</td>
                  <td align="left" class="bgTable_data">' . $numero_vuelo_vuelta_4 . '</td>
                  <td align="left" class="bgTable_data">' . $clase_vuelta_4 . '</td>
                   <td align="left" class="bgTable_data">23 KG</td>
                </tr>
        </table>';
        } elseif ($tipo_viaje_4 == 0) {

            $table_cabecera_4 .= '<table width="900" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td colspan="6" align="left" class="titleTable gradiante" style="color:white;">Itinerario</td>
                </tr>
                <tr>
                    <td height="3" colspan="6"  style="background:#fdb813;"></td>
               </tr>
                <tr>
                  <td width="170" align="left" class="subtitleTabla">Fecha de Ida</td>
                  <td width="172" align="left" class="subtitleTabla">Hora de Salida</td>
                  <td width="172" align="left" class="subtitleTabla">Hora de Llegada</td>
                  <td width="132" align="left" class="subtitleTabla">N° de Vuelo</td>
                  <td width="104" align="left" class="subtitleTabla">Clase</td>
                  <td width="104" align="left" class="subtitleTabla">Equipaje</td>
                </tr>
                <tr style="background: #F0F0F0">
                  <td align="left" class="bgTable_data">' . date("d/m/Y", strtotime($fecha_salida_ida_4)) . '</td>
                  <td align="left" class="bgTable_data"><strong>' . $hora_salida_ida_4 . '</strong> ' . $nombre_origen_4 . ' (' . $origen_ida_4 . ')</td>
                  <td align="left" class="bgTable_data"><strong>' . $hora_llegada_ida_4 . '</strong> ' . $nombre_destino_4 . ' (' . $destino_ida_4 . ')</td>
                  <td align="left" class="bgTable_data">' . $numero_vuelo_ida_4 . '</td>
                  <td align="left" class="bgTable_data">' . $clase_ida_4 . '</td>
                  <td align="left" class="bgTable_data">23 KG</td>
                </tr></table>';
        }

        $table_precio_4 .= '<table width="900" border="0" cellpadding="0" cellspacing="0" class="bgTable_data">
                <tr>
                  <td colspan="5" align="left" class="titleTable gradiante" style="color:white;">Tarifa en D&oacute;lares Americanos</td>
                </tr>
                <tr>
                    <td height="3" colspan="5"  style="background:#fdb813;"></td>
               </tr>
                <tr>
                  <td width="171" class="subtitleTabla">Cantidad de Pasajeros</td>
                  <td width="191" align="center" class="subtitleTabla">Tarifa</td>
                  <td width="173" align="center" class="subtitleTabla">Impuesto</td>
                  <td width="161" align="center" class="subtitleTabla">TUUA</td>   
                  <td width="202" align="center" class="subtitleTabla">Sub Total</td>
                </tr>';

//if($origen_ida_4=='HUU'){
//    $ciudad_exonerada_TUUA_origen=1;
//}



        if (($adultos_4 > 0 and $menores_4 == 0 and $infantes_4 == 0)) {

            $cant_adult = $adultos_4;
            $tarifa_adulto = $tarifa_adulto_4;
            $tuua_adulto = $tuua_adulto_4;
            $igv_adulto = $igv_adulto_4;

            $subtotal_adulto = $igv_adulto + $tuua_adulto + $tarifa_adulto; //VALOR REAL SE GUARDA EN AL BASE DE DATOS
            $subtotal_tabla_adl = $igv_adulto + $tarifa_adulto + $tuua_adulto; //VALOR MOSTRADO AL USUARIO
            $table_precio_4 .= '<tr style="background: #F0F0F0">
                        <td height="18" align="left" class="bgTable_data">(' . $cant_adult . ') Pasajeros Adultos </td>
                        <td align="center" class="bgTable_data">' . number_format($tarifa_adulto, 2, '.', ',') . '</td>
                        <td align="center" class="bgTable_data">' . number_format($igv_adulto, 2, '.', ',') . '</td>    
                        <td align="center" class="bgTable_data">' . number_format($tuua_adulto, 2, '.', ',') . '</td>
                        <td align="center" class="bgTable_data">' . number_format($subtotal_tabla_adl, 2, '.', ',') . '</td>
                        
                    </tr>';
        } else {
            if ($adultos_4 > 0) {

                $cant_adult = $adultos_4;
                $tarifa_adulto = $tarifa_adulto_4;
                $tuua_adulto = $tuua_adulto_4;
                $igv_adulto = $igv_adulto_4;


                $subtotal_adulto = $igv_adulto + $tuua_adulto + $tarifa_adulto; //VALOR REAL SE GUARDA EN AL BASE DE DATOS
                $subtotal_tabla_adl = $igv_adulto + $tarifa_adulto + $tuua_adulto; //VALOR MOSTRADO AL USUARIO
                $table_precio_4 .= '<tr style="background: #F0F0F0">
                        <td height="18" align="left" class="bgTable_data">(' . $cant_adult . ') Pasajeros Adultos</td>
                        <td align="center" class="bgTable_data">' . number_format($tarifa_adulto, 2, '.', ',') . '</td>
                        <td align="center" class="bgTable_data">' . number_format($igv_adulto, 2, '.', ',') . '</td>                        
                        <td align="center" class="bgTable_data">' . number_format($tuua_adulto, 2, '.', ',') . '</td>    
                        <td align="center" class="bgTable_data">' . number_format($subtotal_tabla_adl, 2, '.', ',') . '</td>
                    </tr>';
            }
            if ($menores_4 > 0) {

                $cant_chil = $menores_4;
                $tarifa_chil = $tarifa_chil_4;
                $tuua_chil = $tuua_chil_4;
                $igv_chil = $igv_chil_4;


                $subtotal_chil = $igv_chil + $tuua_chil + $tarifa_chil; //VALOR REAL SE GUARDA EN AL BASE DE DATOS
                $subtotal_tabla_ch = $igv_chil + $tarifa_chil + $tuua_chil; //VALOR MOSTRADO AL USUARIO
                $table_precio_4 .= '<tr style="background: #F0F0F0">
                        <td height="18" align="left" class="bgTable_data">(' . $cant_chil . ') Pasajeros Niños</td>
                        <td align="center" class="bgTable_data">' . number_format($tarifa_chil, 2, '.', ',') . '</td>
                        <td align="center" class="bgTable_data">' . number_format($igv_chil, 2, '.', ',') . '</td>
                        <td align="center" class="bgTable_data">' . number_format($tuua_chil, 2, '.', ',') . '</td>
                        <td align="center" class="bgTable_data">' . number_format($subtotal_tabla_ch, 2, '.', ',') . '</td>
                    </tr>';
            }

            if ($infantes_4 > 0) {

                $cant_bb = $infantes_4;
                $tarifa_bb = $tarifa_bb_4;
                $tuua_bb = $tuua_bb_4;
                $igv_bb = $igv_bb_4;

                $subtotal_bb = $igv_bb + $tuua_bb + $tarifa_bb; //VALOR REAL SE GUARDA EN AL BASE DE DATOS
                $subtotal_tabla_i = $igv_bb + $tarifa_bb + $tuua_bb; //VALOR MOSTRADO AL USUARIO
                $table_precio_4 .= '<tr style="background: #F0F0F0">
                        <td height="18" align="left" class="bgTable_data">(' . $cant_bb . ') Pasajeros Infantes</td>
                        <td align="center" class="bgTable_data">' . number_format($tarifa_bb, 2, '.', ',') . '</td>
                        <td align="center" class="bgTable_data">' . number_format($igv_bb, 2, '.', ',') . '</td>    
                        <td align="center" class="bgTable_data">' . number_format($tuua_bb, 2, '.', ',') . '</td>     
                        <td align="center" class="bgTable_data">' . number_format($subtotal_tabla_i, 2, '.', ',') . '</td>
                    </tr>';
            }
        }
        $total_pagar_tabla_4 = $subtotal_tabla_adl + $subtotal_tabla_ch + $subtotal_tabla_i;
        $table_precio_4 .= '<tr>
                  <td colspan="4" align="left" class="subtitleTabla">Total a pagar:</td>
                  <td align="center" class="subtitleTabla gradiante" style="color:white;">' . $tipo_moneda_4 . ' ' . number_format($total_pagar_tabla_4, 2, '.', ',') . '</td>
                </tr>
              </table>';

        $cantidad_pasajeros = $adultos_4 + $menores_4 + $infantes_4;

        $table_pasajeros = ' <table width="898" border="0" cellpadding="0" cellspacing="0">';

        for ($i = 1; $i <= $adultos_4; $i++) {
            $table_pasajeros .= '<tr>
                          <td align="left" class="titleTable gradiante" style="color:white;">Datos - Adulto N° ' . $i . '</td>
                        </tr>
                         <tr>
                            <td height="3" colspan="5"  style="background:#fdb813;"></td>
                       </tr>
                        <tr>
                          <td height="1" style="background-color: #FFFFFF"></td>
                        </tr>
                        <tr>
                          <td height="30" align="center">
                         <table width="898" cellpadding="0" cellspacing="0" border="0">
                              <tr class="pasajeros">
                                <td width="8" height="30"></td>
                                <td width="140" align="left">Nombres <span class="colorRed">* </span>:</td>
                                <td width="1" style="background-color: #FFFFFF"></td>
                                <td width="8"></td>
                                <td width="140" align="left">Apellido Paterno <span class="colorRed">* </span>:</td>
                                <td width="1" style="background-color: #FFFFFF"></td>
                                <td width="8"></td>
                                <td width="140" align="left">Apellido Materno:</td>
                                <td width="1" style="background-color: #FFFFFF"></td>
                                <td width="8"></td>
                                <td colspan="4" align="left">Documento de Identidad <span class="colorRed">* </span>:</td>
                                <td width="1" style="background-color: #FFFFFF"></td>
                                <td width="8"></td>
                                <td width="173" align="left">E-mail <span class="colorRed">* </span> :</td>
                              </tr>
                              <tr>
                                <td height="1" colspan="17" style="background-color: #FFFFFF"></td>
                              </tr>
                              <tr class="pasajeros">
                                <td height="36"></td>
                                <td align="left"><input type="text" name="nombre_a_' . $i . '" id="nombre_a_' . $i . '" class="frmInput" style="width: 124px; text-transform: uppercase" onKeyPress="Change(); " value="" /></td>
                                <td style="background-color: #FFFFFF"></td>
                                <td></td>
                                <td align="left"><input type="text" name="paterno_a_' . $i . '" id="paterno_a_' . $i . '" class="frmInput" style="width: 124px; text-transform: uppercase" onKeyPress="Change(); "  value=""/></td>
                                <td style="background-color: #FFFFFF"></td>
                                <td></td>
                                <td align="left"><input type="text" name="materno_a_' . $i . '" id="materno_a_' . $i . '" class="frmInput" style="width: 124px; text-transform: uppercase" onKeyPress="Change(); "  value=""/></td>
                                <td style="background-color: #FFFFFF"></td>
                                <td></td>
                                <td width="140" align="left">
                                  <select id="tipo_doc_a_' . $i . '" name="tipo_doc_a_' . $i . '" class="reserva_option" style="width: 130px" onChange="Change()">
                                    <option value="NI" selected>DNI</option>
                                    <option value="PP">PASAPORTE</option>
                                    <option value="ID">CARN&Eacute; EXTRANJERIA</option>

                                  </select>
                                </td>
                                <td width="1" style="background-color: #FFFFFF"></td>
                                <td width="8"></td>
                                <td width="112" align="left"><input name="num_doc_a_' . $i . '" type="text" id="num_doc_a_' . $i . '" maxlength="15" class="frmInput documento_a" style="width: 96px" onKeyPress="Change()"  title="Ingrese el número de Documento para obtener información del Pasajero de forma automática." value=""/></td>
                                <td style="background-color: #FFFFFF"></td>
                                <td></td>
                                <td align="left"><input type="text" name="email_a_' . $i . '" id="email_a_' . $i . '" class="frmInput" style="width: 157px; text-transform: uppercase" onKeyPress="Change(); return CaractValidoEmail(event)"  value=""/></td>
                              </tr>
                              <tr>
                                <td height="1" colspan="17" style="background-color: #FFFFFF"></td>
                              </tr>
                              <tr class="pasajeros">
                                <td height="36"></td>
                                <td align="left">Tel&eacute;f. Oficina + Anexo:</td>
                                <td style="background-color: #FFFFFF"></td>
                                <td></td>
                                <td align="left">Celular <span class="colorRed">* </span> :</td>
                                <td style="background-color: #FFFFFF"></td>
                                <td></td>
                                ' . (($i == 1) ? '<td align="left">RUC :</td>
                                <td style="background-color: #FFFFFF"></td>
                                <td></td>' : ' ') . '
                                <td align="left" colspan="17"></td>
                                <td style="background-color: #FFFFFF"></td>
                                <td></td>    
                              </tr>
                              <tr>
                                <td height="1" colspan="17" style="background-color: #FFFFFF"></td>
                              </tr>
                              <tr class="pasajeros">
                                <td height="36"></td>
                                <td align="left">
                                        <table cellpadding="0" cellspacing="0" border="0">
                                        <tr>
                                        <td><input name="ofic_a_' . $i . '" type="text" id="ofic_a_' . $i . '" maxlength="7" class="frmInput" style="width: 72px" onKeyPress="return NumeroInt(event)" /></td>
                                                        <td width="8"></td>
                                        <td><input name="ofic_ane_a_' . $i . '" type="text" id="ofic_ane_a_' . $i . '" maxlength="6" class="frmInput" style="width: 34px" onKeyPress="return NumeroInt(event)" /></td>
                                    </tr>
                                  </table>
                                </td>
                                <td style="background-color: #FFFFFF"></td>
                                <td></td>
                                <td align="left"><input name="celular_a_' . $i . '" type="text" id="celular_a_' . $i . '" maxlength="9" class="frmInput" style="width: 96px" onKeyPress="return NumeroInt(event)"  value=""/></td>
                                <td style="background-color: #FFFFFF"></td>
                                <td></td>
                                ' . (($i == 1) ? '<td align="left"><input name="ruc_a_' . $i . '" type="text" id="ruc_a_' . $i . '" maxlength="11" class="frmInput" style="width: 96px" onKeyPress="return NumeroInt(event)" /></td>
                                <td style="background-color: #FFFFFF"></td><td></td>' : ' ') . '
                                <td align="left" colspan="11">
                              
                              </tr>
                              <tr>
                                <td height="1" colspan="17" style="background-color: #FFFFFF"></td>
                              </tr>
                              <tr class="pasajeros">
                                <td height="30"></td>
                                <td colspan="16" align="left" id="resultado_a_' . $i . '" style="color: #CC0033"></td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                ';
        }

        if ($menores_4 > 0) {
            for ($j = 1; $j <= $menores_4; $j++) {
                $table_pasajeros .= '<tr>
                                  <td align="left" class="titleTable gradiante" style="color:white;">Datos - Niño N° ' . $j . '</td>
                                </tr>
                                 <tr>
                                    <td height="3" colspan="5"  style="background:#fdb813;"></td>
                               </tr>
                                <tr>
                                  <td height="1" style="background-color: #FFFFFF"></td>
                                </tr>
                                <tr>
                                  <td height="30" align="center">
                                 <table width="898" cellpadding="0" cellspacing="0" border="0">
                                      <tr class="pasajeros">
                                        <td width="8" height="30"></td>
                                        <td width="140" align="left">Nombres <span class="colorRed">* </span>:</td>
                                        <td width="1" style="background-color: #FFFFFF"></td>
                                        <td width="8"></td>
                                        <td width="140" align="left">Apellido Paterno <span class="colorRed">* </span>:</td>
                                        <td width="1" style="background-color: #FFFFFF"></td>
                                        <td width="8"></td>
                                        <td width="140" align="left">Apellido Materno :</td>
                                        <td width="1" style="background-color: #FFFFFF"></td>
                                        <td width="8"></td>
                                        <td colspan="4" align="left">Documento de Identidad <span class="colorRed">* </span>:</td>
                                        <td width="1" style="background-color: #FFFFFF"></td>
                                        <td width="8"></td>
                                        <td width="173" align="left">E-mail <span class="colorRed">* </span> :</td>
                                      </tr>
                                      <tr>
                                        <td height="1" colspan="17" style="background-color: #FFFFFF"></td>
                                      </tr>
                                      <tr class="pasajeros">
                                        <td height="36"></td>
                                        <td align="left"><input type="text" name="nombre_m_' . $j . '" id="nombre_m_' . $j . '" class="frmInput" style="width: 124px; text-transform: uppercase" onKeyPress="Change(); " value="" /></td>
                                        <td style="background-color: #FFFFFF"></td>
                                        <td></td>
                                        <td align="left"><input type="text" name="paterno_m_' . $j . '" id="paterno_m_' . $j . '" class="frmInput" style="width: 124px; text-transform: uppercase" onKeyPress="Change(); "  value=""/></td>
                                        <td style="background-color: #FFFFFF"></td>
                                        <td></td>
                                        <td align="left"><input type="text" name="materno_m_' . $j . '" id="materno_m_' . $j . '" class="frmInput" style="width: 124px; text-transform: uppercase" onKeyPress="Change(); "  value=""/></td>
                                        <td style="background-color: #FFFFFF"></td>
                                        <td></td>
                                        <td width="140" align="left">
                                          <select id="tipo_doc_m_' . $j . '" name="tipo_doc_m_' . $j . '" class="reserva_option" style="width: 130px" onChange="Change()">
                                            <option value="NI" selected>DNI</option>
                                            <option value="PP">PASAPORTE</option>
                                            <option value="ID">CARN&Eacute; EXTRANJERIA</option>
                                          </select>
                                        </td>
                                        <td width="1" style="background-color: #FFFFFF"></td>
                                        <td width="8"></td>
                                        <td width="112" align="left"><input name="num_doc_m_' . $j . '" type="text" id="num_doc_m_' . $j . '" maxlength="15" class="frmInput documento_m" style="width: 96px" onKeyPress="Change()"  title="Ingrese el número de Documento para obtener información del Pasajero de forma automática." value=""/></td>
                                        <td style="background-color: #FFFFFF"></td>
                                        <td></td>
                                        <td align="left"><input type="text" name="email_m_' . $j . '" id="email_m_' . $j . '" class="frmInput" style="width: 157px; text-transform: uppercase" onKeyPress="Change(); return CaractValidoEmail(event)"  value=""/></td>
                                      </tr>
                                      <tr>
                                        <td height="1" colspan="17" style="background-color: #FFFFFF"></td>
                                      </tr>
                                      <tr class="pasajeros">
                                        <td height="36"></td>
                                        <td align="left">Tel&eacute;f. Oficina + Anexo:</td>
                                        <td style="background-color: #FFFFFF"></td>
                                        <td></td>
                                        <td align="left">Celular <span class="colorRed">* </span> :</td>
                                        <td style="background-color: #FFFFFF"></td>
                                        <td></td>
                                        <td align="left">Fecha de Nacimiento <span class="colorRed">* </span> :</td>
                                        <td style="background-color: #FFFFFF"></td>
                                        <td></td>
                                        <td align="left" colspan="17"></td>
                                        <td style="background-color: #FFFFFF"></td>
                                        <td></td>   
                                      </tr>
                                      <tr>
                                        <td height="1" colspan="17" style="background-color: #FFFFFF"></td>
                                      </tr>
                                      <tr class="pasajeros">
                                        <td height="36"></td>
                                        <td align="left">
                                                <table cellpadding="0" cellspacing="0" border="0">
                                                <tr>
                                                <td><input name="ofic_m_' . $j . '" type="text" id="ofic_m_' . $j . '" maxlength="7" class="frmInput" style="width: 72px" onKeyPress="return NumeroInt(event)" /></td>
                                                                <td width="8"></td>
                                                <td><input name="ofic_ane_m_' . $j . '" type="text" id="ofic_ane_m_' . $j . '" maxlength="6" class="frmInput" style="width: 34px" onKeyPress="return NumeroInt(event)" /></td>
                                            </tr>
                                          </table>
                                        </td>
                                        <td style="background-color: #FFFFFF"></td>
                                        <td></td>
                                        <td align="left"><input name="celular_m_' . $j . '" type="text" id="celular_m_' . $j . '" maxlength="9" class="frmInput" style="width: 96px" onKeyPress="return NumeroInt(event)" value="" /></td>
                                        <td style="background-color: #FFFFFF"></td>
                                        <td></td>
                                        <td align="left"><input name="fecNac_m_' . $j . '" type="date" id="fecNac_m_' . $j . '" maxlength="9" class="frmInput" style="width: 120px" onKeyPress="return NumeroInt(event)" value="" /></td>
                                        <td style="background-color: #FFFFFF"></td>
                                        <td></td>
                                        <td align="left" colspan="17"></td>
                                        <td style="background-color: #FFFFFF"></td>
                                        <td></td>   
                                      </tr>
                                      <tr>
                                        <td height="1" colspan="17" style="background-color: #FFFFFF"></td>
                                      </tr>
                                      <tr class="pasajeros">
                                        <td height="30"></td>
                                        <td colspan="16" align="left" id="resultado_m_' . $j . '" style="color: #CC0033"></td>
                                      </tr>
                                    </table>
                                  </td>
                                </tr>
                        ';
            }
        }

        if ($infantes_4 > 0) {
            for ($k = 1; $k <= $infantes_4; $k++) {
                $table_pasajeros .= '<tr>
                          <td align="left" class="titleTable gradiante" style="color:white;">Datos - Infante N° ' . $k . '</td>
                        </tr>
                         <tr>
                            <td height="3" colspan="5"  style="background:#fdb813;"></td>
                       </tr>
                        <tr>
                          <td height="1" style="background-color: #FFFFFF"></td>
                        </tr>
                        <tr>
                          <td height="30" align="center">
                         <table width="898" cellpadding="0" cellspacing="0" border="0">
                              <tr class="pasajeros">
                                <td width="8" height="30"></td>
                                <td width="140" align="left">Nombres <span class="colorRed">* </span>:</td>
                                <td width="1" style="background-color: #FFFFFF"></td>
                                <td width="8"></td>
                                <td width="140" align="left">Apellido Paterno <span class="colorRed">* </span>:</td>
                                <td width="1" style="background-color: #FFFFFF"></td>
                                <td width="8"></td>
                                <td width="140" align="left">Apellido Materno :</td>
                                <td width="1" style="background-color: #FFFFFF"></td>
                                <td width="8"></td>
                                <td colspan="4" align="left">Documento de Identidad <span class="colorRed">* </span>:</td>
                                <td width="1" style="background-color: #FFFFFF"></td>
                                <td width="8"></td>
                                <td width="173" align="left">E-mail <span class="colorRed">* </span> :</td>
                              </tr>
                              <tr>
                                <td height="1" colspan="17" style="background-color: #FFFFFF"></td>
                              </tr>
                              <tr class="pasajeros">
                                <td height="36"></td>
                                <td align="left"><input type="text" name="nombre_i_' . $k . '" id="nombre_i_' . $k . '" class="frmInput" style="width: 124px; text-transform: uppercase" onKeyPress="Change(); " value="" /></td>
                                <td style="background-color: #FFFFFF"></td>
                                <td></td>
                                <td align="left"><input type="text" name="paterno_i_' . $k . '" id="paterno_i_' . $k . '" class="frmInput" style="width: 124px; text-transform: uppercase" onKeyPress="Change(); "  value=""/></td>
                                <td style="background-color: #FFFFFF"></td>
                                <td></td>
                                <td align="left"><input type="text" name="materno_i_' . $k . '" id="materno_i_' . $k . '" class="frmInput" style="width: 124px; text-transform: uppercase" onKeyPress="Change(); "  value=""/></td>
                                <td style="background-color: #FFFFFF"></td>
                                <td></td>
                                <td width="140" align="left">
                                  <select id="tipo_doc_i_' . $k . '" name="tipo_doc_i_' . $k . '" class="reserva_option" style="width: 130px" onChange="Change()">
                                    <option value="NI" selected>DNI</option>
                                    <option value="PP">PASAPORTE</option>
                                    <option value="ID">CARN&Eacute; EXTRANJERIA</option>
                                  </select>
                                </td>
                                <td width="1" style="background-color: #FFFFFF"></td>
                                <td width="8"></td>
                                <td width="112" align="left"><input name="num_doc_i_' . $k . '" type="text" id="num_doc_i_' . $k . '" maxlength="15" class="frmInput documento_i" style="width: 96px" onKeyPress="Change()"  title="Ingrese el número de Documento para obtener información del Pasajero de forma automática." value=""/></td>
                                <td style="background-color: #FFFFFF"></td>
                                <td></td>
                                <td align="left"><input type="text" name="email_i_' . $k . '" id="email_i_' . $k . '" class="frmInput" style="width: 157px; text-transform: uppercase" onKeyPress="Change(); return CaractValidoEmail(event)"  value=""/></td>
                              </tr>
                              <tr>
                                <td height="1" colspan="17" style="background-color: #FFFFFF"></td>
                              </tr>
                              <tr class="pasajeros">
                                <td height="36"></td>
                                <td align="left">Tel&eacute;f. Oficina + Anexo:</td>
                                <td style="background-color: #FFFFFF"></td>
                                <td></td>
                                <td align="left">Celular <span class="colorRed">* </span> :</td>
                                <td style="background-color: #FFFFFF"></td>
                                <td></td>
                                <td align="left">Fecha de Nacimiento <span class="colorRed">* </span> :</td>
                                <td style="background-color: #FFFFFF"></td>
                                <td></td>
                                <td align="left" colspan="17"></td>
                                <td style="background-color: #FFFFFF"></td>
                                <td></td>   
                              </tr>
                              <tr>
                                <td height="1" colspan="17" style="background-color: #FFFFFF"></td>
                              </tr>
                              <tr class="pasajeros">
                                <td height="36"></td>
                                <td align="left">
                                        <table cellpadding="0" cellspacing="0" border="0">
                                        <tr>
                                        <td><input name="ofic_i_' . $k . '" type="text" id="ofic_i_' . $k . '" maxlength="7" class="frmInput" style="width: 72px" onKeyPress="return NumeroInt(event)" /></td>
                                                        <td width="8"></td>
                                        <td><input name="ofic_ane_i_' . $k . '" type="text" id="ofic_ane_i_' . $k . '" maxlength="6" class="frmInput" style="width: 34px" onKeyPress="return NumeroInt(event)" /></td>
                                    </tr>
                                  </table>
                                </td>
                                <td style="background-color: #FFFFFF"></td>
                                <td></td>
                                <td align="left"><input name="celular_i_' . $k . '" type="text" id="celular_i_' . $k . '" maxlength="9" class="frmInput" style="width: 96px" onKeyPress="return NumeroInt(event)"  value=""/></td>
                                <td style="background-color: #FFFFFF"></td>
                                <td></td>
                                <td align="left"><input name="fecNac_i_' . $k . '" type="date" id="fecNac_i_' . $k . '" maxlength="9" class="frmInput" style="width: 120px" onKeyPress="return NumeroInt(event)" value=""/></td>
                                <td style="background-color: #FFFFFF"></td>
                                <td></td>
                                <td align="left" colspan="17"></td>
                                <td style="background-color: #FFFFFF"></td>
                                <td></td>   
                              </tr>
                              <tr>
                                <td height="1" colspan="17" style="background-color: #FFFFFF"></td>
                              </tr>
                              <tr class="pasajeros">
                                <td height="30"></td>
                                <td colspan="16" align="left" id="resultado_i_' . $k . '" style="color: #CC0033"></td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                ';
            }
        }
        $table_pasajeros .= '</table>';
    }
}

if (isset($_POST['paso5'])) {
    if ($_POST['paso5'] == 1) {
        if ($_SESSION['s_idusuario'] == '' || $_SESSION['s_entidad'] == '') {
            $tabla_error .= '<center >' . "\n";
            $tabla_error .= '<table >' . "\n";
            $tabla_error .= '<tr><td height="50"></td></tr>' . "\n";
            $tabla_error .= '<tr>' . "\n";
            $tabla_error .= '<td class="subtitleTable"  style="color:red !important;text-align:center;">El tiempo de espera ha termiando. Por favor cierre sesión y vuelva a ingresar.<br/>¡Gracias!</td>' . "\n";
            $tabla_error .= '</tr>' . "\n";
            $tabla_error .= '</table>' . "\n";
            $tabla_error .= '</center >' . "\n";
            echo $tabla_error;
            die;
        }
        $table_cabecera_5 = '';
        $table_precio_5 = '';
        $tipo_moneda_5 = $_POST['tipo_moneda_5'];
        $tipo_viaje_5 = $_POST['tipo_viaje_5'];
        $adultos_5 = $_POST['adultos_5'];
        $menores_5 = $_POST['menores_5'];
        $infantes_5 = $_POST['infantes_5'];

        $total_pagar_5 = number_format($_POST['total_pagar_5'], 2, '.', '');
        $tuua_5 = number_format($_POST['tuua_5'], 2, '.', '');
        $igv_5 = number_format($_POST['igv_5'], 2, '.', '');

        // datos del vuelo ida
        $tarifa_ida_5 = $_POST['tarifa_ida_5'];
        $numero_vuelo_ida_5 = $_POST['numero_vuelo_ida_5'];
        $fecha_hora_salida_ida_5 = $_POST['fecha_hora_salida_ida_5'];

        $fecha_salida_ida_5 = substr($fecha_hora_salida_ida_5, 0, 10);
        $hora_salida_ida_5 = substr($fecha_hora_salida_ida_5, 11, 13);

        $fecha_hora_llegada_ida_5 = $_POST['fecha_hora_llegada_ida_5'];
        $hora_llegada_ida_5 = substr($fecha_hora_llegada_ida_5, 11, 13);

        $clase_ida_5 = $_POST['clase_ida_5'];
        $origen_ida_5 = $_POST['origen_ida_5'];
        $nombre_origen_5 = $obj_tarifa->ObtenerNombreCiudad($origen_ida_5);
        $destino_ida_5 = $_POST['destino_ida_5'];
        $nombre_destino_5 = $obj_tarifa->ObtenerNombreCiudad($destino_ida_5);

        // datos del vuelo vuelta
        $tarifa_vuelta_5 = $_POST['tarifa_vuelta_5'];
        $numero_vuelo_vuelta_5 = $_POST['numero_vuelo_vuelta_5'];
        $fecha_hora_salida_vuelta_5 = $_POST['fecha_hora_salida_vuelta_5'];

        $fecha_salida_vuelta_5 = substr($fecha_hora_salida_vuelta_5, 0, 10);
        $hora_salida_vuelta_5 = substr($fecha_hora_salida_vuelta_5, 11, 13);

        $fecha_hora_llegada_vuelta_5 = $_POST['fecha_hora_llegada_vuelta_5'];
        $hora_llegada_vuelta_5 = substr($fecha_hora_llegada_vuelta_5, 11, 13);
        $clase_vuelta_5 = $_POST['clase_vuelta_5'];
        $origen_vuelta_5 = $_POST['origen_vuelta_5'];
        $nombre_origen_vuelta_5 = $obj_tarifa->ObtenerNombreCiudad($origen_vuelta_5);
        $destino_vuelta_5 = $_POST['destino_vuelta_5'];
        $nombre_destino_vuelta_5 = $obj_tarifa->ObtenerNombreCiudad($destino_vuelta_5);


        // calculo de adultos
        $tarifa_adulto_5 = $_POST['tarifa_adulto_5'];
        $tuua_adulto_5 = $_POST['tuua_adulto_5'];
        $igv_adulto_5 = $_POST['igv_adulto_5'];
        $subtotal_adulto_5 = $_POST['subtotal_adulto_5'];

        // calculo de menores
        $tarifa_chil_5 = $_POST['tarifa_chil_5'];
        $tuua_chil_5 = $_POST['tuua_chil_5'];
        $igv_chil_5 = $_POST['igv_chil_5'];
        $subtotal_chil_5 = $_POST['subtotal_chil_5'];

        // calculo de infantes
        $tarifa_bb_5 = $_POST['tarifa_bb_5'];
        $tuua_bb_5 = $_POST['tuua_bb_5'];
        $igv_bb_5 = $_POST['igv_bb_5'];
        $subtotal_bb_5 = $_POST['subtotal_bb_5'];

        if ($tipo_viaje_5 == 1) {

            $table_cabecera_5 .= '<table width="900" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td colspan="7" align="left" class="titleTable gradiante" style="color:white;">Itinerario</td>
                </tr>
                <tr>
                    <td height="3" colspan="7"  style="background:#fdb813;"></td>
               </tr>
                <tr>
                  <td width="170" align="left" class="subtitleTabla">Fecha de Ida</td>
                  <td width="172" align="left" class="subtitleTabla">Hora de Salida</td>
                  <td width="172" align="left" class="subtitleTabla">Hora de Llegada</td>
                  <td width="132" align="left" class="subtitleTabla">N° de Vuelo</td>
                  <td width="104" align="left" class="subtitleTabla">Clase</td>
                  <td width="104" align="left" class="subtitleTabla">Equipaje</td>
                </tr>
                <tr style="background: #F0F0F0">
                  <td align="left" class="bgTable_data">' . date("d/m/Y", strtotime($fecha_salida_ida_5)) . '</td>
                  <td align="left" class="bgTable_data"><strong>' . $hora_salida_ida_5 . '</strong> ' . $nombre_origen_5 . ' (' . $origen_ida_5 . ')</td>
                  <td align="left" class="bgTable_data"><strong>' . $hora_llegada_ida_5 . '</strong> ' . $nombre_destino_5 . ' (' . $destino_ida_5 . ')</td>
                  <td align="left" class="bgTable_data">' . $numero_vuelo_ida_5 . '</td>
                  <td align="left" class="bgTable_data">' . $clase_ida_5 . '</td>
                  <td align="left" class="bgTable_data">23 KG</td>
                </tr>
                <tr>
                  <td align="left" class="subtitleTabla">Fecha de Regreso</td>
                  <td align="left" class="subtitleTabla">Hora de Salida</td>
                  <td align="left" class="subtitleTabla">Hora de Llegada</td>
                  <td align="left" class="subtitleTabla">N° de Vuelo</td>
                  <td align="left" class="subtitleTabla">Clase</td>
                  <td align="left" class="subtitleTabla">Equipaje</td>
                </tr>
                <tr style="background: #F0F0F0">
                  <td align="left" class="bgTable_data">' . date("d/m/Y", strtotime($fecha_salida_vuelta_5)) . '</td>
                  <td align="left" class="bgTable_data"><strong>' . $hora_salida_vuelta_5 . '</strong> ' . $nombre_origen_vuelta_5 . ' (' . $origen_vuelta_5 . ')</td>
                  <td align="left" class="bgTable_data"><strong>' . $hora_llegada_vuelta_5 . '</strong> ' . $nombre_destino_vuelta_5 . ' (' . $destino_vuelta_5 . ')</td>
                  <td align="left" class="bgTable_data">' . $numero_vuelo_vuelta_5 . '</td>
                  <td align="left" class="bgTable_data">' . $clase_vuelta_5 . '</td>
                   <td align="left" class="bgTable_data">23 KG</td>
                </tr>
        </table>';
        } elseif ($tipo_viaje_5 == 0) {

            $table_cabecera_5 .= '<table width="900" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td colspan="7" align="left" class="titleTable gradiante" style="color:white;">Itinerario</td>
                </tr>
                <tr>
                    <td height="3" colspan="7"  style="background:#fdb813;"></td>
               </tr>
                <tr>
                  <td width="170" align="left" class="subtitleTabla">Fecha de Ida</td>
                  <td width="172" align="left" class="subtitleTabla">Hora de Salida</td>
                  <td width="172" align="left" class="subtitleTabla">Hora de Llegada</td>
                  <td width="132" align="left" class="subtitleTabla">N° de Vuelo</td>
                  <td width="104" align="left" class="subtitleTabla">Clase</td>
                  <td width="104" align="left" class="subtitleTabla">Equipaje</td>
                </tr>
                <tr style="background: #F0F0F0">
                  <td align="left" class="bgTable_data">' . date("d/m/Y", strtotime($fecha_salida_ida_5)) . '</td>
                  <td align="left" class="bgTable_data"><strong>' . $hora_salida_ida_5 . '</strong> ' . $nombre_origen_5 . ' (' . $origen_ida_5 . ')</td>
                  <td align="left" class="bgTable_data"><strong>' . $hora_llegada_ida_5 . '</strong> ' . $nombre_destino_5 . ' (' . $destino_ida_5 . ')</td>
                  <td align="left" class="bgTable_data">' . $numero_vuelo_ida_5 . '</td>
                  <td align="left" class="bgTable_data">' . $clase_ida_5 . '</td>
                  <td align="left" class="bgTable_data">23 KG</td>
                </tr></table>';
        }

        $table_precio_5 .= '<table width="900" border="0" cellpadding="0" cellspacing="0" class="bgTable_data">
                <tr>
                  <td colspan="5" align="left" class="titleTable gradiante" style="color:white;">Tarifa en D&oacute;lares Americanos</td>
                </tr>
                <tr>
                    <td height="3" colspan="5"  style="background:#fdb813;"></td>
               </tr>
                <tr>
                  <td width="171" class="subtitleTabla">Cantidad de Pasajeros</td>
                  <td width="191" align="center" class="subtitleTabla">Tarifa</td>
                  <td width="173" align="center" class="subtitleTabla">Impuesto</td>
                  <td width="161" align="center" class="subtitleTabla">TUUA</td>
                  <td width="202" align="center" class="subtitleTabla">Sub Total</td>
                  
                </tr>';


        if (($adultos_5 > 0 and $menores_5 == 0 and $infantes_5 == 0)) {

            $cant_adult = $adultos_5;
            $tarifa_adulto = $tarifa_adulto_5;
            $tuua_adulto = $tuua_adulto_5;
            $igv_adulto = $igv_adulto_5;


            $subtotal_adulto = $subtotal_adulto_5;
            $subtotal_tabla_adl = $igv_adulto + $tarifa_adulto + $tuua_adulto;
            $table_precio_5 .= '<tr style="background: #F0F0F0">
                        <td height="18" align="left" class="bgTable_data">(' . $cant_adult . ') Pasajeros Adultos </td>
                        <td align="center" class="bgTable_data">' . number_format($tarifa_adulto, 2, '.', ',') . '</td>
                        <td align="center" class="bgTable_data">' . number_format($igv_adulto, 2, '.', ',') . '</td>    
                        <td align="center" class="bgTable_data">' . number_format($tuua_adulto, 2, '.', ',') . '</td>
                        <td align="center" class="bgTable_data">' . number_format($subtotal_tabla_adl, 2, '.', ',') . '</td>
                    </tr>';
        } else {
            if ($adultos_5 > 0) {

                $cant_adult = $adultos_5;
                $tarifa_adulto = $tarifa_adulto_5;
                $tuua_adulto = $tuua_adulto_5;
                $igv_adulto = $igv_adulto_5;


                $subtotal_adulto = $subtotal_adulto_5;
                $subtotal_tabla_adl = $igv_adulto + $tarifa_adulto + $tuua_adulto;

                $table_precio_5 .= '<tr style="background: #F0F0F0">
                        <td height="18" align="left" class="bgTable_data">(' . $cant_adult . ') Pasajeros Adultos</td>
                        <td align="center" class="bgTable_data">' . number_format($tarifa_adulto, 2, '.', ',') . '</td>
                        <td align="center" class="bgTable_data">' . number_format($igv_adulto, 2, '.', ',') . '</td>
                        <td align="center" class="bgTable_data">' . number_format($tuua_adulto, 2, '.', ',') . '</td>    
                        <td align="center" class="bgTable_data">' . number_format($subtotal_tabla_adl, 2, '.', ',') . '</td>
                    </tr>';
            }
            if ($menores_5 > 0) {
                $cant_chil = $menores_5;
                $tarifa_chil = $tarifa_chil_5;
                $tuua_chil = $tuua_chil_5;
                $igv_chil = $igv_chil_5;

                $subtotal_chil = $subtotal_chil_5;
                $subtotal_tabla_ch = $igv_chil + $tarifa_chil + $tuua_chil;
                $table_precio_5 .= '<tr style="background: #F0F0F0">
                        <td height="18" align="left" class="bgTable_data">(' . $cant_chil . ') Pasajeros Niños</td>
                        <td align="center" class="bgTable_data">' . number_format($tarifa_chil, 2, '.', ',') . '</td>
                        <td align="center" class="bgTable_data">' . number_format($igv_chil, 2, '.', ',') . '</td>     
                        <td align="center" class="bgTable_data">' . number_format($tuua_chil, 2, '.', ',') . '</td>    
                        <td align="center" class="bgTable_data">' . number_format($subtotal_tabla_ch, 2, '.', ',') . '</td>
                    </tr>';
            }

            if ($infantes_5 > 0) {

                $cant_bb = $infantes_5;
                $tarifa_bb = $tarifa_bb_5;
                $tuua_bb = $tuua_bb_5;
                $igv_bb = $igv_bb_5;

                $subtotal_bb = $subtotal_bb_5;
                $subtotal_tabla_i = $igv_bb + $tarifa_bb + $tuua_bb;
                $table_precio_5 .= '<tr style="background: #F0F0F0">
                        <td height="18" align="left" class="bgTable_data">(' . $cant_bb . ') Pasajeros Infantes</td>
                        <td align="center" class="bgTable_data">' . number_format($tarifa_bb, 2, '.', ',') . '</td>
                        <td align="center" class="bgTable_data">' . number_format($igv_bb, 2, '.', ',') . '</td>
                        <td align="center" class="bgTable_data">' . number_format($tuua_bb, 2, '.', ',') . '</td>    
                        <td align="center" class="bgTable_data">' . number_format($subtotal_tabla_i, 2, '.', ',') . '</td>
                    </tr>';
            }
        }
        $total_pagar_tabla_5 = $subtotal_tabla_adl + $subtotal_tabla_ch + $subtotal_tabla_i + $tuua_adulto + $tuua_chil + $tuua_bb + $igv_adulto + $igv_chil + $igv_bb;
        // $table_precio_5.='<tr>
        //                 <td colspan="4" align="left" class="subtitleTabla">Total a pagar:</td>
        //                 <td align="center" class="subtitleTabla gradiante" style="color:white;">'.$tipo_moneda_5.' '.number_format($total_pagar_tabla_5,2,'.',',').'</td>
        //                 </tr>
        //             </table>';
        // construyendo el array de personas
        require_once '../../cd/Funciones/funciones.php';
        $arrayPersonas = array();
        $arrayPersonasKiu = array();

        $p = 0;

        for ($i = 1; $i <= $infantes_5; $i++) {
            $nombres = utf8_decode(caracter_especial2(addslashes(trim($_POST['nombre_a_' . $i]))));
            $apellidos = utf8_decode(caracter_especial2(addslashes(trim($_POST['paterno_a_' . $i] . ' ' . $_POST['materno_a_' . $i]))));
            $tipo_documento = $_POST['tipo_doc_a_' . $i];
            $numero_documento = $_POST['num_doc_a_' . $i];
            $email = strtoupper(trim($_POST['email_a_' . $i]));
            $telf_ofi = $_POST['ofic_a_' . $i];
            $telf_ane = $_POST['ofic_ane_a_' . $i];
            $celular = $_POST['celular_a_' . $i];
            $tipo_pasajero = 'ADT';

            $arrayPersonasKiu[$p] = array('Nombres' => utf8_encode($nombres),
                'Apellidos' => utf8_encode($apellidos),
                'Tipo_Documento' => $tipo_documento,
                'Numero_Documento' => $numero_documento,
                'Email' => $email,
                'Telefono_Oficina' => $telf_ofi,
                'Telefono_Anex' => $telf_ane,
                'Celular' => $celular,
                'Tipo_Pasajero' => $tipo_pasajero);
            // 'Fecha_Nacimiento'=>$fecNac
            $p++;

            $nombres = utf8_decode(caracter_especial2(addslashes(trim($_POST['nombre_i_' . $i]))));
            $apellidos = utf8_decode(caracter_especial2(addslashes(trim($_POST['paterno_i_' . $i] . ' ' . $_POST['materno_i_' . $i]))));
            $tipo_documento = $_POST['tipo_doc_i_' . $i];
            $numero_documento = $_POST['num_doc_i_' . $i];
            $email = strtoupper(trim($_POST['email_i_' . $i]));
            $telf_ofi = $_POST['ofic_i_' . $i];
            $telf_ane = $_POST['ofic_ane_i_' . $i];
            $celular = $_POST['celular_i_' . $i];
            $fecNac = $_POST['fecNac_i_' . $i];
            $tipo_pasajero = 'INF';

            $arrayPersonasKiu[$p] = array('Nombres' => utf8_encode($nombres),
                'Apellidos' => utf8_encode($apellidos),
                'Tipo_Documento' => $tipo_documento,
                'Numero_Documento' => $numero_documento,
                'Email' => $email,
                'Telefono_Oficina' => $telf_ofi,
                'Telefono_Anex' => $telf_ane,
                'Celular' => $celular,
                'Tipo_Pasajero' => $tipo_pasajero,
                'Fecha_Nacimiento' => $fecNac);
            $p++;
        }
        $c = ($p) / 2 + 1;
        for ($i = $c; $i <= $adultos_5; $i++) {

            $nombres = utf8_decode(caracter_especial2(addslashes(trim($_POST['nombre_a_' . $i]))));
            $apellidos = utf8_decode(caracter_especial2(addslashes(trim($_POST['paterno_a_' . $i] . ' ' . $_POST['materno_a_' . $i]))));
            $tipo_documento = $_POST['tipo_doc_a_' . $i];
            $numero_documento = $_POST['num_doc_a_' . $i];
            $email = strtoupper(trim($_POST['email_a_' . $i]));
            $telf_ofi = $_POST['ofic_a_' . $i];
            $telf_ane = $_POST['ofic_ane_a_' . $i];
            $celular = $_POST['celular_a_' . $i];
            $pasajero_ruc = $_POST['ruc_a_' . $i];
            $tipo_pasajero = 'ADT';

            $arrayPersonasKiu[$p] = array('Nombres' => utf8_encode($nombres),
                'Apellidos' => utf8_encode($apellidos),
                'Tipo_Documento' => $tipo_documento,
                'Numero_Documento' => $numero_documento,
                'Email' => $email,
                'Telefono_Oficina' => $telf_ofi,
                'Telefono_Anex' => $telf_ane,
                'Celular' => $celular,
                'Tipo_Pasajero' => $tipo_pasajero,
                'Pasajero_RUC' => $pasajero_ruc);
            $p++;
        }

        if ($menores_5 > 0) {

            for ($j = 1; $j <= $menores_5; $j++) {
                $nombres = utf8_decode(caracter_especial2(addslashes(trim($_POST['nombre_m_' . $j]))));
                $apellidos = utf8_decode(caracter_especial2(addslashes(trim($_POST['paterno_m_' . $j] . ' ' . $_POST['materno_m_' . $j]))));
                $tipo_documento = $_POST['tipo_doc_m_' . $j];
                $numero_documento = $_POST['num_doc_m_' . $j];
                $email = strtoupper(trim($_POST['email_m_' . $j]));
                $telf_ofi = $_POST['ofic_m_' . $j];
                $telf_ane = $_POST['ofic_ane_m_' . $j];
                $celular = $_POST['celular_m_' . $j];
                $fecNac = $_POST['fecNac_m_' . $j];
                $tipo_pasajero = 'CNN';

                $arrayPersonasKiu[$p] = array('Nombres' => utf8_encode($nombres),
                    'Apellidos' => utf8_encode($apellidos),
                    'Tipo_Documento' => $tipo_documento,
                    'Numero_Documento' => $numero_documento,
                    'Email' => $email,
                    'Telefono_Oficina' => $telf_ofi,
                    'Telefono_Anex' => $telf_ane,
                    'Celular' => $celular,
                    'Tipo_Pasajero' => $tipo_pasajero,
                    'Fecha_Nacimiento' => $fecNac);
                $p++;
            }
        }

        $p = 0;

        for ($i = 1; $i <= $adultos_5; $i++) {

            $nombres = utf8_decode(caracter_especial2(addslashes(trim($_POST['nombre_a_' . $i]))));
            $apellidos = utf8_decode(caracter_especial2(addslashes(trim($_POST['paterno_a_' . $i] . ' ' . $_POST['materno_a_' . $i]))));
            $tipo_documento = $_POST['tipo_doc_a_' . $i];
            $numero_documento = $_POST['num_doc_a_' . $i];
            $email = strtoupper(trim($_POST['email_a_' . $i]));
            $telf_ofi = $_POST['ofic_a_' . $i];
            $telf_ane = $_POST['ofic_ane_a_' . $i];
            $celular = $_POST['celular_a_' . $i];
            $tipo_pasajero = 'ADT';
            $pasajero_ruc = $_POST['ruc_a_' . $i];

            $arrayPersonas[$p] = array('Nombres' => utf8_encode($nombres),
                'Apellidos' => utf8_encode($apellidos),
                'Tipo_Documento' => $tipo_documento,
                'Numero_Documento' => $numero_documento,
                'Email' => $email,
                'Telefono_Oficina' => $telf_ofi,
                'Telefono_Anex' => $telf_ane,
                'Celular' => $celular,
                'Tipo_Pasajero' => $tipo_pasajero,
                'Pasajero_RUC' => $pasajero_ruc);

            $p++;
        }

        if ($menores_5 > 0) {

            for ($j = 1; $j <= $menores_5; $j++) {
                $nombres = utf8_decode(caracter_especial2(addslashes(trim($_POST['nombre_m_' . $j]))));
                $apellidos = utf8_decode(caracter_especial2(addslashes(trim($_POST['paterno_m_' . $j] . ' ' . $_POST['materno_m_' . $j]))));
                $tipo_documento = $_POST['tipo_doc_m_' . $j];
                $numero_documento = $_POST['num_doc_m_' . $j];
                $email = strtoupper(trim($_POST['email_m_' . $j]));
                $telf_ofi = $_POST['ofic_m_' . $j];
                $telf_ane = $_POST['ofic_ane_m_' . $j];
                $celular = $_POST['celular_m_' . $j];
                $fecNac = $_POST['fecNac_m_' . $j];
                $tipo_pasajero = 'CNN';

                $arrayPersonas[$p] = array('Nombres' => utf8_encode($nombres),
                    'Apellidos' => utf8_encode($apellidos),
                    'Tipo_Documento' => $tipo_documento,
                    'Numero_Documento' => $numero_documento,
                    'Email' => $email,
                    'Telefono_Oficina' => $telf_ofi,
                    'Telefono_Anex' => $telf_ane,
                    'Celular' => $celular,
                    'Tipo_Pasajero' => $tipo_pasajero,
                    'Fecha_Nacimiento' => $fecNac);
                $p++;
            }
        }

        if ($infantes_5 > 0) {

            for ($k = 1; $k <= $infantes_5; $k++) {
                $nombres = utf8_decode(caracter_especial2(addslashes(trim($_POST['nombre_i_' . $k]))));
                $apellidos = utf8_decode(caracter_especial2(addslashes(trim($_POST['paterno_i_' . $k] . ' ' . $_POST['materno_i_' . $k]))));
                $tipo_documento = $_POST['tipo_doc_i_' . $k];
                $numero_documento = $_POST['num_doc_i_' . $k];
                $email = strtoupper(trim($_POST['email_i_' . $k]));
                $telf_ofi = $_POST['ofic_i_' . $k];
                $telf_ane = $_POST['ofic_ane_i_' . $k];
                $celular = $_POST['celular_i_' . $k];
                $fecNac = $_POST['fecNac_i_' . $k];
                $tipo_pasajero = 'INF';

                $arrayPersonas[$p] = array('Nombres' => utf8_encode($nombres),
                    'Apellidos' => utf8_encode($apellidos),
                    'Tipo_Documento' => $tipo_documento,
                    'Numero_Documento' => $numero_documento,
                    'Email' => $email,
                    'Telefono_Oficina' => $telf_ofi,
                    'Telefono_Anex' => $telf_ane,
                    'Celular' => $celular,
                    'Tipo_Pasajero' => $tipo_pasajero,
                    'Fecha_Nacimiento' => $fecNac);
                $p++;
            }
        }


        // echo "<pre>";
        // print_r($arrayPersonasKiu);
        // echo "</pre>";
        // echo "<pre>";
        // print_r($arrayPersonas);
        // echo "</pre>";


        if ($tipo_viaje_5 == 1) { // R
            $res = $KIU->AirBookRQ(array(
                'City' => 'LIM'
                , 'Country' => 'PE'
                , 'Currency' => 'USD'
                , 'FlightSegment' => array(
                    array('DepartureDateTime' => "$fecha_hora_salida_ida_5", 'ArrivalDateTime' => "$fecha_hora_llegada_ida_5", 'FlightNumber' => "$numero_vuelo_ida_5", 'ResBookDesigCode' => "$clase_ida_5", 'DepartureAirport' => "$origen_ida_5", 'ArrivalAirport' => "$destino_ida_5", 'MarketingAirline' => '2I')
                    , array('DepartureDateTime' => "$fecha_hora_salida_vuelta_5", 'ArrivalDateTime' => "$fecha_hora_llegada_vuelta_5", 'FlightNumber' => "$numero_vuelo_vuelta_5", 'ResBookDesigCode' => "$clase_vuelta_5", 'DepartureAirport' => "$origen_vuelta_5", 'ArrivalAirport' => "$destino_vuelta_5", 'MarketingAirline' => '2I')
                )
                // , 'Passengers' => $arrayPersonas
                , 'Passengers' => $arrayPersonasKiu
                , 'Remark' => 'STARPERU'), $err);
            if ($err['ErrorCode'] != 0) {
                echo $err['ErrorMsg'];
            }

            $fecha_registro = date('Y-m-d H:i:s');
            $tipo_vuelo_letras = 'R';
            $pais = 'PE';
            $ciudad = ', DEMO';
            $ip = $_SERVER["REMOTE_ADDR"];
            $flete = round($tarifa_adulto_5 + $tarifa_chil_5 + $tarifa_bb_5, 2); //SUMA TOTAL DE TARIFAS
            $tuua_reserva = $tuua_adulto_5 + $tuua_chil_5 + $tuua_bb_5; //SUMA TOTAL DE TUUAS
            $igv_reserva = round($igv_adulto_5 + $igv_chil_5 + $igv_bb_5, 2); //SUMA TOTAL DE IGVS
            $total_reserva = $flete + $tuua_reserva + $igv_reserva; //SUMA TOTAL NO IMPORTA LA EXONERACION
            $codigo_reserva = $res['BookingReferenceID']['@attributes']['ID'];

            /*             * *************************** DESCUENTO OSCE ********************************** */

            $res = $KIU->TravelItineraryReadRQ(array(
                'IdReserva' => $codigo_reserva
                    ), $err);

            // echo "<pre>";
            // var_dump($res);die;
            // echo "</pre>";


            if ($err['ErrorCode'] != 0)
                echo $err['ErrorMsg'];
            // echo "<pre>";
            // print_r($res);
            // echo "</pre>";
            //$tarifa_sin_imp = $res[1]['TravelItinerary']['ItineraryInfo']['ItineraryPricing']['Cost']['@attributes']['AmountBeforeTax'];
            $tarifa_con_imp = $res['TravelItinerary']['ItineraryInfo']['ItineraryPricing']['Cost']['@attributes']['AmountAfterTax'];


            //$total_pagar_tabla_5=$subtotal_tabla_adl+$subtotal_tabla_ch+$subtotal_tabla_i+$tuua_adulto+$tuua_ch+$tuua_i;
            $total_pagar_tabla_5 = $subtotal_tabla_adl + $subtotal_tabla_ch + $subtotal_tabla_i;
            $total_pagar_5 = $tarifa_con_imp;
            $descuento = floatval($total_pagar_tabla_5) - floatval($tarifa_con_imp);

            $igv = $res['TravelItinerary']['ItineraryInfo']['ItineraryPricing']['Taxes']['Tax'][0]['@attributes']['Amount'];


            /*             * ********************************************************************************** */

            if ($codigo_reserva != '') {
                $registro = $obj_reserva->GuardarReservaCabecera($codigo_reserva, $arrayPersonas[0]['Nombres'], $arrayPersonas[0]['Apellidos'], $arrayPersonas[0]['Email'], $arrayPersonas[0]['Tipo_Documento'], $arrayPersonas[0]['Numero_Documento'], $arrayPersonas[0]['Telefono_Oficina'], $arrayPersonas[0]['Telefono_Anex'], $arrayPersonas[0]['Celular'], $arrayPersonas[0]['Nextel'], $arrayPersonas[0]['RPM'], $arrayPersonas[0]['RPC'], $pasajero_ruc, $fecha_registro, $fecha_registro, $adultos_5, $menores_5, $infantes_5, $origen_ida_5, $destino_ida_5, $numero_vuelo_ida_5, $clase_ida_5, $fecha_salida_ida_5, $hora_salida_ida_5, $numero_vuelo_vuelta_5, $clase_vuelta_5, $fecha_salida_vuelta_5, $hora_salida_vuelta_5, $pais, $ciudad, $ip, $flete, $tuua_reserva, $igv_reserva, $total_reserva, $_SESSION['s_idusuario'], $_SESSION['s_entidad'], $tipo_vuelo_letras);
                // echo '<br/>';
                // echo $codigo_reserva.'<br/>';
                // die;
                $numero_de_vueltas = $adultos_5 + $menores_5 + $infantes_5;
                $j = 0;
                for ($i = 0; $i < $numero_de_vueltas; $i++) {
                    if ($arrayPersonas[$i]['Tipo_Pasajero'] == 'ADT') {
                        $tipo_pax = 'A';
                        $tarifa_unitaria = number_format($tarifa_adulto_5 / $adultos_5, 2, '.', '');
                        $igv_unitaria = number_format($igv_adulto_5 / $adultos_5, 2, '.', '');
                        $tuua_unitaria = number_format($tuua_adulto_5 / $adultos_5, 2, '.', '');
                        $total = $tarifa_unitaria + $igv_unitaria + $tuua_unitaria;
                    } elseif ($arrayPersonas[$i]['Tipo_Pasajero'] == 'CNN') {
                        $tipo_pax = 'N';
                        $tarifa_unitaria = number_format($tarifa_chil_5 / $menores_5, 2, '.', '');
                        $igv_unitaria = number_format($igv_chil_5 / $menores_5, 2, '.', '');
                        $tuua_unitaria = number_format($tuua_chil_5 / $menores_5, 2, '.', '');
                        $total = $tarifa_unitaria + $igv_unitaria + $tuua_unitaria;
                    } elseif ($arrayPersonas[$i]['Tipo_Pasajero'] == 'INF') {
                        $tipo_pax = 'B';
                        $tarifa_unitaria = number_format($tarifa_bb_5 / $infantes_5, 2, '.', '');
                        $igv_unitaria = number_format($igv_bb_5 / $infantes_5, 2, '.', '');
                        $tuua_unitaria = number_format($tuua_bb_5 / $infantes_5, 2, '.', '');
                        $total = $tarifa_unitaria + $igv_unitaria + $tuua_unitaria;
                    }
                    $j++;
                    $consulta = $obj_reserva->GuardarReservaDetalle($registro, $j, $arrayPersonas[$i]['Tipo_Documento'], $arrayPersonas[$i]['Numero_Documento'], $arrayPersonas[$i]['Apellidos'], $arrayPersonas[$i]['Nombres'], $tipo_pax, $arrayPersonas[$i]['Celular'], $arrayPersonas[$i]['Telefono'], $arrayPersonas[$i]['Telefono_Anex'], $arrayPersonas[$i]['RPC'], $arrayPersonas[$i]['RPM'], $arrayPersonas[$i]['Email'], $tarifa_unitaria, $igv_unitaria, $tuua_unitaria, $total, $total_pagar, $arrayPersonas[$i]['Fecha_Nacimiento']);

                    $numero_de_vueltas = $adultos_5 + $menores_5 + $infantes_5;
                    $j = 0;
                    for ($i = 0; $i < $numero_de_vueltas; $i++) {
                        if ($arrayPersonas[$i]['Tipo_Pasajero'] == 'ADT') {
                            $tipo_pax = 'A';
                            $tarifa_unitaria = number_format($tarifa_adulto_5 / $adultos_5, 2, '.', '');
                            $igv_unitaria = number_format($igv_adulto_5 / $adultos_5, 2, '.', '');
                            $tuua_unitaria = number_format($tuua_adulto_5 / $adultos_5, 2, '.', '');
                            $total = $tarifa_unitaria + $igv_unitaria + $tuua_unitaria;
                            if ($ciudad_exonerada > 0) {
                                $total_pagar = $tarifa_unitaria + $tuua_unitaria;
                            } else if ($ciudad_TUUA_exonerada > 0) {
                                $total_pagar = $tarifa_unitaria + $igv_unitaria;
                            } else {
                                $total_pagar = $total;
                            }
                        } elseif ($arrayPersonas[$i]['Tipo_Pasajero'] == 'CNN') {
                            $tipo_pax = 'N';
                            $tarifa_unitaria = number_format($tarifa_chil_5 / $menores_5, 2, '.', '');
                            $igv_unitaria = number_format($igv_chil_5 / $menores_5, 2, '.', '');
                            $tuua_unitaria = number_format($tuua_chil_5 / $menores_5, 2, '.', '');
                            $total = $tarifa_unitaria + $igv_unitaria + $tuua_unitaria;
                            if ($ciudad_exonerada > 0) {
                                $total_pagar = $tarifa_unitaria + $tuua_unitaria;
                            } else if ($ciudad_TUUA_exonerada > 0) {
                                $total_pagar = $tarifa_unitaria + $igv_unitaria;
                            } else {
                                $total_pagar = $total;
                            }
                        } elseif ($arrayPersonas[$i]['Tipo_Pasajero'] == 'INF') {
                            $tipo_pax = 'B';
                            $tarifa_unitaria = number_format($tarifa_bb_5 / $infantes_5, 2, '.', '');
                            $igv_unitaria = number_format($igv_bb_5 / $infantes_5, 2, '.', '');
                            $tuua_unitaria = number_format($tuua_bb_5 / $infantes_5, 2, '.', '');
                            $total = $tarifa_unitaria + $igv_unitaria + $tuua_unitaria;
                            if ($ciudad_exonerada > 0) {
                                $total_pagar = $tarifa_unitaria + $tuua_unitaria;
                            } else if ($ciudad_TUUA_exonerada > 0) {
                                $total_pagar = $tarifa_unitaria + $igv_unitaria;
                            } else {
                                $total_pagar = $total;
                            }
                        }
                        $j++;
                        $consulta = $obj_reserva->GuardarReservaDetalle($registro, $j, $arrayPersonas[$i]['Tipo_Documento'], $arrayPersonas[$i]['Numero_Documento'], $arrayPersonas[$i]['Apellidos'], $arrayPersonas[$i]['Nombres'], $tipo_pax, $arrayPersonas[$i]['Celular'], $arrayPersonas[$i]['Telefono'], $arrayPersonas[$i]['Telefono_Anex'], $arrayPersonas[$i]['RPC'], $arrayPersonas[$i]['RPM'], $arrayPersonas[$i]['Email'], $tarifa_unitaria, $igv_unitaria, $tuua_unitaria, $total, $total_pagar, $arrayPersonas[$i]['Fecha_Nacimiento']);
                    }
                    $_SESSION['pasajeros'] = $arrayPersonas;
                }
            }
        } else {
            $res = $KIU->AirBookRQ(array(
                'City' => 'LIM'
                , 'Country' => 'PE'
                , 'Currency' => 'USD'
                , 'FlightSegment' => array(
                    array('DepartureDateTime' => "$fecha_hora_salida_ida_5", 'ArrivalDateTime' => "$fecha_hora_llegada_ida_5", 'FlightNumber' => "$numero_vuelo_ida_5", 'ResBookDesigCode' => "$clase_ida_5", 'DepartureAirport' => "$origen_ida_5", 'ArrivalAirport' => "$destino_ida_5", 'MarketingAirline' => '2I')
                )
                , 'Passengers' => $arrayPersonasKiu
                // , 'Passengers' => $arrayPersonas
                , 'Remark' => 'STARPERU'), $err);
            // echo "<pre>";    
            // print_r($arrayPersonas);
            // echo "</pre>";   
            // echo "<pre>";
            // print_r($res);
            // echo "</pre>";

            if ($err['ErrorCode'] != 0) {
                echo $err['ErrorMsg'];
            }

            $fecha_registro = date('Y-m-d H:i:s');
            // echo $fecha_registro;
            $tipo_vuelo_letras = 'O';
            $pais = 'PE';
            $ciudad = ', DEMO';
            $ip = $_SERVER["REMOTE_ADDR"];
            $flete = round($tarifa_adulto_5 + $tarifa_chil_5 + $tarifa_bb_5, 2); //SUMA TOTAL DE TARIFAS
            $tuua_reserva = $tuua_adulto_5 + $tuua_chil_5 + $tuua_bb_5; //SUMA TOTAL DE TUUAS
            $igv_reserva = round($igv_adulto_5 + $igv_chil_5 + $igv_bb_5, 2); //SUMA TOTAL DE IGVS
            $total_reserva = $flete + $tuua_reserva + $igv_reserva; //SUMA TOTAL NO IMPORTA LA EXONERACION
            $codigo_reserva = $res['BookingReferenceID']['@attributes']['ID'];

            /*             * *********************************** DESCUENTO OSCE ********************************** */

            $res = $KIU->TravelItineraryReadRQ(array(
                'IdReserva' => $codigo_reserva
                    ), $err);
            if ($err['ErrorCode'] != 0)
                echo $err['ErrorMsg'];
            $tarifa_con_imp = $res['TravelItinerary']['ItineraryInfo']['ItineraryPricing']['Cost']['@attributes']['AmountAfterTax'];


            $total_pagar_tabla_5 = $subtotal_tabla_adl + $subtotal_tabla_ch + $subtotal_tabla_i;
            $total_pagar_5 = $tarifa_con_imp;

            /*             * ************************************************************************************* */

            if ($codigo_reserva != '') {
                $registro = $obj_reserva->GuardarReservaCabecera($codigo_reserva, $arrayPersonas[0]['Nombres'], $arrayPersonas[0]['Apellidos'], $arrayPersonas[0]['Email'], $arrayPersonas[0]['Tipo_Documento'], $arrayPersonas[0]['Numero_Documento'], $arrayPersonas[0]['Telefono_Oficina'], $arrayPersonas[0]['Telefono_Anex'], $arrayPersonas[0]['Celular'], $arrayPersonas[0]['Nextel'], $arrayPersonas[0]['RPM'], $arrayPersonas[0]['RPC'], $arrayPersonas[0]['Pasajero_RUC'], $fecha_registro, $fecha_registro, $adultos_5, $menores_5, $infantes_5, $origen_ida_5, $destino_ida_5, $numero_vuelo_ida_5, $clase_ida_5, $fecha_salida_ida_5, $hora_salida_ida_5, $numero_vuelo_vuelta_5, $clase_vuelta_5, $fecha_salida_vuelta_5, $hora_salida_vuelta_5, $pais, $ciudad, $ip, $flete, $tuua_reserva, $igv_reserva, $total_reserva, $_SESSION['s_idusuario'], $_SESSION['s_entidad'], $tipo_vuelo_letras);
                // echo $registro;
                // die;
                $numero_de_vueltas = $adultos_5 + $menores_5 + $infantes_5;
                $_SESSION['id_registro'] = $registro;
                $j = 0;
                for ($i = 0; $i < $numero_de_vueltas; $i++) {
                    if ($arrayPersonas[$i]['Tipo_Pasajero'] == 'ADT') {
                        $tipo_pax = 'A';
                        $tarifa_unitaria = number_format($tarifa_adulto_5 / $adultos_5, 2);
                        $igv_unitaria = number_format($igv_adulto_5 / $adultos_5, 2);
                        $tuua_unitaria = number_format($tuua_adulto_5 / $adultos_5, 2);
                        $total = $tarifa_unitaria + $igv_unitaria + $tuua_unitaria;
                        if ($ciudad_exonerada > 0) {
                            $total_pagar = $tarifa_unitaria + $tuua_unitaria;
                        } else if ($ciudad_TUUA_exonerada > 0) {
                            $total_pagar = $tarifa_unitaria + $igv_unitaria;
                        } else {
                            $total_pagar = $total;
                        }
                    } elseif ($arrayPersonas[$i]['Tipo_Pasajero'] == 'CNN') {
                        $tipo_pax = 'N';
                        $tarifa_unitaria = number_format($tarifa_chil_5 / $menores_5, 2);
                        $igv_unitaria = number_format($igv_chil_5 / $menores_5, 2);
                        $tuua_unitaria = number_format($tuua_chil_5 / $menores_5, 2);
                        if ($ciudad_exonerada > 0) {
                            $total_pagar = $tarifa_unitaria + $tuua_unitaria;
                        } else if ($ciudad_TUUA_exonerada > 0) {
                            $total_pagar = $tarifa_unitaria + $igv_unitaria;
                        } else {
                            $total_pagar = $total;
                        }
                    } elseif ($arrayPersonas[$i]['Tipo_Pasajero'] == 'INF') {
                        $tipo_pax = 'B';
                        $tarifa_unitaria = number_format($tarifa_bb_5 / $infantes_5, 2);
                        $igv_unitaria = number_format($igv_bb_5 / $infantes_5, 2);
                        $tuua_unitaria = number_format($tuua_bb_5 / $infantes_5, 2);
                        if ($ciudad_exonerada > 0) {
                            $total_pagar = $tarifa_unitaria + $tuua_unitaria;
                        } else if ($ciudad_TUUA_exonerada > 0) {
                            $total_pagar = $tarifa_unitaria + $igv_unitaria;
                        } else {
                            $total_pagar = $total;
                        }
                    }
                    $j++;
                    $consulta = $obj_reserva->GuardarReservaDetalle($registro, $j, $arrayPersonas[$i]['Tipo_Documento'], $arrayPersonas[$i]['Numero_Documento'], $arrayPersonas[$i]['Apellidos'], $arrayPersonas[$i]['Nombres'], $tipo_pax, $arrayPersonas[$i]['Celular'], $arrayPersonas[$i]['Telefono'], $arrayPersonas[$i]['Telefono_Anex'], $arrayPersonas[$i]['RPC'], $arrayPersonas[$i]['RPM'], $arrayPersonas[$i]['Email'], $tarifa_unitaria, $igv_unitaria, $tuua_unitaria, $total, $total_pagar, $arrayPersonas[$i]['Fecha_Nacimiento']);
                }
                $_SESSION['pasajeros'] = $arrayPersonas;
            }
        }

        $table_precio_5 .= '<tr>
                <td colspan="4" align="left" class="subtitleTabla">Total a pagar:</td>
                <td align="center" class="subtitleTabla gradiante" style="color:white;">' . $tipo_moneda_5 . ' ' . number_format($total_pagar_tabla_5, 2, '.', ',') . '</td>
                </tr>';

        $table_precio_5 .= '<table width="900" border="0" cellpadding="0" cellspacing="0" class="bgTable_data">
            <tr>
                <td colspan="5" align="left" class="titleTable gradiante" style="color:white;">Forma de pago</td>
            </tr>
            <tr>
                <td height="3" colspan="7"  style="background:#fdb813;"></td>
            </tr>
            <tr>
                <td colspan="5" class="subtitleTabla">
                    <select name="forma_pago" id="forma_pago">
                        <option value="TC">Tarjeta de Credito</option>
                        <option value="LC" disabled>Linea de Credito</option>
                    </select>
                </td>
            </tr>';

        $table_precio_5 .= '</table>';
        // if($_POST['forma_pago'] == 'TC'){
        if (isset($_SESSION['registro_id'])) {
            unset($_SESSION['registro_id']);
        }
        if (isset($_SESSION['token_seguridad_visa'])) {
            unset($_SESSION['token_seguridad_visa']);
        }

        include '../../cn/METODOS_PAGO/Connection_visa.php';
        $visa = new Connection_visa();

        $token = $visa->Connection();

        $IP = $_SERVER['REMOTE_ADDR'];
        $request_body = $visa->GenerarBody($total_pagar_tabla_5, $IP);
        $visa_res = $visa->GenerarSesion($token, $request_body);
        $objSessionVisa = json_decode($visa_res);
        // var_dump($objSessionVisa);

        $libreriaJsVisa = $visa->GetLibreriaJSVisa();
        // require_once '../../cp/bloques_formas_pagos/visa_form.php';
        $forma_pago = 'TC';

        // }
    }

    if (isset($_POST['confirmacion'])) {

        if ($_POST['confirmacion'] == 1) {
            if ($_SESSION['s_idusuario'] == '' || $_SESSION['s_entidad'] == '') {
                $tabla_error .= '<center >' . "\n";
                $tabla_error .= '<table >' . "\n";
                $tabla_error .= '<tr><td height="50"></td></tr>' . "\n";
                $tabla_error .= '<tr>' . "\n";
                $tabla_error .= '<td class="subtitleTable"  style="color:red !important;text-align:center;">El tiempo de espera ha termiando. Por favor cierre sesión y vuelva a ingresar.<br/>¡Gracias!</td>' . "\n";
                $tabla_error .= '</tr>' . "\n";
                $tabla_error .= '</table>' . "\n";
                $tabla_error .= '</center >' . "\n";
                echo $tabla_error;
                die;
            }

            $correo_gestor = $_SESSION["s_email"];
            $codigo_reserva_c = $_POST['codigo_reserva'];
            $adultos_confirmacion = $_POST['adultos_confirmacion'];
            $menores_confirmacion = $_POST['menores_confirmacion'];
            $infantes_confirmacion = $_POST['infantes_confirmacion'];
            $registro = $_POST['registro'];
            $total_pagar_cc = $_POST['total_pagar_cc'];
            $tipo_moneda_cc = $_POST['tipo_moneda_cc'];
            $tipo_viaje_cc = $_POST['tipo_viaje_cc'];
            $total_pagar_tabla_5 = $_POST['total_pagar_tabla_5'];

            // datos del vuelo ida
            $numero_vuelo_ida_cc = $_POST['numero_vuelo_ida_cc'];
            $fecha_hora_salida_ida_cc = $_POST['fecha_hora_salida_ida_cc'];

            $fecha_salida_ida_cc = substr($fecha_hora_salida_ida_cc, 0, 10);
            $hora_salida_ida_cc = substr($fecha_hora_salida_ida_cc, 11, 13);

            $fecha_hora_llegada_ida_cc = $_POST['fecha_hora_llegada_ida_cc'];
            $hora_llegada_ida_cc = substr($fecha_hora_llegada_ida_cc, 11, 13);

            $clase_ida_cc = $_POST['clase_ida_cc'];
            $origen_ida_cc = $_POST['origen_ida_cc'];
            $nombre_origen_cc = $obj_tarifa->ObtenerNombreCiudad($origen_ida_cc);
            $destino_ida_cc = $_POST['destino_ida_cc'];
            $nombre_destino_cc = $obj_tarifa->ObtenerNombreCiudad($destino_ida_cc);

            // datos del vuelo vuelta
            $numero_vuelo_vuelta_cc = $_POST['numero_vuelo_vuelta_cc'];
            $fecha_hora_salida_vuelta_cc = $_POST['fecha_hora_salida_vuelta_cc'];

            $fecha_salida_vuelta_cc = substr($fecha_hora_salida_vuelta_cc, 0, 10);
            $hora_salida_vuelta_cc = substr($fecha_hora_salida_vuelta_cc, 11, 13);

            $fecha_hora_llegada_vuelta_cc = $_POST['fecha_hora_llegada_vuelta_cc'];
            $hora_llegada_vuelta_cc = substr($fecha_hora_llegada_vuelta_cc, 11, 13);
            $clase_vuelta_cc = $_POST['clase_vuelta_cc'];
            $origen_vuelta_cc = $_POST['origen_vuelta_cc'];
            $nombre_origen_vuelta_cc = $obj_tarifa->ObtenerNombreCiudad($origen_vuelta_cc);
            $destino_vuelta_cc = $_POST['destino_vuelta_cc'];
            $nombre_destino_vuelta_cc = $obj_tarifa->ObtenerNombreCiudad($destino_vuelta_cc);

            $numero_documento = $obj_empresa->ObtenerRucEmpresa($_SESSION['s_entidad']);
            $ruc = trim($numero_documento->getRuc());


            $cantidad_pasajeros_c = $adultos_confirmacion + $menores_confirmacion + $infantes_confirmacion;
            $tickets = array();
            $endoso = '';
            if ($origen_ida_cc == 'PEM' || $destino_ida_cc == 'PEM' || $origen_ida_5 == 'IQT' || $destino_ida_5 == 'IQT') {
                $endoso = 'PAYABLE ONLY IN USD/BOLETO SUJETO BENEFICIO LEY 29721';
            }
            $correo_gestor = $_SESSION["s_email"];
            $codigo_reserva_c = $_POST['codigo_reserva'];
            $adultos_confirmacion = $_POST['adultos_confirmacion'];
            $menores_confirmacion = $_POST['menores_confirmacion'];
            $infantes_confirmacion = $_POST['infantes_confirmacion'];
            $registro = $_POST['registro'];
            $total_pagar_cc = $_POST['total_pagar_cc'];
            $tipo_moneda_cc = $_POST['tipo_moneda_cc'];
            $tipo_viaje_cc = $_POST['tipo_viaje_cc'];
            $total_pagar_tabla_5 = $_POST['total_pagar_tabla_5'];

            // datos del vuelo ida
            $numero_vuelo_ida_cc = $_POST['numero_vuelo_ida_cc'];
            $fecha_hora_salida_ida_cc = $_POST['fecha_hora_salida_ida_cc'];

            $fecha_salida_ida_cc = substr($fecha_hora_salida_ida_cc, 0, 10);
            $hora_salida_ida_cc = substr($fecha_hora_salida_ida_cc, 11, 13);

            $fecha_hora_llegada_ida_cc = $_POST['fecha_hora_llegada_ida_cc'];
            $hora_llegada_ida_cc = substr($fecha_hora_llegada_ida_cc, 11, 13);

            $clase_ida_cc = $_POST['clase_ida_cc'];
            $origen_ida_cc = $_POST['origen_ida_cc'];
            $nombre_origen_cc = $obj_tarifa->ObtenerNombreCiudad($origen_ida_cc);
            $destino_ida_cc = $_POST['destino_ida_cc'];
            $nombre_destino_cc = $obj_tarifa->ObtenerNombreCiudad($destino_ida_cc);

            // datos del vuelo vuelta
            $numero_vuelo_vuelta_cc = $_POST['numero_vuelo_vuelta_cc'];
            $fecha_hora_salida_vuelta_cc = $_POST['fecha_hora_salida_vuelta_cc'];

            $fecha_salida_vuelta_cc = substr($fecha_hora_salida_vuelta_cc, 0, 10);
            $hora_salida_vuelta_cc = substr($fecha_hora_salida_vuelta_cc, 11, 13);

            $fecha_hora_llegada_vuelta_cc = $_POST['fecha_hora_llegada_vuelta_cc'];
            $hora_llegada_vuelta_cc = substr($fecha_hora_llegada_vuelta_cc, 11, 13);
            $clase_vuelta_cc = $_POST['clase_vuelta_cc'];
            $origen_vuelta_cc = $_POST['origen_vuelta_cc'];
            $nombre_origen_vuelta_cc = $obj_tarifa->ObtenerNombreCiudad($origen_vuelta_cc);
            $destino_vuelta_cc = $_POST['destino_vuelta_cc'];
            $nombre_destino_vuelta_cc = $obj_tarifa->ObtenerNombreCiudad($destino_vuelta_cc);

            $numero_documento = $obj_empresa->ObtenerRucEmpresa($_SESSION['s_entidad']);
            $ruc = trim($numero_documento->getRuc());

            $cantidad_pasajeros_c = $adultos_confirmacion + $menores_confirmacion + $infantes_confirmacion;
            $tickets = array();
            $endoso = '';
            if ($origen_ida_cc == 'PEM' || $destino_ida_cc == 'PEM' || $origen_ida_5 == 'IQT' || $destino_ida_5 == 'IQT') {
                $endoso = 'PAYABLE ONLY IN USD/BOLETO SUJETO BENEFICIO LEY 29721';
            }
            if ($cantidad_pasajeros_c == 1) {
                $respuesta_kiu = $KIU->AirDemandTicketRQ(array(
                    'PaymentType' => "37"
                    , 'MiscellaneousCode' => "SR"
                    , 'Text' => "$ruc"
                    , 'Country' => "PE"
                    , 'Currency' => "USD"
                    , 'TourCode' => ""
                    , 'BookingID' => "$codigo_reserva_c"
                    , 'InvoiceCode' => "ACME"
                    , 'VAT' => "$ruc"
                    , 'Endorsement' => "$endoso"
                        ), $err);
                if ($err['ErrorCode'] != 0)
                    echo $err['ErrorMsg'];
                $res = $respuesta_kiu[0];
                $request = $respuesta_kiu[1];
                $response = $respuesta_kiu[2];
                $mensaje = 'TRAMA ENVIADA<BR>' . print_r($request, true) . '<BR>TRAMA RESPUESTA<BR>' . print_r($response, true);

                // Para enviar un correo HTML mail, la cabecera Content-type debe fijarse
                $cabeceras = 'MIME-Version: 1.0' . "\r\n";
                $cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                // Cabeceras adicionales
                $cabeceras .= 'From:' . utf8_decode("XML DE EMISION DE TICKET WEB AGENCIAS") . ' <ecel@starperu.com>' . "\r\n";
                $cabeceras .= 'Bcc: carlos.gutierrez@starperu.com' . "\r\n";
                $cabeceras .= 'Reply-To: ecel@starperu.com' . "\r\n" .
                        'X-Mailer: PHP/' . phpversion();
                mail($para, $asunto, $mensaje, $cabeceras);


                $array_tickets_number = $res['TicketItemInfo'];
                $ticket = $array_tickets_number['@attributes']['TicketNumber'];



                $tickets[0] = $ticket;
                $array_datos_personas = $_SESSION['pasajeros'];
                $i = 1;
                $obj_reserva->UpdateReservaDetalleTicket($ticket, $i, $registro);
                $campos_consulta .= " Ticket0" . $i . "='$ticket', ";

                $obj_reserva->EnviarAlertaGestor($correo_gestor, $codigo_reserva_c, $ticket);

                $cantidadInfantes = $obj_reserva->cantidadInfantes($registro);
                //var_dump($cantidadInfantes);
                if ($cantidadInfantes > 0) {
                    $obj_reserva->EnviaAlertaNinoEmail($registro);
                }


                $consulta = $obj_reserva->UpdateReservaTicket($codigo_reserva_c, $campos_consulta);

                /* Emitir Ticket y Enviar al correo el ticket al Gestor */
                $correo_gestor = strtoupper($correo_gestor);
                $res = $KIU->TravelItineraryReadRQ(array(
                    //'IdReserva'=>$codigo_reserva_c
                    'IdTicket' => $ticket
                    , 'Email' => $correo_gestor
                        ), $err);

                if ($err['ErrorCode'] != 0)
                    echo $err['ErrorMsg'];
                //print_r($res);

                /* Emitir Ticket y Enviar al correo el ticket al Cliente */
                $email_cliente = strtoupper($array_datos_personas[0]['Email']);
                $res2 = $KIU->TravelItineraryReadRQ(array(
                    //'IdReserva'=>$codigo_reserva_c
                    'IdTicket' => $ticket
                    , 'Email' => $email_cliente
                        ), $err);
                //print_r($res2);
                if ($err['ErrorCode'] != 0) {
                    echo $err['ErrorMsg'];

                    $mensaje = 'TRAMA ENVIADA<BR>' . print_r($request, true) . '<BR>TRAMA RESPUESTA<BR>' . print_r($response, true);
                    // Para enviar un correo HTML mail, la cabecera Content-type debe fijarse
                    $cabeceras = 'MIME-Version: 1.0' . "\r\n";
                    $cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                    // Cabeceras adicionales
                    $cabeceras .= 'From:' . utf8_decode("XML DE EMISION DE TICKET WEB AGENCIAS") . ' <ecel@starperu.com>' . "\r\n";
                    $cabeceras .= 'Bcc: carlos.gutierrez@starperu.com' . "\r\n";
                    $cabeceras .= 'Reply-To: ecel@starperu.com' . "\r\n" .
                            'X-Mailer: PHP/' . phpversion();

                    mail($para, $asunto, $mensaje, $cabeceras);
                } else {
                    $mensaje = $err['ErrorCode'];
                    $cabeceras = 'MIME-Version: 1.0' . "\r\n";
                    $cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                    // Cabeceras adicionales
                    $cabeceras .= 'From:' . utf8_decode("XML DE EMISION DE TICKET WEB AGENCIAS") . ' <ecel@starperu.com>' . "\r\n";
                    $cabeceras .= 'Bcc: carlos.gutierrez@starperu.com' . "\r\n";
                    $cabeceras .= 'Reply-To: ecel@starperu.com' . "\r\n" .
                            'X-Mailer: PHP/' . phpversion();
                    $para = 'carlos.gutierrez@starperu.com';
                    mail($para, $asunto, $mensaje, $cabeceras);
                }
            } else {
                $respuesta_kiu = $KIU->AirDemandTicketRQ(array(
                    'PaymentType' => "37"
                    , 'MiscellaneousCode' => "SR"
                    , 'Text' => "$ruc"
                    , 'Country' => "PE"
                    , 'Currency' => "USD"
                    , 'TourCode' => ""
                    , 'BookingID' => "$codigo_reserva_c"
                    , 'InvoiceCode' => "ACME"
                    , 'VAT' => "$ruc"
                    , 'Endorsement' => "$endoso"
                        ), $err);
                // if($err['ErrorCode']!=0) echo $err['ErrorMsg'];

                $res = $respuesta_kiu[0];
                $request = $respuesta_kiu[1];
                $response = $respuesta_kiu[2];


                $j = 1;
                $fila = 0;
                $cantidad_tickets = count($res['TicketItemInfo']);
                $array_tickets_number = $res['TicketItemInfo'];
                $array_datos_personas = $_SESSION['pasajeros'];
                while ($fila < $cantidad_tickets) {
                    $ticket_number = $array_tickets_number[$fila]['@attributes']['TicketNumber'];
                    $ticket_totales[] = $array_tickets_number[$fila]['@attributes']['TicketNumber'];
                    $tickets[$fila] = $ticket_number;
                    $resulatdo = $obj_reserva->UpdateReservaDetalleTicket($ticket_number, $j, $registro);

                    if ($j < 10) {
                        $campos_consulta .= " Ticket0" . $j . "='$ticket_number',";
                    }
                    $j++;
                    $correo_gestor = strtoupper($correo_gestor);
                    $res = $KIU->TravelItineraryReadRQ(array(
                        'IdReserva' => $codigo_reserva_c
                        , 'IdTicket' => $tickets[$fila]
                        , 'Email' => $correo_gestor
                            ), $err);
                    if ($err['ErrorCode'] != 0)
                        echo $err['ErrorMsg'];

                    $email_cliente = strtoupper($array_datos_personas[$fila]['Email']);

                    $res2 = $KIU->TravelItineraryReadRQ(array(
                        'IdReserva' => $codigo_reserva_c
                        , 'IdTicket' => $tickets[$fila]
                        , 'Email' => $email_cliente
                            ), $err);
                    if ($err['ErrorCode'] != 0) {
                        echo $err['ErrorMsg'];
                        $mensaje = 'TRAMA ENVIADA<BR>' . print_r($request, true) . '<BR>TRAMA RESPUESTA<BR>' . print_r($response, true);
                        // Para enviar un correo HTML mail, la cabecera Content-type debe fijarse
                        $cabeceras = 'MIME-Version: 1.0' . "\r\n";
                        $cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                        // Cabeceras adicionales
                        $cabeceras .= 'From:' . utf8_decode("XML DE EMISION DE TICKET WEB AGENCIAS") . ' <ecel@starperu.com>' . "\r\n";
                        $cabeceras .= 'Bcc: carlos.gutierrez@starperu.com' . "\r\n";
                        $cabeceras .= 'Reply-To: ecel@starperu.com' . "\r\n" .
                                'X-Mailer: PHP/' . phpversion();
                        mail($para, $asunto, $mensaje, $cabeceras);
                    }

                    $fila++;
                }
                $obj_reserva->UpdateReservaTicket($codigo_reserva_c, $campos_consulta);
            }

            $codigo_entidad = $_SESSION['s_entidad'];
            $tipo = 1;
            $monto_recuperado = $total_pagar_tabla_5;
            $obj_persona->ActualizarLineaCredito($codigo_entidad, $monto_recuperado, $tipo);

            if ($tipo_viaje_cc == 1) {

                $table_cabecera_cc .= '<table width="900" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td colspan="7" align="left" class="titleTable gradiante" style="color:white;">Itinerario</td>
                </tr>
                <tr>
                    <td height="3" colspan="7"  style="background:#fdb813;"></td>
               </tr>
                <tr>
                  <td width="170" align="left" class="subtitleTabla">Fecha de Ida</td>
                  <td width="172" align="left" class="subtitleTabla">Hora de Salida</td>
                  <td width="172" align="left" class="subtitleTabla">Hora de Llegada</td>
                  <td width="132" align="left" class="subtitleTabla">N° de Vuelo</td>
                  <td width="104" align="left" class="subtitleTabla">Clase</td>
                  <td width="104" align="left" class="subtitleTabla">Equipaje</td>
                </tr>
                <tr style="background: #F0F0F0">
                  <td align="left" class="bgTable_data">' . date("d/m/Y", strtotime($fecha_salida_ida_cc)) . '</td>
                  <td align="left" class="bgTable_data"><strong>' . $hora_salida_ida_cc . '</strong> ' . $nombre_origen_cc . ' (' . $origen_ida_cc . ')</td>
                  <td align="left" class="bgTable_data"><strong>' . $hora_llegada_ida_cc . '</strong> ' . $nombre_destino_cc . ' (' . $destino_ida_cc . ')</td>
                  <td align="left" class="bgTable_data">' . $numero_vuelo_ida_cc . '</td>
                  <td align="left" class="bgTable_data">' . $clase_ida_cc . '</td>
                  <td align="left" class="bgTable_data">23 KG</td>
                </tr>
                <tr>
                  <td align="left" class="subtitleTabla">Fecha de Regreso</td>
                  <td align="left" class="subtitleTabla">Hora de Salida</td>
                  <td align="left" class="subtitleTabla">Hora de Llegada</td>
                  <td align="left" class="subtitleTabla">N° de Vuelo</td>
                  <td align="left" class="subtitleTabla">Clase</td>
                  <td align="left" class="subtitleTabla">Equipaje</td>
                </tr>
                <tr style="background: #F0F0F0">
                  <td align="left" class="bgTable_data">' . date("d/m/Y", strtotime($fecha_salida_vuelta_cc)) . '</td>
                  <td align="left" class="bgTable_data"><strong>' . $hora_salida_vuelta_cc . '</strong> ' . $nombre_origen_vuelta_cc . ' (' . $origen_vuelta_cc . ')</td>
                  <td align="left" class="bgTable_data"><strong>' . $hora_llegada_vuelta_cc . '</strong> ' . $nombre_destino_vuelta_cc . ' (' . $destino_vuelta_cc . ')</td>
                  <td align="left" class="bgTable_data">' . $numero_vuelo_vuelta_cc . '</td>
                  <td align="left" class="bgTable_data">' . $clase_vuelta_cc . '</td>
                   <td align="left" class="bgTable_data">23 KG</td>
                </tr>
                </table>';
            } elseif ($tipo_viaje_cc == 0) {

                $table_cabecera_cc .= '<table width="900" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td colspan="7" align="left" class="titleTable gradiante" style="color:white;">Itinerario</td>
                </tr>
                <tr>
                    <td height="3" colspan="7"  style="background:#fdb813;"></td>
               </tr>
                <tr>
                  <td width="170" align="left" class="subtitleTabla">Fecha de Ida</td>
                  <td width="172" align="left" class="subtitleTabla">Hora de Salida</td>
                  <td width="172" align="left" class="subtitleTabla">Hora de Llegada</td>
                  <td width="132" align="left" class="subtitleTabla">N° de Vuelo</td>
                  <td width="104" align="left" class="subtitleTabla">Clase</td>
                  <td width="104" align="left" class="subtitleTabla">Equipaje</td>
                </tr>
                <tr style="background: #F0F0F0">
                  <td align="left" class="bgTable_data">' . date("d/m/Y", strtotime($fecha_salida_ida_cc)) . '</td>
                  <td align="left" class="bgTable_data"><strong>' . $hora_salida_ida_cc . '</strong> ' . $nombre_origen_cc . ' (' . $origen_ida_cc . ')</td>
                  <td align="left" class="bgTable_data"><strong>' . $hora_llegada_ida_cc . '</strong> ' . $nombre_destino_cc . ' (' . $destino_ida_cc . ')</td>
                  <td align="left" class="bgTable_data">' . $numero_vuelo_ida_cc . '</td>
                  <td align="left" class="bgTable_data">' . $clase_ida_cc . '</td>
                  <td align="left" class="bgTable_data">23 KG</td>
                </tr></table>';
            }

            $tabla_pasajeros = '';
            $tabla_pasajeros .= ' <table width="900" border="0" cellpadding="0" cellspacing="0" class="bgTable_data">
                <tr>
                   <td colspan="7" align="left" class="titleTable gradiante" style="color:white;"><strong>Pasajeros</strong></td>
                  
                </tr>
                  <tr>
                    <td height="3" colspan="7"  style="background:#fdb813;"></td>
               </tr>
                <tr>
                  <td width="120" class="subtitleTabla">Tipo</td>
                  <td width="252" align="left" class="subtitleTabla">Nombre</td>
                  <td width="252" align="left" class="subtitleTabla">Apellido</td>
                  <td width="142" align="left" class="subtitleTabla">Doc. Identidad</td>
                  <td width="132" align="center" class="subtitleTabla">Boleto Electr&oacute;nico</td>
                </tr>
                ';
            $array = $_SESSION['pasajeros'];

            for ($i = 0; $i < count($array); $i++) {

                if ($array[$i]['Tipo_Pasajero'] == 'ADT') {
                    $letra_tipo_pasajero = 'Adulto';
                } elseif ($array[$i]['Tipo_Pasajero'] == 'CNN') {
                    $letra_tipo_pasajero = 'Niño';
                } else {
                    $letra_tipo_pasajero = 'Infante';
                }
                if ($array[$i]['Tipo_Documento'] == 'NI') {
                    $letra_tipo_documento = 'DNI';
                } elseif ($array[$i]['Tipo_Documento'] == 'PP') {
                    $letra_tipo_documento = 'Pasaporte';
                }

                $_SESSION['ticket'] = $tickets[$i];

                $tabla_pasajeros .= '<tr style="background: #F0F0F0"><td height="18" align="left" class="bgTable_data">' . $letra_tipo_pasajero . '</td>
                <td align="left" class="bgTable_data">' . $array[$i]['Nombres'] . '</td>
                <td align="left" class="bgTable_data">' . $array[$i]['Apellidos'] . '</td>
                <td align="left" class="bgTable_data">' . $letra_tipo_documento . ' ' . $array[$i]['Numero_Documento'] . '</td>
                <td align="center" class="bgTable_data"><a title="Click para visualizar el Boleto" href="imprimir_ticket.php?ticket=' . $_SESSION['ticket'] . '" target="_blank" ><img src="../images/ticket.png"  width="16" height="16" border="0" style="cursor: pointer" /></a></td>
                </tr> ';
            }
            $tabla_pasajeros .= '</table>';
        }
    }
}
?>
<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <style type="text/css">
        #btnCerrar{
                background: -webkit-linear-gradient(#f01515, darkred) !important;
                color: white;
        }
    </style>
</head>
<body>
    <!--PROMO(H, S y T) - IDA-->
    <div class="col-lg-4 col-md-12 mb-4">
        <div class="modal fade" id="modal-condiciones-promo-ida" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-body mb-0 p-0">
                        <div  class="container"><br>
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
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button align="center" type="button" id="btnCerrar" class="btn btn-outline-danger btn-rounded btn-md ml-4" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--SIMPLE(A, B, D, E, O, P, R y Z) - IDA-->
    <div class="col-lg-4 col-md-12 mb-4">
        <div class="modal fade" id="modal-condiciones-simple-ida" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-body mb-0 p-0">
                        <div class="container"><br> 
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
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button align="center" type="button"  id="btnCerrar" class="btn btn-outline-danger btn-rounded btn-md ml-4" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--EXTRA(J, M, N, Q, V, W y X) - IDA-->
    <div class="col-lg-4 col-md-12 mb-4">
        <div class="modal fade" id="modal-condiciones-extra-ida" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-body mb-0 p-0">
                        <div class="container"><br> 
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
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button align="center" type="button"  id="btnCerrar" class="btn btn-outline-danger btn-rounded btn-md ml-4" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--FULL(K, L y Y) - IDA-->
    <div class="col-lg-4 col-md-12 mb-4">
        <div class="modal fade" id="modal-condiciones-full-ida" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-body mb-0 p-0">
                        <div class="container"><br>
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
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button align="center" type="button"  id="btnCerrar" class="btn btn-outline-danger btn-rounded btn-md ml-4" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--PROMO(H, S y T) - VUELTA-->
    <div class="col-lg-4 col-md-12 mb-4">
        <div class="modal fade" id="modal-condiciones-promo-vuelta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-body mb-0 p-0">
                        <div  class="container"><br>
                            <h5>PROMO(H, S y T)</h5>
                            <table class="table">
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
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button align="center" type="button"  id="btnCerrar" class="btn btn-outline-danger btn-rounded btn-md ml-4" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--SIMPLE(A, B, D, E, O, P, R y Z) - VUELTA-->
    <div class="col-lg-4 col-md-12 mb-4">
        <div class="modal fade" id="modal-condiciones-simple-vuelta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-body mb-0 p-0">
                        <div class="container"><br> 
                            <h5>SIMPLE(A, B, D, E, O, P, R y Z)</h5>
                            <table class="table">
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
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button align="center" type="button"  id="btnCerrar" class="btn btn-outline-danger btn-rounded btn-md ml-4" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--EXTRA(J, M, N, Q, V, W y X) - VUELTA-->
    <div class="col-lg-4 col-md-12 mb-4">
        <div class="modal fade" id="modal-condiciones-extra-vuelta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-body mb-0 p-0">
                        <div class="container"><br> 
                            <h5>EXTRA(J, M, N, Q, V, W y X)</h5>
                            <table class="table">
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
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button align="center" type="button"  id="btnCerrar" class="btn btn-outline-danger btn-rounded btn-md ml-4" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--FULL(K, L y Y) - VUELTA-->
    <div class="col-lg-4 col-md-12 mb-4">
        <div class="modal fade" id="modal-condiciones-full-vuelta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-body mb-0 p-0">
                        <div class="container"><br>
                            <h5>FULL(K, L y Y)</h5>
                            <table class="table">
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
                    <div class="modal-footer justify-content-center">
                        <button align="center" type="button"  id="btnCerrar" class="btn btn-outline-danger btn-rounded btn-md ml-4" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>