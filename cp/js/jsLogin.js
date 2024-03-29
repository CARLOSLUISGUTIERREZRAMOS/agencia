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

    if (location.search) {
        var pathname = location.pathname;
        var q = location.search.split('=');
        var html;
        if (q[1] == 'procesado') {
            html = '<div class="alert alert-success alert-dismissible">' +
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                '<span aria-hidden="true">&times;</span>' +
                '</button>' +
                '<strong>¡Cuenta verificada!</strong> Ahora puede iniciar sesión y empezar a vender pasajes por nuestra web agencias.' +
                '</div>';
        } else if (q[1] == 'no-procesado') {
            html = '<div class="alert alert-warning alert-dismissible">' +
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                '<span aria-hidden="true">&times;</span>' +
                '</button>' +
                '<strong>Opss!</strong> Hubo un error al momento de procesar la confirmación de la cuenta, vuelva intentar de nuevo.' +
                '</div>';
        } else if (q[1] == 'not-found') {
            html = '<div class="alert alert-info alert-dismissible">' +
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                '<span aria-hidden="true">&times;</span>' +
                '</button>' +
                '<strong>Opss!</strong> Su cuenta ya esta verificada, ingrese los accesos enviados a su correo.' +
                '</div>';
        } else if (q[1] == 'no-token') {
            html = '<div class="alert alert-danger alert-dismissible">' +
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                '<span aria-hidden="true">&times;</span>' +
                '</button>' +
                '<strong>Opss!</strong> Token invalido, por favor dar click en el boton <b>Verificar ahora</b> o copie correctamente el link enviado a su correo para poder verificar su cuenta.' +
                '</div>';
        } else if (q[1] == 'sin-confirmar') {
            html = '<div class="alert alert-danger alert-dismissible">' +
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                '<span aria-hidden="true">&times;</span>' +
                '</button>' +
                '<strong>¡Su cuenta no está verificada!</strong> Confirme su correo electrónico.' +
                '</div>';
        } else if (q[1] == 'incorrectos') {
            html = '<div class="alert alert-danger alert-dismissible">' +
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                '<span aria-hidden="true">&times;</span>' +
                '</button>' +
                '<strong>¡Datos incorrectos!</strong> Usuario o contraseña incorrectos' +
                '</div>';
        } else if (q[1] == 0) {
            html = '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                '<span aria-hidden="true">&times;</span>' +
                '</button>' +
                '<strong>¡Usuario cancelado!</strong> Por favor pongase en contacto con el Administrador del sistema.' +
                '</div>';
        }
        $(".mensaje-usuario").html('<div class="col-md-10 col-md-offset-1">' + html + '</div>');
        window.history.pushState('', document.title, pathname)
        setTimeout(function() {
            $(".mensaje-usuario").html('');
        }, 20000);
    }

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
    ClaseRUC(id);
    var ancho = this.parentElement.parentElement.parentElement.offsetWidth - 30 - 36;
    CambiarSelectPais(id, ancho);
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

$(document).on('blur', '.ruc-peru', function(arg) {
    if (this.value) {
        if (this.value.length == 11) {
            if (ValidarRucDigito(this.value)) {
                CambiarInputs(false);
                ValidarRucExistente(this.value);
            } else {
                swal({
                    title: "Mensaje de Alerta",
                    text: 'El usuario no existe',
                    icon: "warning",
                    timer: 2000,
                    buttons: {
                        confirm: {
                            className: 'btn btn-warning'
                        }
                    },
                });
                CambiarInputs(true);
            }
        } else {
            swal({
                title: "Mensaje de Alerta",
                text: 'El RUC debe tener 11 digitos',
                icon: "warning",
                timer: 2000,
                buttons: {
                    confirm: {
                        className: 'btn btn-warning'
                    }
                },
            });
            CambiarInputs(true);
        }
    } else {
        CambiarInputs(false);
    }
});

$(document).on('blur', '.ruc-extranjero', function() {
    if (this.value) {
        ValidarRucExistente(this.value);
    }
});

$(document).on('keypress', '.ruc-peru', function() {
    var regex = new RegExp("^[0-9]+$");
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if (!regex.test(key)) {
        event.preventDefault();
        return false;
    } else {
        var len = $(this).val().length;
        if (len > 10) {
            event.preventDefault();
            return false;
        }
    }
});

$(document).on('click', '.modal-agencia', function() {
    $("#modalNuevaAgencia").modal();
    $("#registrar-agencia")[0].reset();
    ClaseRUC('PE');
    CambiarInputs(false);
    $("#Code_Pais").val('PE').trigger('chosen:updated')
    var ancho = $("#Code_Pais")[0].parentElement.parentElement.parentElement.offsetWidth - 30 - 36;
    CambiarSelectPais('PE', ancho);
});

$(document).on('keyup', 'input[name=documento]', function() {
    if (this.value.length > 0) {
        $(".resetear-password").attr('disabled', false);
    } else {
        $(".resetear-password").attr('disabled', true);
    }
});

$(document).on('click', '.resetear-password', function() {
    var doc = $("input[name=documento]").val();
    if (doc) {
        $("#modalPassword").modal('hide');
        mostrarLoadingConsulta();
        $.ajax({
            type: 'POST',
            url: 'cd/Controlador/LoginControl.php',
            data: 'resetear_password=1 && documento=' + doc,
            success: function(data) {
                ocultarLoadingConsulta();
                var data = JSON.parse(data);
                if (data.code == 200) {
                    var contenido = "Hemos enviado un correo electronico " + data.email + " de la cuenta asociada al usuario.";
                    swal({
                        title: "¡Listo!",
                        text: contenido,
                        icon: "success",
                        timer: 4000,
                        buttons: {
                            confirm: {
                                className: 'btn btn-success'
                            }
                        },
                    });
                } else if (data.code == 422) {
                    swal({
                        // title: "¡Listo!",
                        text: 'Hubo algun error, recarga la página',
                        icon: "warning",
                        timer: 3000,
                        buttons: {
                            confirm: {
                                className: 'btn btn-warning'
                            }
                        },
                    });
                } else {
                    swal({
                        // title: "¡Listo!",
                        text: 'N° de documento no existe o la cuenta esta desactivada',
                        icon: "error",
                        timer: 3000,
                        buttons: {
                            confirm: {
                                className: 'btn btn-danger'
                            }
                        },
                    });
                }
            },
            error: function(xhr, textStatus, errorThrown) {
                ocultarLoadingConsulta();
                alert("Error: " + errorThrown);
            }
        });
    }
});

$(document).on('click', '.cambiar-correo', function() {
    var dni = $("input[name=dni]").val();
    var correo = $("input[name=correo]").val();
        if(dni!=="" && correo!==""){
            $("#modalCambiarCorreo").modal('hide');
            mostrarLoadingConsulta();
            $.ajax({
                type: 'POST',
                url: 'cd/Controlador/LoginControl.php',
                data: 'cambiar_correo=1 && dni=' + dni +'&& correo=' + correo,
                success: function(data) {
                    ocultarLoadingConsulta();
                    document.getElementById("dni").value = "";
                    document.getElementById("correo").value = "";
                    var data = JSON.parse(data);
                    if (data.code == 200) {
                        var contenido = "Hemos enviado un correo electronico a " + data.email ;
                        swal({
                            title: "¡Listo!",
                            text: contenido,
                            icon: "success",
                            timer: 5000,
                            buttons: {
                                confirm: {
                                    className: 'btn btn-success'
                                }
                            },
                        });
                    } else if (data.code == 422) {
                        swal({
                            text: 'Cuenta verificada',
                            icon: "warning",
                            timer: 3000,
                            buttons: {
                                confirm: {
                                    className: 'btn btn-warning'
                                }
                            },
                        });
                    } else {
                        swal({
                            text: 'Usuario no existe',
                            icon: "error",
                            timer: 3000,
                            buttons: {
                                confirm: {
                                    className: 'btn btn-danger'
                                }
                            },
                        });
                    } 
                }
            });
    } else {
        swal({
            title: "Mensaje de Alerta",
            text: 'Ingresar usuario y correo',
            icon: "warning",
            timer: 2000,
            buttons: {
                confirm: {
                            className: 'btn btn-warning'
                        }
                    },
                });
                CambiarInputs(true);
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

function CambiarSelectPais(id, ancho) {
    var select = $("#CodigoCiudad");
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
}

function ValidarRucExistente(ruc) {
    var dato = 'verificar_ruc=1&RUC=' + ruc;
    $.ajax({
        type: 'POST',
        url: 'cd/Controlador/RegistroAgencia.php',
        data: dato,
        success: function(data) {
            var data = JSON.parse(data);
            if (data.data == undefined) {
                CambiarInputs(true);
                var contenido = "El RUC " + data.RUC + " ya existe y esta registrado en nuestro web de Agencias con la siguiente razón social " + data.RazonSocial + ", por favor verifique su correo electrónico";
                swal({
                    title: "Mensaje de Alerta",
                    text: contenido,
                    icon: "warning",
                    timer: 4000,
                    buttons: {
                        confirm: {
                            className: 'btn btn-warning'
                        }
                    },
                });
            }
        },
        error: function(xhr, textStatus, errorThrown) {
            alert("Error: " + errorThrown);
        }
    });
}

function ValidarRucDigito(ruc) {
    var digitoverificar;
    var reglas = '5432765432';
    var validar = ruc.substr(0, 10);
    var ultimo = parseInt(ruc.charAt(10));
    var suma = 0;
    for (let i = 0; i < 10; i++) {
        suma = suma + parseInt(validar.charAt(i)) * parseInt(reglas.charAt(i));
    }
    var resto = suma % 11;
    digitoverificar = 11 - resto;

    if (digitoverificar == 11 || digitoverificar == 1) {
        digitoverificar = 1;
    } else if (digitoverificar == 10 || digitoverificar == 0) {
        digitoverificar = 0;
    }

    return digitoverificar == ultimo ? true : false;
}

function ClaseRUC(code) {
    var element = $('input[name=RUC]');
    if (code == 'PE') {
        element.removeClass('ruc-extranjero');
        element.addClass('ruc-peru');
        if (element.val()) {
            if (!ValidarRucDigito(element.val())) {
                swal({
                    title: "Mensaje de Alerta",
                    text: 'RUC no válido',
                    icon: "warning",
                    timer: 2000,
                    buttons: {
                        confirm: {
                            className: 'btn btn-warning'
                        }
                    },
                });
                CambiarInputs(true);
            }
        }
    } else {
        element.removeClass('ruc-peru');
        element.addClass('ruc-extranjero');
        CambiarInputs(false)
    }
}

function mostrarLoadingConsulta() {
    swal({
        text: 'procesando ...',
        closeOnEsc: false,
        closeOnClickOutside: false,
        button: false
    })
}

function ocultarLoadingConsulta() {
    swal.close();
}