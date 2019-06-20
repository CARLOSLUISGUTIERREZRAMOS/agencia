<?php
session_start();

require_once("../../cn/STARPERU/Modelo/PersonalModelo.php");

$obj_personal=new PersonalModelo();

if($_POST['mensaje']==1){
    $_SESSION['s_presentacion']=0;  
    header('Location:../../cp/panel.php');
}
if(isset($_POST['cambio'])){
if($_POST['cambio']==1){
        $flag=0;
        $contra1=$_POST['txtseguridad'];
        $contra2=$_POST['txtconfirma'];
        if($contra1==$contra2){
            $usuario=$_SESSION['s_idusuario'];
            $contrasena=$obj_personal->encrypt($contra1, "$starperu");
            $flag=$obj_personal->CambioContrasena($usuario, $contrasena);
            if($flag==1){
                session_destroy();
                header('Location:../../index.php');
            }else{
                header('Location:../../cp/panel.php');
            }
        }else{
            header('Location:../../cp/panel.php');
        }
        
}
}

?>
