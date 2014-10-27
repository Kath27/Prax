<?php 
    header('Content-Type: text/plain; charset=utf-8');
    include("utilidades.php");
    if (isset($_GET) && isset($_FILES)){
        $paciente = $_GET["paciente"];
        $admin = $_GET["idAdmin"];
        $path = $_FILES['uploadAvatar']['name'];
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $type = $_FILES["uploadAvatar"]["type"];
        
        $file = "gs://imagespacientes/paciente" . $paciente . "_" . $admin . ".png";
        move_uploaded_file($_FILES["uploadAvatar"]["tmp_name"], $file);
        
        $allowedExts = array("jpeg", "jpg", "png");
        
        if ((($type == "image/jpeg") || ($type == "image/jpg") || ($type == "image/png")) && in_array($ext, $allowedExts)){
            imprimir_respuesta(true,"Imagen guardada correctamente");
        }else{
            unlink($file);
            imprimir_respuesta(false,"Tipo de archivo incorrecto");
        }
    }
        imprimir_respuesta(false,"Error al cargar la imagen");
?>