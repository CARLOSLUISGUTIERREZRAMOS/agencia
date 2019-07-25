<?php 
	// session_start();
    // date_default_timezone_set('America/Lima');
    require_once("../../config.php");
	require_once(PATH_PROYECTO."/cn/STARPERU/Modelo/LocalidadModelo.php");
    
    if (isset($_REQUEST['localidad']) && $_REQUEST['localidad']==1) {
        $obj_localidad=new LocalidadModelo();
        $localidades=$obj_localidad->ObtenerLocalidades($_REQUEST['Code_Pais']);
        echo json_encode($localidades);
    }
?>