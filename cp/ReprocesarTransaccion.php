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
    <link href="<?=$url?>/cp/css/pago_reserva.css" rel="stylesheet" type="text/css" />
    <script>
        $(function () {
            $('.modal-opener').click();
        });
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
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="alert alert-info" role="alert">Tome nota de su proceso de pago.</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-9">
                                <div class="accordion destinos--2" id="accordionStar">
                                    <div class="card">
                                        <div class="card-header bg-danger" id="headingTwo">
                                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#collapseTwo" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                <h3>Datos de la Compra:</h3>
                                            </a>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-11">
                                                    <table class="table resumen">
                                                        <tbody>
                                                            <tr>
                                                                <th>Código de reserva:</th>
                                                                <td><?= $data_reprocesa['pnr']?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Número de pedido:</th>
                                                                <td><?= $data_reprocesa['reserva_id']?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Moneda:</th>
                                                                <td>USD</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Monto de la Transacción</th>
                                                                <td><?= $data_reprocesa['$total_pagar']?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Descripción del Vuelo</th>
                                                                <td></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>

                                    <div class="card"></div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <div class="card border-danger resumen destinos-2">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="contacto">Código de Reserva:</label>
                                                    <input type="text" class="form-control vacios" id="codres" value="<?= $data_reprocesa['pnr']?>" disabled="">
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="email">Monto de la transacción:</label>
                                                    <input type="text" class="form-control vacios " id="montotrans" value=" USD <?= $data_reprocesa['$total_pagar']?>" disabled="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php
                                $_SESSION['registro_id'] = $reserva_id;
                                $_SESSION['token_seguridad_visa'] = $token;
                            ?>
                            <form  action="<?=$url?>/cp/MetodoReprocesado.php" target="my-iframe" id="form_visa" method='post' style="display: none">
                                <script src='<?=$url.'/cp/pasarela/'.$libreriaJsVisa?>'
                                    data-sessiontoken='<?= $objSessionVisa->sessionKey ?>'
                                    data-channel='web'
                                    data-merchantid='<?= $visa->getCodigo_comercio() ?>'
                                    data-merchantlogo= 'https://www.starperu.com/es/img/Logotipo.png'
                                    data-formbuttoncolor='#D80000'
                                    data-purchasenumber= <?=$reserva_id?>
                                    data-amount=<?=$data_reprocesa['$total_pagar']?>
                                    data-expirationminutes= 5
                                    data-timeouturl = '<?= $url?>/cp/pasarela/html/tiempo_limite.php'></script>
                            </form>
                        </div>
                        <br>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<?php include(FOOTER_PATH); ?>