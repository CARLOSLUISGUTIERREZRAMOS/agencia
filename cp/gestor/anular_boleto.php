<?php 
	session_start();
	error_reporting(E_ALL);
	ini_set("display_errors",0);
	date_default_timezone_set('America/Lima');
	if($_SESSION['s_entra']==0){
	    header('Location:../../index.php');
	}
	$cantidad_lista=0;
	include('../../cd/Controlador/ReservaControl.php');
	$Tipo=$_SESSION['s_tipo'];
	$directorio='../';
	$directorio_imagen='../';
	require_once("../../config.php");
?>

<?php ob_start(); ?>
	<link href="<?=$url?>/cp/css/entidad.css" rel="stylesheet" type="text/css" />
	<link href="<?=$url?>/cp/css/anular.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" language="javascript1.2">
		$(document).ready(function(){
		    var altocontenido = $( window ).height()-121;
		    $("#contenido_page").css('height',altocontenido);
		});

		$(window).resize(function(){
		    var altocontenido = $( window ).height()-121;
		    $("#contenido_page").css('min-height',altocontenido);
		});

		function MarcarTodos(){    
	        $('#resultado_chk').html("");
	        $(":checkbox").each(function(){
               	if($(this).attr('id')!='marca_todos' ){
                    if($("#marca_todos").prop('checked')){
                         $("#checkbox").removeAttr('checked');
                         $(this).prop('checked','checked');
                    }else{
                         $("#checkbox").removeAttr('checked');
                        $(this).removeAttr('checked');
                    }
               	}
	        });  
		}

		function trim(texto){
			return texto.replace(/^\s+|\s+$/g,"");
		}

		function dgEBI(obj){
			var val='';
			if(document.getElementById(obj)){
				val=trim(document.getElementById(obj).value);
			}
			return val;
		}
		
		function EnviarValores(){
			var v_reserva=dgEBI('reserva');
			if(v_reserva.length=='6' ){ 
                $('#form1').submit();
			}
			else{      
                $('#resultado_chk').html("");
				document.getElementById('resultado').innerHTML='* Ingrese correctamente el c&oacute;digo de reserva.';
				Focus('reserva');
                return false;
			}
		}

		function EnviarValoresCheck(){    
	        var suma = 0;
	        $(":checkbox:checked").each(function(){
	            if(this.checked){
	                 suma++;
	             }
	        });
	          
	        if($("#marca_todos").is(':checked')) {   
	                suma--;
	        } 

	        if(suma != <?php echo  $cantidad_lista;?>){
	            $('#resultado_chk').html("* Debe seleccionar todos los boletos para anular.");
	            return false;
	        }else{
             	var r = confirm("¿Está seguro que desea Anular los boletos seleccionados?");
             	if (r == true) {
                  	return true;
             	} 
             	else {
                   return false;
             	}
	        } 
		}

		function Focus(id_obj){
			if(document.getElementById(id_obj)){
				setTimeout("document.getElementById('"+id_obj+"').focus();",75);
			}
		}
	</script>
	<?php $style_script_contenido = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php require_once(HTML_RECURSO_PATH); ?>
<!-- fin div Credito Personal -->
<div id="contenido_page" style="width: 100%;margin: 0px auto;overflow-y: scroll">
  	<br>
  	<table width="1200" cellpadding="0" cellspacing="0" border="0" style="margin: 0px auto;">
	    <tr>
	      	<td width="100" height="20"></td>
	      	<td width="1000"></td>
	      	<td width="100"></td>
	    </tr>
    	<tr>
      		<td height="100"></td>
      		<td>
		        <form id="form1" name="form1" method="post" action="" autocomplete="off" onSubmit="EnviarValores();return false" style="margin: 0px auto;width: 450px;">
		          	<table width="450" border="0" cellpadding="0" cellspacing="0" style="background-color: #F0F0F0;">
			            <tr>
			              <td colspan="3" class="gradiante" style="color:white;font-size: 13px;padding: 5px 5px;margin: 0px;font-weight: bold;">B&uacute;squeda de Boletos por Reserva</td>
			            </tr>
			            <tr>
			                <td height="3" colspan="3"  style="background:#fdb813;"></td>
			            </tr>
			             <tr>
			                <td height="20" colspan="3"  ></td>
			            </tr>
			            <tr>
			              	<td width="100" align="right" style="padding:0px 0px 0px 18px;">C&oacute;digo  Reserva:</td>
			              	<td width="200" align="center">
			              		<input type="text" name="reserva" id="reserva" maxlength="6" class="input" value="<?php echo $codigo_reserva;?>" style="text-align: center;"/>
			              	</td>
			              	<td align="center">
			                  	<input type="hidden" name="buscar_reserva" value=1>
			                  	<input type="submit" name="btnbusqueda" id="btnbusqueda1" class="btn-red"  value="Consultar" />
			              	</td>
			            </tr>
			            <tr>
			              <td height="30"></td>
			              <td  align="center" id="resultado"></td>
			              <td></td>
			            </tr>
		          	</table>
		        </form>
	      	</td>
      		<td></td>
    	</tr>
	    <tr>
	      	<td height="20"></td>
	      	<td align="center" style="color: darkred">El ticket solo se puede anular el mismo día de su emisión.</td>
	      	<td></td>
	    </tr>
	    <tr>
	      	<td height="50"></td>
	      	<td></td>
	      	<td></td>
	    </tr>
	    <tr>
	      	<td height="20"></td>
	      	<td>
	          	<?php echo $tabla_boletos_reserva; ?>                         
	      	</td>
	      	<td></td>
	    </tr>
  	</table>
</div>
<?php include(FOOTER_PATH); ?>