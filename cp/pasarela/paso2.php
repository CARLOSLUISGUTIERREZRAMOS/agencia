<?php 
session_start();
error_reporting(E_ALL);
ini_set("display_errors",0);
date_default_timezone_set('America/Lima');
if($_SESSION['s_entra']==0){
    header('Location:../../index.php');
}
require_once '../../cd/Controlador/PasarelaControl.php';
$fecha_hoy=date('d/m/Y');
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title></title>
<link href="css/style.css" rel="stylesheet" type="text/css" media="all">
<!--[if lt IE 9]><link rel="stylesheet" href="css/ie.css" type="text/css" media="screen, projection"><![endif]-->
<link type="text/css" href="css/jquery/blitzer/jquery-ui-1.10.4.custom.css" rel="stylesheet" />
<script type="text/javascript" src="js/jquery-1.7.min.js"></script>
<script type="text/javascript" src="js/jquery/jquery-ui-1.10.4.custom.js"></script>
<script type="text/javascript" src="js/funciones.js" language="javascript1.2" ></script>
<script language="javascript1.2" type="text/javascript">

function Cargar_Fecha_Uno(ano, mes, dia){
    $(".tabla_vuelos_de_ida").css('display','none');
    $("#cargando_vuelos_ida").css('display','block');
    document.getElementById('resultado').innerHTML='';
    if(dia.length>0 && mes.length>0 && ano.length>0){
        document.getElementById('fecha0').value=dia + '/' + mes + '/' + ano;
   
        document.form2.submit();
    }else
	{       
                $(".tabla_vuelos_de_ida").css('display','block');
                $("#cargando_vuelos_ida").css('display','none');
		
	}
	return false;
}

function EnviaImporte_old(tipo, ide, precio){
	document.getElementById('resultado').innerHTML='';
	if(tipo.length>0 && ide.length>0){
		if(document.getElementById(ide).checked==true){
			var arr_val=dgEBI(ide).split('|');				
			document.getElementById('clase_' + tipo).value=arr_val[(arr_val.length - 1)];
			if(document.getElementById('clase_vuelta')){
				var v_clase_ida=dgEBI('clase_ida');
				var v_clase_vuelta=dgEBI('clase_vuelta');
				
				if((v_clase_ida.length>0 && v_clase_vuelta.length>0)){
				
					if(document.getElementById('precio_' + tipo)){
						document.getElementById('precio_' + tipo).value=precio;
					}
					
				}else{
					if(document.getElementById('precio_' + tipo)){
						document.getElementById('precio_' + tipo).value=precio;
					}
				}
			}
		}
	}
	CalculaImporte();
}

function Cargar_Fecha_Dos(ano, mes, dia)
{	$(".tabla_vuelos_de_retorno").css('display','none');
        $("#cargando_vuelos_retorno").css('display','block');
	document.getElementById('resultado').innerHTML='';
	if(dia.length>0 && mes.length>0 && ano.length>0 && document.getElementById('fecha0') )
	{
		document.getElementById('fecha1').value=dia + '/' + mes + '/' + ano;
		document.form2.submit();
	}
	else
	{       
                $(".tabla_vuelos_de_retorno").css('display','block');
                $("#cargando_vuelos_retorno").css('display','none');
		document.getElementById('resultado').innerHTML='La fecha de retorno, debe ser mayor que la fecha de salida.';
	}
	return false;
}

function CalculaImporte()
{
	var ida=0.00;
	var wel=0.00;
	if(document.getElementById('importe_vuelos'))
	{
		document.getElementById('importe_vuelos').innerHTML='0.00';
	}
	if(document.getElementById('precio_ida') && parseFloat(dgEBI('precio_ida'))>0 && document.getElementById('precio_vuelta') && parseFloat(dgEBI('precio_vuelta'))>0)
	{
		ida=parseFloat(dgEBI('precio_ida'));
		wel=parseFloat(dgEBI('precio_vuelta'));
		document.getElementById('importe_vuelos').innerHTML=formatCurrency(ida + wel);
	}
}

function EnviaValores(){
	var v_precio_ida = $("#precio_ida").val();
        var v_precio_vuelta=$("#precio_vuelta").val();
        var viaje_tipo=$("#viaje_tipo").val();
         
        if(viaje_tipo==1){
                if(v_precio_ida.length<=0 || parseFloat(v_precio_ida)<=0){
                    document.getElementById('resultado').innerHTML='* Seleccione su vuelo de ida.';
                    return false;
                }
                if(v_precio_vuelta.length<=0 || parseFloat(v_precio_vuelta)<=0){
                    document.getElementById('resultado').innerHTML='* Seleccione su vuelo de retorno.';
                    return false;
                }
        }
        
        if(viaje_tipo==0){
            if(v_precio_ida.length<=0 || parseFloat(v_precio_ida)<=0){
                document.getElementById('resultado').innerHTML='* Seleccione su vuelo de ida.';
                return false;
             }
        }
        return true;
}


	
function EnviaImporteD(){
	
	if($("input[name='vuelo_ida']:checked").val()){		
		var temp=$("input[name='vuelo_ida']:checked").val();
		var importe_depart=temp.split("#");			
		importe_depart=parseFloat(importe_depart[0]);
		var importe_return=$("#importe_return").val();
		var total=parseFloat(importe_depart)+parseFloat(importe_return);
		total=total.toFixed(2);	
		importe_depart=importe_depart.toFixed(2);		
		$("#importe_vuelos").html(total);
		$("#importe_depart").val(importe_depart);
		$("#precio_ida").val(importe_depart);	
	}
}

function EnviaImporteR(){
	
	if($("input[name='vuelo_vuelta']:checked").val()){	
	
	 
		var temp2=$("input[name='vuelo_vuelta']:checked").val();	
		
		importe_return=temp2.split("#");	
	
	 	importe_return=parseFloat(importe_return[0]);		
		importe_return=importe_return.toFixed(2);
		$("#importe_return").val(importe_return)
		var importe_depart=parseFloat($("#importe_depart").val());
		importe_depart=importe_depart.toFixed(2);
		var total=parseFloat(importe_return)+parseFloat(importe_depart);
		total=total.toFixed(2);
		$("#importe_vuelos").html(total);
		$("#precio_vuelta").val(importe_return); 
		
	}
}	

	
function VerCondicion(clase){	
         $("#MostrarCondicion").dialog({
                            resizable: false,
                            title:"Clase "+clase+" - Restricciones",				
                            modal: true,	
                            width: 620,
                            height: 420,
                            show: "fold",
	                    hide: "fade", 
         });	 

          
	 $.ajax({
             url : "../../cd/Controlador/PasarelaControl.php",
	     type : "POST",
             data:"ver_condiciones=1&clase="+clase,
	     success:function(html){
                       
                        var familia=$.trim(html);	
                        if(familia=='Basica'){
                              $("#MostrarCondicion").load("condiciones/tarifa_basica.html");	
                        }else if(familia=='Regular'){
                               $("#MostrarCondicion").load("condiciones/tarifa_regular.html");	
                        }else if(familia=='Premium'){
                               $("#MostrarCondicion").load("condiciones/tarifa_premium.html");	
                        }else if(familia=='Premium Star'){
                              $("#MostrarCondicion").load("condiciones/tarifa_premium_star.html");	
                        }else if(familia=='Star Golden'){
                              $("#MostrarCondicion").load("condiciones/tarifa_star_golden.html");	
                        }
                        
                          $('#MostrarCondicion').dialog('open');
                    
                   },
            error: function(obj,mensaje,e) { 
                      if(e=='Internal Server Error'){
                          alert('Se ha producido un error interno. Consulte con el �rea de Sistemas de StarPer�');
                          return false;
                      }else{
                          alert('Por favor revise su conexi�n a Internet y vuelva a intertarlo.');
                           return false;
                      }
                 }
	 });			

} 
  
 
</script>

<style type="text/css">
body {
	overflow: auto;
}
td, select, input {
	font-family: Arial,Helvetica,sans-serif;
	font-size: 12px;
	color: #656565;
	padding: 0px;
	margin: 0px;
}
#cabecera, #cabecera td {
	padding: 0px;
	margin: 0px;
}
.titleTable {
	background: none repeat scroll 0 0 #DDD1CB;
	font-size: 13px;
	font-weight: bold;
	color: #3B3B3B;
	padding: 4px 5px;
}
.btn-red {
	float: none;
}

.clase {
	 cursor: pointer;	
}	 
a:link {text-decoration:none;color:#C81318;}
a:visited {text-decoration:none;color:#C81318;}
a:active {text-decoration:none;color:#C81318;}
a:hover {text-decoration:none;color:#C81318;}  
element.style {
    background: none repeat scroll 0 0 #F1F1F1;
}
.gradiante{
    background: linear-gradient(#f01515, darkred) !important;
    background: -webkit-linear-gradient(#f01515, darkred) !important;
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#f01515', endColorstr='darkred');
}
</style>
<link href="css/estilos.css" rel="stylesheet" type="text/css" />
</head>
    <body class="waiting">

        <table width="1100" border="0" align="center" cellpadding="0" cellspacing="0" style="background-color: #FFFFFF">
              <tr>
                   <td>&nbsp;</td>
              </tr>
              <tr>
                    <td height="50" align="center">
                        <table id="menu_vuelo" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                    <td height="19" ><a style="color:#323131;" href="paso1.php" title="Volver al paso 1">1. FECHA</a></td>
                                    <td width="4"></td>
                                    <td width="89" style="background-image: url(images/line_off.png); background-repeat: repeat-x"></td>
                                    <td width="30"></td>
                                    <td class="activo" >2. VUELOS</td>
                                    <td width="4"></td>
                                    <td width="89" style="background-image: url(images/line_off.png); background-repeat: repeat-x"></td>
                                    <td width="30"></td>
                                    <td>3. PRECIO</td>
                                    <td width="4"></td>
                                    <td width="89" style="background-image: url(images/line_off.png); background-repeat: repeat-x"></td>
                                    <td width="30"></td>
                                    <td>4. PASAJEROS</td>
                                    <td width="4"></td>
                                    <td width="89" style="background-image: url(images/line_off.png); background-repeat: repeat-x"></td>
                                    <td width="30"></td>
                                    <td>5. CONFIRMACI&Oacute;N</td>
                            </tr>
                        </table>
                    </td>
             </tr>
             <tr>
                    <td height="250" align="center" style="background-color: #FFFFFF">
                        <form id="form2" name="form2" method="post" action="paso2.php">
                            <input name="paso2" type="hidden" id="paso2" value="1" />
                            <input name="fecha0" type="hidden" id="fecha0" value="<?php echo $_SESSION['fecha_ida'];?>" />
                            <input name="fecha1" type="hidden" id="fecha1" value="<?php echo $_SESSION['fecha_retorno'];?>" />
                            <input name="origen" type="hidden" id="origen" value="<?php echo $_SESSION['origen'];?>" />
                            <input name="destino" type="hidden" id="destino" value="<?php echo $_SESSION['destino'];?>" />
                            <input name="rbt_tipo_viaje" type="hidden" id="rbt_tipo_viaje" value="<?php echo $_SESSION['tipo_viaje'];?>" />
                            <input name="adultos" type="hidden" id="adultos" value="<?php echo $_SESSION['adultos'];?>" />
                            <input name="menores" type="hidden" id="menores" value="<?php echo $_SESSION['menores'];?>" />
                            <input name="infantes" type="hidden" id="infantes" value="<?php echo $_SESSION['infantes'];?>" /> 
                        </form>
                        <form id="form1" name="form1" method="post" action="paso3.php" autocomplete="off" onSubmit="return EnviaValores();">
                            <table width="1100" border="0" cellspacing="0" cellpadding="0">
                               <tr>
                                  <td>
                                         <table width="1100">
                                              <tr>
                                                    <td colspan="5"  height="1"  style="background: #323131;"></td>
                                              </tr> 
                                               <tr>
                                                    <td colspan="5" align="left" height="30" class="titleTable" style="color:#323131;font-size: 24px;background: #f0f0f0;font-family:Tahoma, Geneva, sans-serif; ">Paso 2</td>
                                              </tr>
                                               <tr>
                                                    <td colspan="5"  height="1"  style="background: #323131;"></td>
                                              </tr>  
                                             <tr>
                                                 <td height="10" >&nbsp;</td>
                                             </tr>
                                             <tr>
                                                    <td colspan="7" align="left" class="titleTable gradiante" style="color:white;">Su Selecci&oacute;n</td>
                                                </tr>
                                                <tr>
                                                    <td height="3" colspan="5"  style="background:#fdb813;"></td>
                                                </tr>
                                                <tr class="bgTable">
                                                   <?php  if($_SESSION['tipo_viaje']==1){?>
                                                      <td align="left" class="subtitleTable">Ida</td>
                                                      <td align="left" class="subtitleTable">Regreso</td>
                                                   <?php }else{?>
                                                      <td align="left" class="subtitleTable">Ida</td>
                                                   <?php }?> 
                                                     <td align="left" class="subtitleTable">Pasajeros</td>
                                                     <td align="left" class="subtitleTable">Cabina</td>
                                                </tr>
                                                <tr class="bgTable-3">
                                                   <?php if($_SESSION['tipo_viaje']==1){?>
                                                    <td height="50" align="left" valign="middle" class="bgTable-data"><?php echo $_SESSION['nombre_origen'].' - '.$_SESSION['nombre_destino'];?><br><?php echo $_SESSION['fecha_ida'];?></td>
                                                    <td class="bgTable-data" valign="middle" align="left"><?php echo $_SESSION['nombre_destino'].' - '.$_SESSION['nombre_origen'];?><br><?php echo $_SESSION['fecha_retorno'];?></td>
                                                    <?php }else{?>
                                                    <td height="50" align="left" valign="middle" class="bgTable-data"><?php echo $_SESSION['nombre_origen'].' - '.$_SESSION['nombre_destino'];?><br><?php echo $_SESSION['fecha_ida'];?></td>
                                                    <?php }?>
                                                    <td align="left" valign="middle" class="bgTable-data"><?php echo $_SESSION['cantidad_adultos'];
                                                    if($_SESSION['menores']>1){
                                                        echo '<br/>'.$_SESSION['cantidad_menores'];
                                                    }
                                                    if($_SESSION['infantes']>1){
                                                        echo '<br/>'.$_SESSION['cantidad_infantes'];
                                                    }
                                                    ?></td>
                                                    <td align="left" valign="middle" class="bgTable-data">Econ&oacute;mica</td>  
                                                </tr>
                                        </table>
                                  </td>
                               </tr>
                            </table>
                            <table width="1100" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td height="30"></td>
                               </tr>
                            </table>
                            <table width="1100" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td>
                                        <table border="0" cellspacing="0" cellpadding="0" class="contenido">
                                            <tr>
                                                
                                                <?php 
                                                        if($_SESSION['dias_diferencia1']>0){ ?>
                                                    <td>
                                                         <img src="images/arrow-red-left.png" width="10" height="10" style="cursor: pointer" onClick="Cargar_Fecha_Uno('<?php echo $_SESSION['fecha_dividida_anterior_ida_2']; ?>', '<?php echo $_SESSION['fecha_dividida_anterior_ida_0']; ?>', '<?php echo $_SESSION['fecha_dividida_anterior_ida_1']; ?>')" title="Haga click para buscar vuelos el d&iacute;a: <?php echo $_SESSION['fecha_ida_anterior']; ?>" />
                                                    </td>
                                                <?php }else{  ?>
                                                   
                                                    <td>
                                                        <img src="images/arrow-gray-left.png" width="10" height="10" />
                                                    </td>
                                                <?php }?>
                                                <td width="6"></td>
                                                <td><?php echo $_SESSION['fecha_ida']; ?></td>
                                                <td width="6"></td>
                                                <?php if($_SESSION['dias_diferencia']>0){ ?>
                                                    <td>
                                                         <img src="images/arrow-red.png" width="10" height="10" style="cursor: pointer" onClick="Cargar_Fecha_Uno('<?php echo $_SESSION['fecha_dividida_posterior_ida_2']; ?>', '<?php echo $_SESSION['fecha_dividida_posterior_ida_0']; ?>', '<?php echo $_SESSION['fecha_dividida_posterior_ida_1']; ?>')" title="Haga click para buscar vuelos el d&iacute;a: <?php echo $_SESSION['fecha_ida_posterior']; ?>" />
                                                    </td>
                                                <?php }else{ ?>
                                                    <td>
                                                        <img src="images/arrow-gray.png" width="10" height="10" />
                                                    </td>
                                                <?php }?>
                                            </tr>
                                        </table>             
                                        <table>                	
                                             <tr>
                                                <td height="10"></td>
                                             </tr>
                                             <tr>
                                                 <td width="1100" class="titleTable gradiante" style="color:white;"><?php echo $_SESSION['nombre_origen'].' - '.$_SESSION['nombre_destino'];?></td>
                                             </tr>
                                             <tr>
                                                 <td height="3"  style="background:#fdb813;"></td>
                                             </tr>
                                        </table>
                                       <?php echo $_SESSION['tabla_vuelos_ida'];?>
                                      <table id="cargando_vuelos_ida" style="display: none;">
                                          <tr>
                                              <td width="1100" height="50"><center><img style="vertical-align: middle;" src="images/cargando.gif" />&nbsp;&nbsp;&nbsp;<span>Cargando vuelos disponibles ... </span></center></td>
                                          </tr>
                                      </table>
                                  </td>
                               </tr>
                            </table>
                            <table width="1100" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td height="30"></td>
                               </tr>
                            </table>
                            <?php   if($_SESSION['tipo_viaje']==1){ ?>
                            <table align="center" width="1100" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td>  
                                            <table border="0" cellspacing="0" cellpadding="0" class="contenido">
                                                <tr>
                                                    <?php if($_SESSION['dias_diferencia']>0){ ?>
                                                    <td>
                                                         <img src="images/arrow-red-left.png" width="10" height="10" style="cursor: pointer" onClick="Cargar_Fecha_Dos('<?php echo $_SESSION['fecha_dividida_anterior_retorno_2']; ?>', '<?php echo $_SESSION['fecha_dividida_anterior_retorno_1']; ?>', '<?php echo $_SESSION['fecha_dividida_anterior_retorno_0']; ?>')" title="Haga click para buscar vuelos el d&iacute;a: <?php echo $_SESSION['fecha_retorno_anterior']; ?>" />
                                                    </td>
                                                <?php }else{ ?>
                                                    <td>
                                                        <img src="images/arrow-gray-left.png" width="10" height="10" />
                                                    </td>
                                                <?php }?>
                                                  
                                                   <td width="6"></td>
                                                   <td><?php echo $_SESSION['fecha_retorno']; ?></td>
                                                   <td width="6"></td>
                                                   <td><img src="images/arrow-red.png" width="10" height="10" style="cursor: pointer" onClick="Cargar_Fecha_Dos('<?php echo $_SESSION['fecha_dividida_posterior_retorno_2']; ?>', '<?php echo $_SESSION['fecha_dividida_posterior_retorno_1']; ?>', '<?php echo $_SESSION['fecha_dividida_posterior_retorno_0']; ?>')" title="Haga click para buscar vuelos el d&iacute;a: <?php echo $_SESSION['fecha_retorno_posterior']; ?>" /></td>
                                                </tr>
                                            </table>
                                            <table>                	
                                                 <tr>
                                                     <td height="10"></td>
                                                 </tr>
                                                 <tr>
                                                     <td width="1100" class="titleTable gradiante" style="color:white;"><?php echo $_SESSION['nombre_destino'].' - '.$_SESSION['nombre_origen'];?></td>
                                                 </tr>
                                                 <tr>
                                                     <td height="3" style="background:#fdb813;"></td>
                                                 </tr>
                                            </table>                     
                                            <?php echo $_SESSION['tabla_vuelos_retorno'];?>
                                            <table id="cargando_vuelos_retorno" style="display: none;">
                                                <tr>
                                                    <td width="1100" height="50"><center><img style="vertical-align: middle;" src="images/cargando.gif" />&nbsp;&nbsp;&nbsp;<span>Cargando vuelos disponibles ... </span></center></td>
                                                </tr>
                                            </table>
                                    </td>
                                </tr>
                            </table>
                            <?php } ?>
                            <table width="1100" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                   <td height="30"></td>
                                </tr>
                            </table>
                            <table width="1100" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                 <td>
                                     <table width="1100" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                                <td width="420">
                                                        <table width="420" border="0" cellpadding="0" cellspacing="0" class="contenido" style="border: 1px solid #DCE0EE; background-color: #F0F0F0">
                                                                <tr>
                                                                  <td width="8" height="30"></td>
                                                                  <td width="420" align="left"> - Valores estimados incluyendo impuestos para 1 pasajero adulto</td>
                                                                </tr>
                                                                <tr>
                                                                  <td height="30"></td>
                                                                  <td align="left"> - Cupos y precios sujetos a confirmaci&oacute;n en los pasos siguientes</td>
                                                                </tr>
                                                        </table>
                                                 </td>
                                                 <td width="363">

                                                 </td>
                                                 <td width="317" align="right">
                                                        <table style="border: 1px solid #DCE0EE; background-color: #F0F0F0" class="contenido" border="0" cellpadding="0" cellspacing="0">
                                                                <tr>
                                                                    <td class="Titulo_ruta" height="30" width="112" align="right"><b>Tarifa * :</b> </td>
                                                                    <td width="8"></td>
                                                                    <td width="80" align="left" class="Titulo_ruta" id="importe_vuelos">0.00</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="3" height="30" align="center">Valores en D&oacute;lares Americanos.</td>
                                                                </tr>
                                                        </table>
                                                </td>
                                         </tr>
                                     </table>
                                 </td>
                            </tr>
                            </table>
                            <table width="1100" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                     <td height="30"></td>
                                </tr>
                            </table>
                            <table width="1100" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                 <td align="right">
                                        <table width="100%" border="0" cellpadding="0" cellspacing="0"  >
                                            <tr>
                                                <td align="right">
                                                      <input name="btnAceptar" id="btnAceptar" value="Continuar" class="btn-red" type="submit"> 
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="center" >
                                                    <div id="div_aviso_show" style="display:none">
                                                        <table border="0" cellspacing="0" cellpadding="0" align="center">
                                                            <tr>
                                                                <td  align="center"><img src="../images/LogoStar.png" width="181" height="60" /></td>
                                                            </tr>
                                                            <tr>
                                                                <td align="center"><img src="images/ajax-loader.gif" width="220" height="19" /></td>
                                                            </tr>
                                                            <tr>
                                                                <td align="center" ><b>Procesando,  por favor espere.</b></td>
                                                            </tr>          
                                                        </table>                       
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                  </td>
                            </tr>
                            </table>
                            <table width="1100" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                      <td height="30" align="left" id="resultado" style="color: #CC0033"></td>
                                </tr>
                            </table>
                            <table width="1100" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                     <td height="30"></td>
                                </tr>
                            </table>
                            <table width="1100" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                     <td height="30"></td>
                                </tr>
                            </table>
                            <?php echo $_SESSION['hide_paso2'];?>

                        </form>
                    </td>
             </tr>
        </table>
    <div id="MostrarCondicion" style="display: none"></div>
    </body>
</html>