<?php
    session_start();
    require_once("config.php");
    date_default_timezone_set('America/Lima');
    include "cn/STARPERU/Modelo/LocalidadModelo.php";
    $obj_modelo=new LocalidadModelo();
    // echo "<pre>";
    // var_dump($obj_modelo->ObtenerPaises());
    // echo "</pre>";
    // die;
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" style="height: 100%">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link href="cp/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
        <link href="cp/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="cp/css/agencias.min.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous" />
        <link href="cp/css/chosen.css" rel="stylesheet" type="text/css"/>
        <link href="cp/css/toastr.css" rel="stylesheet" type="text/css"/>
        <!-- <link href="cp/css/sweetalert.min.css" rel="stylesheet" type="text/css"/> -->
        <title>Web Agencias - StarPeru</title>
        <style>
            #content > span { 
                display: block; font-size: 20px; color: #b90007; line-height: 24px; 
            } 
            .col-submenu { 
                text-align: center; transform: translateY(15%); 
            }
            .btn{ 
                height: auto !important; font-size: 14px !important; 
            } 
            a { 
                color: #e8e9ea; 
            } 
            a:hover { 
                color: #c7c9cc; 
            } 
            .modal { 
                overflow-x: hidden; overflow-y: auto; 
            }
            #modalPassword .modal-header .close { 
                margin-top: -30px; 
            } 
            #modalPassword .modal-header { 
                background-color: #b90007; 
                border-radius: 5px 5px 0 0; 
            }
            button.close { 
                color: #020202; 
            } 
            #modalPassword .modal-title { 
                color:#f3f3f3; 
                font-size: 18px; 
                font-weight: bold; 
            }
            .btn-success { 
                color: #fff; background-color: #28a745 !important; border-color: #28a745 !important; 
            }
            p {
                margin-top: 0;
                margin-bottom: 1rem;
            }
            .text-muted {
                color: #73818f !important;
            }
            .toast-top-right {
                top: 30px;
                right: 12px;
            }
            .swal-footer{
                text-align: center;
            }
            .alert{
                margin-bottom: 0;
            }
        </style>
    </head>
    <body class="fondo_panel">
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="top-bar">
                <div class="container">
                    <ul class="top-nav">
                        <li style="margin-left: 0px;">
                            <span style="font-size: 17px;">&nbsp;</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="container">
                <div class="navbar-header" style="margin-top: 6px;">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-top">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="logo-22">
                    <!--<div id="content" class="hidden-xs">
                        <span>PORTAL</span>
                        <span style="font-weight: bold;">EMPRESAS</span>
                    </div>-->
                </div>
                <div class="collapse navbar-collapse" id="navbar-top">
                    <ul class="nav navbar-nav navbar-right">
<!--                        <li>
                            <a target="_blank">
                                <i class="fa fa-info-circle fa-2x" aria-hidden="true"></i>
                                <span class="span">INFORMACIÓN AL</span>
                                <span class="span span-bold span-font-medium">PASAJERO</span>
                            </a>
                        </li>-->
                        <li>
                            <a style="cursor: pointer;" class="modal-agencia">
                                <i class="fa fa-university fa-2x" aria-hidden="true"></i>
                                <span class="span">REGISTRA TU</span>
                                <span class="span span-bold span-font-medium">AGENCIA</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div id="shadow"></div>
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-sm-12 col-xs-12" id="carrito" >
                        <div class="carrito-seccion">
                            <div class="row quick-search">
                                <div class="row mensaje-usuario">
                                    <!-- <div class="col-md-10 col-md-offset-1">
                                        <div class="alert alert-success alert-dismissible">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                            <strong>¡Cuenta verificada!</strong> Ahora puede iniciar sesión y disfrutar de la plataforma.
                                        </div>
                                    </div> -->
                                </div>
                                <?php if (isset($_SESSION["s_entra"]) && $_SESSION["s_entra"]==1): ?>
                                    <div style="height: 210px;align-items: center;text-align: center;display: flex;justify-content: center;">
                                        <a href="cp/panel.php" style="text-decoration: none;">
                                            <i class="fa fa-university fa-2x" aria-hidden="true"></i>
                                            <span class="span" style="color: #ffffff;">IR A MI</span>
                                            <span class="span span-bold span-font-medium" style="color: #ffffff;">AGENCIA</span>
                                        </a>
                                    </div>
                                <?php else: ?>
                                    <form action="cd/Controlador/LoginControl.php" method="post" name="form1" id="form1" autocomplete="off">
                                        <input type="hidden"  name="login" value="1"/>
                                        <div class="row form-group" style="margin-top: 40px;">
                                            <div class="col-md-1 col-sm-1 col-xs-1">&nbsp;</div>
                                            <div class="col-md-10 col-sm-10 col-xs-10" style="text-align: center">
                                                <i class="fa fa-user" style="color: white;"></i>
                                                <span style="font-weight: bold; color: white; font-size: larger">INICIA SESIÓN AQUI</span>
                                            </div>
                                            <div class="col-md-1 col-sm-1 col-xs-1">&nbsp;</div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-1 col-sm-1 col-xs-1">&nbsp;</div>
                                            <div class="col-md-10 col-sm-10 col-xs-10" style="text-align: center">
                                                <input type="text" maxlength="8" placeholder="Ingrese usuario" name="usuario" id="usuario"  class="form-control"/>
                                            </div>
                                            <div class="col-md-1 col-sm-1 col-xs-1">&nbsp;</div>
                                        </div> 
                                        <div class="row form-group">
                                            <div class="col-md-1 col-sm-1 col-xs-1">&nbsp;</div>
                                            <div class="col-md-10 col-sm-10 col-xs-10" style="text-align: center">
                                                <input type="password" maxlength="12"  placeholder="Ingrese contraseña" name="password" id="password"   class="form-control"/>
                                                <span style="float: right; font-size: 13px; margin-top:2px; cursor: pointer;">
                                                    <a class="links btn-reset-pass" data-toggle="modal" data-target="#modalPassword">¿Olvido su contraseña?</a>
                                                </span>
                                            </div>
                                            <div class="col-md-1 col-sm-1 col-xs-1">&nbsp;</div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-1 col-sm-1 col-xs-1">&nbsp;</div>
                                            <div class="col-md-10 col-sm-10 col-xs-10" style="text-align: center">
                                                <input type="submit" name="btn_login" value="Iniciar Sesion" id="btn_login" class="btn btn-lg btn-secondary"  />
                                            </div>
                                            <div class="col-md-1 col-sm-1 col-xs-1">&nbsp;</div>
                                        </div>
                                    </form>
                                <?php endif ?>
                                
                                <div class="row form-group">
                                    <div class="col-md-1 col-sm-1 col-xs-1">&nbsp;</div>
                                    <div class="col-md-10 col-sm-10 col-xs-10">
                                        <div style="border: solid; border-width: 0.5px; border-color: white;"></div>
                                    </div>
                                    <div class="col-md-1 col-sm-1 col-xs-1">&nbsp;</div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-1 col-sm-1 col-xs-1">&nbsp;</div>
                                    <div class="col-md-10 col-sm-10 col-xs-10" style="text-align: center">
                                        <p style="vertical-align: central">
                                            <a style="font-weight: 100; color: white; font-size: large; cursor: pointer;" class="modal-agencia">!REGISTRA TU AGENCIA!
                                            </a>
                                            <br />
                                            <span style="font-weight: 900; color: white; font-size: large">COMIENZA A AHORRAR</span>
                                        </p>
                                    </div>
                                    <div class="col-md-1 col-sm-1 col-xs-1">&nbsp;</div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-1 col-sm-1 col-xs-1">&nbsp;</div>
                                    <div class="col-md-10 col-sm-10 col-xs-10">
                                        <span id="lblError"></span>
                                    </div>
                                    <div class="col-md-1 col-sm-1 col-xs-1">&nbsp;</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12 avisos-seccion">
                        <div style="background-color: initial;">
                            <div class="row quick-search-white" style="text-align: center;">
                                <div class="row form-group">
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <i class="fa fa-trophy fa-5x" aria-hidden="true" style="font-weight: 900"></i>
                                        <p>
                                            <span style="font-weight: 900; color: #ffffff; font-size: large">FÁCIL Y RÁPIDO</span>
                                            <br />
                                            <span style="color: #ffffff;">Gestione la reservas y compras de los pasajes desde un solo lugar.</span>
                                        </p>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <i class="fa fa-piggy-bank fa-5x" aria-hidden="true" style="font-weight: 900"></i>
                                        <p>
                                            <span style="font-weight: 900; color: #ffffff; font-size: large">AHORRA</span>
                                            <br />
                                            <span style="color: #ffffff;">Ahorre tiempo y dinero sin costos o comisiones adicionales.</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal" tabindex="-1" role="dialog" id="modalPassword">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Restablecer Contraseña</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row previo-clave">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <p>
                                    Para realizar el restablecimiento de la contraseña ingrese el numero de documento y se le enviara instrucciones a su correo.
                                </p>
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label>Documento</label>
                                        <input name="documento" type="text" id="documento" class="form-control" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer buttons-clave">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button class="btn btn-success resetear-password" disabled>Enviar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal" tabindex="-1" role="dialog" id="modalNuevaAgencia">
            <div class="modal-dialog" style="max-width: 450px" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="padding-bottom: 0;">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h2 class="modal-title">Registrar mi Agencia</h2>
                        <p class="text-muted">
                            Completa los campos con información válida <br>
                            <span style="color: #bf1b1b;">Todo los campos son obligatorios</span>
                        </p>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="registrar_agencia" value="1" form="registrar-agencia">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                                        <select id="Code_Pais" name="Code_Pais" class="form-control select-chosen" title="Seleccionar Pais" form="registrar-agencia">
                                            <?php foreach ($obj_modelo->ObtenerPaises() as $key => $pais): ?>
                                                <option <?= $pais->Code_Pais=='PE' ? 'selected' : ''?> value="<?= $pais->Code_Pais?>"><?= $pais->Pais?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                                        <select id="CodigoCiudad" name="CodigoCiudad" class="form-control select-chosen" title="Seleccionar Ciudad" form="registrar-agencia">
                                            <?php foreach ($obj_modelo->ObtenerLocalidades('PE') as $key => $ciudad): ?>
                                                <option <?= $ciudad->Codigo=='LIM' ? 'selected' : ''?> value="<?= $ciudad->Codigo?>"><?= $ciudad->Nombre?></option>
                                            <?php endforeach ?>
                                            <!-- <option value="ANC">ANCASH</option>
                                            <option value="ANS">ANDAHUAYLAS</option>
                                            <option value="APU">APURIMAC</option>
                                            <option value="AQP">AREQUIPA</option>
                                            <option value="AYP">AYACUCHO</option>
                                            <option value="CJA">CAJAMARCA</option>
                                            <option value="CIX">CHICLAYO</option>
                                            <option value="CUZ">CUZCO</option>
                                            <option value="ILQ">ILO</option>
                                            <option value="IQT">IQUITOS</option>
                                            <option value="JAU">JAUJA</option>
                                            <option value="JUL">JULIACA</option>
                                            <option value="JNN">JUNIN</option>
                                            <option value="LIM" selected="">LIMA</option>
                                            <option value="PSC">PASCO</option>
                                            <option value="PIO">PISCO</option>
                                            <option value="PIU">PIURA</option>
                                            <option value="PCL">PUCALLPA</option>
                                            <option value="PEM">PUERTO MALDONADO</option>
                                            <option value="PUN">PUNO</option>
                                            <option value="TCQ">TACNA</option>
                                            <option value="TYL">TALARA</option>
                                            <option value="TPP">TARAPOTO</option>
                                            <option value="TRU">TRUJILLO</option>
                                            <option value="TBP">TUMBES</option>
                                            <option value="UCY">UCAYALI</option> -->
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">RUC</span>
                                <input type="text" class="form-control ruc-peru" placeholder="RUC" id="RUC" name="RUC" required="" form="registrar-agencia">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-university"></i></span>
                                <input type="text" class="form-control" placeholder="Razon Social - Ejm: Mi Empresa SAC" id="RazonSocial" name="RazonSocial" required="" form="registrar-agencia">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-university"></i></span>
                                <input type="text" class="form-control" placeholder="Nombre Comercial - Ejm: Empresa" id="NombreComercial" name="NombreComercial" title="Nombre comercial o marca" required="" form="registrar-agencia">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-bars"></i></span>
                                <input type="text" class="form-control" placeholder="Domicilio Fiscal" id="Direccion" name="Direccion" required="" form="registrar-agencia">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-phone-square"></i></span>
                                <input type="text" class="form-control" placeholder="Teléfono de Oficina" id="TelefoniaOficina" name="TelefoniaOficina" required="" form="registrar-agencia">
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                        <input type="text" class="form-control" placeholder="Apellido Paterno" id="ApellidoPaterno" name="ApellidoPaterno" required="" form="registrar-agencia">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                        <input type="text" class="form-control" placeholder="Apellido Materno" id="ApellidoMaterno" name="ApellidoMaterno" required="" form="registrar-agencia">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="text" class="form-control" placeholder="Nombres" id="Nombres" name="Nombres" required="" form="registrar-agencia">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">DNI</span>
                                        <input type="text" class="form-control" placeholder="DNI" id="DNIFuncionario" name="DNIFuncionario" maxlength="8" minlength="8" required="" form="registrar-agencia">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                        <input type="text" class="form-control" placeholder="Celular" id="Celular" name="Celular" form="registrar-agencia">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                <input type="email" class="form-control" placeholder="Email" id="Email" name="Email" required="" form="registrar-agencia">
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-block btn-success" form="registrar-agencia">Registrarme</button>
                        </div>
                        <form id="registrar-agencia" onsubmit="return false"></form>
                        <form></form>
                    </div>
                </div>

            </div>
        </div>
        <!-- <script src="http://code.jquery.com/jquery-1.9.1.js"></script> -->
        <script src="https://code.jquery.com/jquery-2.2.4.min.js" type="text/javascript"></script>
        <script src="cp/js/bootstrap.js" type="text/javascript"></script>
        <script src="cp/js/toastr.js" type="text/javascript"></script>
        <script src="cp/js/chosen.js" type="text/javascript"></script>
        <script src="cp/js/sweetalert.min.js" type="text/javascript"></script>
        <script src="cp/js/jsLogin.js" type="text/javascript"></script>
    </body>
</html>
