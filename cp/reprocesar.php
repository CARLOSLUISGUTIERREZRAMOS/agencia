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
    require_once PATH_PROYECTO.'/cd/Controlador/PasarelaControl.php';
?>