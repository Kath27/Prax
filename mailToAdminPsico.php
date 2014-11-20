<?php
	    use google\appengine\api\app_identity\AppIdentityService;
        use \google\appengine\api\mail\Message;
        require_once ("utilidades.php");
    
        function mailToPsico($ctagmail_usuario){
            try
            {
              $access_token = AppIdentityService::getAccessToken('https://www.googleapis.com/auth/userinfo.email');
              $headers= array(sprintf('Authorization: OAuth %s', $access_token['access_token']));
              $opts = array(
                  'http' => array(
                    'header' => implode("\r\n", $headers),
                  ),
                );
        $message = new Message();
        $message->setSender("info@prax.com.co");
    	$message->addCc("ayuda@prax.com.co");//ayuda@prax.com.co	
    	$message->addTo($ctagmail_usuario);
        $message->setSubject("Prax Assist");
    	$message->setHtmlBody("<html>
    						<head>
    						<title></title>
    						</head>	
    						<body>
    						<div style='text-align: justify;'>
    							<p>Cordial saludo.</p>
    							<p>Nos complace informar que ha sido creado en el sistema Prax Assist. A partir de este momento puede comenzar a utilizar el sistema.
    							<br />
    							<br />
    								Recuerde que su usuario es la cuenta de gmail que registró al momento de inscribirse y la clave es la que asignó a dicha cuenta. Nuestra organización desconoce la clave, si requiere recuperarla o cambiarla debe utilizar los métodos disponibles por Google.
    							<br/>
    							<br/>
    								Puede ingresar al sistema ingresando a nuestra página web y seleccionando la opción Prax Assist.
    							<br/>
    							<br/>
    							Si tiene alguna pregunta o algo más en lo que nuestro equipo pueda ayudarle no dude en enviarnos un mensaje a ayuda@prax.com.co o consulte el Centro de aprendizaje.</p>
    					   		<p>Cordialmente,</p>
    					   		<p>El equipo de Prax.</p>
    					   	</div>	
    					   	</body>
    					   	</html>");
        $message->send();
        } catch (InvalidArgumentException $e) {
            imprimir_respuesta(false, "El correo no se pudo enviar: " . $e->getMessage(), "mailError");
        }
    }
    
?>