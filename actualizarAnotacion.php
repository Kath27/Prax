<?php
include ("config.php");
include ("utilidades.php");
include("config_mongo.php");
session_start();

    // Verificamos que no alla ningun dato sin rellenar.
    if(!empty($_POST['anotacion']) && !empty($_POST['id_anotacion']))
    {
        // Pasamos los datos de los POST a Variables, y le ponemos seguridad.
        $anotacion = htmlentities($_POST['anotacion']);
        $id_anotacion = $_POST['id_anotacion'];
        
        date_default_timezone_set('America/Lima');
        $fecha = date("Y-m-d H:i:s");
        
        actualizarAnotacion($id_anotacion,$anotacion,$fecha);
                
        imprimir_respuesta(true,"Sus datos se actualizaron correctamente.","",$fecha);
    }
    else{
        imprimir_respuesta(false,"Falta llenar algun dato","FormularioVacio");
    }


?>