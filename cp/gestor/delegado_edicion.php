<?php 
	session_start();
	error_reporting(E_ALL);
	ini_set("display_errors",0);
	date_default_timezone_set('America/Lima');
	if($_SESSION['s_entra']==0){
	    header('Location:../../index.php');
	}
	require_once("../../cd/Controlador/DelegadoControl.php");
	$Tipo=$_SESSION['s_tipo'];
	$directorio='../';
	$directorio_imagen='../';
	require_once("../../config.php");
?>

<?php ob_start(); ?>
	<link href="<?=$url?>/cp/css/gestor.css" rel="stylesheet" type="text/css" />
	<link href="<?=$url?>/cp/js/jqueryui/css/blitzer/jquery-ui-1.10.4.custom.css" rel="stylesheet" type="text/css" />
	<link href="<?=$url?>/cp/js/msgbox/css/jquery.msgbox.css" rel="stylesheet" type="text/css" />

	<script src="<?=$url?>/cp/js/jquery/jquery-1.8.0.min.js"></script>
	<script src="<?=$url?>/cp/js/jqueryui/js/jquery-ui-1.10.4.custom.js"></script>
	<script src="<?=$url?>/cp/js/msgbox/jquery.msgbox.i18n.js"></script>
	<script src="<?=$url?>/cp/js/msgbox/jquery.msgbox.js"></script>
	<script src="<?=$url?>/cp/js/ajax/MBAjax.js"></script>
	<script src="<?=$url?>/cp/js/ajax/funcionesGestorDelegado.js"></script>
	<script src="<?=$url?>/cp/js/ajax/funcionesGestor.js"></script>
	<?php $style_script_contenido = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php require_once(HTML_RECURSO_PATH); ?>
<div style="width:1000px; margin:0 auto;">
	<a href="delegado_registro.php" class="btn btn-dark" style="margin: 10px 0 0 30px;">Registrar Usuario</a>
    <form id="formRegistro" name="formRegistro" method="post" action="" autocomplete="off">
      	<div id="div-delegado" style="width:1000px;margin: 0px auto;">
           	<table width="900" border="0" cellpadding="0" cellspacing="0" style="margin:10px 0 0 30px;background-color: #F0F0F0;">
                <tr>
                	<td height="26" colspan="5" class="gradiante" style="color:white;font-size: 13px;padding: 0px 5px;margin: 0px;font-weight: bold;">Usuario - Editar Datos Personales</td>
                </tr>
                <tr>
                    <td height="3" colspan="5"  style="background:#fdb813;"></td>
                </tr>
             	<tr>
                    <td height="10" colspan="5"  ></td>
                </tr>
                <tr>
                    <td  class="label_info" style="padding: 10px 10px 7px 0;">DNI:</td>
                    <td >
                    	<input type="hidden" id="codigo_entidad" value="<?php echo $codigo_entidad;?>">
                    	<input type="hidden" id="dni_d" value="<?php echo $dni;?>">&nbsp;&nbsp;&nbsp; <?php echo $dni;?>
                    </td>
                    <td  class="label_info" style="padding: 10px 10px 7px 0;">tel&eacute;fono oficina:</td>
                    <td > 
                    	<input type="text" name="ofic_d" id="ofic_d" maxlength="7" onKeyPress="javascript:return Numero(event);" value="<?php echo $telefono_oficina;?>"/> 
                    	<span class="span-requerido">*</span>
                    </td>
                 	<td  rowspan="2">
                 		<button style="cursor:pointer;" id="editar_delegado" onClick="event.preventDefault();" title="Guardar datos" >
                 			<img  src="../images/disk-black.png" />
                 		</button>
                 	</td>
                </tr>
             	<tr>
                 	<td  class="label_info" style="padding: 10px 10px 7px 0;">estado:</td>
                 	<td >
                     	<select name="estado" id="estado">
                            <option value="-1">- Seleccione estado -</option>
                            <option value="1" <?php if($estado==1){ echo 'selected';}?> >Activo</option>
                            <option value="0" <?php if($estado==0){ echo 'selected';}?> >Inactivo</option>
                        </select>
                 	</td>
                    <td  class="label_info" style="padding: 10px 10px 7px 0;">anexo:</td>
                    <td >  
                    	<input type="text" name="anexo_d" id="anexo_d" maxlength="6" onKeyPress="javascript:return Numero(event);" value="<?php echo $anexo;?>"/>
                    </td>
                </tr>
                <tr>
                    <td  class="label_info" style="padding: 10px 10px 7px 0;">apellido paterno:</td>
                    <td >
                        <input type="hidden" id="apellido_pat" value="<?php echo $apellido_paterno;?>">
                        <input type="text" name="apep_d" id="apep_d" style="text-transform:uppercase;" value="<?php echo $apellido_paterno;?>"/>
                        <span class="span-requerido">*</span>  
                    </td>
                    <td  class="label_info" style="padding: 10px 10px 7px 0;">celular:</td>
                    <td > 
                    	<input type="text" name="celu_d" id="celu_d" maxlength="9" onKeyPress="javascript:return Numero(event);" value="<?php echo $celular;?>"/>
                    </td>
                    <td  rowspan="2"> 
                    	<button style="cursor:pointer;" id="resetear_clave1" onClick="event.preventDefault();verPanelResetPassword();" title="Resetar clave" >
                    		<img src="../images/reset_password.png"  width="24"/>
                    	</button>
                    </td>
                </tr>
                <tr>
                    <td  class="label_info" style="padding: 10px 10px 7px 0;">apellido materno:</td>
                    <td >
                        <input type="hidden" id="apellido_mat" value="<?php echo $apellido_materno;?>">
                        <input type="text" name="apem_d" id="apem_d" style="text-transform:uppercase;" value="<?php echo $apellido_materno;?>"/>
                        <span class="span-requerido">*</span>
                    </td>
                    <td  class="hidden" style="padding: 10px 10px 7px 0;"></td>
                    <td > 
                    	<input type="hidden" name="rpm_d" id="rpm_d" maxlength="9" onKeyPress="javascript:return NumeroRPM(event);" value="<?php echo $RPM;?>"/>
                    </td>
                </tr>
                <tr>
                    <td  class="label_info" style="padding: 10px 10px 7px 0;">nombres:</td>
                    <td >
                       <input type="hidden" id="nombres" value="<?php echo $nombres;?>">
                       <input type="text" name="nom_d" id="nom_d" style="text-transform:uppercase;" value="<?php echo $nombres;?>"/>
                       <span class="span-requerido">*</span>
                    </td>
                    <td  class="hidden" style="padding: 10px 10px 7px 0;"></td>
                    <td >  
                    	<input type="hidden" name="rpc_d" id="rpc_d" maxlength="9" onKeyPress="javascript:return Numero(event);" value="<?php echo $RPC;?>"/>
                    </td>
                    <td  rowspan="2">
                    	<button style="cursor:pointer;" onClick="event.preventDefault();window.location.href='delegado_listado.php';" title="Volver al listado" >
                    		<img src="../images/table.png" />
                    	</button>
                    </td>
                </tr>
                <tr>
                    <td  class="label_info" style="padding: 10px 10px 7px 0;">email:</td>
                    <td >
                        <input type="hidden" id="email" value="<?php echo $email;?>">
                        <input type="text" name="email_d" id="email_d" value="<?php echo $email;?>"/>
                        <span class="span-requerido">*</span>
                    </td>
                    <td  class="hidden" style="padding: 10px 10px 7px 0;"></td>
                    <td > 
                    	<input type="hidden" name="nextel_d" id="nextel_d" maxlength="8" onKeyPress="javascript:return NumeroNextel(event);" value="<?php echo $nextel;?>"/>
                    </td>
                </tr>
                <tr>
                    <td height="10" colspan="5"  ></td>
                </tr>
           	</table>
     	</div>
    </form>
</div>
<?php include(FOOTER_PATH); ?>