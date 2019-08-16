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
        $clave_encrypt= $obj_personal->encrypt($clave,"starperu");
        $Personal= $obj_personal->AutentificarPersonal($usuario,$clave_encrypt);
        // var_dump($Personal);die;
        if($Personal!=""){
            // $_SESSION["s_idusuario"] = $Personal->getCodigoPersonal();
            // $_SESSION["s_nombre"] = $Personal->getNombres();
            // $_SESSION["s_apellido_paterno"] = $Personal->getApellidoPaterno();
            // $_SESSION["s_apellido_materno"] = $Personal->getApellidoMaterno();
            // $_SESSION["s_email"] = $Personal->getEmail();
            // $_SESSION["s_dni"] = $Personal->getDNI();
            // $_SESSION["s_telefono_fijo"] = $Personal->getTelefonoOficina();
            // $_SESSION["s_anexo"] = $Personal->getAnexo();
            // $_SESSION["s_celular"] = $Personal->getCelular();
            // $_SESSION["s_rpm"] = $Personal->getRPM();
            // $_SESSION["s_rpc"] = $Personal->getRPC();
            // $_SESSION["s_nextel"] = $Personal->getNextel();
            // $_SESSION["s_entidad"] = $Personal->getCodigoEntidad();
            $_SESSION["s_idusuario"] = $Personal->CodigoPersonal;
            $_SESSION["s_nombre"] = $Personal->Nombres;
            $_SESSION["s_apellido_paterno"] = $Personal->ApellidoPaterno;
            $_SESSION["s_apellido_materno"] = $Personal->ApellidoMaterno;
            $_SESSION["s_email"] = $Personal->Email;
            $_SESSION["s_dni"] = $Personal->DNI;
            $_SESSION["s_telefono_fijo"] = $Personal->TelefonoOficina;
            $_SESSION["s_anexo"] = $Personal->Anexo;
            $_SESSION["s_celular"] = $Personal->Celular;
            $_SESSION["s_rpm"] = $Personal->RPM;
            $_SESSION["s_rpc"] = $Personal->RPC;
            $_SESSION["s_nextel"] = $Personal->Nextel;
            $_SESSION["s_entidad"] = $Personal->CodigoEntidad;
            // $razon_social= $obj_personal->ObtenerNombreEntidad($_SESSION["s_entidad"]);
            // if($razon_social!=""){
            // }
            $_SESSION["nombre_entidad"] =$Personal->RazonSocial;
            $_SESSION["s_cambio_clave"] = $Personal->CambioClave;
            $_SESSION["s_tipo"] = $Personal->CodigoTipo;
            $_SESSION["s_tipo2"] = $Personal->Tipo;
            
            $_SESSION["s_entra"] =1;
            $_SESSION["s_presentacion"] = 1;
            $_SESSION["s_personal"] = $Personal;
            $_SESSION["email_gestor"] = $obj_personal->ObtenerEmailGestor($Personal->CodigoEntidad);
            $_SESSION["s_agencia"] = $obj_agencia->ObtenerEmpresaFindID($Personal->CodigoEntidad);
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

if(isset($_POST['cambio_password'])){
    $obj_personal=new PersonalModelo();
    $Password=$_POST["password"];
    $clave_encrypt= $obj_personal->encrypt($Password,"starperu");
    $contrasena=$obj_personal->CambioContrasena($_SESSION["s_idusuario"],$clave_encrypt);
    if ($contrasena==1) {
        $_SESSION["s_cambio_clave"]=0;
    }
    echo json_encode(['code'=>$contrasena]);
}

if(isset($_POST['resetear_password'])){
    $obj_personal=new PersonalModelo();
    $documento=$_POST["documento"];
    $existe=$obj_personal->ConsultarUsuario($documento);
    if ($existe==1) {
        $pass=  $obj_personal->generaPassword();
        $clave_encrypt= $obj_personal->encrypt($pass,"starperu");
        $usuario=$obj_personal->ObtenerEmailUsuario($documento);
        if ($usuario) {
            $obj_personal->ResetearPassword($usuario->CodigoPersonal,$clave_encrypt);
            $obj_personal->EnvioMailResetPassword($usuario->Email,$usuario->ApellidoPaterno,$usuario->ApellidoMaterno,$usuario->Nombres,$documento,$pass);
            echo json_encode(['code'=>'200','email'=>$usuario->Email]);
        } else {
            echo json_encode(['code'=>'422']);
        }
    }
    else{
        echo json_encode(['code'=>'403']);
    }
}
?>
