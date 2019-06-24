<?php
	error_reporting(E_ALL);
	ini_set("display_errors",0);
	date_default_timezone_set('America/Lima'); 
	require_once("../../cn/STARPERU/Modelo/PersonalModelo.php");
	require_once("../../cn/STARPERU/Modelo/EmpresaModelo.php");

	$obj_personal=new PersonalModelo();
	$obj_empresa=new EmpresaModelo();

	if($_REQUEST['registrar_agencia']==1){
		$pass=  $obj_personal->generaPassword();
    	$password=$obj_personal->encrypt($pass, "");
		$RUC=$_REQUEST['RUC'];
		$RazonSocial=$_REQUEST['RazonSocial'];
		$NombreComercial=$_REQUEST['NombreComercial'];
		$CodigoCiudad=$_REQUEST['CodigoCiudad'];
		$Direccion=$_REQUEST['Direccion'];
		$TelefoniaOficina=$_REQUEST['TelefoniaOficina'];
		$ApellidoPaterno=$_REQUEST['ApellidoPaterno'];
		$ApellidoMaterno=$_REQUEST['ApellidoMaterno'];
		$Nombres=$_REQUEST['Nombres'];
		$DNIFuncionario=$_REQUEST['DNIFuncionario'];
		$Celular=$_REQUEST['Celular'];
		$Email=$_REQUEST['Email'];
		$registro=$obj_empresa->RegistarEmpresa($RUC,$RazonSocial,$NombreComercial,$Direccion,$CodigoCiudad,$DNIFuncionario,$ApellidoPaterno,$ApellidoMaterno,$Nombres,$Email,$TelefoniaOficina,$Celular);
		if ($registro==1) {
			$id=$obj_empresa->UltimaEmpresa();
			if ($id) {
				$pass=  $obj_personal->generaPassword();
            	$Password=$obj_personal->encrypt($pass, "");
				$usuario=$obj_personal->GuardaGestor($id,$DNIFuncionario,$ApellidoPaterno,$ApellidoMaterno,$Nombres,$Email,$Celular,$Password);
				if ($usuario==1) {
					//entidad y usuario registrado y enviar correo a edita.gadea@starperu.com
					$data['data']='ok';
					echo json_encode($data);
				}
				else{
					$data['data']='ok-error';
					echo json_encode($data);
				}
			}
			else{
				$data['data']='registro-error';
				echo json_encode($data);
			}
		}
		else{
			$data['data']='error';
			echo json_encode($data);
		}
		return;
	}
?>