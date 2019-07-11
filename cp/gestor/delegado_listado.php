<?php 
	session_start();
	error_reporting(E_ALL);
	ini_set("display_errors",0);
	date_default_timezone_set('America/Lima');
	if($_SESSION['s_entra']==0){
	    header('Location:../../index.php');
	}
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
	<script src="<?=$url?>/cp/js/fnMain.js"></script>
	<script src="<?=$url?>/cp/js/ajax/funcionesGestorDelegado.js"></script>
	<style type="text/css">
		.div-contenido-body{
			width: 1116px;
			margin:0px auto;
			display: flex;
		}
	</style>
	<script type="text/javascript">
	    $(window).load(function(){
	        $("#btnbusqueda1").click(function(){
	            var dni=$.trim($("#dni").val());
	            var apellido=$.trim($("#apellido").val().toUpperCase());
	            
	            if(dni=="" &&  apellido==""){
	                $.msgbox({
	                    open:true,type:'alert',title:'Alerta',content: 'Debe llenar al menos un campo.', overlay:true
	                });
	                // $.msgbox().open();
	                return false;
	            }
	            
	//            var data = new FormData();
	//            data.append('filtrar',1);
	//            data.append('dni',dni);
	//            data.append('apellido',apellido);

	            $.ajax({
	                url:"../../cd/Controlador/DelegadoControl.php",
	                type: "POST", 
	                // contentType:false,
	                data:"filtrar=1&dni="+dni+"&apellido="+apellido,
	                // processData:false,
	                success: function(mensaje){
	                    if($.trim(mensaje)==''){
	                        $("#listaResultado").html('<p style="text-align:center;color:red;margin-top:20px;">No existen datos para visualizar. Por favor registre nuevos delegados.</p><br><p style="text-align:center;"><a href="javascript:void(0);"><img src="../images/reload.png"  title="Recargar Listado..." onclick="javascript:$(window).load();"></a></p>');
	                    }else{
	                        $("#listaResultado").html(mensaje);
	                    }
	                },
	                error: function(obj,mensaje,e) { 
	                    if(e=='Internal Server Error'){
	                        alert('Se ha producido un error interno. Consulte con el área de Sistemas de StarPerú');
	                    }else{
	                        alert('Por favor revise su conexión a Internet y vuelva a intertarlo.');
	                    }
	                }
	           });
	        });
	   
	//            var data = new FormData();
	//            data.append('listar',1);

	        $.ajax({
	            url:"../../cd/Controlador/DelegadoControl.php",
	            type: "POST", 
	            // contentType:false,
	            data:"listar=1",
	            // processData:false,
	            success: function(mensaje){
	                if($.trim(mensaje)==''){
	                    $("#listaResultado").html('<p style="text-align:center;color:red;margin-top:20px;">No existen datos para visualizar. Por favor registre nuevos delegados.</p><br><p style="text-align:center;"><a href="javascript:void(0);"><img src="../images/reload.png"  title="Recargar Listado..." onclick="javascript:$(window).load();"></a></p>');
	                }else{
	                    $("#listaResultado").html(mensaje);
	                }
	            },
	           error: function(obj,mensaje,e) { 
	                if(e=='Internal Server Error'){
	                    alert('Se ha producido un error interno. Consulte con el área de Sistemas de StarPerú');
	                }else{
	                    alert('Por favor revise su conexión a Internet y vuelva a intertarlo.');
	                }
	            }
	       });
	    });
	</script>
	<?php $style_script_contenido = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php require_once(HTML_RECURSO_PATH); ?>
<!-- fin div Credito Personal -->
<div style="width:auto;">
    <br>
    <a href="delegado_registro.php" class="btn btn-dark">Registrar Usuario</a>
    <div id="div-busqueda">
        <form id="formBusqueda" name="formBusqueda" method="post" action="../../cd/Controlador/DelegadoControl.php" autocomplete="off">
            <table border="0" cellpadding="0" cellspacing="0" style="background-color: #F0F0F0; width: 100%">
                <tr>
                    <td height="26" colspan="5" align="left" class="titleTable gradiante" style="color:white;padding: 0px 5px;margin: 0px;font-weight: bold;">Opciones de B&uacute;squeda</td>
                </tr>
                <tr>
                     <td height="3" colspan="5"  style="background:#fdb813;"></td>
                </tr>
                 <tr>
                     <td height="20" colspan="5"  ></td>
                </tr>
                <tr>
                    <td align="right">DNI:</td>
                    <td > <input type="text" style="text-align: center;" name="dni" id="dni" maxlength="8" onKeyPress="javascript:return Numero(event);"/></td>
                    <td align="right">Apellidos</td>
                    <td><input type="text" style="text-align: center;" name="apellido" id="apellido" style="text-transform:uppercase;"/></td>
                    <td align="center"><input type="button" class="btn-red" name="btnbusqueda" id="btnbusqueda1" value="Consultar" title="Presionar para ver resultados ..." /></td>
                </tr>
                 <tr>
                     <td height="20" colspan="5"  ></td>
                </tr>
            </table>
        </form>
    </div>
        <br>
        <br>
    <div id="div-listado">
        <div id="listaResultado" >
        </div>
    </div>
</div>
<?php include(FOOTER_PATH); ?>