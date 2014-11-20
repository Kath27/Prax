<?php
include ("config.php");
include ("utilidades.php");
session_start();
if (!isset($_SESSION["userId"])){ header('Location: /'); }

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
        $ctagmail_usuario = trim(htmlentities($_POST['ctagmail_usuario']));
		$city = $_POST["city"];
		$cityChanged = ($_POST["cityChanged"] == "T");
        $isActive=$_POST["isActive"];
        $idPsico = $_POST['idPsico'];
        

        if (!filter_var($ctagmail_usuario, FILTER_VALIDATE_EMAIL)) {
            imprimir_respuesta(false,"Esta dirección de correo ($ctagmail_usuario) no es válida.","ErrorCorreo");
        }
        if($ctagmail_usuario!=$_SESSION["ctagmail_usuario"] && !stristr($ctagmail_usuario, "gmail.com")){
            imprimir_respuesta(false,"Esta dirección de correo ".$ctagmail_usuario . " debe ser Gmail","ErrorCorreo");
        }        
        $sql="SELECT ctagmail_usuario FROM prax.admin_psico WHERE ctagmail_usuario='".$ctagmail_usuario."' AND id_adminpsic != " .$idPsico; 
        $result=mysql_query($sql, $link)or die(imprimir_respuesta(false,mysql_error($link),"ErrorMysql"));
        
        if(mysql_num_rows($result)>0){
            imprimir_respuesta(false,"El correo insertado se encuentra asociado a otra cuenta","ErrorCorreo");
        }
        
        $sql="SELECT ctagmail_usuario FROM prax.admin_admin WHERE ctagmail_usuario='".$ctagmail_usuario."'"; 
        $result=mysql_query($sql, $link)or die(imprimir_respuesta(false,mysql_error($link),"ErrorMysql"));
        
        if(mysql_num_rows($result)>0){
            imprimir_respuesta(false,"El correo insertado se encuentra asociado a otra cuenta","ErrorCorreo");
        }
		
		$sql="SELECT documento FROM prax.admin_psico WHERE documento='".$documento."' && id_adminpsic != " . $idPsico; 
        $result=mysql_query($sql, $link)or die(imprimir_respuesta(false,mysql_error($link),"ErrorMysql"));
        
        if(mysql_num_rows($result)>0){
            imprimir_respuesta(false,"El documento de identidad se encuentra asociado a otra cuenta","ErrorMysql");
        }
        
        /*$dominio=substr($ctagmail_usuario,strpos($ctagmail_usuario,"@")+1);
        if(!dominioEsGmail($dominio)){
            imprimir_respuesta(false,"Esta direccion de correo ".$ctagmail_usuario."no es una cuenta de google","ErrorCorreo");
        }*/
         // Insertamos los datos en la base de datos, si da algun error lo muestra. 
        $sql = "UPDATE prax.admin_psico SET nombre='".$nombre."',apellido='".$apellido."',documento='".$documento."',sexo='".$sexo."',fechnac='".$fechnac.
        "',targProfe='".$targProfe."',ubicacion='".$ubicacion."',ctagmail_usuario='".$ctagmail_usuario."', isActive='".$isActive."'";
        
        if ($cityChanged)
        	$sql .= ", ciudad='" . $city . "'";
        
        $sql .= " WHERE id_adminpsic=".$idPsico;
       
        mysql_query($sql,$link) or die(imprimir_respuesta(false,mysql_error($link),"ErrorMysql"));

        mysql_close($link);
        
        if($_SESSION["userId"]==$idPsico){
            session_start();
            $_SESSION["nombre"] = $nombre;
            $_SESSION["apellido"] = $apellido;
            $_SESSION["documento"] = $documento;
            $_SESSION["sexo"] = $sexo;
            $_SESSION["fechnac"] = $fechnac;
            $_SESSION["targProfe"] = $targProfe;
            $_SESSION["ubicacion"] = $ubicacion;
            $_SESSION["ctagmail_usuario"] = $ctagmail_usuario;
        }
       
        imprimir_respuesta(true,"Sus datos se actualizaron correctamente.");
    }
    else{
        imprimir_respuesta(false,"Falta llenar algun dato","FormularioVacio");
    }


?>