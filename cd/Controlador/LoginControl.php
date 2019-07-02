<?php
session_start();
require_once("../../cn/STARPERU/Modelo/PersonalModelo.php");
require_once("../../cn/STARPERU/Modelo/EmpresaModelo.php");



if(isset($_POST['login'])){

    $obj_personal=new PersonalModelo();
    $obj_agencia=new EmpresaModelo();
    if($_POST['login']==1){
        if (isset($_POST['usuario'])) {
            $usuario = (get_magic_quotes_gpc()) ? $_POST['usuario'] : addslashes($_POST['usuario']);
        }

        if (isset($_POST['password'])) {
            $clave = (get_magic_quotes_gpc()) ? $_POST['password'] : addslashes($_POST['password']);
        }

            $clave_encrypt= $obj_personal->encrypt($clave,"$starperu");
            $Personal= $obj_personal->AutentificarPersonal($usuario,$clave_encrypt);

            if($Personal!=""){

                $_SESSION["s_entra"] =1;
                $_SESSION["s_idusuario"] = $Personal->getCodigoPersonal();
                $_SESSION["s_nombre"] = $Personal->getNombres();
                $_SESSION["s_apellido_paterno"] = $Personal->getApellidoPaterno();
                $_SESSION["s_apellido_materno"] = $Personal->getApellidoMaterno();
                $_SESSION["s_email"] = $Personal->getEmail();
                $_SESSION["s_dni"] = $Personal->getDNI();
                $_SESSION["s_telefono_fijo"] = $Personal->getTelefonoOficina();
                $_SESSION["s_anexo"] = $Personal->getAnexo();
                $_SESSION["s_celular"] = $Personal->getCelular();
                $_SESSION["s_rpm"] = $Personal->getRPM();
                $_SESSION["s_rpc"] = $Personal->getRPC();
                $_SESSION["s_nextel"] = $Personal->getNextel();
                $_SESSION["s_entidad"] = $Personal->getCodigoEntidad();
                $razon_social= $obj_personal->ObtenerNombreEntidad($_SESSION["s_entidad"]);
                $agencia=$obj_agencia->ObtenerEmpresaFindID($_SESSION["s_entidad"]);
                $_SESSION["s_logo_entidad"] = $agencia->LogoEntidad;
                if($razon_social!=""){
                    $_SESSION["nombre_entidad"] =$razon_social;
                }
                $_SESSION["s_presentacion"] = 1;
                $_SESSION["s_cambio_clave"] = $Personal->getCambioClave();
                $_SESSION["s_tipo"] = $Personal->getCodigoTipo();
                $_SESSION["email_gestor"] = $obj_personal->ObtenerEmailGestor($_SESSION["s_entidad"]);
                header('Location:../../cp/panel.php');


            }else{
                $_SESSION["s_entra"] =0;
                header('Location:../../index.php');
            }

    }
}

if(isset($_POST['deuda'])){
    if ($_POST['deuda']==1){
        $usuario = (get_magic_quotes_gpc()) ? $_POST['usuario'] : addslashes($_POST['usuario']);
        $empresa = new EmpresaModelo();

        $deuda = $empresa->ObtenerEmpresaPermitida($usuario);
        echo $deuda.'*3';
    }
}

?>
