<?php 
    session_start();
    error_reporting(E_ALL);
    ini_set("display_errors", 0);
    date_default_timezone_set('America/Lima');
    // date_default_timezone_set('UTC-5');

	include '../cd/Navegador/index.php';
	if ($_SESSION['s_entra'] == 0) {
	    header('Location:../index.php');
	}
	$Tipo = $_SESSION['s_tipo'];
	if ($Tipo == 'G') {
	    $directorio_personal = 'gestor/';
	} else {
	    $directorio_personal = 'delegado/';
	}
	$directorio = '';
	$directorio_imagen = '';
	$display = 'none';
	$contra = 'none';

	if ($_SESSION['s_cambio_clave'] == 1) {
	    $contra = 'block';
	} elseif ($_SESSION['s_presentacion'] == 1) {
	    $display = 'block';
	}
    require_once("../config.php");
?>
<?php ob_start(); ?>
    <style type="text/css">
        body {
            /*overflow: auto;*/
        }
        #div-alerta{
            height:10px;
            margin:5px 0 10px 210px;
            color:#900;
            font-size:12px;
            font-weight:bold;
            clear:both;
            float:left;
        }
        .btn_cerrar{
            /*height:40px;
            width:40px;*/
            position: absolute;
        }
    </style>
    
    <script type="text/javascript" >
        $(document).ready(function () {
            var alto_pantalla = $(window).height();
            $("#frame_principal").attr('height', alto_pantalla - 124);
            //               alert(alto_pantalla);
            $("#btn_cerrar").click(function () {
                cerrarAvisoIngreso();
            });
            if(<?= $_SESSION["s_cambio_clave"]?> ==1){
                $("#modalCambiarPassword").modal({backdrop: 'static', keyboard: false});
            }
        });

        function enviaFormSeguridad()
        {
            var msg;
            if ((document.form1.txtseguridad.value != '' && document.form1.txtconfirma.value != '') && document.form1.txtseguridad.value == document.form1.txtconfirma.value)
            {
                document.forms["form1"].submit();
            } else {
                if (document.form1.txtseguridad.value == '' || document.form1.txtconfirma.value == '')
                {
                    msg = 'Por favor, ingrese el nuevo password y la confirmaci&oacute;n.';
                } else if (document.form1.txtseguridad.value != document.form1.txtconfirma.value)
                {
                    msg = 'El password y la confirmaci&oacute;n no son iguales.';
                }
                document.getElementById('div-alerta').innerHTML = '';
                document.getElementById('div-alerta').innerHTML = msg;
                document.getElementById('txtseguridad').focus();
                return false;
            }
        }

        function limpiaAlerta()
        {
            document.getElementById('div-alerta').innerHTML = '';
        }

        function cerrarAvisoIngreso()
        {
            document.getElementById('div-ingreso-usuario').style.display = 'none';
            var iframe = document.getElementById('frame_principal');
            //iframe.src = 'pasarela/paso1.php';
        }

        function cerrarAvisoAdvertencia(){
            window.location = "logout.php";
        }

        $(document).on('click','.cambiar-password',function () {
            var pass=$("input[name=password]").val();
            var pass1=$("input[name=password1]").val();
            if(pass!='' && pass1!=''){
                if (pass==pass1) {
                    $.ajax({
                        url:"<?=$url?>/cd/Controlador/LoginControl.php",
                        type: "POST", 
                        data:'cambio_password=1 && password='+pass,
                        success: function(mensaje){
                            var data=JSON.parse(mensaje);
                            $("#modalCambiarPassword").modal('hide');
                            if (data.code==1) {
                                swal({
                                    title: "Mensaje",
                                    text: '¡Listo! Su contraseña fue cambiado con exito',
                                    icon: "success",
                                    timer: 2000,
                                    buttons: {
                                        confirm: {
                                            className: 'btn btn-success'
                                        }
                                    },
                                });
                            }
                            else{
                                swal({
                                    title: "Mensaje",
                                    text: 'Ups! Hubo un error al cambiar',
                                    icon: "warning",
                                    timer: 2000,
                                    buttons: {
                                        confirm: {
                                            className: 'btn btn-warning'
                                        }
                                    },
                                });
                            }
                        },
                        error: function (error,obj,mensaje) {
                            $("#modalCambiarPassword").modal('hide');
                            swal({
                                title: "Mensaje de Error",
                                text: 'Error en sentencia SQL',
                                icon: "error",
                                timer: 2000,
                                buttons: {
                                    confirm: {
                                        className: 'btn btn-danger'
                                    }
                                },
                            });
                        }
                    });
                }
                else{
                    swal({
                        title: "Mensaje de Alerta",
                        text: 'Las contraseñas son diferentes, digite correctamente',
                        icon: "warning",
                        timer: 2000,
                        buttons: {
                            confirm: {
                                className: 'btn btn-warning'
                            }
                        },
                    });
                }
            }
            else{
                swal({
                    title: "Mensaje de Alerta",
                    text: 'Ingrese la nueva contraseña',
                    icon: "warning",
                    timer: 2000,
                    buttons: {
                        confirm: {
                            className: 'btn btn-warning'
                        }
                    },
                });
            }
        });

        $(document).on('blur','input[name=password]',function () {
            var pass1=$("input[name=password1").val();
            if (pass1) {
                if (this.value!=pass1) {
                    swal({
                        title: "Mensaje de Alerta",
                        text: 'Las contraseñas son diferentes, digite correctamente',
                        icon: "warning",
                        timer: 2000,
                        buttons: {
                            confirm: {
                                className: 'btn btn-warning'
                            }
                        },
                    });
                    $('.cambiar-password').attr('disabled',true);
                }
                else{
                    $('.cambiar-password').attr('disabled',false);
                }
            }
        });

        $(document).on('blur','input[name=password1]',function () {
            var pass=$("input[name=password").val();
            if (pass) {
                if (this.value!=pass) {
                    swal({
                        title: "Mensaje de Alerta",
                        text: 'Las contraseñas son diferentes, digite correctamente',
                        icon: "warning",
                        timer: 2000,
                        buttons: {
                            confirm: {
                                className: 'btn btn-warning'
                            }
                        },
                    });
                    $('.cambiar-password').attr('disabled',true);
                }
                else{
                    $('.cambiar-password').attr('disabled',false);
                }
            }
        });
    </script>
    <?php $style_script_contenido = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php require_once(HTML_RECURSO_PATH); ?>
	<!-- fin div Credito Personal -->
    <div class="modal fade" id="miModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
             <div class="modal-content">
                <div class="modal-header">
                    <h3>Condiciones Tarifarias</h3>
                </div>                                              
                <div class="modal-body">
                    <div class="container">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active " data-toggle="tab" href="#promo" style="color: darkred;">PROMO</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " data-toggle="tab" href="#simple" style="color: darkred;">SIMPLE</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link  " data-toggle="tab" href="#extra" style="color: darkred;">EXTRA</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " data-toggle="tab" href="#full" style="color: darkred;">FULL</a>
                            </li>                                                       
                        </ul>
                        <div class="tab-content">
                            <div id="promo" class="container tab-pane active"><br>
                                <h5>PROMO(H, S y T)</h5>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th><strong>IDA</strong></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                • Totalmente gratis: Una (1) pieza de equipaje chequeado de 23Kgs y una (1) de mano de 8Kgs.<br>
                                                • Máximo de estadía 180 días.<br>
                                                • Tarifa combinable con todas las clases.<br>
                                                • Niños (2-11 años) pagan el 100% de la tarifa. Infantes (0-2 años) pagan el 100% de la tarifa.<br>
                                                • Cambio de vuelo, fecha, ruta o nombre: Sin cargo antes de las 24hrs.a la salida del vuelo. Corresponde diferencia tarifaria de darse el caso.<br>
                                                • Cambio de vuelo, fecha, ruta o nombre: Dentro de las 24hrs.a la salida del vuelo, cargo de $17.70 por transacción . Corresponde diferencia tarifaria de presentarse el caso.<br>
                                                • Reembolsos permitidos sólo para futura transportación con cargo de $23.60.
                                            </td>
                                        </tr>
                                    </tbody>
                                    <thead>
                                        <tr>
                                            <th><strong>VUELTA</strong></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                • Totalmente gratis: Una (1) pieza de equipaje chequeado de 23Kgs y una (1) de mano de 8Kgs.<br>
                                                • Máximo de estadía 180 días.<br>
                                                • Tarifa combinable con todas las clases.<br>
                                                • Niños (2-11 años) pagan el 100% de la tarifa. Infantes (0-2 años) pagan el 100% de la tarifa.<br>
                                                • Cambio de vuelo, fecha, ruta o nombre: Sin cargo antes de las 24hrs.a la salida del vuelo. Corresponde diferencia tarifaria de darse el caso.<br>
                                                • Cambio de vuelo, fecha, ruta o nombre: Dentro de las 24hrs.a la salida del vuelo, cargo de $17.70 por transacción . Corresponde diferencia tarifaria de presentarse el caso.<br>
                                                • Reembolsos permitidos sólo para futura transportación con cargo de $23.60.<br>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div id="simple" class="container tab-pane fade"><br> 
                                    <h5>SIMPLE(A, B, D, E, O, P, R y Z)</h5>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th><strong>IDA</strong></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    • Totalmente gratis: Una (1) pieza de equipaje chequeado de 23Kgs y una (1) de mano de 8Kgs.<br> 
                                                    • Máximo de estadía 180 días.<br> 
                                                    • Tarifa combinable con todas las clases.<br> 
                                                    • Niños (2-11 años) pagan el 100% de la tarifa. Infantes (0-2 años) pagan el 10% de la tarifa. <br> 
                                                    • Cambio de vuelo, fecha, ruta o nombre: Sin cargo antes de las 24hrs.a la salida del vuelo. Corresponde diferencia tarifaria de darse el caso.<br> 
                                                    • Cambio de vuelo, fecha, ruta o nombre: Dentro de las 24hrs.a la salida del vuelo, cargo de $17.70 por transacción . Corresponde diferencia tarifaria de presentarse el caso.<br> 
                                                    • Reembolsos permitidos sólo para futura transportación con cargo de $23.60. 
                                                </td>
                                            </tr>
                                        </tbody>
                                        <thead>
                                            <tr>
                                                <th><strong>VUELTA</strong></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    • Totalmente gratis: Una (1) pieza de equipaje chequeado de 23Kgs y una (1) de mano de 8Kgs.<br>
                                                    • Máximo de estadía 180 días.<br>
                                                    • Tarifa combinable con todas las clases.<br>
                                                    • Niños (2-11 años) pagan el 100% de la tarifa. Infantes (0-2 años) pagan el 10% de la tarifa.<br>
                                                    • Cambio de vuelo, fecha, ruta o nombre: Sin cargo antes de las 24hrs.a la salida del vuelo. Corresponde diferencia tarifaria de darse el caso.<br>
                                                    • Cambio de vuelo, fecha, ruta o nombre: Dentro de las 24hrs.a la salida del vuelo, cargo de $17.70 por transacción . Corresponde diferencia tarifaria de presentarse el caso.<br>
                                                    • Reembolsos permitidos sólo para futura transportación con cargo de $23.60.<br>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                            </div>
                            <div id="extra" class="container tab-pane fade"><br>
                                    <h5>EXTRA(J, M, N, Q, V, W y X)</h5>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th><strong>IDA</strong></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    • Totalmente gratis: Una (1) pieza de equipaje chequeado de 23Kgs y una (1) de mano de 8Kgs.<br>
                                                    • Máximo de estadía 180 días.<br>
                                                    • Tarifa combinable con todas las clases.<br>
                                                    • Niños (2-11 años) pagan el 75% de la tarifa. Infantes (0-2 años) pagan el 10% de la tarifa.<br>
                                                    • Cambio de vuelo, fecha, ruta o nombre: Sin cargo antes de las 24hrs.a la salida del vuelo. Corresponde diferencia tarifaria de darse el caso.<br>
                                                    • Cambio de vuelo, fecha, ruta o nombre: Dentro de las 24hrs.a la salida del vuelo, cargo de $17.70 por transacción . Corresponde diferencia tarifaria de presentarse el caso.<br>
                                                    • Reembolsos permitidos sólo para futura transportación con cargo de $23.60.
                                                </td>
                                            </tr>
                                        </tbody>
                                        <thead>
                                            <tr>
                                                <th><strong>VUELTA</strong></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    • Totalmente gratis: Una (1) pieza de equipaje chequeado de 23Kgs y una (1) de mano de 8Kgs.<br>
                                                    • Máximo de estadía 180 días.<br>
                                                    • Tarifa combinable con todas las clases.<br>
                                                    • Niños (2-11 años) pagan el 75% de la tarifa. Infantes (0-2 años) pagan el 10% de la tarifa.<br>
                                                    • Cambio de vuelo, fecha, ruta o nombre: Sin cargo antes de las 24hrs.a la salida del vuelo. Corresponde diferencia tarifaria de darse el caso.<br>
                                                    • Cambio de vuelo, fecha, ruta o nombre: Dentro de las 24hrs.a la salida del vuelo, cargo de $17.70 por transacción . Corresponde diferencia tarifaria de presentarse el caso.<br>
                                                    • Reembolsos permitidos sólo para futura transportación con cargo de $23.60.
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                            </div>
                            <div id="full" class="container tab-pane fade"><br>
                                    <h5>FULL(K, L y Y)</h5>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th><strong>IDA</strong></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    • Totalmente gratis: Dos (2) piezas de equipaje chequeado de 23Kgs y una (1) de mano de 8Kgs.<br>
                                                    • Máximo de estadía 180 días.<br>
                                                    • Tarifa combinable con todas las clases.<br>
                                                    • Niños (2-11 años) pagan el 50% de la tarifa. Infantes (0-2 años) pagan el 10% de la tarifa.<br>
                                                    • Cambio de vuelo, fecha, ruta o nombre sin cargo. Corresponde diferencia tarifaria de darse el caso.<br>
                                                    • Reembolsos permitidos sin cargo
                                                </td>
                                            </tr>
                                        </tbody>
                                        <thead>
                                            <tr>
                                                <th><strong>VUELTA</strong></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    • Totalmente gratis: Dos (2) piezas de equipaje chequeado de 23Kgs y una (1) de mano de 8Kgs.<br>
                                                    • Máximo de estadía 180 días.<br>
                                                    • Tarifa combinable con todas las clases.<br>
                                                    • Niños (2-11 años) pagan el 50% de la tarifa. Infantes (0-2 años) pagan el 10% de la tarifa.<br>
                                                    • Cambio de vuelo, fecha, ruta o nombre sin cargo. Corresponde diferencia tarifaria de darse el caso.<br>
                                                    • Reembolsos permitidos sin cargo.
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                            </div>
                        </div>
                    </div>
                </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-danger" data-dismiss="modal" style="background: -webkit-linear-gradient(#f01515, darkred) !important;">Cerrar</button>
                 </div>          
             </div>           
         </div>           
    </div>
    <div class="modal" tabindex="-1" role="dialog" id="modalCambiarPassword">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">¡Cambiar Contraseña!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <p>
                                <b>Ingrese su nuevo password, el sistema le pedirá solo por primera vez.</b>
                            </p>
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <label>Nueva Contraseña</label>
                                    <input name="password" type="password" id="password" class="form-control input-password" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <label>Repetir Contraseña</label>
                                    <input name="password1" type="password" id="password1" class="form-control input-password" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success cambiar-password">Cambiar Contraseña</button>
                </div>
            </div>
        </div>
    </div>
    <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td height="15" align="center" style="background-color: #FFFFFF">&nbsp;</td>
        </tr>
        <tr>
            <td>
                <table width="900" align="center" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td>
                            <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#miModal" style="background: -webkit-linear-gradient(#f01515, darkred) !important;">Condiciones Tarifarias</button>
                            <!-- <a href="pago_reservas.php" class="btn btn-warning btn-sm">Pago de Reservas</a> -->
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td id="secciones">
                <iframe id="frame_principal" width="100%"  src="pasarela/paso1.php" allowtransparency="true" frameborder="0" scrolling="auto"></iframe>
            </td>
        </tr>
    </table>

<?php include(FOOTER_PATH); ?>