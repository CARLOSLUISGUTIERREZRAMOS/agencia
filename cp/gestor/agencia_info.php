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
	$agencia_entidad=$_SESSION['s_agencia'];
	require_once("../../config.php");
?>

<?php ob_start(); ?>
	<link href="<?=$url?>/cp/css/gestor.css" rel="stylesheet" type="text/css" />
	<script src="<?=$url?>/cp/js/ajax/funcionesGestorDelegado.js"></script>
	<?php $style_script_contenido = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php require_once(HTML_RECURSO_PATH); ?>
<div style="margin:0px auto; width:1000px;">
  	<br>
	<div id="div-delegado" style="width:1000px;">
    	<!-- <?php echo $tabla_info_delegado;?> -->
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
					<td class="label_info">RUC:</td>
					<td class="span_info">
						<?= $agencia_entidad->RUC ? $agencia_entidad->RUC : '-'?>
					</td>
					<td rowspan="2">
						<button style="cursor:pointer;" onclick="event.preventDefault();editar_agencia(<?= $agencia_entidad->CodigoEntidad?>);" title="Editar datos"><img src="../images/pencil.png">
						</button>
					</td>
				</tr>
				<tr>
					<td class="label_info">agencia:</td>
					<td class="span_info"><?= $agencia_entidad->NombreComercial ? $agencia_entidad->NombreComercial : '-' ?></td>
				</tr>
				<tr>
					<td class="label_info">razon social:</td>
					<td class="span_info"><?= $agencia_entidad->RazonSocial ? $agencia_entidad->RazonSocial : '-'?></td>
				</tr>
				<tr>
					<td class="label_info">Abreviatura:</td>
					<td class="span_info"><?= $agencia_entidad->Abreviatura ? $agencia_entidad->Abreviatura : '-'?></td>
				</tr>
				<tr>
					<td class="label_info">ciudad:</td>
					<td class="span_info"><?= $agencia_entidad->CodigoCiudad ? $agencia_entidad->CodigoCiudad : '-'?></td>
				</tr>
				<tr>
					<td class="label_info">dirección:</td>
					<td class="span_info"><?= $agencia_entidad->Direccion ? $agencia_entidad->Direccion : '-'?></td>
				</tr>
				<tr>
					<td class="label_info">teléfono oficina:</td>
					<td class="span_info"><?= $agencia_entidad->TelefoniaOficina ? $agencia_entidad->TelefoniaOficina : '-'?></td>
				</tr>
				<tr>
					<td class="label_info">anexo:</td>
					<td class="span_info"><?= $agencia_entidad->Anexo ? $agencia_entidad->Anexo : '-'?></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<?php include(FOOTER_PATH); ?>