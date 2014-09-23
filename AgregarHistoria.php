<?php
    include("config_mongo.php");
    include("utilidades.php");
    include("config.php");
     
    $objResponse = ""; 
    if (!empty($_POST['anotaciones'])){
        $documento = htmlentities($_POST['documento']);    
        $anotaciones = htmlentities($_POST['anotaciones']);
        date_default_timezone_set('America/Lima');
        $fecha = date("Y-m-d H:i:s");
        $objResponse = guardarAnotaciones($documento, $anotaciones, $fecha);
     }
     
     if(!empty($_POST['motivo']) && !empty($_POST['evaluacionMedico']) && !empty($_POST['evaluacionFami'])  && !empty($_POST['evaluacionPsico'])
     && !empty($_POST['evaluacionNeuro'])&& !empty($_POST['diagnostico'])&& !empty($_POST['tratamiento'])
     && !empty($_POST['evaluacionMedico']) && !empty($_POST['nombre']) && !empty($_POST['apellido']) && !empty($_POST['documento']) 
     && !empty($_POST['fechanac']) && !empty($_POST['ubicacion']) && !empty($_POST['telFijo']) && !empty($_POST['telMovil'])
     && !empty($_POST['mail']) && !empty($_POST['nombre_cont']) && !empty($_POST['apellido_cont']) && !empty($_POST['documento_cont'])
     && !empty($_POST['fechanac_cont']) && !empty($_POST['ubicacion_cont']) && !empty($_POST['telFijo_cont']) && !empty($_POST['telMovil_cont'])
     && !empty($_POST['mail_cont']) && !empty($_POST['tipo_relacion'])){
         $id_paciente = htmlentities($_POST['id_paciente']); 
         $motivo = htmlentities($_POST['motivo']);    
         $evaluacionMedico = htmlentities($_POST['evaluacionMedico']);
         $evaluacionFami = htmlentities($_POST['evaluacionFami']);
         $evaluacionPsico = htmlentities($_POST['evaluacionPsico']);
         $evaluacionNeuro = htmlentities($_POST['evaluacionNeuro']);
         $diagnostico = htmlentities($_POST['diagnostico']);
         $tratamiento = htmlentities($_POST['tratamiento']);
         $nombre = htmlentities($_POST['nombre']);
         $apellido = htmlentities($_POST['apellido']);
         $documento = htmlentities($_POST['documento']);
         $fechanac = htmlentities($_POST['fechanac']);
         $ubicacion = htmlentities($_POST['ubicacion']);
         $telFijo = htmlentities($_POST['telFijo']);
         $telMovil = htmlentities($_POST['telMovil']);
         $mail = htmlentities($_POST['mail']);
         $nombre_cont = htmlentities($_POST['nombre_cont']);
         $apellido_cont = htmlentities($_POST['apellido_cont']);
         $documento_cont = htmlentities($_POST['documento_cont']);
         $fechanac_cont = htmlentities($_POST['fechanac_cont']);
         $ubicacion_cont = htmlentities($_POST['ubicacion_cont']);
         $telFijo_cont = htmlentities($_POST['telFijo_cont']);
         $telMovil_cont = htmlentities($_POST['telMovil_cont']);
         $mail_cont = htmlentities($_POST['mail_cont']);
         $tipo_relacion = htmlentities($_POST['tipo_relacion']);
         date_default_timezone_set('America/Lima');
         $fecha = date("Y-m-d H:i:s");
         
                
         $result = guardarHistoria($documento, $motivo, $evaluacionMedico, $evaluacionFami, $evaluacionPsico, $evaluacionNeuro, $diagnostico, $tratamiento);
         
         if($result->{"error"} != null){
             imprimir_respuesta(false,$result->{"error"}, "ErrorMongo");
         }
         
         $sql = "UPDATE prax.paciente SET  nombre='".$nombre."', apellido='".$apellido."', documento='".$documento."', fechnac='".$fechanac."', ubicacion='".$ubicacion."', tel_fijo='".$telFijo."',
         tel_movil='".$telMovil."',ctagmail='".$mail."', fecha_mod='".$fecha."' WHERE id_paciente=".$id_paciente;
         $result = mysql_query($sql, $link)or die(imprimir_respuesta(false,mysql_error($link),"ErrorMysql"));
         
         $sql = "SELECT count(*) FROM prax.paciente_contac where id_paciente =".$id_paciente ;
         $result =mysql_query($sql, $link)or die(imprimir_respuesta(false,mysql_error($link),"ErrorMysql"));
         $existe =  mysql_fetch_row($result);
         
         if($existe[0]>=1){
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
         
         mysql_close($link);
         imprimir_respuesta(true,"Guardado correctamente", "", $objResponse);
     }
     else{
         if($objResponse=="")
        imprimir_respuesta(false,"Falta llenar algun dato","FormularioVacio");
         else{
             imprimir_respuesta(true,"Guardado correctamente", "", $objResponse);
         }
    }
?>
