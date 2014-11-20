<?php
include ("config.php");
include ("utilidades.php");
include("mailToAdminPsico.php");
session_start();

    // Verificamos que no alla ningun dato sin rellenar.
    if(!empty($_POST['nombre']) && !empty($_POST['apellido']) && !empty($_POST['documento']) && !empty($_POST['sexo']) && !empty($_POST['fechnac']) && !empty($_POST['targProfe']) && !empty($_POST['ubicacion']) && !empty($_POST['ctagmail_usuario']))
    {
        // Pasamos los datos de los POST a Variables, y le ponemos seguridad.
        $nombre = htmlentities($_POST['nombre']);
        $apellido = htmlentities($_POST['apellido']);
        $documento = htmlentities($_POST['documento']);
        $sexo = htmlentities($_POST['sexo']);
        $fechnac = htmlentities($_POST['fechnac']);
        $targProfe = htmlentities($_POST['targProfe']);
        $ubicacion = htmlentities($_POST['ubicacion']);
		$city = $_POST['city'];
        $ctagmail_usuario = trim(htmlentities($_POST['ctagmail_usuario']));
        

        if (!filter_var($ctagmail_usuario, FILTER_VALIDATE_EMAIL)) { imprimir_respuesta(false,"Esta dirección de correo ($ctagmail_usuario) no es válida.","ErrorCorreo"); }
		if (!isReal($documento)) { imprimir_respuesta(false,"El documento $documento debe ser numérico","ErrorMysql"); }
		if (!isTextOnly($nombre)) { imprimir_respuesta(false,"El nombre $nombre no debe contener números","ErrorMysql"); }
		if (!isTextOnly($apellido)) { imprimir_respuesta(false,"El apellido $apellido no debe contener números","ErrorMysql"); }

        $sql = "SELECT * FROM admin_psico WHERE ctagmail_usuario='" . $ctagmail_usuario . "'";
        $result = mysql_query($sql, $link);
        if ($result && mysql_num_rows($result) > 0){
            imprimir_respuesta(false,"Esta cuenta gmail ya existe","ErrorCorreo");
        }

        // Insertamos los datos en la base de datos, si da algun error lo muestra.
        date_default_timezone_set('America/Lima');
        $fecha = date("Y-m-d H:i:s"); 
        $sql = "INSERT INTO admin_psico (nombre, apellido, documento, sexo, fechnac, targProfe, ubicacion, ctagmail_usuario, fechregistro, ciudad) VALUES ('".$nombre."','".$apellido."','".$documento."','".$sexo."','".$fechnac."','".$targProfe."','".$ubicacion."','".$ctagmail_usuario."', '" . $fecha . "', '" . $city . "')";
       
        mysql_query($sql,$link) or die(imprimir_respuesta(false,mysql_error($link),"ErrorMysql"));

        mysql_close($link);
        // Mostramos un mensaje diciendo que todo salio como lo esperado
        mailToPsico($ctagmail_usuario);
        imprimir_respuesta(true,"Tu pre inscripción ha sido realizada con éxito, cuando sea activado el sistema te enviaremos un correo electrónico." . "\n" ." Fecha prevista de activación: Septiembre de 2014.");
    }
    else{
        imprimir_respuesta(false,"Falta llenar algun dato","FormularioVacio");
    }


?>