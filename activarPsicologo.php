<?php
    include("config.php");
    include("utilidades.php");
    session_start();
    if (!isset($_SESSION["userId"]) || $_SESSION["rol"] != "admin"){ header('Location: /'); }
    
    $documento = $_POST["documento"];
    $activar = $_POST["activar"];
    
    $sql = "UPDATE prax.admin_psico SET isActive = '".$activar."' WHERE documento = '".$documento."'";
    $result = mysql_query($sql,$link)or die (imprimir_respuesta(false,mysql_error($link),"ErrorMysql"));
    
    if($result){
        if($activar =="T"){
            imprimir_respuesta(true,"Psicólogo activado correctamente");
        }else{
            imprimir_respuesta(true,"Psicólogo desactivado correctamente");
        }
    }
    
    mysql_close($link);
?>