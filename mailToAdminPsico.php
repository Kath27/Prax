<?php
	require_once("PHPMailer_5.2.4/class.phpmailer.php");
    require_once ("utilidades.php");
    
    function mailToPsico($ctagmail_usuario){
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
    	$mail->AddAddress($ctagmail_usuario);  
    	$mail->AddCC("catalina.meneses@qtagtech.com");//ayuda@prax.com.co	
    	$mail->Subject  = "Confirmación de creación de cuenta en Prax Assist";
    	$mail->Body     = "<html>
    						<head>
    						<title></title>
    						</head>	
    						<body>
    						<div style='text-align: justify;'>
    							<p>Cordial saludo.</p>
    							<br/>
    							<p>Nos complace informar que ha sido creado en el sistema Prax Assist. A partir de este momento puede comenzar a utilizar el sistema.
    							<br/>
    								Recuerde que su usuario es la cuenta de gmail que registró al momento de inscribirse y la clave es la que asignó a dicha cuenta. Nuestra organización desconoce la clave, si requiere recuperarla o cambiarla debe utilizar los métodos disponibles por Google.
    							<br/>
    								Puede ingresar al sistema ingresando a nuestra página web y seleccionando la opción Prax Assist.
    							<br/>
    							Si tiene alguna pregunta o algo más en lo que nuestro equipo pueda ayudarle no dude en enviarnos un mensaje a ayuda@prax.com.co o consulte el Centro de aprendizaje.</p>
    					   		<br/>
    					   		<p>Cordialmente,</p>
    					   		<br/>
    					   		<p>El equipo de Prax.</p>
    					   	</div>	
    					   	</body>
    					   	</html>";
    	$mail->WordWrap = 50;
    	if(!$mail->Send()) {
          imprimir_respuesta(false, "El correo no se pudo enviar: " . $mail->ErrorInfo, "mailError");
        }
    }
	
?>