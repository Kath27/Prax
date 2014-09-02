<?php
include ("config.php");
include ("utilidades.php");


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
        $ctagmail_usuario = htmlentities($_POST['ctagmail_usuario']);

        if (!filter_var($ctagmail_usuario, FILTER_VALIDATE_EMAIL)) {
            imprimir_respuesta(false,"Esta dirección de correo ($ctagmail_usuario) no es válida.","ErrorCorreo");
        }

        $sql = "SELECT * FROM admin_psico WHERE ctagmail_usuario='" . $ctagmail_usuario . "'";
        $result = mysql_query($sql);
        if ($result && mysql_num_rows($result) > 0){
            imprimir_respuesta(false,"Esta cuenta gmail ya existe","ErrorCorreo");
        }

        // Insertamos los datos en la base de datos, si da algun error lo muestra. 
        $sql = "INSERT INTO admin_psico (nombre, apellido, documento, sexo, fechnac, targProfe, ubicacion, ctagmail_usuario,id_admin) VALUES ('".$nombre."','".$apellido."','".$documento."','".$sexo."','".$fechnac."','".$targProfe."','".$ubicacion."', '".$ctagmail_usuario."', 1)";
       
        mysql_query($sql) or die(imprimir_respuesta(false,mysql_error(),"ErrorMysql"));

        mysql_close();
        // Mostramos un mensaje diciendo que todo salio como lo esperado
        imprimir_respuesta(true,"Tu pre inscripción ha sido realizada con éxito, cuando sea activado el sistema te enviaremos un correo electrónico." . "\n" ." Fecha prevista de activación: Septiembre de 2014.");
    }
    else{
        imprimir_respuesta(false,"Falta llenar algun dato","FormularioVacio");
    }


?>