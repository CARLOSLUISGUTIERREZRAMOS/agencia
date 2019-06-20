<?php 
     session_start();
     session_destroy();
     error_reporting(E_ALL);
     ini_set("display_errors",0);
     include 'cd/Navegador/index.php';
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>M&oacute;dulo Corporativo - StarPer&uacute;</title>
<link href="cp/images/favicon_starperu.png" rel="shortcut icon" />
<link href="cp/css/font-face.css" rel="stylesheet" type="text/css"/>
<link href="cp/css/modulo.css" rel="stylesheet" type="text/css"/>
<link href="cp/css/login.css" rel="stylesheet" type="text/css"/>
<link href="cp/css/style.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="cp/js/jquery.js"></script>
<script type="text/javascript" src="cp/js/login.js"></script>
<script>
    
</script>
    
</head>
<body style="background:#fff;">
<div id="div-main">
	    <div id="div-header">
    	<div id="div-header-content">
            <div id="div-header-logo">
                <a href="http://www.starperu.com/empresas/">
                    <img src="cp/images/LogoStar.png" title="" border="0" />
                </a>
            </div>
            <div id="div-header-info-modulo">
                M&oacute;dulo Corporativo
            </div>
        </div>
    </div>    
    <div id="div-contenido">
    	<div id="div-top-contenido"></div>
        
		<div id="div-login" style="background-color: #F0F0F0;border-top: 2px  #f01515 solid ;">
                 
                    <form action="cd/Controlador/LoginControl.php" method="post" name="form1" id="form1" autocomplete="off">
		<table class="tabla_login" >
                   

                    <tr>
                        <td><label class="label_login">Usuario : </label></td>
                        <td><input type="text" maxlength="8" placeholder="Ingrese usuario" name="usuario" id="usuario"  /></td>
                    </tr>
                    <tr>
                        <td> <label  class="label_login">Contraseña : </label></td>
                        <td><input type="password" maxlength="8"  placeholder="Ingrese contraseña" name="password" id="password"  /></td>
                    </tr>
                     <tr>
                         <td colspan="2" align="center">&nbsp;</td>
                           
                    </tr>
                    <tr>
                        <td colspan="2" class="texto_derecha">
                            <input type="hidden"  name="login" value="1"  />
                            <input title="click para ingresar" type="button" class="btn_login gradiante" id="btn_login" name="btn_login" value="Ingresar"/></td>
                    </tr>
                    
                </table>
           </form>
        </div>
        <div id="error_contenedor">
        <p class="error_login"></p>
        </div>
    </div>
</div>
</body>
</html>