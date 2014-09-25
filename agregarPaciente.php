<?php
include ("config.php");
include ("utilidades.php");
include_once("config_mongo.php");
session_start();
if (!isset($_SESSION["userId"])){ header('Location: /'); }
    
    if(!empty($_POST['documento']) && !empty($_POST['nombre']) && !empty($_POST['apellido']))
    {
        
        $documento = htmlentities($_POST['documento']);
        $nombre = htmlentities($_POST['nombre']);
        $apellido = htmlentities($_POST['apellido']);
        $user=$_SESSION["userId"];
        date_default_timezone_set('America/Lima');
        $fecha = date("Y-m-d H:i:s");

        if (!filter_var($ctagmail, FILTER_VALIDATE_EMAIL)) {
            imprimir_respuesta(false,"Esta dirección de correo ($ctagmail_usuario) no es válida.","ErrorCorreo");
        }
        if($_SESSION["rol"]=="admin"){
           $columnaAdmin =  "id_admin";
        }
        else{
            $columnaAdmin = "id_adminpsic";
        }
        
                // Insertamos los datos en la base de datos, si da algun error lo muestra. 
        $sql = "INSERT INTO paciente (documento, nombre, apellido, fecha_crea, " . $columnaAdmin . ") VALUES ('".$documento."','".$nombre."','".$fecha."','".$user."')";
       
        mysql_query($sql,$link) or die(imprimir_respuesta(false,mysql_error($link),"ErrorMysql"));

        mysql_close($link);
        crearHistoria($documento);
        // Mostramos un mensaje diciendo que todo salio como lo esperado
        imprimir_respuesta(true,"Paciente agregaro correctamente");
    }
    else{
        imprimir_respuesta(false,"Falta llenar algun dato","FormularioVacio");
    }


?>