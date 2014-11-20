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
		
		if (!isReal($documento)) { imprimir_respuesta(false,"El documento $documento debe ser numérico","ErrorMysql"); }
		if (!isTextOnly($nombre)) { imprimir_respuesta(false,"El nombre $nombre no debe contener números","ErrorMysql"); }
		if (!isTextOnly($apellido)) { imprimir_respuesta(false,"El apellido $apellido no debe contener números","ErrorMysql"); }

        if($_SESSION["rol"]=="admin"){
           $columnaAdmin =  "id_admin";
        }
        else{
            $columnaAdmin = "id_adminpsic";
        }
        
        $sql="SELECT documento FROM prax.paciente WHERE documento ='".$documento."' AND ".$columnaAdmin."=".$user;
        $result2=mysql_query($sql,$link)or die(imprimir_respuesta(false,mysql_error($link),"ErrorMysql"));
        
        if(mysql_num_rows($result2)>0){
            imprimir_respuesta(false,"Ya existe un paciente con ese número de identificación: " . $documento,"ErrorMysql");
        }
                
                // Insertamos los datos en la base de datos, si da algun error lo muestra. 
        $sql = "INSERT INTO paciente (documento, nombre, apellido, fecha_crea, fecha_mod," . $columnaAdmin . ") VALUES ('".$documento."','".$nombre."','".$apellido."','".$fecha."','".$fecha."','".$user."')";
       
        mysql_query($sql,$link) or die(imprimir_respuesta(false,mysql_error($link),"ErrorMysql"));
        mysql_close($link);
        
        $idAdmin = ($_SESSION["rol"] == "admin")? "a" : "p";
        $idAdmin .= $_SESSION["userId"];
        
        crearHistoria($documento, $idAdmin);
        
        imprimir_respuesta(true,"Paciente agregado correctamente");

    }
    else{
        imprimir_respuesta(false,"Falta llenar algun dato","FormularioVacio");
    }


?>