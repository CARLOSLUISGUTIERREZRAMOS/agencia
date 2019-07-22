<?php
	// error_reporting(E_ALL);
	// ini_set("display_errors",0);
	date_default_timezone_set('America/Lima');
	require_once("../../cn/STARPERU/Modelo/PersonalModelo.php");
	require_once("../../cn/STARPERU/Modelo/EmpresaModelo.php");

	$obj_personal=new PersonalModelo();
	$obj_empresa=new EmpresaModelo();

	if(isset($_REQUEST['registrar_agencia']) && $_REQUEST['registrar_agencia']==1){
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
		$Usuario=substr($RUC, 0,2).$DNIFuncionario;
		$registro=$obj_empresa->RegistarEmpresa($RUC,$RazonSocial,$NombreComercial,$Direccion,$CodigoCiudad,$DNIFuncionario,$ApellidoPaterno,$ApellidoMaterno,$Nombres,$Email,$TelefoniaOficina,$Celular);
		if ($registro==1) {
			$id=$obj_empresa->UltimaEmpresa();
			if ($id) {
				$pass=  $obj_personal->generaPassword();
            	$Password=$obj_personal->encrypt($pass, "s");
				$usuario=$obj_personal->GuardaUsuario($id,$DNIFuncionario,$ApellidoPaterno,$ApellidoMaterno,$Nombres,$Email,$Celular,$Password,$Usuario,'G','administrador');
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

	if (isset($_REQUEST['verificar_ruc']) && $_REQUEST['verificar_ruc']==1) {
		$RUC=$_REQUEST['RUC'];
		$registro=$obj_empresa->VerificarRucEmpresa($RUC);
		echo json_encode($registro);
		return;
	}

	if (isset($_REQUEST['prueba']) && $_REQUEST['prueba']==1) {
		$pass=  $obj_personal->generaPassword();
        $p1=$obj_personal->encrypt($pass, "");
        echo $p1;
        echo '<br>------------<br>';
        echo $obj_personal->decrypt($p1, "");
	}
?>