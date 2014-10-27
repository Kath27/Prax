<?php
include ("config.php");
require_once ("utilidades.php");
include ("mailToAdminAdmin.php");
session_start();
if (!isset($_SESSION["userId"]) || $_SESSION["rol"] != "admin"){ header('Location: /'); }

    // Verificamos que no alla ningun dato sin rellenar.
    if(!empty($_POST['nombre']) && !empty($_POST['apellido']) && !empty($_POST['documento'])  && !empty($_POST['ctagmail_usuario']))
    {
        // Pasamos los datos de los POST a Variables, y le ponemos seguridad.
        $nombre = htmlentities($_POST['nombre']);
        $apellido = htmlentities($_POST['apellido']);
        $documento = htmlentities($_POST['documento']);        
        $ctagmail_usuario = trim(htmlentities($_POST['ctagmail_usuario']));
        /*user=$_SESSION["getUserId"]*/

        if (!filter_var($ctagmail_usuario, FILTER_VALIDATE_EMAIL)) {
            imprimir_respuesta(false,"Esta dirección de correo ($ctagmail_usuario) no es válida.","ErrorCorreo");
        }

        $sql = "SELECT * FROM admin_admin WHERE ctagmail_usuario='" . $ctagmail_usuario . "'";
        $result = mysql_query($sql, $link)or die(imprimir_respuesta(false,mysql_error($link),"ErrorMysql"));
        if ($result && mysql_num_rows($result) > 0){
            imprimir_respuesta(false,"Esta cuenta gmail ya existe","ErrorCorreo");
        }
        
        $sql="SELECT ctagmail_usuario FROM prax.admin_psico WHERE ctagmail_usuario='".$ctagmail_usuario."'"; 
        $result=mysql_query($sql, $link)or die(imprimir_respuesta(false,mysql_error($link),"ErrorMysql"));
        
        if(mysql_num_rows($result)>0){
            imprimir_respuesta(false,"Esta cuenta gmail ya existe","ErrorCorreo");
        }

        // Insertamos los datos en la base de datos, si da algun error lo muestra. 
        $sql = "INSERT INTO admin_admin (nombre, apellido, documento, ctagmail_usuario) VALUES ('".$nombre."','".$apellido."','".$documento."','".$ctagmail_usuario."')";
       
        mysql_query($sql,$link) or die(imprimir_respuesta(false,mysql_error($link),"ErrorMysql"));

        mysql_close($link);
        // Mostramos un mensaje diciendo que todo salio como lo esperado
        mailToAdmin($ctagmail_usuario);
        imprimir_respuesta(true,"Administrador agregado correctamente");
      
    }
    else{
        imprimir_respuesta(false,"Falta llenar algun dato","FormularioVacio");
    }


?>