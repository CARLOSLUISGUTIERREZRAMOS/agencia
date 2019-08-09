<?php
session_start();
error_reporting(E_ALL);
ini_set("display_errors", 0);
date_default_timezone_set('America/Lima');
if ($_SESSION['s_entra'] == 0) {
    header('Location:../../index.php');
}
require_once("../../cd/Controlador/AgenciaControl.php");
$Tipo = $_SESSION['s_tipo'];
$directorio = '../';
$directorio_imagen = '../';
$agencia_entidad = $_SESSION['s_agencia'];
require_once("../../config.php");

$agencias = array();
$ciudad = array();
$agencias = $obj_empresa->ObtenerAgencia($agencia_entidad->CodigoEntidad);
$ciudad = $obj_empresa->ObtenerNombreCiudad($agencias[13],$agencia_entidad->CodigoEntidad);
?>

<?php ob_start(); ?>
<link href="<?= $url ?>/cp/css/gestor.css" rel="stylesheet" type="text/css" />
<script src="<?= $url ?>/cp/js/ajax/funcionesGestorDelegado.js"></script>
<script src="<?= $url ?>/cp/js/ajax/funcionesEntidad.js"></script>
<?php $style_script_contenido = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php require_once(HTML_RECURSO_PATH); ?>
<div style="margin:0px auto; width:1000px;">
    <br>
    <div id="div-delegado" style="width:1000px;">
        <table width="900" border="0" cellpadding="0" cellspacing="0" style="margin:10px 0 0 30px;background-color: #F0F0F0;">
            <tbody>
                <tr>
                    <td height="26" colspan="5" class="gradiante" style="color:white;font-size: 13px;padding: 0px 5px;margin: 0px;font-weight: bold;">Agencia - Información</td>
                </tr>
                <tr>
                    <td height="3" colspan="5" style="background:#fdb813;"></td>
                </tr>
                <tr>
                    <td height="10" colspan="5"></td>
                </tr>
                <tr>
                    <td class="label_info" >RUC:</td>
                    <td class="span_info">
                        <?= $agencias[0] ? $agencias[0] : '-' ?>
                    </td>
                    <td class="label_info">Apellido Paterno:</td>
                    <td class="span_info">
                        <?= $agencias[7] ? $agencias[7] : '-' ?>
                    </td>
                    <td rowspan="2">
                        <button style="cursor:pointer;" onclick="event.preventDefault();editar_agencia(<?= $agencia_entidad->CodigoEntidad ?>);" title="Editar datos"><img src="../images/pencil.png">
                        </button>
                    </td>
                </tr>
                <tr>
                    <td class="label_info">Razón Social:</td>
                    <td class="span_info"><?= $agencias[10] ? $agencias[10] : '-' ?></td>
                    <td class="label_info">Apellido Materno:</td>
                    <td class="span_info"><?= $agencias[6] ? $agencias[6] : '-' ?></td>
                </tr>
                <tr>
                    <td class="label_info">Nombre Comercial:</td>
                    <td class="span_info"><?= $agencias[2] ? $agencias[2] : '-' ?></td>
                    <td class="label_info">Nombres:</td>
                    <td class="span_info"><?= $agencias[5] ? $agencias[5] : '-' ?></td>
                </tr>
                <tr>
                    <td class="label_info">País:</td>
                    <td class="span_info"><?= $ciudad[2] ?></td>
                    <td class="label_info">DNI:</td>
                    <td class="span_info"><?= $agencias[1] ? $agencias[1] : '-' ?></td>
                </tr>
                <tr>
                    <td class="label_info">Ciudad:</td>
                    <td class="span_info"><?= $ciudad[0] ?></td>
                    <td class="label_info">Celular:</td>
                    <td class="span_info"><?= $agencias[9] ? $agencias[9] : '-' ?></td>
                </tr>
                <tr>
                    <td class="label_info">Domicilio Fiscal:</td>
                    <td class="span_info"><?= $agencias[3] ? $agencias[3] : '-' ?></td>
                    <td class="label_info">Email:</td>
                    <td class="span_info"><?= $agencias[11] ? $agencias[11] : '-' ?></td>
                </tr>
                <tr>
                    <td class="label_info">Teléfono de Oficina:</td>
                    <td class="span_info"><?= $agencias[8] ? $agencias[8] : '-' ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<?php // } ?>
<?php include(FOOTER_PATH); ?>