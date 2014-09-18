<?php
include ("config.php");
include ("utilidades.php");
include_once("config_mongo.php");
session_start();

    // Verificamos que no alla ningun dato sin rellenar.
    if(!empty($_POST['documento']) && !empty($_POST['nombre']) && !empty($_POST['apellido']) && !empty($_POST['fechnac']) && !empty($_POST['ubicacion']) && !empty($_POST['tel_fijo']) && !empty($_POST['tel_movil']) && !empty($_POST['ctagmail']) && !empty($_POST['sexo']))
    {
        // Pasamos los datos de los POST a Variables, y le ponemos seguridad.
        $documento = htmlentities($_POST['documento']);
        $nombre = htmlentities($_POST['nombre']);
        $apellido = htmlentities($_POST['apellido']);
        $fechnac = htmlentities($_POST['fechnac']);
        $ubicacion = htmlentities($_POST['ubicacion']);
        $tel_fijo = htmlentities($_POST['tel_fijo']);
        $tel_movil = htmlentities($_POST['tel_movil']);
        $ctagmail = htmlentities($_POST['ctagmail']);
        $sexo = htmlentities($_POST['sexo']);
        $user=$_SESSION["userId"];

        if (!filter_var($ctagmail, FILTER_VALIDATE_EMAIL)) {
            imprimir_respuesta(false,"Esta dirección de correo ($ctagmail_usuario) no es válida.","ErrorCorreo");
        }

                // Insertamos los datos en la base de datos, si da algun error lo muestra. 
        $sql = "INSERT INTO paciente (documento, nombre, apellido, fechnac, ubicacion, tel_fijo, tel_movil, ctagmail, sexo, id_adminpsic) VALUES ('".$documento."','".$nombre."','".$apellido."','".$fechnac."','".$ubicacion."','".$tel_fijo."','".$tel_movil."','".$ctagmail."','".$sexo."', '".$user."')";
       
        mysql_query($sql,$link) or die(imprimir_respuesta(false,mysql_error($link),"ErrorMysql"));

        mysql_close($link);
        crearHistoria($documento);
        // Mostramos un mensaje diciendo que todo salio como lo esperado
        imprimir_respuesta(true,"Tu pre inscripción ha sido realizada con éxito, cuando sea activado el sistema te enviaremos un correo electrónico." . "\n" ." Fecha prevista de activación: Septiembre de 2014." . "\n" . " Por confidencialidad con tu paciente evita registrar información sensible donde se identifiquen personas o hechos
        ");
    }
    else{
        imprimir_respuesta(false,"Falta llenar algun dato","FormularioVacio");
    }


?>