<?php
session_start();
error_reporting(E_ALL);
ini_set("display_errors",0);
date_default_timezone_set('America/Lima');
require_once("../../cn/STARPERU/Modelo/PersonalModelo.php");

$obj_personal=new PersonalModelo();


if ($_POST['listar'] == 1) {

    $lista_delegados = array();
    $lista_delegados = $obj_personal->ListaDelegados($_SESSION['s_entidad']);
    if (count($lista_delegados) == 0) {
        echo '';
    } else {
        $tabla_delegados = '<table class="table" border="0" cellpadding="0" cellspacing="0" style="background-color: #F0F0F0;">' . "\n";
        $tabla_delegados .= '<tr>' . "\n";
        $tabla_delegados .= '<td height="26" colspan="14" class="gradiante" style="color:white;font-size: 13px;padding: 0px 5px;margin: 0px;font-weight: bold;">Datos de Agencia</td>' . "\n";
        $tabla_delegados .= '</tr>' . "\n";
        $tabla_delegados .= '<tr>' . "\n";
        $tabla_delegados .= '<td height="3" colspan="14"  style="background:#fdb813;"></td>' . "\n";
        $tabla_delegados .= '</tr>' . "\n";
        $tabla_delegados .= '<tr >' . "\n";
        $tabla_delegados .= '<th class="subtitleTabla">DNI</th>' . "\n";
        $tabla_delegados .= '<th class="subtitleTabla">Razón Social</th>' . "\n";
        $tabla_delegados .= '<th class="subtitleTabla">Dirección</th>' . "\n";
        $tabla_delegados .= '<th class="subtitleTabla">RUC</th>' . "\n";
        $tabla_delegados .= '<th class="subtitleTabla">Apellidos</th>' . "\n";
        $tabla_delegados .= '<th class="subtitleTabla">Nombre</th>' . "\n";
        $tabla_delegados .= '<th class="subtitleTabla">Email</th>' . "\n";
        $tabla_delegados .= '<th class="subtitleTabla">Tel. Oficina</th>' . "\n";
        $tabla_delegados .= '<th class="subtitleTabla">Anexo</th>' . "\n";
        $tabla_delegados .= '<th class="subtitleTabla">Celular</th>' . "\n";
        $tabla_delegados .= '<th class="subtitleTabla">Estado</th>' . "\n";
        $tabla_delegados .= '<th colspan="3" class="subtitleTabla">Opciones</th>' . "\n";
        $tabla_delegados .= '</tr>' . "\n";
        foreach ($lista_delegados as $delegado) {
            $tabla_delegados .= '<tr style="/*color: #333;*/">' . "\n";
            $tabla_delegados .= '<td class="bgTable_data">' . utf8_encode($delegado->getDNI()) . '</td>' . "\n";
            $tabla_delegados .= '<td class="bgTable_data">' . utf8_encode($delegado->getRazonSocial()) . '</td>' . "\n";
            $tabla_delegados .= '<td class="bgTable_data">' . utf8_encode($delegado->getDireccion()) . '</td>' . "\n";
            $tabla_delegados .= '<td class="bgTable_data">' . utf8_encode($delegado->getRUC()) . '</td>' . "\n";
            $tabla_delegados .= '<td class="bgTable_data">' . utf8_encode($delegado->getApellidoPaterno() . ' ' . $delegado->getApellidoMaterno()) . '</th>' . "\n";
            $tabla_delegados .= '<td class="bgTable_data">' . utf8_encode($delegado->getNombres()) . '</td>' . "\n";
            $tabla_delegados .= '<td class="bgTable_data email">' . utf8_encode($delegado->getEmail()) . '</td>' . "\n";
            $tabla_delegados .= '<td class="bgTable_data">';
            if ($delegado->getTelefonoOficina() == '') {
                $tabla_delegados .= '<span class="no-info">no-info</span>';
            } else {
                $tabla_delegados .= utf8_encode($delegado->getTelefonoOficina());
            }
            $tabla_delegados .= '</td>' . "\n";
            $tabla_delegados .= '<td class="bgTable_data">';
            if ($delegado->getAnexo() == '') {
                $tabla_delegados .= '<span class="no-info">no-info</span>';
            } else {
                $tabla_delegados .= utf8_encode($delegado->getAnexo());
            }
            $tabla_delegados .= '</td>' . "\n";
            $tabla_delegados .= '<td class="bgTable_data">';
            if ($delegado->getCelular() == '') {
                $tabla_delegados .= '<span class="no-info">no-info</span>';
            } else {
                $tabla_delegados .= utf8_encode($delegado->getCelular());
            }
            $tabla_delegados .= '</td>' . "\n";
            $tabla_delegados .= '<td class="bgTable_data">';

            if (utf8_encode($delegado->getEstadoRegistro()) == 1) {
                $estado_cambio = 0;
                $tabla_delegados .= '<span class="span-activo">Activo</span>';
            } else {
                $estado_cambio = 1;
                $tabla_delegados .= '<span class="span-inactivo">Inactivo</span>';
            }
            $tabla_delegados .= '</td>' . "\n";
            $tabla_delegados .= '<td class="bgTable_data"><a href="javascript:void(0);"><img id="' . $delegado->getDNI() . '" width="16" src="../images/magnifier-zoom.png" title="Ver informaci&oacute;n del Usuario" onclick="ver(this.id);"/></a></td>' . "\n";
            $tabla_delegados .= '<td class="bgTable_data"><a href="javascript:void(0);"><img id="' . $delegado->getDNI() . '" width="16" src="../images/pencil.png" title="Editar datos" onclick="editar(this.id);"/></a></td>' . "\n";
            $tabla_delegados .= '<td class="bgTable_data"><a href="javascript:void(0);"><img id="' . $delegado->getDNI() . '" width="16" src="../images/';
            if ($estado_cambio == 1) {
                $tabla_delegados .= 'tick.png';
            } else {
                $tabla_delegados .= 'prohibition.png';
            }
            $tabla_delegados .= '" title="';
            if ($estado_cambio == 1) {
                $tabla_delegados .= 'Activar Usuario';
            } else {
                $tabla_delegados .= 'Desactivar Usuario';
            }
            $tabla_delegados .= '" onclick="cambiaEstado(this.id,' . $estado_cambio . ');"/></td>' . "\n";
            $tabla_delegados .= '</tr>' . "\n";
        }
        $tabla_delegados .= '</table>' . "\n";
        echo $tabla_delegados;
    }
}
if ($_POST['filtrar'] == 1) {
    $dni = trim($_POST["dni"]);
    $apellido = trim(strtoupper($_POST["apellido"]));
    $lista_delegados = array();
    $lista_delegados = $obj_personal->ListaDelegados($_SESSION['s_entidad'], $dni, $apellido);
    if (count($lista_delegados) == 0) {
        echo '';
    } else {
        $tabla_delegados = '<table class="table" border="0" cellpadding="0" cellspacing="0" style="background-color: #F0F0F0;">' . "\n";
        $tabla_delegados .= '<tr>' . "\n";
        $tabla_delegados .= '<td height="26" colspan="14"  class="gradiante" style="color:white;font-size: 13px;padding: 0px 5px;margin: 0px;font-weight: bold;">Datos de Agencia</td>' . "\n";
        $tabla_delegados .= '</tr>' . "\n";
        $tabla_delegados .= '<tr>' . "\n";
        $tabla_delegados .= '<td height="3" colspan="14"  style="background:#fdb813;"></td>' . "\n";
        $tabla_delegados .= '</tr>' . "\n";
        $tabla_delegados .= '<tr >' . "\n";
        $tabla_delegados .= '<th class="subtitleTabla">DNI</th>' . "\n";
        $tabla_delegados .= '<th class="subtitleTabla">Razón Social</th>' . "\n";
        $tabla_delegados .= '<th class="subtitleTabla">Dirección</th>' . "\n";
        $tabla_delegados .= '<th class="subtitleTabla">RUC</th>' . "\n";
        $tabla_delegados .= '<th class="subtitleTabla">Apellidos</th>' . "\n";
        $tabla_delegados .= '<th class="subtitleTabla">Nombre</th>' . "\n";
        $tabla_delegados .= '<th class="subtitleTabla">Email</th>' . "\n";
        $tabla_delegados .= '<th class="subtitleTabla">Tel. Oficina</th>' . "\n";
        $tabla_delegados .= '<th class="subtitleTabla">Anexo</th>' . "\n";
        $tabla_delegados .= '<th class="subtitleTabla">Celular</th>' . "\n";
        $tabla_delegados .= '<th class="subtitleTabla">Estado</th>' . "\n";
        $tabla_delegados .= '<th colspan="3" class="subtitleTabla">Opciones</th>' . "\n";
        $tabla_delegados .= '</tr>' . "\n";
        foreach ($lista_delegados as $delegado) {
            $tabla_delegados .= '<tr style="/*color: #333;*/">' . "\n";
            $tabla_delegados .= '<td class="bgTable_data">' . utf8_encode($delegado->getDNI()) . '</td>' . "\n";
            $tabla_delegados .= '<td class="bgTable_data">' . utf8_encode($delegado->getRazonSocial()) . '</td>' . "\n";
            $tabla_delegados .= '<td class="bgTable_data">' . utf8_encode($delegado->getDireccion()) . '</td>' . "\n";
            $tabla_delegados .= '<td class="bgTable_data">' . utf8_encode($delegado->getRUC()) . '</td>' . "\n";
            $tabla_delegados .= '<td class="bgTable_data">' . utf8_encode($delegado->getApellidoPaterno() . ' ' . $delegado->getApellidoMaterno()) . '</th>' . "\n";
            $tabla_delegados .= '<td class="bgTable_data">' . utf8_encode($delegado->getNombres()) . '</td>' . "\n";
            $tabla_delegados .= '<td class="bgTable_data email">' . utf8_encode($delegado->getEmail()) . '</td>' . "\n";
            $tabla_delegados .= '<td class="bgTable_data">';
            if ($delegado->getTelefonoOficina() == '') {
                $tabla_delegados .= '<span class="no-info">no-info</span>';
            } else {
                $tabla_delegados .= utf8_encode($delegado->getTelefonoOficina());
            }
            $tabla_delegados .= '</td>' . "\n";
            $tabla_delegados .= '<td class="bgTable_data">';
            if ($delegado->getAnexo() == '') {
                $tabla_delegados .= '<span class="no-info">no-info</span>';
            } else {
                $tabla_delegados .= utf8_encode($delegado->getAnexo());
            }
            $tabla_delegados .= '</td>' . "\n";
            $tabla_delegados .= '<td class="bgTable_data">';
            if ($delegado->getCelular() == '') {
                $tabla_delegados .= '<span class="no-info">no-info</span>';
            } else {
                $tabla_delegados .= utf8_encode($delegado->getCelular());
            }
            $tabla_delegados .= '</td>' . "\n";
            $tabla_delegados .= '<td class="bgTable_data">';
            if (utf8_encode($delegado->getEstadoRegistro()) == 1) {
                $estado_cambio = 0;
                $tabla_delegados .= '<span class="span-activo">Activo</span>';
            } else {
                $estado_cambio = 1;
                $tabla_delegados .= '<span class="span-inactivo">Inactivo</span>';
            }
            $tabla_delegados .= '</td>' . "\n";
            $tabla_delegados .= '<td class="bgTable_data"><a href="javascript:void(0);"><img id="' . $delegado->getDNI() . '" width="16" src="../images/magnifier-zoom.png" title="Ver informaci&oacute;n del Delegado" onclick="ver(this.id);"/></a></td>' . "\n";
            $tabla_delegados .= '<td class="bgTable_data"><a href="javascript:void(0);"><img id="' . $delegado->getDNI() . '" width="16" src="../images/pencil.png" title="Editar datos" onclick="editar(this.id);"/></a></td>' . "\n";
            $tabla_delegados .= '<td class="bgTable_data"><a href="javascript:void(0);"><img id="' . $delegado->getDNI() . '" width="16" src="../images/';
            if ($estado_cambio == 1) {
                $tabla_delegados .= 'tick.png';
            } else {
                $tabla_delegados .= 'prohibition.png';
            }
            $tabla_delegados .= '" title="';
            if ($estado_cambio == 1) {
                $tabla_delegados .= 'Activar Gelegado';
            } else {
                $tabla_delegados .= 'Desactivar Delegado';
            }
            $tabla_delegados .= '" onclick="cambiaEstado(this.id,' . $estado_cambio . ');"/></td>' . "\n";
            $tabla_delegados .= '</tr>' . "\n";
        }
        $tabla_delegados .= '</table>' . "\n";
        echo $tabla_delegados;
    }
}

if($_POST['guardar_delegado']==1){ 
        require_once '../Funciones/funciones.php';
          
            $dni=trim($_POST['dni']);
            $apep=  utf8_decode(caracter_especial(addslashes(trim($_POST['apep']))));
            $apem=  utf8_decode(caracter_especial(addslashes(trim($_POST['apem']))));
            $nom=  utf8_decode(caracter_especial(addslashes(trim($_POST['nom']))));
            $email= strtolower(trim($_POST['email']));
            $ofic= trim($_POST['ofic']);
            $anexo= trim($_POST['anexo']);
            $celular= trim($_POST['celular']);
            $rpm= trim($_POST['rpm']);
            $depa= trim($_POST['depa']);
            $prov= trim($_POST['prov']);
            $dist= trim($_POST['dist']);
            $codigo_entidad=$_SESSION['s_entidad'];
            $pass=  generaPass();
            
            $password=$obj_personal->encrypt($pass, "$starperu");
            if (!preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/',$email)) {
                        echo "4_|_";
                        die;
              }
            $dni_duplicado=$obj_personal->DNIValidar($dni,$codigo_entidad);
            if($dni_duplicado==0){
                    $filas_afectadas=$obj_personal->GuardaDelegado($codigo_entidad,$dni,$apep,$apem,$nom,$email,$ofic,$anexo,$celular,$rpm,$depa,$prov,$dist,$password);
                     if($filas_afectadas==1){
                          $obj_personal->EnvioMailCreacionUser($email,$apep,$apem,$nom,$dni,$pass);
                          echo '1_|_';
                   }else{
                        echo '2_|_';
                       
                    }
            }else{
                echo '3_|_';
                
            }
    }
    
    
    if(isset($_GET["id"])){
        
        if($_GET["id"]!=''){
            $dni=$_GET["id"];
            $delegado=$obj_personal->ConsultarDelegadoDNI($dni,$_SESSION['s_entidad']);
            if($delegado==''){
                $tabla_info_delegado= 'No existe un Usuario con ese DNI.';
            }else{
                //Datos para la edici�n del Delegado
                $codigo_entidad=$_SESSION['s_entidad'];
                $estado=utf8_encode($delegado->getEstadoRegistro());
                $dni=utf8_encode($delegado->getDNI());
                $apellido_paterno=utf8_encode($delegado->getApellidoPaterno());
                $apellido_materno=utf8_encode($delegado->getApellidoMaterno());
                $nombres=utf8_encode($delegado->getNombres());
                $email=utf8_encode($delegado->getEmail());
                $telefono_oficina=utf8_encode($delegado->getTelefonoOficina());
                $anexo=utf8_encode($delegado->getAnexo());
                $celular=utf8_encode($delegado->getCelular());
                
                $tabla_info_delegado='<table width="900" border="0" cellpadding="0" cellspacing="0" style="margin:10px 0 0 30px;background-color: #F0F0F0;">'."\n";
                $tabla_info_delegado.='<tr>'."\n";
                $tabla_info_delegado.='<td height="26" colspan="5"  class="gradiante" style="color:white;font-size: 13px;padding: 0px 5px;margin: 0px;font-weight: bold;">Usuario - Datos Personales</td>'."\n";
                $tabla_info_delegado.='</tr>'."\n";
                $tabla_info_delegado.='<tr>'."\n";
                $tabla_info_delegado.='<td height="3" colspan="5"  style="background:#fdb813;"></td>'."\n";
                $tabla_info_delegado.='</tr>'."\n";
                $tabla_info_delegado.='<tr>'."\n";
                $tabla_info_delegado.='<td height="10" colspan="5"  ></td>'."\n";
                $tabla_info_delegado.='</tr>'."\n";
	        $tabla_info_delegado.='<tr>'."\n";
                $tabla_info_delegado.='<td class="label_info">estado:</td><td class="span_info">';
                if(utf8_encode($delegado->getEstadoRegistro())==1){ 
                    $tabla_info_delegado.='<span class="span-activo">Activo</span>';
                }else{
                    $tabla_info_delegado.='<span class="span-inactivo">Inactivo</span>';           
                }
                $tabla_info_delegado.='</td>'."\n";
               
                $tabla_info_delegado.='<td rowspan="2"><button style="cursor:pointer;" onClick="event.preventDefault();editar('.$dni.');" title="Editar datos"  ><img src="../images/pencil.png" /></button></td>'."\n";
                $tabla_info_delegado.='</tr>'."\n";
                $tabla_info_delegado.='<tr>'."\n";
                $tabla_info_delegado.='<td class="label_info">DNI:</td><td class="span_info">'.$dni.'</td>'."\n";
                
                $tabla_info_delegado.='</tr>'."\n";
                $tabla_info_delegado.='<tr>'."\n";
                $tabla_info_delegado.='<td class="label_info">apellido paterno:</td><td class="span_info">'.$apellido_paterno.'</td>'."\n";
                
                $tabla_info_delegado.='<td rowspan="2"> <button style="cursor:pointer;" onClick="event.preventDefault();cambiaEstado('.$dni.','."\n"; 
                        if($estado==1){
                         $tabla_info_delegado.='0';
                        }else{
                         $tabla_info_delegado.='1';
                        } 
                $tabla_info_delegado.=');" title="';
                          if($estado==1){
                              $tabla_info_delegado.='Desactivar Usuario';
                          }else{
                              $tabla_info_delegado.='Activar Usuario';
                          } 
                $tabla_info_delegado.='" ><img src="../images/';
                        if($estado==1){
                             $tabla_info_delegado.='prohibition.png';
                        }else{
                             $tabla_info_delegado.='tick.png';
                        } 
                $tabla_info_delegado.='" /></button></td>'."\n";
                $tabla_info_delegado.='</tr>'."\n";
                $tabla_info_delegado.='<tr>'."\n";
                $tabla_info_delegado.='<td class="label_info">apellido materno:</td><td class="span_info">'.$apellido_materno.'</td>'."\n";
                
                $tabla_info_delegado.='</tr>'."\n";
		$tabla_info_delegado.='<tr>'."\n";
                $tabla_info_delegado.='<td class="label_info">nombre:</td><td class="span_info">'.$nombres.'</td>'."\n";
                
                 $tabla_info_delegado.='<td rowspan="2"> <button style="cursor:pointer;" onClick="window.location.href=\'delegado_listado.php\';" title="Volver al listado..." ><img src="../images/table.png" /></button></td>'."\n";
                $tabla_info_delegado.='</tr>'."\n";
                $tabla_info_delegado.='<tr>'."\n";
                $tabla_info_delegado.='<td class="label_info">email:</td><td class="span_info">'.$email.'</td>'."\n";
                
                $tabla_info_delegado.='</tr>'."\n";
                
                $tabla_info_delegado.='</table>'."\n"; 
                
                $tabla_info_delegado.='<br>'."\n"; 
                
                $tabla_info_delegado.='<table width="900" border="0" cellpadding="0" cellspacing="0" style="margin:10px 0 0 30px;background-color: #F0F0F0;">'."\n";
                
                $tabla_info_delegado.='<tr>'."\n";
                $tabla_info_delegado.='<td height="26" colspan="5"  class="gradiante" style="color:white;font-size: 13px;padding: 0px 5px;margin: 0px;font-weight: bold;">Usuario - Datos Adicionales</td>'."\n";
                $tabla_info_delegado.='</tr>'."\n";
                $tabla_info_delegado.='<tr>'."\n";
                $tabla_info_delegado.='<td height="3" colspan="5"  style="background:#fdb813;"></td>'."\n";
                $tabla_info_delegado.='</tr>'."\n";
                $tabla_info_delegado.='<tr>'."\n";
                $tabla_info_delegado.='<td height="10" colspan="5"  ></td>'."\n";
                $tabla_info_delegado.='</tr>'."\n";
                $tabla_info_delegado.='<tr>'."\n";
                $tabla_info_delegado.='<td class="label_info">teléfono fijo:</td><td class="span_info">';
                if($telefono_oficina!=''){
                     $tabla_info_delegado.=$telefono_oficina;
                }else{
                    $tabla_info_delegado.='<span style="font-style:italic;">[informaci&oacute;n no disponible]</span>';
                }
                $tabla_info_delegado.='</td>'."\n";
                 $tabla_info_delegado.='</tr>'."\n";
                $tabla_info_delegado.='<tr>'."\n";
                $tabla_info_delegado.='<td class="label_info">anexo:</td><td class="span_info">';
                if($anexo!=''){
                     $tabla_info_delegado.=$anexo;
                }else{
                    $tabla_info_delegado.='<span style="font-style:italic;">[informaci&oacute;n no disponible]</span>';
                }
                $tabla_info_delegado.='</td>'."\n";
                $tabla_info_delegado.='</tr>'."\n";
                $tabla_info_delegado.='<tr>'."\n";
                $tabla_info_delegado.='<td class="label_info">celular:</td><td class="span_info">'."\n";
                if($celular!=''){
                     $tabla_info_delegado.=$celular;
                }else{
                    $tabla_info_delegado.='<span style="font-style:italic;">[informaci&oacute;n no disponible]</span>'."\n";
                }
            }
            
        }else{
             
            header('Location:../../cp/panel.php');
            
        }
        
    }
    
    
    if($_POST["activar_desactivar"]==1){
        
        $dni=$_POST["dni"];
        $estado=$_POST["estado"];
        $exito=$obj_personal->ActivarDesactivarDelegado($dni,$estado);
        if($exito==1){
            echo '1';
        }else{
            echo '0';
        }
        
    }
    
    
    if($_POST['editar_delegado']==1){ 
            
            require_once '../Funciones/funciones.php';
            
            $estado=trim($_POST['estado']);
            $dni=trim($_POST['dni']);
            $apep=  utf8_decode(caracter_especial(addslashes($_POST['apep'])));
            $apem=  utf8_decode(caracter_especial(addslashes($_POST['apem'])));
            $nom=  utf8_decode(caracter_especial(addslashes($_POST['nom'])));
            $email= strtolower(trim($_POST['email']));
            $ofic= trim($_POST['ofic']);
            $anexo= trim($_POST['anexo']);
            $celular= trim($_POST['celular']);
            $rpm= trim($_POST['rpm']);
            $rpc= trim($_POST['rpc']);
            $nextel= trim($_POST['nextel']);
            $codigo_entidad=$_SESSION['s_entidad'];
            
            if (!preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/',$email)) {
                        echo "4_|_";
                        die;
            }
            
            $filas_afectadas=$obj_personal->EditarDelegado($codigo_entidad,$dni,$apep,$apem,$nom,$email,$ofic,$anexo,$celular,$rpm,$rpc,$nextel,$estado,0);

            if($filas_afectadas==1){
                 echo '1_|_';
            }else{
                 echo '2_|_';
            }

    }
    
    
    if($_POST['resetear_clave']==1){ 
            require_once '../Funciones/funciones.php';
            
            $dni=$_POST['dni'];
            $codigo_entidad=$_SESSION['s_entidad'];
            $apep=$_POST['apellidopat'];
            $apem=$_POST['apellidomat'];
            $nom=$_POST['nombres'];
            $email=$_POST['email'];
            
            
            $pass=  generaPass();
            $password=$obj_personal->encrypt($pass, "$starperu");
            
            $filas_afectadas=$obj_personal->EditarDelegado($codigo_entidad,$dni,'','','','','','','','','','','',1,$password);
            if($filas_afectadas==1){
                 $obj_personal->EnvioMailResetPassword($email,$apep,$apem,$nom,$dni,$pass);
                 echo '1_|_';
            }else{
                 echo '2_|_';
            }

    }
    
    if($_POST['ObtenerDepartamentos']==1){ 
            require_once '../Funciones/funciones.php';
            //$id_depa = $_POST['departamento'];
            $rsDepartamentos = $obj_personal->obtenerDepartamentos();
            $select = '<option value="0">SELECCIONE</option>';
            while($departamento = mysqli_fetch_assoc($rsDepartamentos)){
                $select.="<option value='".$departamento['id']."'>".$departamento['name']."</option>";
            }
            echo $select;
    }
    
    if($_POST['ObtenerProvincias']==1){ 
            require_once '../Funciones/funciones.php';
            $id_depa = $_POST['departamento'];
            $rsProvincias = $obj_personal->obtenerProvincias($id_depa);
            $select = '<option value="0">SELECCIONE</option>';
            while($provincia = mysqli_fetch_assoc($rsProvincias)){
                $select.="<option value='".$provincia['id']."'>".$provincia['name']."</option>";
            }
            echo $select;
    }
    
    if($_POST['ObtenerDistritos']==1){ 
            require_once '../Funciones/funciones.php';
            $id_prov = $_POST['provincia'];
            $rsDistrito = $obj_personal->obtenerDistritos($id_prov);
            $select = '<option value="0">SELECCIONE</option>';
            while($distrito = mysqli_fetch_assoc($rsDistrito)){
                $select.="<option value='".$distrito['id']."'>".$distrito['name']."</option>";
            }
            echo $select;
    }
    
    
    
?>
