<?php 
	session_start();
	error_reporting(E_ALL);
	ini_set("display_errors",0);
	date_default_timezone_set('America/Lima');
	require_once("../../cn/STARPERU/Modelo/EmpresaModelo.php");

	$obj_empresa=new EmpresaModelo();

	if(isset($_REQUEST['cambiar_logo']) && $_REQUEST['cambiar_logo']==1){
		// $LogoEntidad=$_REQUEST['LogoEntidad'];
		$CodigoEntidad=$_REQUEST['CodigoEntidad'];
		$valid_extensions = array('jpeg', 'jpg', 'png'); // valid extensions
		$path = '../../cp/images/uploads/'; // upload directory
		if($_FILES['LogoEntidad']){
			$img = $_FILES['LogoEntidad']['name'];
			$tmp = $_FILES['LogoEntidad']['tmp_name'];
			// get uploaded file's extension
			$ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
			// can upload same image using rand function
			$final_image = time().$img;
			// check's valid format
			if(in_array($ext, $valid_extensions)) {
				$path = $path.strtolower($final_image); 
				if(move_uploaded_file($tmp,$path)) {
					$registro=$obj_empresa->ActualizarLogoEmpresa($CodigoEntidad,$path);
					if ($registro==1) {
						$data['error']='Error al intentar actualizar logo';
						echo json_encode($data);
					}
					else{
						$data['success']='Success';
						echo json_encode($data);
					}
				}
				else{
					$data['error']='Error al intentar mover la imagen';
					echo json_encode($data);
				}
			} 
			else {
				$data['error']='Imagen seleccionado no es válido'
				echo json_encode($data);
			}
		}
		else{
			$data['error']='Seleccione una Imagen'
			echo json_encode($data);
		}
	}
?>