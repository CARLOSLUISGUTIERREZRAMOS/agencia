<?php
    date_default_timezone_set('America/Lima');
    require_once("config.php");
    require_once(PATH_PROYECTO."/cn/STARPERU/Modelo/EmpresaModelo.php");
    require_once(PATH_PROYECTO."/cn/STARPERU/Modelo/PersonalModelo.php");
    if (isset($_REQUEST['token']) && $_REQUEST['token']!='') {
        $request=explode("|",$_REQUEST['token']);
        if (count($request)==3) {
            $obj_empresa=new EmpresaModelo();
            $obj_personal=new PersonalModelo();
            $token=$request[0];
            $entidad_id=$request[1];
            $user_id=$request[2];
            $reg=$obj_empresa->ObtenerTokenEmpresa($token,$entidad_id,$user_id);
            if ($reg==1) {
                $delete=$obj_empresa->EliminarTokenEmpresa($token,$entidad_id,$user_id);
                if ($delete==1) {
                    $obj_empresa->ActualizarEstadoEmpresa($entidad_id);
                    $obj_personal->ActualizarEstadoUsuario($user_id);
                    header('Location:'.URL_PROYECTO.'/index.php?flag=procesado');
                }
                else {
                    header('Location:'.URL_PROYECTO.'/index.php?flag=no-procesado');
                }
            }
            else {
                header('Location:'.URL_PROYECTO.'/index.php?flag=not-found');
            }
        }
        else{
            header('Location:'.URL_PROYECTO.'/index.php?flag=no-token');
        }
    }
    else{
        header('Location:'.URL_PROYECTO);
    }
?>