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

if($_REQUEST['fecha_inicio']){
    $fecha_inicio=$_REQUEST['fecha_inicio'];
    $fecha_fin=$_REQUEST['fecha_final'];
}else{
   
    $fecha_inicio=date('d/m/Y');
    $fecha_fin=date('d/m/Y');
}

if($_POST['buscar']==1){
        $fecha_inicio=$_REQUEST['fecha_inicio'];
        $fecha_fin=$_REQUEST['fecha_final'];
        $boleto=$_REQUEST['boletos'];
        $pnr=$_REQUEST['pnr'];
        $usuario=$_REQUEST['usuario'];
}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Web Agencias - StarPeru</title>
<link href="../images/favicon_starperu.png" rel="shortcut icon" />
<link href="../css/modulo.css" rel="stylesheet" type="text/css" />
<link href="../css/entidad.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../plugins/flexigrid/css/flexigrid.css">
<link rel="stylesheet" type="text/css" href="../js/jqueryui/css/blitzer/jquery-ui-1.10.4.custom.css">
<script src="../js/jquery/jquery-1.8.0.min.js"></script>
<script src="../plugins/flexigrid/js/flexigrid.js"></script>
<!--<script src="../plugins/flexigrid/js/flexigrid.pack.js"></script>-->
<script src="../js/jqueryui/js/jquery-ui-1.10.4.custom.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    
$("#flex2").flexigrid({
//		 showToggleBtn: false,
		/* indicamos la direcci?n del archivo que desde el servidor se encarga de
		acceder a la base de datos, puede ser un XML o una cadena en formato JSON
		devuelta por un archivo PHP, por ejemplo.
		*/
	        url: '../../cd/Controlador/MovimientoControl.php?fecha_inicial=<?php echo $fecha_inicio;?>&fecha_final=<?php echo $fecha_fin;?>&usuario=<?php echo $usuario;?>&boleto=<?php echo $boleto?>&pnr=<?php echo $pnr ?>&movimientos=1',
		// indicamos en que formato se manejaran los datos
		dataType: 'json',
		/* establecemos una lista de columnas a usar, indicando :
		  display -> el nombre que vera el usuario
		  name -> nombre interno de la columna
		  width -> anchura de la columna
		  sortable -> si la columna se puede ordenar
		  align -> la alineaci?n del texto.
		*/
		colModel : [		  
		  {display: "Detalle", name : "view", width : 50,  align: 'center',sortable : false},
		  {display: "Ticket", name : "ticket", width : 40,  align: "center",sortable : false},
		  {display: "ID Mov.", name : "id_movimiento", width : 80,  align: "center",sortable : false},
		  {display: "Cod. Reserva", name : "reser_cod_kiu", width : 80,  align: "center",sortable : false},		 
		  {display: "RUC Entidad", name : "ruc_enti", width : 80,  align: 'center',sortable : false} ,
		  {display: "Tipo Oper.", name : "ope_tipo", width : 60, align: 'center',sortable : false},
		  {display: "Fec. Hora Oper.", name : "fecha_ope", width : 120, align: 'center',sortable : false},
		  {display: "Boleto", name : "boleto", width : 100,  align: 'center',sortable : false},
		  {display: "Ap. Paterno", name : "apepa_pas", width : 100,  align: 'left',sortable : false},
                  {display: "Ap. Materno", name : "apema_pas", width : 100,  align: 'left',sortable : false},
                  {display: "Nombres", name : "nom_pas", width : 120,  align: 'left',sortable : false},
		  {display: "Administrador", name : "ges_user", width : 60, align: 'center',sortable : false},
		  {display: "Delegado", name : "del_user", width : 60, align: 'center',sortable : false},		  
		  {display: "Cant. Boletos", name : "cant_boletos", width : 70,  align: 'center',sortable : false},
		  {display: "Tipo Serv.", name : "ser_tipo", width : 60,  align: 'center',sortable : false},		  
		  {display: "Tramo", name : "tramo", width : 40,  align: 'center',sortable : false},
		  {display: "N&ordm; de Vuelo", name : "nro_vuelo", width : 60, align: 'center',sortable : false},
		  {display: "Origen", name : "aero_ori", width : 40,  align: 'center',sortable : false},
		  {display: "Fec. Hora Origen", name : "f_h_origen", width : 120,  align: 'center',sortable : false},  
		  {display: "Destino", name : "aero_dest", width : 40,  align: 'center',sortable : false},
		  {display: "Fec. Hora Destino", name : "f_h_destino", width : 120,  align: 'center',sortable : false},	
		  {display: "Doc. Id. Pasajero", name : "pas_doc", width : 100, align: 'center',sortable : false},	  
		  {display: "Importe Tramo", name : "costo_tramo", width : 80,  align: 'right',sortable : false}	  
		],	
		// indicamos que columnas se pueden usar para filtrar las busquedas
		/*searchitems : [
		  { //display: 'Id Mov', name : 'id_movimiento'}
		  //,  {display: 'Name', name : 'name', isdefault: true}
		],*/
		// indicamos el nombre de la columna con la
		// q se ordenaran los registros por defecto
		//sortname: "",
		// indicamos que por defecto los registros se mostraran ascendentemente
		//sortorder: "",
		// esta propiedad permite activar o desactivar los botones de navegaci?n de la p?gina
		usepager: true,
		// titulo que aparecer? en la ventana
		title: 'Lista de Movimientos',
		// indicamos si se permite al usuario especificar el n?mero de resultados por p?gina.
		useRp: false,
		// numero de registros a mostrar, por defecto 10
		rp: 10,
		// esta propiedad permite establecer si se puede o no, minimizar la Flexigrid
		// (icono en la esquina superior derecha)
		showTableToggleBtn: false,
		// ancho de la flexigrid por defecto
		width: 1100,
		// alto de la flexigrid por defecto
		height: 250,
		resizable: false 
});


    $( ".detalle" ).dialog({ width: 960 });
    $( ".detalle" ).dialog('close');

    $( ".datepicker" ).datepicker({
            showOn: "button",
            closeText: 'Cerrar',
            prevText: '<Ant',
            nextText: 'Sig>',
            currentText: 'Hoy',
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
            dayNames: ['Domingo', 'Lunes', 'Martes', 'Mi�rcoles', 'Jueves', 'Viernes', 'S&aacute;bado'],
            dayNamesShort: ['Dom','Lun','Mar','Mie','Juv','Vie','S&aacute;b'],
            dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
            weekHeader: 'Sm',
            buttonImage: "../images/calendario.png",
            buttonImageOnly: true,
            buttonText: "Presione para ver el calendario",
            dateFormat: "dd/mm/yy"
    });
    
$.ajax({
        url:"../../cd/Controlador/MovimientoControl.php",
        type: "POST", 
        data:'listar=1',
        success: function(mensaje){

                 if($.trim(mensaje)==''){
                     $("#usuario").html('<option>NO EXISTEN DELEGADOS</option>');
                     $("#usuario").attr('disabled','disabled');
                 }else{
                     $("#usuario").html(mensaje);
                 }
            }
});   
        
}); 

function trim(texto){
	return texto.replace(/^\s+|\s+$/g,"");
}
function Detalle_movimiento(registro,detalle,codigo_reserva,ruc_entidad,tipo_operacion,fecha_registro,ticket,nombres_pasajero,gestor,delegado,cantidad_boleto,tipo_vuelo,tramo,numero_vuelo,origen,fecha_hora_salida,destino,fecha_hora_retorno,nro_documento,total_pagar){
     
      $.ajax({
            url: "../../cd/Controlador/MovimientoControl.php",
            data: "movimiento_detalle=1&registro="+registro+"&detalle="+detalle+"&codigo_reserva="+codigo_reserva+"&ruc_entidad="+ruc_entidad+
                    "&tipo_operacion="+tipo_operacion+"&fecha_registro="+fecha_registro+"&nombres_pasajero="+nombres_pasajero+
                    "&gestor="+gestor+"&delegado="+delegado+"&ticket="+ticket+"&cantidad_boleto="+cantidad_boleto+"&tipo_vuelo="+tipo_vuelo+
                    "&tramo="+tramo+"&numero_vuelo="+numero_vuelo+"&origen="+origen+"&fecha_hora_salida="+fecha_hora_salida+
                    "&destino="+destino+"&fecha_hora_retorno="+fecha_hora_retorno+"&nro_documento="+nro_documento+"&total_pagar="+total_pagar,
            type: "POST",
            cache: false,
           success: function(html) {
                if (html !=''){
                   $('.detalle').html(html);
                   $('.detalle').dialog({open:true,resizable: false,modal:true});
                }else{
                    alert('No hubo conexion, o hay una falla en la sentencia SQL!');
                }
            }
//            ,
//            error: function(obj,mensaje,e) { 
//                if(e=='Internal Server Error'){
//                    alert('Se ha producido un error interno. Consulte con el �rea de Sistemas de StarPer�');
//                }else{
//                    alert('Por favor revise su conexi�n a Internet y vuelva a intertarlo.');
//                }
//            }
        });
}

function dgEBI(obj){
	var val='';
	if(document.getElementById(obj)){
		val=trim(document.getElementById(obj).value);
	}
	return val;
}

function NumeroFecha(ev){
	tecla=(document.all) ? ev.keyCode : ev.which;
	if(tecla==8 || tecla==13 || tecla==0){
		return true;
	}
	var regEx=/^[0-9\/]+$/i;
	teAsc = String.fromCharCode(tecla);
	return regEx.test(teAsc);
}

function ComprobarNumeroFecha(texto){
	var v_texto=trim(texto);
	var ok=1;
	var regEx=/^[0-9\/]+$/i;
	if(v_texto.length>0){
		ok=0;
		if(v_texto.match(regEx)){
			ok=1;
		}
	}
	return ok;
}

function Paginacion(num){
	if(num.length>0){
		document.getElementById('nro').value=num;
		document.form1.submit();
	}
}

function DetalleMovimiento(mov){	
	$(".detalle").html('');
	if(mov.length>0){	
		$(".detalle").html(getDetMov(mov));
		$(".detalle").dialog('open')
	}
	
}

function ExportarExcelMov(){
	window.open('../../cd/Controlador/MovimientoControl.php?fecha_inicial=<?php echo $fecha_inicio;?>&fecha_final=<?php echo $fecha_fin;?>&usuario=<?php echo $usuario;?>&excel=1', '_blank', '');
}

function ExportarExcelDetalleMov(mov){
	if(mov.length>0){
		window.open('excel_detalle_movimiento.php?mov=' + mov, '_blank', '');
	}
}

 function getLineaCredito(){          
    var mensaje_linea_credito=0;
    var codigo_entidad=<?php echo trim($_SESSION["s_entidad"]); ?>;
    $.ajax({
        url:"../../cd/Controlador/MovimientoControl.php",
        type: "POST", 
        data:"obtener_linea_credito=1&codigo_entidad="+codigo_entidad,
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
</head>
<body onLoad=" LineaCredito();" >
<div id="div-main">
    <?php include('../includes/cabecera.php'); ?>
    <div id="div-contenido" style="background:none;">
    <?php include('../includes/menu.php'); ?>
        <div style="margin:0 3%;">
            <!-- Div Credito Personal -->
                        <div style="position: absolute; height: 60px; top: 0px; left: 42%; right: 42%">
                                <table width="160" cellpadding="0" cellspacing="0" border="0" style=" background-color: #F0F0F0;color: #dd1414">
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
             <!-- fin div Credito Personal -->
            <br>
            <br>
            <div style="width:1100px;margin:0px auto;">
                <form id="form1" name="form1" method="post" action="" autocomplete="off">
                  <table width="1100" border="0" cellpadding="0" cellspacing="0" style="background-color: #F0F0F0">
                        <tr>
                            <td height="26" colspan="7" align="left" class="titleTable gradiante" style="color:white;padding: 0px 5px;margin: 0px;font-weight: bold;">Opciones de B&uacute;squeda</td>
                        </tr>
                        <tr>
                             <td height="3" colspan="7"  style="background:#fdb813;"></td>
                        </tr>
                         <tr>
                             <td height="20" colspan="7"  ></td>
                        </tr>
                        <tr>
                            <td align="right">Fecha Inicio :</td>
                            <td > <input type="text" name="fecha_inicio" id="fecha_inicio" maxlength="10" placeholder="dd/mm/yyyy" style="width: 80px" onKeyPress="return NumeroFecha(event)" value="<?php echo $fecha_inicio;?>" readonly class="datepicker Cursor"/> </td>
                            <td align="right">PNR :</td>
                            <td><input type="text" name="pnr" id="pnr" maxlength="6" style="width: 100px;text-align: center" value="<?php echo $pnr;?>" /></td>
                            <td align="right" >Boleto :</td>
                            <td ><input type="text" name="boletos" id="boletos" maxlength="13" style="width: 100px;text-align: center" value="<?php echo $boleto;?>" /></td>
                            <td rowspan="3" align="center">
                                <input type="hidden" name="buscar" value="1"  />
                                <input type="submit" class="btn-red" name="btnbusqueda" id="btnbusqueda1" value="Consultar" title="Presionar para ver resultados ..." /></td>
                        </tr>  
                        <tr>
                            <td align="right">Fecha Final :</td>
                            <td > <input type="text" name="fecha_final" id="fecha_final" maxlength="10" placeholder="dd/mm/yyyy" style="width: 80px" onKeyPress="return NumeroFecha(event)" value="<?php echo $fecha_fin;?>" readonly class="datepicker Cursor"/> </td>
                            <td align="right">Usuario :</td>
                            <td colspan="4" >
                                <select name="usuario" id="usuario" style="width: 387px;height: 22px;border: #e2e2e2 1px solid;" >
                                </select>   
                            </td>
                        </tr>  
                         <tr>
                             <td height="20" colspan="7"  ></td>
                        </tr>
                    </table>
                </form>
                <br>
            </div>
            <div id="div_flex1" style="width:1100px;margin:0px auto;">
              <table id="flex2" style="display:none"></table>
            </div>
            <div class="detalle" title="Detalle del Movimiento"></div>
        </div>
    </div>
</div>
</body>
</html>