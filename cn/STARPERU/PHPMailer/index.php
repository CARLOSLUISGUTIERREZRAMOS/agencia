<!-- Author URL: http://obedalvarado.pw
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
--> 
<!DOCTYPE HTML>
<html>
<head>
<title>Como Enviar un correo electrónico desde Localhost con PHP | Sistemas Web</title>
<!-- Custom Theme files -->
<link href="css/style.css" rel="stylesheet" type="text/css" media="all"/>
<!-- Custom Theme files -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<meta name="keywords" content="" />
<!--Google Fonts-->
<link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:400italic,700italic,400,300,700' rel='stylesheet' type='text/css'>
<!--Google Fonts-->
</head>
<body>
<!--coact start here-->
<h1>Formulario de contacto</h1>
<div class="contact">
	<div class="contact-main">
	<form method="post">
		<h3>Tu correo electrónico</h3>
		<input type="email" placeholder="your@email.com" class="hola"  name="customer_email" required />		
		<h3>Tu nombre</h3>
		<input type="text" placeholder="Your name" class="hola"  name="customer_name" required />
		<h3>Asunto</h3>
		<input type="text" placeholder="Subject" class="hola"  name="subject" required />
		<h3>Mensaje</h3>
		<textarea  name="message" placeholder="Leave your message here ...." required /></textarea>
		<?php
				include("sendemail.php");//Mando a llamar la funcion que se encarga de enviar el correo electronico
				
				/*Configuracion de variables para enviar el correo*/
				$mail_username="test.sistems01@gmail.com";//Correo electronico saliente ejemplo: tucorreo@gmail.com
				$mail_userpassword="123456..a";//Tu contraseña de gmail
				$mail_addAddress="aluigui.19@gmail.com";//correo electronico que recibira el mensaje
				$template="email_template.html";//Ruta de la plantilla HTML para enviar nuestro mensaje
				
				/*Inicio captura de datos enviados por $_POST para enviar el correo */
				$mail_setFromEmail="pruebaenvio@starperu.com";
				$mail_setFromName="STARPERU";
				
                $mail_subject="TEST 53";
                $ccopia="perfectohenry@gmail.com,codegperu@gmail.com,anthony.vilchez@starperu.com,henrry.cachicatari@starperu.com,";       

                
                                          

				sendemail($mail_username,$mail_userpassword,$mail_setFromEmail,$mail_setFromName,$mail_addAddress,$ccopia,$template,$mail_subject);//Enviar el mensaje
		?>
	</div>
	<div class="enviar">
		<div class="contact-check">
			
		</div>
        <div class="contact-enviar">
		  <input type="submit" value="Enviar mensaje" name="send">
		</div>
		<div class="clear"> </div>
		</form>
</div>
</div>
<div class="copyright">
	<p>Template by <a href="http://w3layouts.com/" target="_blank"> W3layouts </a></p>
</div>
<!--contact end here-->
</body>
</html>