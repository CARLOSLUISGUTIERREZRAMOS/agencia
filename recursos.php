<?php
	// require_once("config.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//PE" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es-PE" lang="es-PE"> 
    <!--<html>-->
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <title>Web Agencias - StarPeru</title>
        <link href="<?=$url?>/cp/images/favicon_starperu.png" rel="shortcut icon" />
        <link href="<?=$url?>/cp/css/modulo.css" rel="stylesheet" type="text/css" />
        <script src="<?=$url?>/cp/js/jquery.js"></script>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css"  crossorigin="anonymous" />
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" crossorigin="anonymous">
        <style type="text/css">
		    #div-header-logo .a-logo,.logoEntidadCambiar,._icon_logo{
		        position: absolute;
		    }
		    #div-header-logo .a-logo{
		        z-index: 0;
		    }
		    ._icon_logo,.logoEntidadCambiar{
		        margin: 25px 10px 0 10px;
		        text-align: center;
		        width: 170px;
		        z-index: 1;
		        cursor: pointer;
		    }
		    ._icon_logo ._156n{
		        opacity: 0;
		    }
		    .logoEntidadCambiar {
		        border-radius: 15px;
		        background-color: #000000;
		        opacity: 0.8;
		    }
		    .logoEntidadCambiar ._156n{
		        opacity: 1;
		    }
		    ._156n {
		        text-align: center;
		        color: #ffffff;
		    }
		    ._156n .icon{
		        margin-bottom: -8px;
		    }
		</style>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script type="text/javascript">
        	URLs="<?=$url?>";
        	$(document).on('mouseover','._icon_logo',function (arg) {
		        $(this).addClass('logoEntidadCambiar');
		        this.previousElementSibling.style.cssText='opacity:0.5';
		    });
		    $(document).on('mouseout','._icon_logo',function (arg) {
		        $(this).removeClass('logoEntidadCambiar');
		        this.previousElementSibling.style.cssText='';
		    });
		    
		    $(document).on('click','.logoEntidadCambiar',function (arg) {
		        $("#LogoEntidad").trigger("click");
		    });

		    $(document).on('change','#LogoEntidad',function (ar) {
		        var files = this.files; // FileList object
		        var frame=$("#div-header-logo img");
		        if (files.length==0) {
		            frame.attr('src',URLs+'/cp/images/LogoStar.png');
		            $("#LogoEntidad").val('');
		        }
		        else{
		            if (files[0].type =="image/jpeg" || files[0].type =="image/png" || files[0].type =="image/jpeg") {
		                imgfile_url=URL.createObjectURL(files[0]);
		                frame.attr('src',imgfile_url);
		                cambiarLogo();
		            }
		            else{
		                frame.attr('src',URLs+'/cp/images/LogoStar.png');
		                $("#LogoEntidad").val('');
		                // mostrarMsgError('No se aceptan archivos solo imagenes en formato PNG,JPG y JPEG.',1);
		            }
		        }

		    });

		    function cambiarLogo() {
		        var codigo_entidad=<?php echo $_SESSION["s_entidad"];?>;
		        var formData = new FormData($("#form-logo")[0]);
		        formData.append('CodigoEntidad',codigo_entidad);
		        formData.append('cambiar_logo',1);
		        $.ajax({
		            url:"<?=$url?>/cd/Controlador/AgenciaControl.php",
		            type: "POST", 
		            data:formData,
		            contentType: false,
        			processData: false,
		            success: function(mensaje){
		            	var data=JSON.parse(mensaje);
		            	if (data.success) {
		            		console.log(data.success);
		            	}
		            	else{
		            		console.log(data.error)
		            	}
		            },
		        });
		    }

			function getLineaCredito(){   
	            var mensaje_linea_credito=0;
	            var codigo_entidad=<?php echo $_SESSION["s_entidad"];?>;
	            $.ajax({
	                url:"<?=$url?>/cd/Controlador/MovimientoControl.php",
	                type: "POST", 
	                data:"obtener_linea_credito=1&codigo_entidad"+codigo_entidad,
	                success: function(mensaje){
	                    mensaje_linea_credito=parseFloat($.trim(mensaje)).toFixed(2); 
	                    $("#loadLinea").html('USD '+mensaje_linea_credito);  
	                },
	            });
	        }

			function LineaCredito(){    
			    getLineaCredito();
			    setInterval("getLineaCredito()", 1000);   
			}
		</script>
        <?php 
        	if (isset($style_script_contenido)) {
        		echo $style_script_contenido;
        	}
        ?>
    </head>
    <body onLoad=" LineaCredito();">
        <div style="position:absolute; width:100%; height:100%;">
            <div id="div-main">
            	<?php include(CABECERA_PATH); ?>
            	<div id="div-contenido">
            		<!-- Menu principal -->
                    <?php include(MENU_PATH); ?>
                    <!-- fin menu principal -->
                    <div>
                        <!-- Div Credito Personal -->
                        <div style="position: absolute; height: 60px; top: 0px; left: 42%; right: 42%">
                            <table width="160" cellpadding="0" cellspacing="0" border="0" style=" background-color: #F0F0F0;/*font-family: Arial, Helvetica, sans-serif; */color: #dd1414">
                                <tr style="">
                                    <td height="25" align="center" class="gradiante" style="color:white;font-family: Arial,Helvetica,sans-serif;font-weight: bold;font-size: 13px;"> 
                                        L&iacute;nea de cr&eacute;dito
                                    </td>
                                </tr>
                                <tr>
                                    <td height="3"   style="background:#fdb813;"></td>
                                </tr>
                                <tr>
                                    <td id="loadLinea" height="35" align="center" style="font-size: 16px;font-weight: bold;"></td>
                                </tr>
                            </table>
                        </div>
