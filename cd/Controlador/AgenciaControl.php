<?php

session_start();
error_reporting(E_ALL);
ini_set("display_errors", 0);
date_default_timezone_set('America/Lima');
require_once("../../cn/STARPERU/Modelo/EmpresaModelo.php");
require_once("../../config.php");

$obj_empresa = new EmpresaModelo();

if (isset($_REQUEST['cambiar_logo']) && $_REQUEST['cambiar_logo'] == 1) {
    $CodigoEntidad = (int) $_REQUEST['CodigoEntidad'];
    $valid_extensions = array('jpeg', 'jpg', 'png'); // valid extensions
    $path = '../../cp/images/uploads/'; // upload directory
    $name = '/cp/images/uploads/';
    if ($_FILES['LogoEntidad']) {
        $img = $_FILES['LogoEntidad']['name'];
        $tmp = $_FILES['LogoEntidad']['tmp_name'];
        // get uploaded file's extension
        $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
        $final_image = time() . str_replace(' ', '_', $img);
        // check's valid format
        if (in_array($ext, $valid_extensions)) {
            $path = $path . strtolower($final_image);
            $name = $name . strtolower($final_image);
            if (move_uploaded_file($tmp, $path)) {
                $agencia = $obj_empresa->ObtenerEmpresaFindID($CodigoEntidad);
                if ($agencia->LogoEntidad) {
                    if (file_exists('../..' . $agencia->LogoEntidad)) {
                        unlink('../..' . $agencia->LogoEntidad);
                    }
                }
                $registro = $obj_empresa->ActualizarLogoEmpresa($CodigoEntidad, $name);
                if ($registro == 0) {
                    $data['error'] = 'Error al intentar actualizar logo';
                    echo json_encode($data);
                } else {
                    $_SESSION['s_logo_entidad'] = $name;
                    $data['success'] = 'Success';
                    echo json_encode($data);
                }
            } else {
                $data['error'] = 'Error al intentar mover la imagen';
                echo json_encode($data);
            }
        } else {
            $data['error'] = 'Imagen seleccionado no es válido';
            echo json_encode($data);
        }
    } else {
        $data['error'] = 'Seleccione una Imagen';
        echo json_encode($data);
    }
}

if ($_REQUEST['prueba'] == 1) {
    // $registro=$obj_empresa->ObtenerEmpresa(3);
    $registro = $obj_empresa->ObtenerEmpresaFindID(311);
    var_dump($registro->LogoEntidad);
    // var_dump(str_replace(' ', '_', 'hola como estas'));
}

if ($_POST['editar_agencia'] == 1) {
//          var_dump($_POST['editar_agencia']);
//            require_once '../Funciones/funciones.php';
//            
    $estado = trim($_POST['estado']);
    $CodigoEntidad = $_POST['codigo_entidad'];
    $ruc = trim($_POST['ruc']);
    $apellido_paterno = utf8_decode(trim($_POST['apep']));
    $razon_social = utf8_decode(trim($_POST['razon_social']));
    $apellido_materno = utf8_decode(trim($_POST['apem']));
    $nombre_comercial = utf8_decode(trim($_POST['nom_comercial']));
    $nombres = utf8_decode($_POST['nombres']);
    $pais = "";
    $DNIFuncionario = trim($_POST['dni']);
    $ciudad = utf8_decode(trim($_POST['ciudad']));
    $celular = trim($_POST['celular']);
    $domicilio_fiscal = utf8_decode(trim($_POST['domicilio']));
    $email = strtolower(trim($_POST['email']));
    $telefono_oficina = trim($_POST['telefono']);
    if (!preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $email)) {
        echo "4_|_";
        die;
    }
    $filas_afectadas = $obj_empresa->EditarAgencia($estado,$CodigoEntidad, $ruc, $apellido_paterno, $razon_social, $apellido_materno, $nombre_comercial, $nombres, $DNIFuncionario, $ciudad, $celular, $domicilio_fiscal, $email, $telefono_oficina);
    if ($filas_afectadas == 1) {
        echo '1_|_';
    } else {
        echo '2_|_';
    }
}
?>