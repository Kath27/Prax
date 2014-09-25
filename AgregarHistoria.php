<?php
    include("config_mongo.php");
    include("utilidades.php");
    include("config.php");
    session_start();
    if (!isset($_SESSION["userId"])){ header('Location: /'); }
     
    $objResponse = ""; 
    if (!empty($_POST['anotaciones'])){
        $documento = htmlentities(getParameter('documento'));    
        $anotaciones = htmlentities(getParameter('anotaciones'));
        date_default_timezone_set('America/Lima');
        $fecha = date("Y-m-d H:i:s");
        $objResponse = guardarAnotaciones($documento, $anotaciones, $fecha);
        $objResponse->{"updated"} = $fecha;
        
        mysql_close($link);
        imprimir_respuesta(true,"Guardado correctamente. Por confidencialidad con tu paciente evita registrar información sensible donde se identifiquen personas o hechos", "", $objResponse);
     }
     
     $id_paciente = htmlentities(getParameter('id_paciente')); 
     $motivo = htmlentities(getParameter('motivo'));    
     $evaluacionMedico = htmlentities(getParameter('evaluacionMedico'));
     $evaluacionFami = htmlentities(getParameter('evaluacionFami'));
     $evaluacionPsico = htmlentities(getParameter('evaluacionPsico'));
     $evaluacionNeuro = htmlentities(getParameter('evaluacionNeuro'));
     $diagnostico = htmlentities(getParameter('diagnostico'));
     $tratamiento = htmlentities(getParameter('tratamiento'));
     $nombre = htmlentities(getParameter('nombre'));
     $apellido = htmlentities(getParameter('apellido'));
     $documento = htmlentities(getParameter('documento'));
     $fechanac = htmlentities(getParameter('fechanac'));
     $ubicacion = htmlentities(getParameter('ubicacion'));
     $telFijo = htmlentities(getParameter('telFijo'));
     $telMovil = htmlentities(getParameter('telMovil'));
     $mail = htmlentities(getParameter('mail'));
     $nombre_cont = htmlentities(getParameter('nombre_cont'));
     $apellido_cont = htmlentities(getParameter('apellido_cont'));
     $documento_cont = htmlentities(getParameter('documento_cont'));
     $fechanac_cont = htmlentities(getParameter('fechanac_cont'));
     $ubicacion_cont = htmlentities(getParameter('ubicacion_cont'));
     $telFijo_cont = htmlentities(getParameter('telFijo_cont'));
     $telMovil_cont = htmlentities(getParameter('telMovil_cont'));
     $mail_cont = htmlentities(getParameter('mail_cont'));
     $tipo_relacion = htmlentities(getParameter('tipo_relacion'));
     date_default_timezone_set('America/Lima');
     $fecha = date("Y-m-d H:i:s");
                
     $result = guardarHistoria($documento, $motivo, $evaluacionMedico, $evaluacionFami, $evaluacionPsico, $evaluacionNeuro, $diagnostico, $tratamiento);
     
     if($result->{"error"} != null){
         imprimir_respuesta(false,$result->{"error"}, "ErrorMongo");
     }
     
     $sql = "UPDATE prax.paciente SET  nombre='".$nombre."', apellido='".$apellido."', documento='".$documento."', fechnac='".$fechanac."', ubicacion='".$ubicacion."', tel_fijo='".$telFijo."',
     tel_movil='".$telMovil."',ctagmail='".$mail."', fecha_mod='".$fecha."' WHERE id_paciente=".$id_paciente;
     $result = mysql_query($sql, $link)or die(imprimir_respuesta(false,mysql_error($link),"ErrorMysql"));
     
     if ($nombre_cont != "" && $apellido_cont != "" && $documento_cont != "" && $fechanac_cont != "" && $ubicacion_cont != "" && $telFijo_cont != "" && $telMovil_cont != "" && $mail_cont!=""){
         $sql = "SELECT id_paciente FROM prax.paciente_contac where id_paciente =".$id_paciente ;
         $result =mysql_query($sql, $link)or die(imprimir_respuesta(false,mysql_error($link),"ErrorMysql"));
     
         if(mysql_num_rows($result) > 0){
             $sql = "UPDATE prax.paciente_contac SET documento='".$documento_cont."',nombre='".$nombre_cont."',apellido='".$apellido_cont."',fechnac='".$fechanac_cont."', " .
             " ubicacion='".$ubicacion_cont."', tel_fijo='".$telFijo_cont."',tel_movil='".$telMovil_cont."',ctagmail='".$mail_cont."',tipo_relacion='".$tipo_relacion."',id_paciente='".$id_paciente."'" . 
             " WHERE id_paciente=".$id_paciente;
             $result = mysql_query($sql, $link)or die(imprimir_respuesta(false,mysql_error($link),"ErrorMysql"));
         }
         else{
             $sql="INSERT INTO prax.paciente_contac (documento, nombre, apellido, fechnac, ubicacion, tel_fijo, tel_movil, ctagmail, id_paciente, tipo_relacion) " .
             "VALUES ('".$documento_cont."','".$nombre_cont."','".$apellido_cont."','".$fechanac_cont."','".$ubicacion_cont."','".$telFijo_cont."','".$telMovil_cont."'," . 
             "'".$mail_cont."',".$id_paciente.",'".$tipo_relacion."')";
             $result = mysql_query($sql, $link)or die(imprimir_respuesta(false,mysql_error($link),"ErrorMysql"));
         }
     }
     
     if ($objResponse == ""){ $objResponse = new stdClass(); }
     $objResponse->{"updated"} = $fecha;
     
     mysql_close($link);
     imprimir_respuesta(true,"Guardado correctamente. Por confidencialidad con tu paciente evita registrar información sensible donde se identifiquen personas o hechos", "", $objResponse);
?>
