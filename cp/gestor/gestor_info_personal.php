<?php 
	session_start();
	error_reporting(E_ALL);
	ini_set("display_errors",0);
	date_default_timezone_set('America/Lima');
	if($_SESSION['s_entra']==0){
	    header('Location:../../index.php');
	}
	$Tipo=$_SESSION['s_tipo'];
	$directorio='../';
	$directorio_imagen='../';
	require_once("../../config.php");
?>

<?php ob_start(); ?>
	<link href="<?=$url?>/cp/css/gestor.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript">
	</script>
	<?php $style_script_contenido = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php require_once(HTML_RECURSO_PATH); ?>
<br>
<div id="div-gestor">
    <table  width="900" border="0" cellpadding="0" cellspacing="0" style="margin: 0px auto;background-color: #F0F0F0;">
        <tr>
            <td height="26" colspan="4" class="gradiante" style="color:white;font-size: 13px;padding: 0px 5px;margin: 0px;font-weight: bold;">Usuario - Datos Personales</td>
        </tr>
        <tr>
            <td height="3" colspan="4"  style="background:#fdb813;"></td>
        </tr>
        <tr>
            <td height="10" colspan="4"  ></td>
        </tr>
        <tr>
        	<td  class="label_info">DNI:</td>
        	<td class="span_info">
        		<?php if($_SESSION['s_dni']!=''){ echo $_SESSION['s_dni'];}
        		else{ echo '<span style="font-style:italic;">[informaci&oacute;n no disponible]</span>';}?>
        	</td>
        </tr>
        <tr>
            <td class="label_info">apellido paterno:</td>
            <td class="span_info">
            	<?php if($_SESSION['s_apellido_paterno']!=''){ echo utf8_encode($_SESSION['s_apellido_paterno']);}
            	else{ echo '<span style="font-style:italic;">[informaci&oacute;n no disponible]</span>';}?>
        	</td>
        </tr>
    	<tr>
        	<td class="label_info">apellido materno:</td>
        	<td class="span_info">
        		<?php if($_SESSION['s_apellido_materno']!=''){ echo utf8_encode($_SESSION['s_apellido_materno']);}
        		else{ echo '<span style="font-style:italic;">[informaci&oacute;n no disponible]</span>';}?>
        	</td>
        </tr>
    	<tr>
        	<td class="label_info">nombre:</td>
        	<td class="span_info">
        		<?php if($_SESSION['s_nombre']!=''){ echo utf8_encode($_SESSION['s_nombre']);}
        		else{ echo '<span style="font-style:italic;">[informaci&oacute;n no disponible]</span>';}?>
    		</td>
        </tr>
        <tr>
        	<td class="label_info">email:</td>
        	<td class="span_info">
        		<?php if($_SESSION['s_email']!=''){ echo $_SESSION['s_email'];}
        		else{ echo '<span style="font-style:italic;">[informaci&oacute;n no disponible]</span>';}?>
    		</td>
        </tr>
        <tr>
            <td height="10" colspan="4"  ></td>
        </tr>
    </table>
    <br>
    <table width="900" border="0" cellpadding="0" cellspacing="0" style="margin: 0px auto;background-color: #F0F0F0;">
        <tr>
            <td height="26" colspan="4" class="gradiante" style="color:white;font-size: 13px;padding: 0px 5px;margin: 0px;font-weight: bold;">Usuario - Datos Adicionales</td>
        </tr>
        <tr>
            <td height="3" colspan="4"  style="background:#fdb813;"></td>
        </tr>
        <tr>
            <td height="10" colspan="4"  ></td>
        </tr>
        <tr>
        	<td class="label_info">tel&eacute;fono fijo:</td>
        	<td class="span_info">
        		<?php if($_SESSION['s_telefono_fijo']!=''){ echo $_SESSION['s_telefono_fijo'];}
        		else{ echo '<span style="font-style:italic;">[informaci&oacute;n no disponible]</span>';}?>
    		</td>
        </tr>
        <tr>
        	<td class="label_info">anexo:</td>
        	<td class="span_info">
        		<?php if($_SESSION['s_anexo']!=''){ echo $_SESSION['s_anexo'];}
        		else{ echo '<span style="font-style:italic;">[informaci&oacute;n no disponible]</span>';}?>
    		</td>
        </tr>
        <tr>
           	<td class="label_info">celular:</td>
           	<td class="span_info">
           		<?php if($_SESSION['s_celular']!=''){ echo $_SESSION['s_celular'];}
           		else{ echo '<span style="font-style:italic;">[informaci&oacute;n no disponible]</span>';}?>
       		</td>
        </tr>
        <tr>
            <td height="10" colspan="4"  ></td>
        </tr>
    </table>
</div>
<?php include(FOOTER_PATH); ?>