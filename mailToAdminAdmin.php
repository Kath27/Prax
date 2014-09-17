<?php
    require_once("PHPMailer_5.2.4/class.phpmailer.php");
    require_once ("utilidades.php");
    
    function mailToAdmin($ctagmail_usuario){
        $mail = new PHPMailer();
        $mail->CharSet = 'UTF-8';
        $mail->IsSMTP();  // telling the class to use SMTP
        $mail->IsHTML(true);
        $mail->Host     = "smtp.gmail.com"; // SMTP server
        $mail->Username = "contacto@qtagtech.com";
        $mail->Password = "farroyavefami";
        $mail->Port     = 587;
        $mail->SMTPSecure = 'tls';
        $mail->SMTPAuth = true;
        $mail->SetFrom("contacto@qtagtech.com", "Prax Assist Info");
        $mail->AddAddress($ctagmail_usuario);
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
          imprimir_respuesta(false, "El correo no se pudo enviar: " . $mail->ErrorInfo, "mailError");
        }
    }
	
?>