<?php
	include("config.php");
	require("PHPMailer_5.2.4/class.phpmailer.php");
	$mail = new PHPMailer();
	$mail->CharSet = 'UTF-8';
	$mail->IsSMTP();  // telling the class to use SMTP
	$mail->IsHTML(true);
	$mail->Host     = "smtp.gmail.com"; // SMTP server
	$mail->Username = "contacto@qtagtech.com";
	$mail->Password = "farroyavefami";
	$mail->Port 	= 587;
	$mail->SMTPSecure = 'tls';
	$mail->SMTPAuth = true;
	$mail->SetFrom("contacto@qtagtech.com", "Prax Assist Info");
	$sql = "SELECT ctagmail_usuario FROM prax.admin_admin";
	$result = mysql_query($sql, $link) or die(imprimir_respuesta(false,mysql_error($link),"ErrorMysql"));
	while($row = mysql_fetch_array($result)) {
  		$valor = $row["ctagmail_usuario"];                                        
		$mail->AddAddress($valor);
		$mail->AddAddress("");//ayuda@prax.com.co
	}	
	$mail->Subject  = "Confirmación de creación de administrador";
	$mail->Body     = "<html>
						<head>
						<title></title>
						</head>	
						<body>
							<p>Cordial saludo.</p>
							<br/>
							<p>Nos complace informar que ha sido creado en el sistema Prax Assist como administrador del sistema.
							Si tiene alguna pregunta o algo más en lo que nuestro equipo pueda ayudarle no dude en enviarnos un mensaje a ayuda@prax.com.co o consulte el Centro de Aprendizaje.</p>
					   		<br/>
					   		<p>Cordialmente,</p>
					   		<br/>
					   		<p>El equipo de Prax.</p>
					   	</body>
					   	</html>";
	$mail->WordWrap = 50;
	if(!$mail->Send()) {
	  echo 'Message was not sent.';
	  echo 'Mailer error: ' . $mail->ErrorInfo;
	} else {
	  echo 'Message has been sent...';
	}
	mysql_close($link);
?>