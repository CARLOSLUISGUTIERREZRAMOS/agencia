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
$agencias = $obj_empresa->ObtenerAgencia($agencia_entidad->CodigoEntidad);

require_once("../../cn/STARPERU/Modelo/LocalidadModelo.php");
$obj_modelo = new LocalidadModelo();
?>

<?php ob_start(); ?>
<link href="<?= $url ?>/cp/css/gestor.css" rel="stylesheet" type="text/css" />
<link href="<?= $url ?>/cp/js/jqueryui/css/blitzer/jquery-ui-1.10.4.custom.css" rel="stylesheet" type="text/css" />
<link href="<?= $url ?>/cp/js/msgbox/css/jquery.msgbox.css" rel="stylesheet" type="text/css" />

<script src="<?= $url ?>/cp/js/jquery/jquery-1.8.0.min.js"></script>
<script src="<?= $url ?>/cp/js/jqueryui/js/jquery-ui-1.10.4.custom.js"></script>
<script src="<?= $url ?>/cp/js/msgbox/jquery.msgbox.i18n.js"></script>
<script src="<?= $url ?>/cp/js/msgbox/jquery.msgbox.js"></script>
<script src="<?= $url ?>/cp/js/ajax/MBAjax.js"></script>
<script src="<?= $url ?>/cp/js/ajax/funcionesEntidad.js"></script>
<script src="<?= $url ?>/cp/js/ajax/funcionesGestorDelegado.js"></script>
<script src="<?= $url ?>/cp/js/ajax/funcionesGestor.js"></script>
<?php $style_script_contenido = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php require_once(HTML_RECURSO_PATH); ?>
<div style="width:1000px; margin:0 auto;">
    <form id="form" name="form" method="post" action="" autocomplete="off">
        <div id="div-delegado" style="width:1000px;margin: 0px auto;">
            <table width="900" border="0" cellpadding="0" cellspacing="0" style="margin:10px 0 0 30px;background-color: #F0F0F0;">

                <tr>
                    <td height="26" colspan="5" class="gradiante" style="color:white;font-size: 13px;padding: 0px 5px;margin: 0px;font-weight: bold;">Agencia - Editar Datos</td>
                </tr>                
                <tr>
                    <td height="3" colspan="5"  style="background:#fdb813;"></td>
                </tr>
                <tr>
                    <td height="10" colspan="5"  ></td>
                </tr>
                <tr>

                </tr>
                <tr>
                    <td class="label_info" >RUC:</td>
                    <td>
                        <input type="text" name="ruc_a" maxlength="11" id="ruc_a" style="text-transform:uppercase;" value="<?php echo $agencias[0]; ?>"/>
                        <span class="span-requerido">*</span>  
                    </td>
                    <td class="label_info">Apellido Paterno:</td>
                    <td>
                        <input type="text" name="apep_a" id="apep_a" style="text-transform:uppercase;" value="<?php echo $agencias[7]; ?>"/>
                        <span class="span-requerido">*</span>  
                    </td>
<!--                    <td  rowspan="2">
                        <button type="submit" style="cursor:pointer;" name="editar_agencia" id="editar_agencia" value="<?= $agencia_entidad->CodigoEntidad ?>" title="Guardar datos" >
                            <img  src="../images/disk-black.png" />
                        </button>
                    </td>-->
                    <td  rowspan="2">
                        <button style="cursor:pointer;" id="editar_agencia" onClick="event.preventDefault();" title="Guardar datos" >
                            <img  src="../images/disk-black.png" />
                        </button>
                    </td>
                </tr>
                <tr>
                    <td class="label_info">Razón Social:</td>
                    <td>
                        <input type="text" name="razon_social_a" id="razon_social_a" style="text-transform:uppercase;" value="<?php echo $agencias[10]; ?>"/>
                        <span class="span-requerido">*</span>  
                    </td>                    
                    <td class="label_info">Apellido Materno:</td>
                    <td>
                        <input type="text" name="apem_a" id="apem_a" style="text-transform:uppercase;" value="<?php echo $agencias[6]; ?>"/>
                        <span class="span-requerido">*</span>
                    </td>                
                </tr>
                <tr>
                    <td class="label_info">Nombre Comercial:</td>
                    <td>
                        <input type="text" name="nom_comer_a" id="nom_comer_a" style="text-transform:uppercase;" value="<?php echo $agencias[2]; ?>"/>
                        <span class="span-requerido">*</span>  
                    </td>                    
                    <td class="label_info">Nombres:</td>
                    <td>
                        <input type="text" name="nom_a" id="nom_a" style="text-transform:uppercase;" value="<?php echo $agencias[5] ?>"/>
                        <span class="span-requerido" >*</span>
                    </td>
                </tr>
                <tr>
                    <td class="label_info">País:</td>
                    <td class="span_info">
                        <select id="Code_Pais" name="Code_Pais" title="Seleccionar Pais" form="registrar-agencia">
                            <?php foreach ($obj_modelo->ObtenerPaises() as $key => $pais): ?>
                                <option <?= $pais->Code_Pais == 'PE' ? 'selected' : '' ?> value="<?= $pais->Code_Pais ?>"><?= $pais->Pais ?></option>
                            <?php endforeach ?>
                        </select>
                    </td>
                    <td class="label_info">DNI Funcionario:</td>
                    <td>
                        <input type="text" name="dni_a" maxlength="8" id="dni_a" style="text-transform:uppercase;" value="<?php echo $agencias[1]; ?>"/>
                        <span class="span-requerido">*</span>  
                    </td>                
                </tr>
                <tr>
                    <td class="label_info">Ciudad:</td>
                    <td>
                        <select id="ciudad_a" title="Seleccionar Ciudad">
                            <?php foreach ($obj_modelo->ObtenerLocalidades('PE') as $key => $ciudad): ?>
                                <option <?= $ciudad->Codigo == $agencias[13] ? 'selected' : '' ?> value="<?= $ciudad->Codigo ?>"><?= $ciudad->Nombre ?></option>
                            <?php endforeach ?>
                        </select>
                    </td>                    
                    <td class="label_info">Celular:</td>
                    <td>
                        <input type="text" maxlength="9" name="cel_a" id="cel_a" style="text-transform:uppercase;" value="<?php echo $agencias[9]; ?>"/>
                        <span class="span-requerido">*</span>  
                    </td>                
                </tr>
                <tr>
                    <td class="label_info">Domicilio Fiscal:</td>
                    <td>
                        <input type="text" name="domicilio_a" id="domicilio_a" style="text-transform:uppercase;" value="<?php echo $agencias[3]; ?>"/>
                        <span class="span-requerido">*</span>  
                    </td>                    
                    <td class="label_info">Email:</td>
                    <td>
                        <input type="text" name="email_a" id="email_a" style="text-transform:uppercase;" value="<?php echo $agencias[11]; ?>"/>
                        <span class="span-requerido">*</span>  
                    </td>                
                </tr>
                <tr>
                    <td class="label_info">Teléfono de Oficina:</td>
                    <td>
                        <input type="text" name="telefono_a" id="telefono_a" style="text-transform:uppercase;" value="<?php echo $agencias[8]; ?>"/>
                        <span class="span-requerido">*</span>  
                    </td>
                    <td  class="label_info" style="padding: 10px 10px 7px 0;">estado:</td>
                    <td>
                        <select name="estado" id="estado">
                            <option value="-1">- Seleccione estado -</option>
                            <option value="1" <?php if ($agencias[12] == 1) {
                                echo 'selected';
                            } ?> >Activo</option>
                            <option value="0" <?php if ($agencias[12] == 0) {
                                echo 'selected';
                            } ?> >Inactivo</option>
                        </select>
                    </td>
                    <td class=""></td>
                    <td>
                        <input type="hidden" name="codigo_entidad_a" id="codigo_entidad_a" style="text-transform:uppercase;" value="<?php echo $agencia_entidad->CodigoEntidad; ?>"/>
                        <!--<span class="hidden">*</span>-->  
                    </td>                
                </tr>
            </table>
        </div>
    </form>
</div>

<div id="div-panel-reset">
    <div id="div-reset-password">
        <p style="height:auto; margin:10px 0;">
            &iquest;Ha solicitado el 'reset' del password?. <img src="../images/unlock.png" width="32" height="32" alt="Reset Password" title="Reset Password">
        </p>
        <a class="aceptar" href="javascript:void(0);"><span onClick="resetPasswordDelegado(1);">Aceptar</span></a>
        <a class="cancelar" href="javascript:void(0);"><span onClick="resetPasswordDelegado(0);">Cancelar</span></a>
    </div>
</div>
<?php include(FOOTER_PATH); ?>
