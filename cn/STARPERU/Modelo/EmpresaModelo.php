<?php

use ___PHPSTORM_HELPERS\object;

if (isset($url_proyecto)) {
    require_once(PATH_PROYECTO . "/cn/STARPERU/Conexion/ConexionBD.php");
    require_once(PATH_PROYECTO . "/cn/STARPERU/Entidades/EmpresaEntidad.php");
} else {
    require_once("../../cn/STARPERU/Conexion/ConexionBD.php");
    require_once("../../cn/STARPERU/Entidades/EmpresaEntidad.php");
}

class EmpresaModelo {

    private $basedatos = 'db_agencia';

    public function ObtenerNombreEntidad($codigo_entidad) {

        $obj_conexion = new ConexionBD();
        $conexion = $obj_conexion->CrearConexion();
        $consulta = "SELECT RazonSocial FROM Entidad WHERE CodigoEntidad=$codigo_entidad";

        $resultado = $obj_conexion->ConsultarDatos($consulta, $this->basedatos, $conexion);
        $numero_filas = $obj_conexion->ContarFilas($resultado);
        $fila = $obj_conexion->ObtenerDatos($resultado);
        if ($numero_filas > 0) {
            $empresa = new EmpresaEntidad();
            $empresa->setRazonSocial($fila['RazonSocial']);
            $obj_conexion->CerrarConexion($conexion);

            return $empresa;
        } else {
            return "";
        }
    }

    public function ObtenerRucEmpresa($codigo_entidad) {

        $obj_conexion = new ConexionBD();
        $conexion = $obj_conexion->CrearConexion();
        $consulta = "SELECT RUC FROM Entidad WHERE CodigoEntidad=$codigo_entidad";

        $resultado = $obj_conexion->ConsultarDatos($consulta, $this->basedatos, $conexion);
        $numero_filas = $obj_conexion->ContarFilas($resultado);
        $fila = $obj_conexion->ObtenerDatos($resultado);
        if ($numero_filas > 0) {
            $empresa = new EmpresaEntidad();
            $empresa->setRUC($fila['RUC']);
            $obj_conexion->CerrarConexion($conexion);

            return $empresa;
        } else {
            return "";
        }
    }

    public function ObtenerEmpresaPermitida($dni_personal) {

        $obj_conexion = new ConexionBD();
        $conexion = $obj_conexion->CrearConexion();
        $consulta = "SELECT e.EstadoRegistro FROM Entidad e, Personal p "
                . "WHERE e.CodigoEntidad=p.CodigoEntidad AND p.CodigoUsuario = '$dni_personal' AND p.EstadoRegistro=1";

        $resultado = $obj_conexion->ConsultarDatos($consulta, $this->basedatos, $conexion);
        $fila = $obj_conexion->ObtenerDatos($resultado);
        if ($fila['EstadoRegistro'] == 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function RegistarEmpresa($RUC, $RazonSocial, $NombreComercial, $Direccion, $CodigoCiudad, $DNIFuncionario, $ApellidoPaterno, $ApellidoMaterno, $Nombres, $Email, $TelefoniaOficina, $Celular) {
        $flag = 0;
        $obj_conexion = new ConexionBD();
        $conexion = $obj_conexion->CrearConexion();
        $consulta = "INSERT INTO entidad (RUC,RazonSocial,NombreComercial,Direccion,CodigoCiudad,DNIFuncionario,ApellidoPaterno,ApellidoMaterno,Nombres,Email,TelefoniaOficina,Celular,EstadoRegistro)
                   VALUES ('$RUC','$RazonSocial','$NombreComercial','$Direccion','$CodigoCiudad','$DNIFuncionario','$ApellidoPaterno','$ApellidoMaterno','$Nombres','$Email','$TelefoniaOficina','$Celular',0)";
        $obj_conexion->ConsultarDatos($consulta, $this->basedatos, $conexion);
        $error = $obj_conexion->ErrorEjecucion($conexion);
        if ($error == 1) {
            $flag = 1;
        }
        $obj_conexion->CerrarConexion($conexion);
        return $flag;
    }

    public function RegistarTokenEmpresa($token, $empresa, $usuario) {
        $flag = 0;
        $obj_conexion = new ConexionBD();
        $conexion = $obj_conexion->CrearConexion();
        $consulta = "INSERT INTO confirmacion_token (token,entidad_id,user_id) VALUES ('$token',$empresa,$usuario)";
        $obj_conexion->ConsultarDatos($consulta, $this->basedatos, $conexion);
        $error = $obj_conexion->ErrorEjecucion($conexion);
        if ($error == 1) {
            $flag = 1;
        }
        $obj_conexion->CerrarConexion($conexion);
        return $flag;
    }

    public function ObtenerTokenEmpresa($token, $empresa, $usuario) {
        $flag = 0;
        $obj_conexion = new ConexionBD();
        $conexion = $obj_conexion->CrearConexion();
        $consulta = "SELECT * FROM confirmacion_token WHERE token='$token' AND entidad_id=$empresa AND user_id=$usuario";
        $resultado = $obj_conexion->ConsultarDatos($consulta, $this->basedatos, $conexion);
        $numero_filas = $obj_conexion->ContarFilas($resultado);
        // $fila=  $obj_conexion->ObtenerDatos($resultado);
        if ($numero_filas > 0) {
            $flag = 1;
            $obj_conexion->CerrarConexion($conexion);
        }
        return $flag;
    }

    public function EliminarTokenEmpresa($token, $empresa, $usuario) {
        $flag = 0;
        $obj_conexion = new ConexionBD();
        $conexion = $obj_conexion->CrearConexion();
        $consulta = "DELETE FROM confirmacion_token WHERE token='$token' AND entidad_id=$empresa AND user_id=$usuario";
        $obj_conexion->ConsultarDatos($consulta, $this->basedatos, $conexion);
        $error = $obj_conexion->ErrorEjecucion($conexion);
        if ($error == 1) {
            $flag = 1;
        }
        $obj_conexion->CerrarConexion($conexion);
        return $flag;
    }

    public function ActualizarEstadoEmpresa($CodigoEntidad) {
        $flag = 1;
        $obj_conexion = new ConexionBD();
        $conexion = $obj_conexion->CrearConexion();
        $consulta = "UPDATE entidad SET EstadoRegistro=1 WHERE CodigoEntidad=$CodigoEntidad";
        $obj_conexion->ConsultarDatos($consulta, $this->basedatos, $conexion);
        $error = $obj_conexion->ErrorEjecucion($conexion);
        if ($error == 1) {
            $flag = 0;
        }
        $obj_conexion->CerrarConexion($conexion);
        return $flag;
    }

    public function UltimaEmpresa() {
        $obj_conexion = new ConexionBD();
        $conexion = $obj_conexion->CrearConexion();
        $consulta = "SELECT CodigoEntidad FROM entidad ORDER BY CodigoEntidad DESC LIMIT 1";
        $resultado = $obj_conexion->ConsultarDatos($consulta, $this->basedatos, $conexion);
        $numero_filas = $obj_conexion->ContarFilas($resultado);
        $fila = $obj_conexion->ObtenerDatos($resultado);
        if ($numero_filas > 0) {
            return $fila['CodigoEntidad'];
            $obj_conexion->CerrarConexion($conexion);
        } else {
            return "";
        }
    }

    public function ActualizarLogoEmpresa($CodigoEntidad, $LogoEntidad) {
        $flag = 0;
        $obj_conexion = new ConexionBD();
        $conexion = $obj_conexion->CrearConexion();
        $consulta = "UPDATE entidad SET LogoEntidad='$LogoEntidad' WHERE CodigoEntidad=$CodigoEntidad";
        $obj_conexion->ConsultarDatos($consulta, $this->basedatos, $conexion);
        $error = $obj_conexion->ErrorEjecucion($conexion);
        if ($error == 1) {
            $flag = 1;
        }
        $obj_conexion->CerrarConexion($conexion);
        return $flag;
    }

    public function ObtenerEmpresa($Limit = null) {
        $flag = 0;
        $obj_conexion = new ConexionBD();
        $conexion = $obj_conexion->CrearConexion();
        $consulta = "SELECT * FROM entidad ORDER BY CodigoEntidad ASC ";
        if ($Limit) {
            $consulta .= " LIMIT  $Limit";
        }
        $resultado = $obj_conexion->ConsultarDatos($consulta, $this->basedatos, $conexion);
        $numero_filas = $obj_conexion->ContarFilas($resultado);
        if ($numero_filas > 0) {
            $dato = array();
            while ($fila = $obj_conexion->ObtenerDatos($resultado)) {
                $obj = new stdClass();
                foreach ($fila as $name => $value) {
                    $obj->{$name} = $value;
                }
                $dato[] = $obj;
            }
            $obj_conexion->CerrarConexion($conexion);
            return $dato;
        } else {
            return 'Sin datos';
        }
    }

    public function ObtenerEmpresaFindID($CodigoEntidad) {
        $flag = 0;
        $obj_conexion = new ConexionBD();
        $conexion = $obj_conexion->CrearConexion();
        $consulta = "SELECT * FROM entidad WHERE CodigoEntidad=$CodigoEntidad";
        $resultado = $obj_conexion->ConsultarDatos($consulta, $this->basedatos, $conexion);
        $numero_filas = $obj_conexion->ContarFilas($resultado);
        $filas = $obj_conexion->ObtenerDatos($resultado);
        if ($numero_filas > 0) {
            $obj = new stdClass();
            foreach ($filas as $name => $value) {
                $obj->{$name} = $value;
            }
            $obj_conexion->CerrarConexion($conexion);
            return $obj;
        } else {
            return 'Sin datos';
        }
    }

    public function VerificarRucEmpresa($ruc) {

        $obj_conexion = new ConexionBD();
        $conexion = $obj_conexion->CrearConexion();
        $consulta = "SELECT RUC,RazonSocial FROM entidad WHERE RUC=$ruc";

        $resultado = $obj_conexion->ConsultarDatos($consulta, $this->basedatos, $conexion);
        $numero_filas = $obj_conexion->ContarFilas($resultado);
        $fila = $obj_conexion->ObtenerDatos($resultado);

        if ($numero_filas > 0) {
            return $fila;
            $obj_conexion->CerrarConexion($conexion);
        } else {
            return ['data' => 'vacio'];
        }
    }

    public function EditarAgencia($estado, $CodigoEntidad, $ruc, $apellido_paterno, $razon_social, $apellido_materno, $nombre_comercial, $nombres, $DNIFuncionario, $ciudad, $celular, $domicilio_fiscal, $email, $telefono_oficina) {
        $obj_conexion = new ConexionBD();
        $conexion = $obj_conexion->CrearConexion();
        $consulta = "UPDATE Entidad SET RUC='$ruc', ApellidoPaterno='$apellido_paterno',RazonSocial='$razon_social',ApellidoMaterno='$apellido_materno',
            NombreComercial='$nombre_comercial',Nombres='$nombres',DNIFuncionario='$DNIFuncionario',CodigoCiudad='$ciudad',Celular='$celular',
            Direccion= '$domicilio_fiscal',Email='$email',TelefoniaOficina='$telefono_oficina',EstadoRegistro='$estado' WHERE CodigoEntidad='$CodigoEntidad'";
        $obj_conexion->ConsultarDatos($consulta, $this->basedatos, $conexion);
//        var_dump($consulta); 
        $error = $obj_conexion->ErrorEjecucion($conexion);
        if ($error == 1) {
            $flag = 1;
        }
        $obj_conexion->CerrarConexion($conexion);
        return $flag;
    }

    public function ObtenerAgencia($CodigoEntidad) {
        $agencias = array();
        $obj_conexion = new ConexionBD();
        $conexion = $obj_conexion->CrearConexion();

        $consulta = "SELECT * FROM entidad WHERE CodigoEntidad=$CodigoEntidad";

        $resultado = $obj_conexion->ConsultarDatos($consulta, $this->basedatos, $conexion);
        $numero_filas = $obj_conexion->ContarFilas($resultado);

        $cant = 0;
        if ($numero_filas > 0) {

            while ($fila = $obj_conexion->ObtenerDatos($resultado)) {

                $agencia = array();
                $empresa = new EmpresaEntidad();
                $ruc = '';
                $dni = '';
                $nom_comercial = '';
                $direccion = '';
                $codigo_ciudad = '';
                $nombres = '';
                $ape_materno = '';
                $ape_paterno = '';
                $tel_oficina = '';
                $celular = '';
                $razon_social = '';
                $email = '';
                $estado = '';
                $ciudad = '';

                $ruc = $fila['RUC'];
                $dni = $fila['DNIFuncionario'];
                $nom_comercial = $fila['NombreComercial'];
                $direccion = $fila['Direccion'];
                $codigo_ciudad = $fila['CodigoCiudad'];
                $nombres = $fila['Nombres'];
                $ape_materno = $fila['ApellidoMaterno'];
                $ape_paterno = $fila['ApellidoPaterno'];
                $tel_oficina = $fila['TelefoniaOficina'];
                $celular = $fila['Celular'];
                $razon_social = $fila['RazonSocial'];
                $email = $fila['Email'];
                $estado = $fila['EstadoRegistro'];
                $ciudad = $fila['CodigoCiudad'];

                $agencias[] = $ruc;
                $agencias[] = $dni;
                $agencias[] = $nom_comercial;
                $agencias[] = $direccion;
                $agencias[] = $codigo_ciudad;
                $agencias[] = $nombres;
                $agencias[] = $ape_materno;
                $agencias[] = $ape_paterno;
                $agencias[] = $tel_oficina;
                $agencias[] = $celular;
                $agencias[] = $razon_social;
                $agencias[] = $email;
                $agencias[] = $estado;
                $agencias[] = $ciudad;
            }
            $obj_conexion->CerrarConexion($conexion);
            return $agencias;
        }
    }

    public function ObtenerNombreCiudad($codigoCiudad, $codigoEntidad) {
        $obj_conexion = new ConexionBD();
        $conexion = $obj_conexion->CrearConexion();
        $consulta = "SELECT L.Nombre,L.Codigo,L.Pais FROM  entidad as E, localidades as L where L.Codigo='$codigoCiudad' AND E.CodigoEntidad=$codigoEntidad";

        $resultado = $obj_conexion->ConsultarDatos($consulta, $this->basedatos, $conexion);
        $numero_filas = $obj_conexion->ContarFilas($resultado);
         if ($numero_filas > 0) {
            while ($fila = $obj_conexion->ObtenerDatos($resultado)) {
            $ciudad = array();
            $nombre_ciudad = '';
            $codigo_ciudad = '';
            $pais = '';
            $nombre_ciudad = $fila['Nombre'];
            $codigo_ciudad = $fila['Codigo'];
            $pais = $fila['Pais'];
            $ciudad[] = $nombre_ciudad;
            $ciudad[] = $codigo_ciudad;
            $ciudad[] = $pais;
            }
            $obj_conexion->CerrarConexion($conexion);
            return $ciudad;
        }
    }
}
?>

