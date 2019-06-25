<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" style="height: 100%">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <!-- <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script> -->
        <link href="cp/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
        <link href="cp/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="cp/css/agencias.min.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous" />
        <link href="cp/css/toastr.css" rel="stylesheet" type="text/css"/>
        <title>Web Agencias - StarPeru</title>
        <style>
            #content > span { display: block; font-size: 20px; color: #b90007; line-height: 24px; } 
            .col-submenu { text-align: center; transform: translateY(15%); }
            .btn{ height: auto !important; font-size: 14px !important; } 
            a { color: #e8e9ea; } 
            a:hover { color: #c7c9cc; } 
            .modal { overflow-x: hidden; overflow-y: auto; }
            #modalPassword .modal-header .close { margin-top: -30px; } 
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
            .btn-success { color: #fff; background-color: #28a745 !important; border-color: #28a745 !important; }
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
        </style>
        <<!-- link href="App_Themes/PasarelaTheme/jquery-ui-1.8.16.custom.css" type="text/css" rel="stylesheet" />
        <link href="App_Themes/PasarelaTheme/style.css" type="text/css" rel="stylesheet" /> -->
    </head>
    <body class="fondo_panel">
        <form action="cd/Controlador/LoginControl.php" method="post" name="form1" id="form1" autocomplete="off">
            <div class="aspNetHidden">
                <input type="hidden" name="__VIEWSTATE" id="__VIEWSTATE" value="/wEPDwUJMzQ3NzUxNTQ2D2QWAgIDD2QWAgITDxYCHgdvbmNsaWNrBTFSZXN0YWJsZWNlclBhc3N3b3JkKCd0eHREb2N1bWVudG8nKTsgcmV0dXJuIGZhbHNlZGTjGgS6O/IhFWd9uM9DqQ3xa0BiEREs7md8KicUpQdvSA==" />
            </div>

            <div class="aspNetHidden">
            	<input type="hidden" name="__VIEWSTATEGENERATOR" id="__VIEWSTATEGENERATOR" value="BC02C6D9" />
            	<input type="hidden" name="__EVENTVALIDATION" id="__EVENTVALIDATION" value="/wEdAAXc8vSV1MnZTqq+wYAXNOFuy96dWkumrXzDckADywQ75JxpWckI3qdmfEJVCu2f5cGzbZAChv7dk9rhe3bMi6TgQOrX9gIP1cj7j7QB658SkzzsIRf0FOHLz8iJw2J1SAL9UH9wmu+Bvn398ayRKOlc" />
            </div>
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
                            <li>
                                <a target="_blank">
                                    <i class="fa fa-info-circle fa-2x" aria-hidden="true"></i>
                                    <span class="span">INFORMACIÓN AL</span>
                                    <span class="span span-bold span-font-medium">PASAJERO</span>
                                </a>
                            </li>
                            <li>
                                <a data-toggle="modal" data-target="#modalNuevaAgencia" style="cursor: pointer;">
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
                                            <input type="text" maxlength="8" placeholder="Ingrese usuario" name="usuario" id="usuario"  class="form-control" value="46516152"/>
                                            <!--<input name="txtusuario" type="text" id="txtusuario" class="form-control" placeholder="Usuario" />-->
                                        </div>
                                        <div class="col-md-1 col-sm-1 col-xs-1">&nbsp;</div>
                                    </div> 
                                    <div class="row form-group">
                                        <div class="col-md-1 col-sm-1 col-xs-1">&nbsp;</div>
                                        <div class="col-md-10 col-sm-10 col-xs-10" style="text-align: center">
                                            <input type="password" maxlength="8"  placeholder="Ingrese contraseña" name="password" id="password"   class="form-control" value="ricardo"/>
                                            <!--<input name="txtpassword" type="password" id="txtpassword" class="form-control" placeholder="Contraseña" />-->
                                            <span style="float: right; font-size: 13px; margin-top:2px; cursor: pointer;">
                                                <a class="links btn-reset-pass" data-toggle="modal" data-target="#modalPassword">¿Olvido su contraseña?</a>
                                            </span>
                                        </div>
                                        <div class="col-md-1 col-sm-1 col-xs-1">&nbsp;</div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-1 col-sm-1 col-xs-1">&nbsp;</div>
                                        <div class="col-md-10 col-sm-10 col-xs-10" style="text-align: center">
                                            <!--<input title="click para ingresar" type="button" class="btn_login gradiante" id="btn_login" name="btn_login" value="Ingresar"/>-->
                                            <input type="submit" name="btn_login" value="Iniciar Sesion" id="btn_login" class="btn btn-lg btn-secondary"  />
                                        </div>
                                        <div class="col-md-1 col-sm-1 col-xs-1">&nbsp;</div>
                                    </div>
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
                                                <a style="font-weight: 100; color: white; font-size: large; cursor: pointer;" data-toggle="modal" data-target="#modalNuevaAgencia">!REGISTRA TU AGENCIA!
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
                                        <input type="hidden"  name="login" value="1"/>
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
        </form>
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
                                <p>&nbsp;</p>
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <span id="lblDNI">Documento</span>
                                        <input name="txtDocumento" type="text" id="txtDocumento" class="form-control" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row post-clave">
                            <div class="col-md-3 col-sm-3 col-xs-12 hidden-xs">
                                <img src="images/success.png" style="margin-top: 21px;" />
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-12 visible-xs" style="text-align:center; margin-bottom:15px;">
                                <img src="images/success.png" />
                            </div>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <p>¡Listo!</p>
                                <p>Hemos enviado un correo electronico a la cuenta asociada al usuario.</p>
                                <p>Gracias</p>
                            </div>
                        </div>
                        
                    </div>
                    <div class="modal-footer buttons-clave">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <span id="btnEnviar" class="btn btn-success" onclick="RestablecerPassword(&#39;txtDocumento&#39;); return false">Enviar</span>
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
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">RUC</span>
                                <input type="text" class="form-control" placeholder="RUC" id="RUC" name="RUC" required="" form="registrar-agencia">
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
                                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                                <select id="CodigoCiudad" name="CodigoCiudad" class="form-control" title="Seleccionar Ciudad" form="registrar-agencia">
                                    <option value="ANC">ANCASH</option>
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
                                    <option value="UCY">UCAYALI</option>
                                </select>
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
                                <input type="Email" class="form-control" placeholder="Email" id="Email" name="Email" required="" form="registrar-agencia">
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
        <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
        <script src="cp/js/bootstrap.js" type="text/javascript"></script>
        <script src="cp/js/toastr.js" type="text/javascript"></script>
        <script src="cp/js/jsLogin.js" type="text/javascript"></script>
        <script>
            $(function () {
                $('.btn-reset-pass').on("click", function () {
                    $('.buttons-clave').show();
                    $('.previo-clave').show();
                    $('.post-clave').hide();
                });
            });
        </script>
    </body>
</html>
