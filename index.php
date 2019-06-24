<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" style="height: 100%">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <link href="cp/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="cp/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="cp/css/agencias.min.css" rel="stylesheet" type="text/css" />
    <!--        <script src="cp/js/bootstrap_v3.3.5.min.js" type="text/javascript"></script>-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="cp/js/jsLogin.js" type="text/javascript"></script>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous" />
    <title>
        Web Agencias - StarPeru
    </title>

</head>

<body class="fondo_panel">
    <form action="cd/Controlador/LoginControl.php" method="post" name="form1" id="form1" autocomplete="off">
        <div class="aspNetHidden">
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
                <div class="logo">
                <a href="/agencia" class="navbar-brand animated fadeInDown" style="padding-top: 0;">
                        <img alt="logo StarPeru" class="logo" src="cp/images/LogoStar.png">
                    </a>
                </div>
                <div class="collapse navbar-collapse" id="navbar-top">
                    <ul class="nav navbar-nav navbar-right">
                        
                        <li>
                            <a href="Contactanos" target="_blank">
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
                    <div class="col-md-6 col-sm-12 col-xs-12" id="carrito">
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
                                        <input type="text" maxlength="8" placeholder="Ingrese usuario" name="usuario" id="usuario" class="form-control" value="46516152" />
                                        <!--<input name="txtusuario" type="text" id="txtusuario" class="form-control" placeholder="Usuario" />-->
                                    </div>
                                    <div class="col-md-1 col-sm-1 col-xs-1">&nbsp;</div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-1 col-sm-1 col-xs-1">&nbsp;</div>
                                    <div class="col-md-10 col-sm-10 col-xs-10" style="text-align: center">
                                        <input type="password" maxlength="8" placeholder="Ingrese contraseña" name="password" id="password" class="form-control" value="ricardo" />
                                        <!--<input name="txtpassword" type="password" id="txtpassword" class="form-control" placeholder="Contraseña" />-->
                                        <span style="float: right; font-size: 13px; margin-top:2px;">
                                            <a class="links btn-reset-pass" data-toggle="modal" data-target="#modalPassword">¿Olvido su contraseña?</a>
                                        </span>
                                    </div>
                                    <div class="col-md-1 col-sm-1 col-xs-1">&nbsp;</div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-1 col-sm-1 col-xs-1">&nbsp;</div>
                                    <div class="col-md-10 col-sm-10 col-xs-10" style="text-align: center">
                                        <!--<input title="click para ingresar" type="button" class="btn_login gradiante" id="btn_login" name="btn_login" value="Ingresar"/>-->
                                        <input type="submit" name="btn_login" value="Iniciar Sesion" id="btn_login" class="btn btn-lg btn-secondary" />
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
                                            <a style="font-weight: 100; color: white; font-size: large" href="solicitud.php">!REGISTRA TU AGENCIA!
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
                                    
                                    <input type="hidden" name="login" value="1" />
                                    
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

        </div>
    </form>
</body>

</html>