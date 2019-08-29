<?php 
    session_start();
    // error_reporting(E_ALL);
    // ini_set("display_errors", 0);
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
    // var_dump(isset($_POST['transactionToken']));die;
    if (!isset($_POST['transactionToken']) || !isset($_SESSION['registro_id'])) {
        header('Location:'.$url.'/cp/panel.php');
    }
?>

<?php ob_start(); ?>
    <link href="<?=$url?>/cp/pasarela/css/style.css" rel="stylesheet" type="text/css" media="all">
    <link href="<?=$url?>/cp/pasarela/css/jquery/jquery.ui.all.css" rel="stylesheet" type="text/css" />
    <link href="<?=$url?>/cp/pasarela/js/thickbox/thickbox.css" rel="stylesheet" type="text/css" />
    <link href="<?=$url?>/cp/pasarela/css/estilos.css" rel="stylesheet" type="text/css" />
    <?php $style_script_contenido = ob_get_contents(); ?>
<?php ob_end_clean(); ?>


<?php require_once(HTML_RECURSO_PATH); ?>
<table width="100%" cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td>
            <!-- <table width="1000" align="center" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td>
                        
                        <br>
                    </td>
                </tr>
            </table> -->
            <?php require_once PATH_PROYECTO.'/cp/pasarela/metodos_pago.php'; ?> 
        </td>
    </tr>
</table>
<?php include(FOOTER_PATH); ?>