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
    require_once PATH_PROYECTO.'/cd/Controlador/PasarelaControl.php';

?>
<?php ob_start(); ?>
    <?php $style_script_contenido = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php require_once(HTML_RECURSO_PATH); ?>
<table width="100%" cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td>
            <table width="900" align="center" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td>
                        <br>
                        <div class="col-sm-12">
                            <div class="accordion destinos--2" id="accordionStar">
                                <div class="card">
                                    <div class="card-header" id="headingOne">
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
                                                            <tr>
                                                                <td>28/Aug</td>
                                                                <td>14:40/15:40</td>
                                                                <td>IQT</td>
                                                                <td>PCL</td>
                                                                <td>125  | Operado por Peruavian</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                        
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card" id="accordionStar">
                                    <div class="card-header" id="headingTwo">
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
                                                            <tr>
                                                                <td>Pasajero 1 </td>
                                                                <td>ADT</td>
                                                                <td>RENDON MATHEWS/RAQUEL</td>
                                                                <td>NI : 07699168</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        
                                <div class="card" id="accordionStar">
                                    <div class="card-header" id="headingThree">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#collapseThree" href="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                                            <h3>Información de Contacto:</h3>
                                        </a>
                                    </div>
                                    <div id="collapseThree" class="collapse show" aria-labelledby="headingThree" data-parent="#accordionStar" style="">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-10">
                                                    <p>Estos datos son necesarios para enviar notificaciones y mensajes relacionados a tu compra, cambios en el vuelo u otros.</p>
                                                </div>
                                                <div class="col-sm-12 col-md-10">
                                                    <div class="form-group">
                                                        <label for="contacto">Contacto:</label>
                                                        <input type="text" class="form-control vacios" id="contacto" name="contacto" value="RENDON MATHEWS/RAQUEL" disabled="">
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-10">
                                                    <div class="form-group">
                                                        <label for="email">Correo electrónico:</label>
                                                        <input type="text" class="form-control vacios " id="email" name="email" value="JOSEAR74@HOTMAIL.COM" disabled="">
                                                    </div>
                                                    <hr>
                                                </div>
                        
                                                <div class="col-sm-12 col-md-5">
                                                                                        <div class="form-group">
                                                        <label for="num-loc">Número de contacto:</label>
                                                        <input type="text" class="form-control" aria-describedby="num-loc" id="num-loc" name="num_tlfn" value="061939407347" disabled="">
                                                    </div>
                                                        <div class="form-group">
                                                        <label for="num-loc">RUC:</label>
                                                        <input type="text" class="form-control" aria-describedby="num-loc" id="num-loc" name="num_tlfn" value="" disabled="">
                                                    </div>
                                                </div>
                        
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        
                                <div class="card" id="accordionStar">
                                    <div class="card-header" id="headingFour">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#collapseFour" href="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
                                            <h3>Forma de pago:</h3>
                                        </a>
                                    </div>
                                    <div id="collapseFour" class="collapse show" aria-labelledby="headingFour" data-parent="#accordionStar" style="">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-6">
                                                    <label for="pre-loc">Forma de pago:</label>
                                                    <input hidden="movil" value="">
                                                    <div class="select">
                                                        <select id="select_cards" name="cc_code">
                                                            <option value="TC_V">Visa</option>
                                                            <option value="TC_M">Mastercard</option>
                                                            <option value="TC_D">Diners Club</option>
                                                            <option value="TC_A">American Express</option>
                                                            <!--Bloque safetypay-->
                                                            <option value="SP_C">Pago en Efectivo</option>
                                                            <option value="SP_I">Banca por Internet</option>
                                                            <option value="SP_E">Pagos Internacionales</option>
                                                            <!-- <option value="PE">Depósitos en efectivo</!--> -->
                                                            <!-- <option value="PEB">Transferencias Bancarias</option> -->
                                                            <!--Bloque safetypay-->
                                                        </select>
                                                        <div class="select__arrow"></div>
                                                    </div>
                                                </div>
                        
                                                <div class="col-sm-12 col-md-6">
                                                    <div class="logo-medio-pago">
                                                        <!--<img class="d-block w-70" id="img_cards" src="https://www.starperu.com/PasarelaWeb/img/metodos_pagos/logo_pp.png" alt="First slide">-->
                                                        <img class="d-block w-100" id="img_cards" src="https://www.starperu.com/PasarelaWeb/img/metodos_pagos/logo_visa_opc2.png" alt="First slide">
                                                    </div>
                                                </div>
                                                <label id="pagoefectivo"></label>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <br>
                                                    <p># Web Check-in No aplica para vuelos operados por Peruvian, acercarse 2 hrs antes al counter para hacer su check-in gracias. </p>
                                                </div>
                                                <div class="col-sm-12 col-md-8">
                                                    <div class="form-check">
                                                        <input class="form-check-input vacios_radio" type="checkbox" value="" id="defaultCheck1">
                                                        <label class="form-check-label" for="defaultCheck1">
                                                            Acepto las condiciones de compra
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4">
                                                    <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#TerminosCondiciones">Ver condiciones</button>
                                                    <!--<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">ver condiciones</button>-->
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12"><br></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12 col-md-8">
                                                    <div class="form-check">
                                                        <input class="form-check-input vacios_radio" type="checkbox" value="" id="defaultCheck2">
                                                        <label class="form-check-label" for="defaultCheck2">
                                                            Acepto las condiciones de Transporte.
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4">
                                                    <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#ModalCondiciones_Transporte">Ver condiciones</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<?php include(FOOTER_PATH); ?>