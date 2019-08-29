
<?php
	function sendemail($responder,$alias,$destino,$html,$asunto,$ccopia=''){
		$username='test.sistems01@gmail.com';
		$mail = new PHPMailer;
		$mail->isSMTP();  // Establecer el correo electrónico para utilizar SMTP    
		$mail->Host = 'ssl://smtp.googlemail.com';  // Especificar el servidor de correo a utilizar 
		$mail->SMTPAuth = true;  // Habilitar la autenticacion con SMTP
		$mail->Username = $username;  // Correo electronico saliente ejemplo: tucorreo@gmail.com
		$mail->Password = '123456..a'; // Tu contraseña de gmail
		$mail->Port = 465;  // Puerto TCP  para conectarse 
		$mail->setFrom($username, $alias);//Introduzca la dirección de la que debe aparecer el correo electrónico. Puede utilizar cualquier dirección que el servidor SMTP acepte como válida. El segundo parámetro opcional para esta función es el nombre que se mostrará como el remitente en lugar de la dirección de correo electrónico en sí.
		$mail->addReplyTo($responder, $alias);//Introduzca la dirección de la que debe responder. El segundo parámetro opcional para esta función es el nombre que se mostrará para responder
		$mail->addAddress($destino);// Agregar quien recibe el e-mail enviado											
		if ($ccopia) {
			$array_copia=explode(',',$ccopia);
			foreach ($array_copia as $copia) {
				if ($copia) {
					$mail->AddBCC($copia);//con copia
				}
			}
		}
		$message = $html;
		$mail->isHTML(true);// Establecer el formato de correo electrónico en HTML	
		$mail->Subject = $asunto;
		$mail->CharSet = 'UTF-8';
		$mail->msgHTML($message);
		$mail->send();
	}
?>