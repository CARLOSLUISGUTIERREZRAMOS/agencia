

function PaginacionNueva(num)
{

    document.getElementById('nro').value = num;
    document.getElementsByName('form1').submit();

}

window.onload = function () {
    $('#ruc_e').focus();
};

var objAjax = new MBAjax();

function sendData()
{
    objAjax.flag = false;
    objAjax.ajax();
}

/* ============================= REGISTRO ====================================== */
function setInsert(val_url, a_url)
{
    objAjax.valores = val_url;
    objAjax.metodo = 'POST';
    objAjax.url = a_url;
    sendData();
}

function registraEntidad()
{
    var ajax_url = sw = i = j = 0;
    var array_input_vacio = new Array();

    //var formulario= new Array('ruc_e', 'razon_e', 'abreviatura_e', 'direccion_e', 'linea_credito_e', 'dni_f', 'apep_f', 'apem_f', 'nombre_f', 'email_f', 'ofic_f', 'dni_g', 'apep_g', 'apem_g', 'nombre_g', 'email_g', 'ofic_g' );
    var formulario = new Array('ruc_e', 'razon_e', 'abreviatura_e', 'direccion_e', 'linea_credito_e', 'dni_f', 'apep_f', 'nombre_f', 'dni_g', 'apep_g', 'nombre_g', 'email_g', 'ofic_g');
    for (i in formulario)
    {
        if ($('#' + formulario[i]).val().length == 0 || $('#' + formulario[i]).val() == '')
        {
            array_input_vacio[j] = formulario[i];
            j++;
        } else {
            $('#' + formulario[i]).css('background', '#eeeeee');
            sw = 1;
        }
    }
    if (sw == 1 && array_input_vacio.length == 0)
    {
        if (($('#ruc_e').val().length > 0 && $('#ruc_e').val().length == 11) && ($('#dni_f').val().length >= 8 && $('#dni_f').val().length <= 15) && ($('#dni_g').val().length >= 8 && $('#dni_g').val().length <= 15))
        {
            ajax_url = 'ajax/ajax_valida_dataEntidad.php';
            var val_urlValidaEntidad = 'rucE=' + $('#ruc_e').val() + '&dniF=' + $('#dni_f').val() + '&dniG=' + $('#dni_g').val();
            objAjax.valores = val_urlValidaEntidad;
            objAjax.metodo = 'POST';
            objAjax.url = ajax_url;
            sendData();
            var val_validacionEntidad = objAjax.texto;
            if (val_validacionEntidad != 'eRUC' && val_validacionEntidad != 'eDNI')
            {
                var distrito = $('#distrito').val();
                if (distrito != 0)
                {
                    //RegistroDatosEntidad			
                    var val_urlEntidad = 'rucE=' + $('#ruc_e').val() + '&razonE=' + $('#razon_e').val() + '&abrevE=' + $('#abreviatura_e').val() + '&dirE=' + $('#direccion_e').val() + '&distriE=' + distrito + '&lineaE=' + $('#linea_credito_e').val(); //alert(val_urlEntidad);
                    ajax_url = 'ajax/ajax_insert_entidad.php';
                    setInsert(val_urlEntidad, ajax_url)
                    var val_idEntidad = objAjax.texto;
                    if (val_idEntidad != 'e01')
                    {
                        //RegistroDatosFuncionario
                        var val_urlFuncionario = 'dniF=' + $('#dni_f').val() + '&apepF=' + $('#apep_f').val() + '&apemF=' + $('#apem_f').val() + '&nomF=' + $('#nombre_f').val() + '&emailF=' + $('#email_f').val() + '&oficF=' + $('#ofic_f').val() + '&anexoF=' + $('#anexo_f').val() + '&celuF=' + $('#celu_f').val() + '&rpmF=' + $('#rpm_f').val() + '&rpcF=' + $('#rpc_f').val() + '&nextelF=' + $('#nextel_f').val() + '&entidadF=' + val_idEntidad;
                        ajax_url = 'ajax/ajax_insert_funcionario.php';
                        setInsert(val_urlFuncionario, ajax_url)
                        var val_idFuncionario = objAjax.texto;
                        if (val_idFuncionario != 'e2' && val_idFuncionario != 'e3' && val_idFuncionario != 'e4')
                        {
                            //RegistroDatosGestor
                            var val_urlGestor = 'dniG=' + $('#dni_g').val() + '&apepG=' + $('#apep_g').val() + '&apemG=' + $('#apem_g').val() + '&nomG=' + $('#nombre_g').val() + '&emailG=' + $('#email_g').val() + '&oficG=' + $('#ofic_g').val() + '&anexoG=' + $('#anexo_g').val() + '&celuG=' + $('#celu_g').val() + '&rpmG=' + $('#rpm_g').val() + '&rpcG=' + $('#rpc_g').val() + '&nextelG=' + $('#nextel_g').val() + '&entidadG=' + val_idEntidad + '&funcionarioG=' + val_idFuncionario;
                            ajax_url = 'ajax/ajax_insert_gestor.php';
                            setInsert(val_urlGestor, ajax_url)
                            var val_idGestor = objAjax.texto;
                            if (val_idGestor != 'e2' && val_idGestor != 'e3')
                            {
                                div_aviso_ok('#div-entidad-aviso');
                                document.getElementById('formRegistro').reset();
                                $('#ruc_e').focus();
                            } else if (val_idGestor == 'e2' || val_idGestor == 'e3')
                            {
                                div_aviso_error('#div-entidad-aviso', 'Error en el Proceso de Registro!');
                            }
                        } else if (val_idFuncionario != 'e2' || val_idFuncionario == 'e3' || val_idFuncionario == 'e4')
                        {
                            div_aviso_error('#div-entidad-aviso', 'Error en el Proceso de Registro!');
                        }
                    } else if (val_idEntidad == 'e01')
                    {
                        div_aviso_error('#div-entidad-aviso', 'Error en el Proceso de Registro!');
                    }
                } else {
                    div_aviso_error('#div-entidad-aviso', 'Por favor, Seleccione el Ubigeo.');
                }
            } else if (val_validacionEntidad == 'eRUC' || val_validacionEntidad == 'eDNI')
            {
                div_aviso_error('#div-entidad-aviso', 'Error, datos duplicados.<br/>RUC o DNI ya existen en el Sistema.');
            }
        } else {
            div_aviso_error('#div-entidad-aviso', 'Error, los datos de RUC o DNI no cumplen con el Formato.');
        }
    } else {
        for (i in array_input_vacio)
        {
            $('#' + array_input_vacio[i]).css('background', '#FDFCCC');
        }
        $('#' + array_input_vacio[0]).focus();
        div_aviso_error('#div-entidad-aviso', 'Por favor ingrese los Datos al formulario.');
    }
}

function actualizaEntidad()
{
    var ajax_url = sw = i = j = 0;
    var array_input_vacio = new Array();

    var formulario = new Array('ruc_e', 'razon_e', 'abreviatura_e', 'direccion_e', 'dni_f', 'apep_f', 'nombre_f');
    for (i in formulario)
    {
        if ($('#' + formulario[i]).val().length == 0 || $('#' + formulario[i]).val() == '')
        {
            array_input_vacio[j] = formulario[i];
            j++;
        } else {
            $('#' + formulario[i]).css('background', '#eeeeee');
            sw = 1;
        }
    }
    if (sw == 1 && array_input_vacio.length == 0)
    {
        if (($('#ruc_e').val().length > 0 && $('#ruc_e').val().length == 11) && ($('#dni_f').val().length > 0 && $('#dni_f').val().length <= 15))
        {
            var entidadId = $('#hdn_enti_id').val();
            var distrito = $('#distrito').val();
            var estado = $('#estado').val();
            var linea_credito = $('#hdn_linea_credito_e').val();
            var fcreacionE = $('#hdn_fcreacion_e').val();
            if (distrito != 0 && estado != -1)
            {
                var val_urlEntidad = 'idEnti=' + entidadId + '&rucE=' + $('#ruc_e').val() + '&razonE=' + $('#razon_e').val() + '&abrevE=' + $('#abreviatura_e').val() + '&dirE=' + $('#direccion_e').val() + '&distriE=' + distrito + '&lineaE=' + linea_credito + '&fcreacionE=' + fcreacionE + '&estadoE=' + estado;
                ajax_url = 'ajax/ajax_update_entidad.php';
                setInsert(val_urlEntidad, ajax_url)
                var val_idEntidad = objAjax.texto;
                if (val_idEntidad != 'e01')
                {
                    var funId = $('#hdn_ucorpId').val();
                    var fcreacionF = $('#hdn_fcreacion_f').val();
                    var tipoUcorp = $('#hdn_tipoUcorp').val();
                    var val_urlFuncionario = 'idFun=' + funId + '&dniF=' + $('#dni_f').val() + '&apepF=' + $('#apep_f').val() + '&apemF=' + $('#apem_f').val() + '&nomF=' + $('#nombre_f').val() + '&emailF=' + $('#email_f').val() + '&oficF=' + $('#ofic_f').val() + '&anexoF=' + $('#anexo_f').val() + '&celuF=' + $('#celu_f').val() + '&rpmF=' + $('#rpm_f').val() + '&rpcF=' + $('#rpc_f').val() + '&nextelF=' + $('#nextel_f').val() + '&fcreacionF=' + fcreacionF + '&entidadF=' + entidadId + '&idUcorpPadre=' + funId + '&tipoUcorp=' + tipoUcorp + '&estadoF=' + estado;
                    ajax_url = 'ajax/ajax_update_funcionario.php';
                    setInsert(val_urlFuncionario, ajax_url)
                    var val_idFuncionario = objAjax.texto;
                    if (val_idFuncionario != 'e2')
                    {
                        div_aviso_ok('#div-entidad-aviso');
                        setTimeout("window.location='entidad_listado.php';", 4000);
                    } else if (val_idFuncionario == 'e2')
                    {
                        div_aviso_error('#div-entidad-aviso', 'Error en el Proceso de Edici&oacute;n!');
                    }
                } else if (val_idEntidad == 'e01')
                {
                    div_aviso_error('#div-entidad-aviso', 'error en el Proceso de  Edici&oacute;n!');
                }
            } else {
                div_aviso_error('#div-entidad-aviso', 'Error, faltan datos de "Ubigeo" o "Estado"');
            }
        } else {
            div_aviso_error('#div-entidad-aviso', 'Error, los datos de RUC o DNI no cumplen con el Formato.');
        }
    } else {
        for (i in array_input_vacio)
        {
            $('#' + array_input_vacio[i]).css('background', '#FDFCCC');
        }
        $('#' + array_input_vacio[0]).focus();
        div_aviso_error('#div-entidad-aviso', 'Por favor ingrese los Datos al formulario.');
    }
}

function getProvincia(val)
{
    if (val != 0)
    {
        $('#distrito').html('<option value="0">Seleccione</option>');
        objAjax.valores = 'id=' + val;
        objAjax.metodo = 'POST';
        objAjax.url = 'ajax/ajax_get_provincia.php';
        sendData();
        $('#loadProvincia').html('<img src="../images/small_loader.gif" />');
        $('#provincia').html(objAjax.texto);
        setTimeout("$('#loadProvincia').empty()", 600);
    }
}

function getDistrito(val)
{
    if (val != 0)
    {
        objAjax.valores = 'id=' + val;
        objAjax.metodo = 'POST';
        objAjax.url = 'ajax/ajax_get_distrito.php';
        sendData();
        $('#loadDistrito').html('<img src="../images/small_loader.gif" />');
        $('#distrito').html(objAjax.texto);
        setTimeout("$('#loadDistrito').empty()", 600);
    }
}

function div_aviso_ok(id)
{
    var dom_error = $('.aviso_error')
    if (dom_error != '')
    {
        $(id).removeClass('aviso_error').empty();
    }
    $(id).addClass('aviso_ok').html('<p><img src="../images/icon_ok.png"/><span>Registro agregado!.. formulario libre para nuevos registros.</span></p>').fadeIn(1500);
    $(id).fadeOut(15000, function () {
        $(id).removeClass('aviso_ok').empty().css('display', 'none');
    });
}

function div_aviso_error(id, msg)
{
    $(id).addClass('aviso_error').html('<p><img src="../images/icon_alert.png"/><span>' + msg + '</span></p>').fadeIn(1500);
}
/* ============================= LISTADO ====================================== */
function iniciarListado()
{
    listaEntidad(1);
}

function listaEntidad(pag)
{
    var lista;
    objAjax.valores = 'pag=' + pag;
    objAjax.metodo = 'POST';
    objAjax.url = 'ajax/ajax_listar_entidad.php';
    sendData();
    if (objAjax.texto.length != 0)
    {
        eval(objAjax.texto);
        $('#recargar-lista').empty();
        $('#listaResultado').html(lista[0]);
        $('#listaResultado').css({'font-weight': 'normal', 'font-size': '11px', 'color': '#000000'})
    } else {
        $('#listaResultado').html('<p>No existen Datos para Visualizar. Por favor ingrese nuevos registros.</p>').css({'font-weight': 'bold', 'font-size': '15px', 'color': '#000099'});
    }
}

function ver(id)
{
    window.location = 'entidad_info.php' + '?id=' + id;
}

function editar(id)
{
    window.location = 'entidad_edicion.php' + '?id=' + id;
}

function cambiaEstado(var_id, var_estado)
{
    var consulta;
    if (var_estado == 0)
    {
        consulta = confirm("�Desea Desactivar la Entidad Seleccionada?");
    } else if (var_estado == 1)
    {
        consulta = confirm("Se activar� la Entidad Seleccionada?");
    }
    if (consulta)
    {
        objAjax.valores = 'id=' + var_id + '&estado=' + var_estado;
        objAjax.metodo = 'POST';
        objAjax.url = 'ajax/ajax_desactivar_entidad.php';
        sendData();
        if (objAjax.texto == 1)
        {
            iniciarListado();
        }
    }
}

function busqueda(pag)
{
    var val_url = amp = val = j = '';
    var busqueda = new Array('ruc', 'razon', 'abreviatura', 'departamento', 'provincia', 'distrito');
    for (i in busqueda)
    {
        if ($.trim($('#' + busqueda[i]).val()).length > 0 && $('#' + busqueda[i]).val() != 0)
        {
            amp = (j > 0) ? '&' : '';
            val = amp + busqueda[i];
            val_url += val + '=' + $('#' + busqueda[i]).val();
            j++;
        }
    }
    if (val_url.length > 0)
    {
        pag = (pag != undefined) ? pag : 1;
        val_url += '&pag=' + pag;
        objAjax.valores = val_url;
        objAjax.metodo = 'POST';
        objAjax.url = 'ajax/ajax_busqueda_entidad.php';
        sendData();
        var linkRecarga = '<a href="javascript:void(0);"><img src="../images/reload.png" style="margin:0 0 0 220px;" title="Recargar Listado..." onClick="javascript:iniciarListado();"/></a>';
        if (objAjax.texto.length > 0)
        {
            var lista;
            eval(objAjax.texto);
            $('#recargar-lista').html(linkRecarga);
            $('#listaResultado').empty();
            $('#listaResultado').html(lista[0]);
            $('#listaResultado').css({'font-weight': 'normal', 'font-size': '11px', 'color': '#000000'})
        } else {
            $('#recargar-lista').html(linkRecarga);
            $('#listaResultado').html('<p>No existen Datos para Visualizar. Por favor seleccione otras opciones de b�squeda.</p>').css({'font-weight': 'bold', 'font-size': '15px', 'color': '#000099'});
        }
    }
}
/* ======================================  SALDO ==============================================*/
function asignarSaldo()
{
    if ($('#monto').val().length > 0 && $('#hdn_idEntidad').val().length > 0 && $('#hdn_creditoEntidad').val().length > 0)
    {
        document.forms["form1"].submit();
    }
}
$(document).ready(function () {
//    $.msgbox({
//        open: false, type: 'alert', title: 'Alerta', content: ' ', overlay: true
//    });
    $('#editar_agencia').click(function () {

        var estado = $.trim($('#estado').val());
        var dni = $.trim($('#dni_a').val());
        var nom_comercial = $.trim($('#nom_comer_a').val());
        var apem = $.trim($('#apem_a').val());
        var nombres = $.trim($('#nom_a').val());
        var email = $.trim($('#email_a').val());
        var telefono = $.trim($('#telefono_a').val());
        var ciudad = $.trim($('#ciudad_a').val());
        var celular = $.trim($('#cel_a').val());
        var ruc = $.trim($('#ruc_a').val());
        var apep = $.trim($('#apep_a').val());
        var razon_social = $.trim($('#razon_social_a').val());
        var domicilio = $.trim($('#domicilio_a').val());
        var codigo_entidad = $.trim($('#codigo_entidad_a').val());
        if (estado == -1) {
            $.msgbox().content('Debe seleccionar un estado para la agencia');
            $.msgbox().open();
            return false;
        }

        if (ruc == '' || ruc == null) {
            $.msgbox().content('El campo RUC es un campo requerido');
            $.msgbox().open();
            return false;
        }
        if (nom_comercial == '' || nom_comercial == null) {
            $.msgbox().content('El campo nombre comercial es un campo requerido');
            $.msgbox().open();
            return false;
        }
        if (domicilio == '' || domicilio == null) {
            $.msgbox().content('El campo domicilio fiscal es un campo requerido');
            $.msgbox().open();
            return false;
        }
        if (celular == '' || celular == null) {
            $.msgbox().content('El campo celular es un campo requerido');
            $.msgbox().open();
            return false;
        }
        if (dni == '' || dni == null) {
            $.msgbox().content('El campo DNI es un campo requerido');
            $.msgbox().open();
            return false;
        }
        if (apep == '' || apep == null) {
            $.msgbox().content('El campo apellido paterno es un campo requerido');
            $.msgbox().open();
            return false;
        }
        if (apem == '' || apem == null) {
            $.msgbox().content('El campo apellido materno es un campo requerido');
            $.msgbox().open();
            return false;
        }
        if (nombres == '' || nombres == null) {
            $.msgbox().content('El campo nombre es un campo requerido');
            $.msgbox().open();
            return false;
        }
        if (email == '' || email == null) {
            $.msgbox().content('El campo email es un campo requerido');
            $.msgbox().open();
            return false;
        } else if (!/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(email)) {
            $.msgbox().content('El email ingresado no es correcto');
            $.msgbox().open();
            return false;
        }
        if (telefono == '' || telefono == null) {
            $.msgbox().content('El campo teléfono oficina es un campo requerido');
            $.msgbox().open();
            return false;
        }


        $.ajax({
            url: "../../cd/Controlador/AgenciaControl.php",
            data: "editar_agencia=1&dni=" + dni + "&codigo_entidad=" +
                    codigo_entidad + "&apep=" + apep +
                    "&apem=" + apem + "&nombres=" + nombres + "&email=" + email + "&telefono=" + telefono +
                    "&nom_comercial=" + nom_comercial + "&celular=" + celular + "&ciudad=" + ciudad +
                    "&razon_social=" + razon_social + "&ruc=" + ruc + "&domicilio=" + domicilio,
            type: "POST",
            cache: false,
            success: function (html) {
                var resultado = html.split('_|_')
//                console.log(html);
                if (resultado[0] == 1) {
                    $("#form").each(function () {
//                        this.reset();
                    });
                    window.location.href = 'agencia_info.php';

                } else if (resultado[0] == 4) {
                    $.msgbox().content('El email ingresado es incorrecto');
                    $.msgbox().open();

                } else {
                    $.msgbox().content('Lo sentimos hubo un error de conexion');
                    $.msgbox().open();
                }
            },
            error: function (obj, mensaje, e) {
                if (e == 'Internal Server Error') {
                    alert('Se ha producido un error interno. Consulte con el &Aacute;rea de Sistemas de StarPeru');
                } else {
                    alert('Por favor revise su conexi&oacute;n a Internet y vuelva a intertarlo.');
                }
            }
        });
    });
});