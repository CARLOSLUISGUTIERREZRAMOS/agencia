<?php 
    session_start();
    error_reporting(E_ALL);
    ini_set("display_errors", 0);
    date_default_timezone_set('America/Lima');

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
        input{
            text-transform: uppercase;
        }
    </style>
    
    <script type="text/javascript" >
        $(document).ready(function () {
            var alto_pantalla = $(window).height();
            $("#frame_principal").attr('height', alto_pantalla - 124);
        });
        $(document).on('keypress', 'input[name=codigo_reserva]', function() {
            var regex = new RegExp("^[aA-zZ]+$");
            var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
            if (!regex.test(key)) {
                event.preventDefault();
                return false;
            } 
            else {
                var len = $(this).val().length;
                if (len > 5) {
                    event.preventDefault();
                    return false;
                }
            }
        });
        $(document).on('keyup','input[name=codigo_reserva]',function(){
            $(this).val(this.value.toUpperCase());
        });

        function EnviarValores() {
            var reserva=$("input[name=codigo_reserva]").val();
            if (reserva) {
                $("form").submit();
            }
            else{
                swal({
                    title: "Mensaje de Alerta",
                    text: 'Ingresar Codigo de reserva',
                    icon: "warning",
                    timer: 2000,
                    buttons: {
                        confirm: {
                            className: 'btn btn-warning'
                        }
                    },
                });
                return false;
            }
        }
    </script>
    <?php $style_script_contenido = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php require_once(HTML_RECURSO_PATH); ?>
	<!-- fin div Credito Personal -->
    <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td>
                <table width="900" align="center" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td>
                            <br>
                            <div class="card border-warning">
                                <div class="card-header text-center bg-warning">
                                    <h4>Pago de Reservas</h4>
                                </div>
                                <div class="card-body">
                                    <form action="reprocesar.php" method="get" onsubmit="EnviarValores(); return false;">
                                        <div class="row form-body">
                                            <div class="col-sm-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="codigo_reserva">Código de reserva:</label>
                                                    <input name="codigo_reserva" id="codigo_reserva" type="text" class="form-control" placeholder="Ingrese">
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="apellido">Apellido:</label>
                                                    <input name="apellido" id="apellido" type="text" class="form-control" placeholder="Opcional" maxlength="60">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <input class="btn btn-danger" name="botoncillo" type="submit" value="buscar">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

<?php include(FOOTER_PATH); ?>