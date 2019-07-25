$(document).ready(function() {
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "timeOut": "100000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }

    // $('#CodigoCiudad').select2();

    $('#btn_login').click(function() {
        var usuario = $.trim($('#usuario').val());
        var password = $.trim($('#password').val());

        var error = 0;
        var tipoError = '';

        if (usuario == '') {
            error = error + 1;
            tipoError = 'U';
        }

        if (password == '') {
            error = error + 1;
            tipoError = 'C';
        }

        if (error == 0) {
            $('#form1').submit();
        } else {
            if (error == 2) {
                $('.error_login').text('Ud. debe ingresar un usuario y contraseÃ±a.');
            } else {
                if (tipoError == 'U') {
                    $('.error_login').text('Ud. debe ingresar un usuario.');
                } else {
                    $('.error_login').text('Ud. debe ingresar una contraseÃ±a.');
                }
            }
        }
    });

});

$('#Code_Pais').chosen({
    no_results_text: "¡Vaya, no se encontró nada!",
    width: "100%"
});

$('#CodigoCiudad').chosen({
    no_results_text: "¡Vaya, no se encontró nada!",
    width: "100%"
});

$(document).on('change', '#Code_Pais', function() {
    var id = this.value;
    var select = $("#CodigoCiudad");
    var ancho = this.parentElement.parentElement.parentElement.offsetWidth - 30 - 36;
    $.ajax({
        type: 'POST',
        url: 'cd/Controlador/LocalidadControl.php',
        data: 'localidad=1&Code_Pais=' + id,
        success: function(data) {
            var data = JSON.parse(data);
            select.chosen("destroy");
            var op = '';
            $.each(data, function(index, elem) {
                op += '<option value]="' + elem.Codigo + '">' + elem.Nombre + '</option>';
            });
            select.html(op);
            select.chosen({
                no_results_text: "¡Vaya, no se encontró nada!",
                width: ancho + "px"
            });
        },
        error: function(xhr, textStatus, errorThrown) {
            alert("Error: " + errorThrown);
        }
    });
});

$(document).on('submit', '#registrar-agencia', function(event) {
    event.preventDefault();
    var data = $(this).serialize();
    var button = $("#modalNuevaAgencia .btn-block");
    button.html('<i class="fa fa-refresh fa-lg fa-spin"></i> Procesando');
    button.attr('disabled', true);
    $.ajax({
        type: 'POST',
        url: 'cd/Controlador/RegistroAgencia.php',
        data: data,
        success: function(data) {
            button.html('Registrarme');
            button.attr('disabled', false);
            toastr.options.timeOut = "10000";
            var data = JSON.parse(data);
            if (data.data == 'ok') {
                toastr.options.timeOut = "100000";
                $("#registrar-agencia")[0].reset();
                $("#modalNuevaAgencia").modal('hide');
                toastr.success("Su agencia fue registrado correctamente, los administradores estan validando la información enviada y le llegará un correo de confirmación", "Mensaje de confirmación");
            } else if (data.data == 'ok-error') {
                alert('ok-error');
            } else if (data.data == 'registro-error') {
                alert('registro-error');
            } else if (data.data == 'error') {
                alert('error');
            }
        },
        error: function(xhr, textStatus, errorThrown) {
            alert("Error: " + errorThrown);
        }
    });
    return false;
});

$(document).on('blur', 'input[name=RUC]', function(arg) {
    if (this.value) {
        CambiarInputs(false);
        var data = 'verificar_ruc=1&RUC=' + this.value;
        $.ajax({
            type: 'POST',
            url: 'cd/Controlador/RegistroAgencia.php',
            data: data,
            success: function(data) {
                var data = JSON.parse(data);
                toastr.options.timeOut = "10000";
                if (data.data == undefined) {
                    CambiarInputs(true);
                    toastr.warning("El RUC <strong>" + data.RUC + "</strong> ya existe y esta registrado con la siguiente razón social <strong>" + data.RazonSocial + "</strong>", "Mensaje de Alerta");
                }
            },
            error: function(xhr, textStatus, errorThrown) {
                alert("Error: " + errorThrown);
            }
        });
        // return false;
    } else {
        CambiarInputs(false);
    }
});

function CambiarInputs(option) {
    var form = $("#modalNuevaAgencia .modal-body").find('input,button');
    $.each(form, function(index, elem) {
        if ($(this).hasClass('form-control') || $(this).hasClass('btn-success')) {
            if (this.id != 'RUC') {
                $(this).prop('disabled', option)
            }
        }
    });
}