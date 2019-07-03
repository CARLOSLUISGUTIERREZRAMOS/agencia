<?php 
	session_start();
	error_reporting(E_ALL);
	ini_set("display_errors",0);
	date_default_timezone_set('America/Lima');
	if($_SESSION['s_entra']==0){
	    header('Location:../../index.php');
	}
	require_once("../../cd/Controlador/DelegadoControl.php");
	$Tipo=$_SESSION['s_tipo'];
	$directorio='../';
	$directorio_imagen='../';
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
  		<a href="delegado_registro.php" class="btn btn-dark" style="margin: 10px 0 0 30px;">Registrar Usuario</a>
    	<?php echo $tabla_info_delegado;?>
	</div>
</div>
<?php include(FOOTER_PATH); ?>