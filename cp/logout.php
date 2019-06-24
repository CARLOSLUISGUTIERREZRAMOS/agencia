<?php 
session_start();
error_reporting(E_ALL);
ini_set("display_errors",0);
include '../cd/Navegador/index.php';
if($_SESSION['s_entra']==0){
     header('Location:../index.php');
}
session_destroy();
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Web Agencias - StarPeru</title>
<link href="images/favicon_starperu.png" rel="shortcut icon" />
<link href="css/font-face.css" rel="stylesheet" type="text/css" />
<link href="css/modulo.css" rel="stylesheet" type="text/css" />
<link href="css/login.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body{ overflow:hidden;}
.info_user {
	font-family: Tahoma, Geneva, sans-serif;
	font-size: 14px;
	font-weight: bold;
}
-->
</style>
<script type="text/javascript" language="javascript1.2" src="pasarela/js/funciones.js"></script>
<script language="javascript1.2" type="text/javascript">
<!--
var tmp=0;
function PagInicio()
{
	if(tmp==4)
	{
		window.location='../index.php';
	}
	tmp++;
	setTimeout("PagInicio()", 1000);
}
-->
</script>
</head>
<body onLoad="PagInicio()">
<table width="100%" height="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
    	<td height="70" align="center">     <div id="div-header">
    	<div id="div-header-content">
            <div id="div-header-logo">
                <a href="../index.php">
                    <img src="images/LogoStar.png" title="" border="0" />
                </a>
            </div>
            <div id="div-header-info-modulo">
			Web Agencias - StarPeru           </div>
        </div>
    </div> </td>
  </tr>
	<tr>
  	<td height="2" style="background-color: #E41922"></td>
  </tr>
	<tr>
  	<td height="340" style="background-color: #CCCCCC" align="center">
    	<table cellpadding="0" cellspacing="0" border="0">
      	<tr>
        	<td width="300" height="50" align="center" class="info_user">Su sesi&oacute;n ha finalizado correctamente</td>
        </tr>
      	<tr>
        	<td height="50" align="center"><input type="button" name="button" id="button" value="Ir al login" class="boton" onClick="window.location='../index.php'"></td>
        </tr>
      </table>
    </td>
  </tr>
	<tr>
  	<td style="background-color: #CCCCCC"></td>
  </tr>
</table>
</body>
</html>