<?php 
session_start();
error_reporting(E_ALL);
ini_set("display_errors",0);
date_default_timezone_set('America/Lima');
if($_SESSION['s_entra']==0){
    header('Location:../../index.php');
}

$fechahoy=date("d/m/Y");
$diahoy=date("d");
$meshoy=date("m");
$aniohoy=date("Y");


$dia_manana = date('d',time()+84600);
$mes_manana = date('m',time()+84600);
$ano_manana = date('Y',time()+84600);

$fechamanana=$dia_manana."/".$mes_manana."/".$ano_manana;
$fechahoy=$dia_manana."/".$mes_manana."/".$ano_manana;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//PE" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es-PE" lang="es-PE"> 
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title></title>
<link href="css/style.css" rel="stylesheet" type="text/css" media="all">

<link type="text/css" href="css/jquery/blitzer/jquery-ui-1.10.4.custom.css" rel="stylesheet" />
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
    .gradiante{
        background: linear-gradient(#f01515, darkred) !important;
        background: -webkit-linear-gradient(#f01515, darkred) !important;
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#f01515', endColorstr='darkred');
    }
</style>
<script type="text/javascript" src="js/jquery-1.7.min.js"></script>
<script type="text/javascript" src="js/jquery/jquery-ui-1.10.4.custom.js"></script>
<script type="text/javascript" src="js/site.js"></script>

<script type="text/javascript" language="javascript1.2" src="js/MB.js"></script>
<script type="text/javascript" language="javascript1.2" src="js/MBAjax.js"></script>
<script type="text/javascript" language="javascript1.2" src="js/funciones.js"></script>

<script type="text/javascript" language="javascript1.2">
    // var objA = new MBAjax();
    function ValorRadio(ide, input){
        //alert('Hola mundo ');
        ide=trim(ide);
        input=trim(input);
        if(ide.length>0 && input.length>0){
            if(document.getElementById(ide)){
                if(document.getElementById(input)){
                    document.getElementById(input).value='';
                    if(dgEBI(ide).length>0){
                        document.getElementById(input).value=dgEBI(ide);
                    }
                }
            }
        }
    }

    function EnviaValores(){
        //alert('Estoy enviando valores');
        $("#button").css('display','none');
        $("#cargando_img").css('display','block');
        var err=0;
        var v_origen=dgEBI('origen');
        var v_destino=dgEBI('destino');
        var v_tipo_viaje=dgEBI('tipo_viaje');
        var v_fecha0=dgEBI('fecha0');
        var v_fecha1='';
        if(v_tipo_viaje=='1'){
            v_fecha1=dgEBI('fecha1');
        }
        var v_adultos=dgEBI('adultos');
        var v_infantes=dgEBI('infantes');
        var int_fecha0=0;
        var int_fecha1=0;
        

        if(v_fecha0.length>0 && v_fecha1.length>0){
            var arr_fecha0=v_fecha0.split('/');
            var arr_fecha1=v_fecha1.split('/');
            int_fecha0=parseInt(arr_fecha0[2].toString() + arr_fecha0[1].toString() + arr_fecha0[0].toString());
            int_fecha1=parseInt(arr_fecha1[2].toString() + arr_fecha1[1].toString() + arr_fecha1[0].toString());
        }
        if(v_origen.length>0 && v_destino.length>0 && v_fecha0.length>0 && v_tipo_viaje.length>0 && (parseInt(v_adultos)>=parseInt(v_infantes)) && (v_tipo_viaje=='0' || (v_tipo_viaje=='1' && v_fecha1.length>0)) && (v_tipo_viaje=='0' || (v_tipo_viaje=='1' && int_fecha1>0 && int_fecha1>=int_fecha0))){
    
            document.form1.submit();
        }
        else{
            if(v_origen.length<=0){
                document.getElementById('resultado').innerHTML='* Seleccione una ciudad de origen.';
                Focus('origen');
            }
            else if(v_destino.length<=0){
                document.getElementById('resultado').innerHTML='* Seleccione la ciudad de destino.';
                Focus('destino');
            }
            else if(v_fecha0.length<=0){
                document.getElementById('resultado').innerHTML='* Seleccione la fecha de ida.';
                Focus('fecha0');
            }
            else if(parseInt(v_adultos)<parseInt(v_infantes)){
                document.getElementById('resultado').innerHTML='* Por seguridad, debe haber un adulto por cada infante a bordo.';
                Focus('adultos');
            }
            else if(v_tipo_viaje=='1' && v_fecha1.length<=0){
                document.getElementById('resultado').innerHTML='* Seleccione la fecha de regreso.';
                Focus('fecha1');
            }
            else if(int_fecha1>0 && int_fecha1<int_fecha0){
                document.getElementById('resultado').innerHTML='* La fecha de retorno no debe ser menor que la fecha de salida.';
                Focus('fecha1');
            }
            $("#button").css('display','block');
            $("#cargando_img").css('display','none');
            return false;
        }
    }
</script>
<script>
	$(function(){
        $.ajax({
            url:"../../cd/Controlador/PasarelaControl.php",
            type: "POST", 
            data:"obtener_ciudades=1",
            success: function(mensaje){
                $('#origen').html(mensaje);
            },
            error: function(obj,mensaje,e,a,b,c,d) { 
                if(e=='Internal Server Error'){
                    alert('Se ha producido un error interno. Consulte con el �rea de Sistemas de StarPer�');
                }
                else{
                    alert('Por favor revise su conexi�n a Internet y vuelva a intertarlo.');
                }
            }
        });
                   
		$('#fecha0').click(function (){ document.getElementById("xe").value='1' });
		$('#fecha1').click(function (){ document.getElementById("xe").value='2' });
		$('#origen').change(function(){
			var val_origen = $('#origen option:selected').val();
			if(val_origen!=''){
                $.ajax({
                    url:"../../cd/Controlador/PasarelaControl.php",
                    type: "POST", 
                    data:"obtener_ciudades=1&origen="+val_origen,
                    success: function(mensaje){
                        $('#destino').html(mensaje);
                    },
                    error: function(obj,mensaje,e) { 
                        if(e=='Internal Server Error'){
                            alert('Se ha producido un error interno. Consulte con el �rea de Sistemas de StarPer�');
                        }
                        else{
                            alert('Por favor revise su conexi�n a Internet y vuelva a intertarlo.');
                        }
                    }
                });
            }
		});
	
		var dates = $("#fecha0").datepicker({
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
                        defaultDate: null,
                        numberOfMonths: 1,
                        dateFormat: 'dd/mm/yy',
                        gotoCurrent: true ,
                        hideIfNoPrevNext: true,
                        maxDate: '+1y',
                        dateRange:true,
                        minDate: new Date(<?php echo $aniohoy; ?>, <?php echo $meshoy-1; ?>, <?php echo $diahoy; ?>),
                        onSelect: function( selectedDate ){
                            if($('#xe').val()=='1'){
                                var fecha = addToDate(selectedDate, 1);
                                document.getElementById("fecha1").value = fecha;
                                document.getElementById("xe").value='1';
                                Change();
                            }
                        }
		            });
        var fecha_salida = $("#fecha0").val();
        var fecha_split = fecha_salida.split("/");
        var dia_salida=fecha_split[0];
        var mes_salida=fecha_split[1];
        var anio_salida=fecha_split[2];
	
		var dates = $("#fecha1").datepicker({
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
                        defaultDate: null,
                        showOn: "button",
                        numberOfMonths: 1,
                        dateFormat: 'dd/mm/yy',
                        gotoCurrent: true ,
                        hideIfNoPrevNext: true,
                        maxDate: '+1y',
                        dateRange:true,
                        minDate: new Date(anio_salida, mes_salida-1, dia_salida) //new Date(2014, 04-1, 10)
		            });
				
		$('#radio').click(function(){
			var dates = $("#fecha0, #fecha1").datepicker({
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
                                defaultDate: null,
                                showOn: "button",
                                numberOfMonths: 1,
                                dateFormat: 'dd/mm/yy',
                                maxDate: '+1y',
                                minDate: new Date("2014/04/10"),
                                onSelect: function( selectedDate ){
                                    var option = this.id == "fecha0" ? "minDate" : "maxDate",
                                    instance = $( this ).data( "datepicker" ),
                                    date = $.datepicker.parseDate(
                                        instance.settings.dateFormat ||
                                        $.datepicker._defaults.dateFormat,
                                        selectedDate, instance.settings );
                                }
			});
			$("#fecha1").show();
			$("#fregreso").show();
		});
		
		$('#radio2').click(function(){
			$("#fecha1").hide();
			$("#fregreso").hide();
			$("#fec_regreso").hide();
			$("#fecha1").datepicker('destroy');
		});
	
        //Eliminar esta linea cuando contemplen en la web services  2 infantes
        $('#button').click(function(){

            if($('#infantes').val()>$('#adultos').val()){
                document.getElementById('resultado').innerHTML='* No est&aacute; permitido llevar m&aacute;s infantes que adultos.';
                Focus('infantes');
                return false;
            }
                        
            if((parseInt($('#infantes').val())+parseInt($('#adultos').val())+parseInt($('#menores').val()))>9){
                document.getElementById('resultado').innerHTML='*No est&aacute; permitido llevar m&aacute;s de 9 pasajeros.';
                Focus('adultos');
                return false; 
            }
        });
	});
</script>
<link href="css/estilos.css" rel="stylesheet" type="text/css" />
</head>
<body class="waiting">
    <table width="900" border="0" align="center" cellpadding="0" cellspacing="0" style=" background-color: #FFFFFF;/*border-left: 1px solid #DADAD8; border-right: 1px solid #DADAD8;*/">
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td height="50" align="center">
                <table id="menu_vuelo" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td height="19" class="activo">1. FECHA</td>
                        <td width="4"></td>
                        <td width="89" style="background-image: url(images/line_off.png); background-repeat: repeat-x"></td>
                        <td width="30"></td>
                        <td>2. VUELOS</td>
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
	        <td height="320" align="center" style="background-color: #FFFFFF">
                <form id="form1" name="form1" method="post" action="paso2.php" autocomplete="off" onSubmit="EnviaValores(); return false;">
                    <table width="900" border="0" cellpadding="0" cellspacing="0" style="background-color: #F0F0F0">
                        <tr>
                            <td colspan="5"  height="1"  style="background: #323131;"></td>
                        </tr> 
                        <tr>
                            <td colspan="5" align="left" height="30" class="titleTable" style="color:#323131;font-size: 24px;background: #f0f0f0;font-family:Tahoma, Geneva, sans-serif; ">Paso 1</td>
                        </tr>
                        <tr>
                            <td colspan="5"  height="1"  style="background: #323131;"></td>
                        </tr>  
                        <tr>
                            <td colspan="5" style="background:white;" height="10" >&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="5" align="left" class="titleTable gradiante" style="color:white;">Seleccione el punto de partida y el destino del viaje</td>
                        </tr>
                        <tr>
                            <td height="3" colspan="5"  style="background:#fdb813;"></td>
                        </tr>
                        <tr >
                            <td width="20" height="30"></td>
                            <td width="220" align="left" valign="bottom">Ciudad de origen:</td>
                            <td width="220" align="left" valign="bottom">Fecha de Ida:</td>
                            <td width="220" align="left" valign="bottom">Ciudad de Destino:</td>
                            <td width="220" align="left" valign="bottom" id="fec_regreso">Fecha de Regreso:</td>
                        </tr>
                        <tr>
                            <td height="30"></td>
                            <td align="left">
                                <select name="origen" id="origen" class="reserva_option bg2" onChange="Change()" style="width: 140px;border: 1px solid #BDBDBD;">
                                </select>
                            </td>
                            <td align="left">
                                <input id="fecha0" name="fecha0" type="text" class="datepicker Cursor" readonly value="<?php echo $fechahoy;?>" style="width: 100px;text-align: center;margin-top: 3px;border: 1px solid #BDBDBD;">
                            </td>
                            <td align="left" id="td_cbo_destino">
                                <select name="destino" id="destino" class="reserva_option bg2" onChange="Change()" style="width: 140px;border: 1px solid #BDBDBD;">
                                    <option value="" selected>- Hacia -</option>
                                </select>
                            </td>
                            <td align="left" id="fregreso">
                                <input id="fecha1" name="fecha1" type="text" class="datepicker Cursor" readonly value="<?php echo $fechamanana; ?>" style="width: 100px;text-align: center;margin-top: 3px;border: 1px solid #BDBDBD;" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5">&nbsp;</td>
                        </tr> 
                        <tr>
                            <td height="30"></td>
                            <td align="left">
                                <label>
                                    <input type="radio" name="rbt_tipo_viaje" id="radio" value="1" checked onClick="ValorRadio(this.id, 'tipo_viaje')"> Ida y Vuelta
                                </label>
                            </td>
                            <td align="left">
                                <label>
                                    <input type="radio" name="rbt_tipo_viaje" id="radio2" value="0" onClick="ValorRadio(this.id, 'tipo_viaje')"> S&oacute;lo Ida
                                </label>
                            </td>
                            <link href="css/estilos.css" rel="stylesheet" type="text/css"/>
                            <td>
                                <input type="hidden" id="tipo_viaje" name="tipo_viaje" value="1">
                                <input type="hidden" value="1" id="xe" name="xe">
                                <input type="hidden" value="1" id="paso2" name="paso2">
                                <input type="hidden" class="datepicker" value="Fecha de salida">
                            </td>
                            <td>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5">&nbsp;</td>
                        </tr> 
                    </table>
                    <br>
                    <br>
                    <table width="900" border="0" cellpadding="0" cellspacing="0" style="background-color: #F0F0F0">
                        <tr>
                            <td colspan="4" align="left" class="titleTable gradiante" style="color:white;">Seleccione la cantidad de pasajeros</td>
                        </tr>
                        <tr>
                            <td height="3" colspan="5"  style="background:#fdb813;"></td>
                        </tr>
                        <tr>
                            <td height="30" width="220" align="left" valign="bottom" style="padding-left: 20px;">N&ordm; Adultos (12 A&ntilde;os a m&aacute;s):</td>
                            <td align="left" width="220" valign="bottom">N&ordm; Ni&ntilde;os (2 -11 A&ntilde;os):</td>
                            <td align="left" valign="bottom">N&ordm; Infantes (0 -1 a&ntilde;o 11 Meses):</td>
                            <td rowspan="2" valign="bottom">
                                <img id="cargando_img" src="images/cargando.gif" style="display: none;margin-right: 47px !important;"/> 
                                <input type="submit" name="button" id="button" value="Continuar" class="btn-red">     
                            </td>
                        </tr>
                        <tr>
                            <td height="30" width="220" align="left" style="padding-left: 20px;" valign="bottom">
                                <select name="adultos" id="adultos" class="reserva_option" style="width:80px;">
                                    <option value="1">01</option>
                                    <option value="2">02</option>
                                    <option value="3">03</option>
                                    <option value="4">04</option>   
                                    <option value="5">05</option>
                                    <option value="6">06</option>
                                    <option value="7">07</option>
                                    <option value="8">08</option>
                                    <option value="9">09</option>
                                </select>
                            </td>
                            <td align="left" width="220" valign="bottom">
                                <select name="menores" id="menores" class="reserva_option" onChange="Change()" style="width:80px;">
                                    <option value="0">00</option>
                                    <option value="1">01</option>
                                    <option value="2">02</option>
                                    <option value="3">03</option>
                                    <option value="4">04</option>            
                                </select>
                            </td>
                            <td align="left" valign="bottom">
                                <select name="infantes" id="infantes" class="reserva_option" onChange="Change()" style="width:80px;">
                                    <option value="0">00</option>
                                    <option value="1">01</option>
                                    <option value="2">02</option>
                                    <option value="3">03</option>         
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td height="50"></td>
                            <td align="left" id="resultado" style="color: #CC0033"></td>
                            <td></td>
                        </tr>
                    </table>
                    <br>
                </form>                  
            </td>
        </tr>
        <tr>
            <td height="70" width="900"  align="left">
                <table width="900" height="70" border="0" cellpadding="0" cellspacing="0" style="border: 1px solid #DCE0EE; background-color: #F0F0F0">
                    <tr>
                        <td  width="900"  align="left"  style="padding-left: 10px;">
                            Si usted o uno de sus acompañantes requiere de un <a href="http://www.starperu.com/es/servicios-especiales.html" target="_blank">Servicio Especial</a>, por favor comunicarse con su coordinador de Aerolíneas Star Perú.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>