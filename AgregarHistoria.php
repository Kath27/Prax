<?php
    include("config_mongo.php");
    include("utilidades.php");

     if(!empty($_POST['motivo']) && !empty($_POST['evaluacionMedico']) && !empty($_POST['evaluacionFami'])  && !empty($_POST['evaluacionPsico'])&& !empty($_POST['evaluacionNeuro'])&& !empty($_POST['diagnostico'])&& !empty($_POST['tratamiento'])&& !empty($_POST['anotaciones'])){
         $id_paciente = htmlentities($_POST['id_paciente']); 
         $motivo = htmlentities($_POST['motivo']);    
         $evaluacionMedico = htmlentities($_POST['evaluacionMedico']);
         $evaluacionFami = htmlentities($_POST['evaluacionFami']);
         $evaluacionPsico = htmlentities($_POST['evaluacionPsico']);
         $evaluacionNeuro = htmlentities($_POST['evaluacionNeuro']);
         $diagnostico = htmlentities($_POST['diagnostico']);
         $tratamiento = htmlentities($_POST['tratamiento']);
         $anotaciones = htmlentities($_POST['anotaciones']);
         
         $result = guardarHistoria($id_paciente, $motivo, $evaluacionMedico, $evaluacionFami, $evaluacionPsico, $evaluacionNeuro, $diagnostico, $tratamiento, $anotaciones);
         if($result->{"error"} == null){
             imprimir_respuesta(true,"Guardado correctamente");
         }
         else{
             imprimir_respuesta(false,$result->{"error"}, "ErrorMongo");
         }
     }
     else{
        imprimir_respuesta(false,"Falta llenar algun dato","FormularioVacio");
    }
?>
