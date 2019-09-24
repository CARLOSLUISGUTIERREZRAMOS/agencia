<?php
session_start();
error_reporting(E_ALL);
ini_set("display_errors", 0);
date_default_timezone_set('America/Lima');
if ($_SESSION['s_entra'] == 0) {
    header('Location:../../index.php');
}
$Tipo = $_SESSION['s_tipo'];
$Tipo2 = $_SESSION['s_tipo2'];
$directorio = '../';
$directorio_imagen = '../';

if ($_REQUEST['fecha_inicio']) {
    $fecha_inicio = $_REQUEST['fecha_inicio'];
    $fecha_fin = $_REQUEST['fecha_final'];
} else {

    $fecha_inicio = date('d/m/Y');
    $fecha_fin = date('d/m/Y');
}

if ($_POST['buscar'] == 1) {
    $fecha_inicio = $_REQUEST['fecha_inicio'];
    $fecha_fin = $_REQUEST['fecha_final'];
    $boleto = $_REQUEST['boletos'];
    $pnr = $_REQUEST['pnr'];
    $usuario_dni = $_REQUEST['usuario_dni'];
    $formaPago = $_REQUEST['formaPago'];
    $estado = $_REQUEST['estado'];
}
require_once("../../config.php");
?>

<?php ob_start(); ?>
<link href="<?= $url ?>/cp/css/entidad.css" rel="stylesheet" type="text/css" />
<link href="<?= $url ?>/cp/plugins/flexigrid/css/flexigrid.css" rel="stylesheet" type="text/css" />
<link href="<?= $url ?>/cp/js/jqueryui/css/blitzer/jquery-ui-1.10.4.custom.css" rel="stylesheet" type="text/css" />
<script src="<?= $url ?>/cp/js/jquery/jquery-1.8.0.min.js"></script>
<script src="<?= $url ?>/cp/plugins/flexigrid/js/flexigrid.js"></script>
<script src="<?= $url ?>/cp/js/jqueryui/js/jquery-ui-1.10.4.custom.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#flex2").flexigrid({
            // showToggleBtn: false,
            /* indicamos la direcci?n del archivo que desde el servidor se encarga de
             acceder a la base de datos, puede ser un XML o una cadena en formato JSON
             devuelta por un archivo PHP, por ejemplo.
             */
            url: '<?= $url ?>/cd/Controlador/MovimientoControl.php?fecha_inicial=<?php echo $fecha_inicio; ?>&fecha_final=<?php echo $fecha_fin; ?>&usuario_dni=<?php echo $usuario_dni; ?>&boleto=<?php echo $boleto ?>&pnr=<?php echo $pnr ?>&formaPago=<?php echo $formaPago ?>&estado=<?php echo $estado ?>&movimientos=1',
            // indicamos en que formato se manejaran los datos
            dataType: 'json',
            /* establecemos una lista de columnas a usar, indicando :
             display -> el nombre que vera el usuario
             name -> nombre interno de la columna
             width -> anchura de la columna
             sortable -> si la columna se puede ordenar
             align -> la alineaci?n del texto.
             */
            colModel: [
                {display: "Detalle", name: "view", width: 50, align: 'center', sortable: true},
                {display: "Ticket", name: "ticket", width: 40, align: "center", sortable: true},
                {display: "ID Mov.", name: "id_movimiento", width: 80, align: "center", sortable: true},
                {display: "Cod. Reserva", name: "reser_cod_kiu", width: 80, align: "center", sortable: true},
                {display: "RUC", name: "ruc_pasajero", width: 80, align: 'center', sortable: true},
                {display: "Tipo Oper.", name: "ope_tipo", width: 60, align: 'center', sortable: true},
                {display: "Hora Registro", name: "hora_registro", width: 120, align: 'center', sortable: true},
                {display: "Boleto", name: "boleto", width: 100, align: 'center', sortable: true},
                {display: "Forma de Pago", name: "tarjeta", width: 90, align: 'center', sortable: true},
                {display: "Ap. Paterno", name: "apepa_pas", width: 100, align: 'center', sortable: true},
                {display: "Ap. Materno", name: "apema_pas", width: 100, align: 'center', sortable: true},
                {display: "Nombres", name: "nom_pas", width: 120, align: 'center', sortable: true},
                {display: "DNI Usuario", name: "ges_user", width: 80, align: 'center', sortable: true},
                {display: "Usuario", name: "del_user", width: 200, align: 'center', sortable: true},
                {display: "Cant. Boletos", name: "cant_boletos", width: 70, align: 'center', sortable: true},
                {display: "Tipo Serv.", name: "ser_tipo", width: 60, align: 'center', sortable: true},
                {display: "Tramo", name: "tramo", width: 40, align: 'center', sortable: true},
                {display: "N&ordm; de Vuelo", name: "nro_vuelo", width: 60, align: 'center', sortable: true},
                {display: "Origen", name: "aero_ori", width: 40, align: 'center', sortable: true},
                {display: "Fec. Hora Origen", name: "f_h_origen", width: 120, align: 'center', sortable: true},
                {display: "Destino", name: "aero_dest", width: 40, align: 'center', sortable: true},
                {display: "Fec. Hora Destino", name: "f_h_destino", width: 120, align: 'center', sortable: true},
                {display: "Doc. Id. Pasajero", name: "pas_doc", width: 100, align: 'center', sortable: true},
                {display: "Total Pasajero", name: "total_sin_descuento", width: 100, align: 'center', sortable: true},
                {display: "Total Agencia", name: "costo_tramo", width: 100, align: 'center', sortable: true},
                {display: "Comisión", name: "ganancias", width: 80, align: 'right', sortable: true}
            ],
            // indicamos que columnas se pueden usar para filtrar las busquedas
            /*searchitems : [
             //                  { //display: 'Id Mov', name : 'id_movimiento'}
             ,  {display: 'Name', name : 'name', isdefault: true}
             ],*/
            // indicamos el nombre de la columna con la
            // q se ordenaran los registros por defecto
//            sortname: "",
            // indicamos que por defecto los registros se mostraran ascendentemente
//            sortorder: "",
            // indicamos el nombre de la columna con la
            // q se ordenaran los registros por defecto
//                sortname: "",
            // indicamos que por defecto los registros se mostraran ascendentemente
            /* mostrar ordenador por id */
//                sortorder: "", /* ordenaor ascendente o descendente */
            // esta propiedad permite activar o desactivar los botones de navegaci?n de la p?gina
            usepager: true,
            // titulo que aparecer? en la ventana
            title: 'Lista de Movimientos',
            // indicamos si se permite al usuario especificar el n?mero de resultados por p?gina.
            useRp: true,
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

        $(".detalle").dialog({width: 960});
        $(".detalle").dialog('close');
        $(".detalle2").dialog({width: 600});
        $(".detalle2").dialog('close');

        $(".datepicker").datepicker({
            showOn: "button",
            closeText: 'Cerrar',
            prevText: '<Ant',
            nextText: 'Sig>',
            currentText: 'Hoy',
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
            dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'S&aacute;bado'],
            dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Juv', 'Vie', 'S&aacute;b'],
            dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
            weekHeader: 'Sm',
            buttonImage: "../images/calendario.png",
            buttonImageOnly: true,
            buttonText: "Presione para ver el calendario",
            dateFormat: "dd/mm/yy"
        });

        $.ajax({
            url: "<?= $url ?>/cd/Controlador/MovimientoControl.php?usuario_dni=<?php echo $usuario_dni; ?>",
            type: "POST",
            data: 'listar=1',
            success: function (mensaje) {
                if ($.trim(mensaje) == '') {
                    $("#usuario").html('<option>NO EXISTEN DELEGADOS</option>');
                    $("#usuario").attr('disabled', 'disabled');
                } else {
                    $("#usuario").html(mensaje);
                }
            }
        });

    });

    function trim(texto) {
        return texto.replace(/^\s+|\s+$/g, "");
    }

    function Detalle_movimiento(registro, detalle, codigo_reserva, ruc_entidad, tipo_operacion, fecha_registro, ticket, tarjeta, num_tarjeta, nombres_pasajero,
            gestor, delegado, nom_usuario, cantidad_boleto, tipo_vuelo, tramo, numero_vuelo, origen, fecha_hora_salida,
            destino, fecha_hora_retorno, nro_documento, porcentaje, comision_tarifa, total_pagar) {

        $.ajax({
            url: "<?= $url ?>/cd/Controlador/MovimientoControl.php",
            data: "movimiento_detalle=1&registro=" + registro + "&detalle=" + detalle + "&codigo_reserva=" + codigo_reserva + "&ruc_entidad=" + ruc_entidad +
                    "&tipo_operacion=" + tipo_operacion + "&fecha_registro=" + fecha_registro + "&ticket=" + ticket + "&tarjeta=" + tarjeta + "&num_tarjeta=" + num_tarjeta +
                    "&nombres_pasajero=" + nombres_pasajero +
                    "&gestor=" + gestor + "&delegado=" + delegado + "&nom_usuario=" + nom_usuario + "&cantidad_boleto=" + cantidad_boleto + "&tipo_vuelo=" + tipo_vuelo +
                    "&tramo=" + tramo + "&numero_vuelo=" + numero_vuelo + "&origen=" + origen + "&fecha_hora_salida=" + fecha_hora_salida +
                    "&destino=" + destino + "&fecha_hora_retorno=" + fecha_hora_retorno + "&nro_documento=" + nro_documento + "&porcentaje=" + porcentaje +
                    "&comision_tarifa=" + comision_tarifa + "&total_pagar=" + total_pagar,
            type: "POST",
            cache: false,
            success: function (html) {
                if (html != '') {
                    $('.detalle').html(html);
                    $('.detalle').dialog({open: true, resizable: false, modal: true});
                } else {
                    alert('No hubo conexion, o hay una falla en la sentencia SQL!');
                }
            }
        });
    }
    function Forma_pago(registro) {
        $.ajax({
            url: "<?= $url ?>/cd/Controlador/MovimientoControl.php",
            data: "forma_pago=1&registro=" + registro,
            type: "POST",
            cache: false,
            success: function (html) {
                if (html != '') {
                    $('.detalle2').html(html);
                    $('.detalle2').dialog({open: true, resizable: false, modal: true});
                } else {
                    alert('No hubo conexion, o hay una falla en la sentencia SQL!');
                }
            }
        });
    }

    function dgEBI(obj) {
        var val = '';
        if (document.getElementById(obj)) {
            val = trim(document.getElementById(obj).value);
        }
        return val;
    }

    function NumeroFecha(ev) {
        tecla = (document.all) ? ev.keyCode : ev.which;
        if (tecla == 8 || tecla == 13 || tecla == 0) {
            return true;
        }
        var regEx = /^[0-9\/]+$/i;
        teAsc = String.fromCharCode(tecla);
        return regEx.test(teAsc);
    }

    function ComprobarNumeroFecha(texto) {
        var v_texto = trim(texto);
        var ok = 1;
        var regEx = /^[0-9\/]+$/i;
        if (v_texto.length > 0) {
            ok = 0;
            if (v_texto.match(regEx)) {
                ok = 1;
            }
        }
        return ok;
    }

    function Paginacion(num) {
        if (num.length > 0) {
            document.getElementById('nro').value = num;
            document.form1.submit();
        }
    }

    function DetalleMovimiento(mov) {
        $(".detalle").html('');
        if (mov.length > 0) {
            $(".detalle").html(getDetMov(mov));
            $(".detalle").dialog('open')
        }

    }
    function ExportarExcelMov() {
        window.open('<?= $url ?>/cd/Controlador/MovimientoControl.php?fecha_inicial=<?php echo $fecha_inicio; ?>&fecha_final=<?php echo $fecha_fin; ?>&usuario_dni=<?php echo $usuario_dni; ?>&boleto=<?php echo $boleto ?>&pnr=<?php echo $pnr ?>&formaPago=<?php echo $formaPago ?>&estado=<?php echo $estado ?>&excel=1', '_blank', '');
    }

    function ExportarExcelDetalleMov(mov) {
        if (mov.length > 0) {
            window.open('excel_detalle_movimiento.php?mov=' + mov, '_blank', '');
        }
    }
</script>
<?php $style_script_contenido = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php require_once(HTML_RECURSO_PATH); ?>
<!-- fin div Credito Personal -->
<br>
<br>
<div style="width:1100px;margin:0px auto;">
    <form id="form1" name="form1" method="post" action="" autocomplete="off">
        <table width="1100" border="0" cellpadding="0" cellspacing="0" style="background-color: #F0F0F0">
            <tr>
                <td height="26" colspan="12" align="left" class="titleTable gradiante" style="color:white;padding: 0px 5px;margin: 0px;font-weight: bold;">Opciones de B&uacute;squeda</td>
            </tr>
            <tr>
                <td height="3" colspan="12"  style="background:#fdb813;"></td>
            </tr>
            <tr>
                <td height="20" colspan="12"  ></td>
            </tr>
            <tr>
                <td align="right">Fecha Inicio :</td>
                <td > <input type="text" name="fecha_inicio" id="fecha_inicio" maxlength="10" placeholder="dd/mm/yyyy" style="width: 80px" onKeyPress="return NumeroFecha(event)" value="<?php echo $fecha_inicio; ?>" readonly class="datepicker Cursor"/> </td>
                <td align="right" >PNR :</td>
                <td><input type="text" name="pnr" id="pnr" maxlength="6" style="width: 100px;text-align: center" value="<?php echo $pnr; ?>" /></td>
                <td align="right" >Boleto :</td>
                <td ><input type="text" name="boletos" id="boletos" maxlength="13" style="width: 120px;text-align: center" value="<?php echo $boleto; ?>" /></td>
                 <td align="right" >Estado :</td>
                <td >
                    <select name="estado" id="estado" style="width: 100px;height: 22px;border: #e2e2e2 1px solid;" >
                        <option value>SELECCIONE</option>
                        <option  <?= ($estado=="0") ? 'selected' : '' ?>  value="0" >SIN BOLETO</option>
                        <option <?= ($estado=="1") ? 'selected' : '' ?> value="1">CON BOLETO</option>
                    </select>   
                </td>       
                <td rowspan="3" >
                    <input type="hidden" name="buscar" value="1"  />
                    <input type="submit" class="btn-red" name="btnbusqueda" id="btnbusqueda1" value="Consultar" title="Presionar para ver resultados ..." />
                </td>
            </tr>  
            <tr>
                <td align="right">Fecha Final :</td>
                <td > <input type="text" name="fecha_final" id="fecha_final" maxlength="10" placeholder="dd/mm/yyyy" style="width: 80px" onKeyPress="return NumeroFecha(event)" value="<?php echo $fecha_fin; ?>" readonly class="datepicker Cursor"/> </td>
                <?php if($Tipo2=='administrador'){?>
                    <td align="right" col>Usuario :</td>
                    <td colspan="3">
                        <select name="usuario_dni" id="usuario" style="width: 387px;height: 22px;border: #e2e2e2 1px solid;" >
                        </select>   
                    </td>
                <?php } ?>
                
                <td align="right">Forma de Pago :</td>
                <td >
                    <select name="formaPago" id="formaPago" style="width: 100px;height: 22px;border: #e2e2e2 1px solid;" >
                        <option value>SELECCIONE</option>
                        <option  <?= ($formaPago=="VI") ? 'selected' : '' ?>  value="VI" >VISA</option>
                        <option <?= ($formaPago=="MC") ? 'selected' : '' ?> value="MC">MASTERCARD</option>
                        <option <?= ($formaPago=="DC") ? 'selected' : '' ?> value="DC">DINERS CLUB</option>
                        <option <?= ($formaPago=="AX") ? 'selected' : '' ?> value="AX">AMEX</option>
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
<div class="detalle2" title="Forma de Pago"></div>
<?php include(FOOTER_PATH); ?> 