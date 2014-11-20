<?php
    include_once("config_mongo.php");
    include_once("utilidades.php");
    include("config.php");
    session_start();
    if (!isset($_SESSION["userId"])){ header('Location: /'); }
     
    $objResponse = ""; 
    $idAdmin = ($_SESSION["rol"] == "admin")? "a" : "p";
    $idAdmin .= $_SESSION["userId"];
    if (!empty($_POST['anotaciones'])){
        $documento = htmlentities(getParameter('documento'));    
        $anotaciones = htmlentities(getParameter('anotaciones'));
        date_default_timezone_set('America/Lima');
        $fecha = date("Y-m-d H:i:s");
        $objResponse = guardarAnotaciones($documento, $anotaciones, $fecha, $idAdmin);
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
     $sexo = htmlentities(getParameter('sexo'));
     $city = getParameter('city');
     $cityChanged = ($_POST['cityChanged'] == "T");
     $telFijo = htmlentities(getParameter('telFijo'));
     $telMovil = htmlentities(getParameter('telMovil'));
     $mail = trim(htmlentities(getParameter('mail')));
     $nombre_cont = htmlentities(getParameter('nombre_cont'));
     $apellido_cont = htmlentities(getParameter('apellido_cont'));
     $documento_cont = htmlentities(getParameter('documento_cont'));
     $fechanac_cont = htmlentities(getParameter('fechanac_cont'));
     $ubicacion_cont = htmlentities(getParameter('ubicacion_cont'));
     $telFijo_cont = htmlentities(getParameter('telFijo_cont'));
     $telMovil_cont = htmlentities(getParameter('telMovil_cont'));
     $mail_cont = trim(htmlentities(getParameter('mail_cont')));
     $tipo_relacion = htmlentities(getParameter('tipo_relacion'));
     date_default_timezone_set('America/Lima');
     $fecha = date("Y-m-d H:i:s");
     
    if($_SESSION["rol"]=="admin"){
		$columnaAdmin = "id_admin";
	}else{
		$columnaAdmin = "id_adminpsic";
    }
	
	if (trim($mail) != "") if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) { imprimir_respuesta(false,"La dirección de correo ($mail) del paciente no es válida.","ErrorCorreo"); }
	if (trim($mail_cont) != "") if (!filter_var($mail_cont, FILTER_VALIDATE_EMAIL)) { imprimir_respuesta(false,"La dirección de correo ($mail_cont) del contacto no es válida.","ErrorCorreo"); }
	
     if ($mail != ""){
         $sql="SELECT ctagmail FROM prax.paciente WHERE ctagmail='".$mail."' AND documento !='".$documento."' AND id_paciente != ".$id_paciente;
         $result= mysql_query($sql, $link)or die(imprimir_respuesta(false,mysql_error($link),"ErrorMysql"));
         if(mysql_num_rows($result)>0){
             imprimir_respuesta(false,"Este correo se encuentra registrado por otro paciente","ErrorCorreo");
         }
     }
     
     $sql="SELECT documento FROM prax.paciente WHERE documento='" . $documento . "' AND ".$columnaAdmin."=".$_SESSION["userId"]." AND id_paciente != ".$id_paciente;
     $result=mysql_query($sql, $link)or die(imprimir_respuesta(false,mysql_error($link),"ErrorMysql"));
     if(mysql_num_rows($result)>0){
         imprimir_respuesta(false,"Ya existe un paciente con ese número de identificación");
     }
	 
	// Actualizar historia mongo y anotaciones
	$sql="SELECT documento FROM prax.paciente WHERE id_paciente = ".$id_paciente;
	$result= mysql_query($sql, $link)or die(imprimir_respuesta(false,mysql_error($link),"ErrorMysql"));
    $oldDoc = mysql_fetch_row($result);
	$oldDoc = $oldDoc[0];
               
	$result = guardarHistoria($oldDoc, $documento, $motivo, $evaluacionMedico, $evaluacionFami, $evaluacionPsico, $evaluacionNeuro, $diagnostico, $tratamiento, $idAdmin);
     
	if($result->{"error"} != null){
		imprimir_respuesta(false,$result->{"error"}, "ErrorMongo");
	}
	
	// Actualizar anotaciones
	if ($oldDoc != $documento){
		$result = cambiarDocumentoAnotaciones($oldDoc, $documento, $idAdmin);
		if($result->{"error"} != null){
			imprimir_respuesta(false,$result->{"error"}, "ErrorMongo");
		}
	}
             
     $sql = "UPDATE prax.paciente SET  nombre='".$nombre."', apellido='".$apellido."', documento='".$documento."', fechnac='".$fechanac."', ubicacion='".$ubicacion."', tel_fijo='".$telFijo."',
     tel_movil='".$telMovil."',ctagmail='".$mail."', fecha_mod='".$fecha."', sexo='" . $sexo . "'";
	 
	 if ($cityChanged) $sql .= ", ciudad='" . $city . "'";
	 
	 $sql .= "WHERE id_paciente=".$id_paciente;
     $result = mysql_query($sql, $link)or die(imprimir_respuesta(false,mysql_error($link),"ErrorMysql"));
     
     $sql = "SELECT id_paciente FROM prax.paciente_contac where id_paciente =".$id_paciente ;
     $result =mysql_query($sql, $link)or die(imprimir_respuesta(false,mysql_error($link),"ErrorMysql"));
     if ($mail_cont != "" && !filter_var($mail_cont, FILTER_VALIDATE_EMAIL)) {
        imprimir_respuesta(false,"Esta dirección de correo ($mail_cont) no es válida.","ErrorCorreo");
    }
 
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
     
     if ($objResponse == ""){ $objResponse = new stdClass(); }
     $objResponse->{"updated"} = $fecha;
     
     mysql_close($link);
     imprimir_respuesta(true,"Guardado correctamente. Por confidencialidad con tu paciente evita registrar información sensible donde se identifiquen personas o hechos", "", $objResponse);
?>
