<?php
    define("ENCRYPTION_KEY", "!@#$%^&*");

    function encrypt($pure_string, $encryption_key) {
        $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $encrypted_string = mcrypt_encrypt(MCRYPT_BLOWFISH, $encryption_key, utf8_encode($pure_string), MCRYPT_MODE_ECB, $iv);
        return $encrypted_string;
    }
    
    function decrypt($encrypted_string, $encryption_key) {
        $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $decrypted_string = mcrypt_decrypt(MCRYPT_BLOWFISH, $encryption_key, $encrypted_string, MCRYPT_MODE_ECB, $iv);
        return $decrypted_string;
    }
    
	function getMongoApiKey(){
		$mongoApiKey = "hSMEv-JIwBocqxY_-q9CKCd0fHoQcgMi";
		return $mongoApiKey;
	}

	function getHistoriaClinica($idPaciente, $idAdmin){
	    $query = urlencode('{"id_paciente":"' . $idPaciente . '","id_admin":"'.$idAdmin.'"}');
		$url = "https://api.mongolab.com/api/1/databases/prax/collections/historia_clinica?apiKey=" . getMongoApiKey() . "&q=" . $query;
        $result = file_get_contents($url);
		$contenido = json_decode($result);
        
        foreach ($contenido as $historia){
            if (trim($historia->{"motivo"}) != "") $historia->{"motivo"}=decrypt(urldecode($historia->{"motivo"}), ENCRYPTION_KEY);
            if (trim($historia->{"evaluacionMedico"}) != "") $historia->{"evaluacionMedico"}=decrypt(urldecode($historia->{"evaluacionMedico"}), ENCRYPTION_KEY);
            if (trim($historia->{"evaluacionFami"}) != "") $historia->{"evaluacionFami"}=decrypt(urldecode($historia->{"evaluacionFami"}), ENCRYPTION_KEY);
            if (trim($historia->{"evaluacionPsico"}) != "") $historia->{"evaluacionPsico"}=decrypt(urldecode($historia->{"evaluacionPsico"}), ENCRYPTION_KEY);
            if (trim($historia->{"evaluacionNeuro"}) != "") $historia->{"evaluacionNeuro"}=decrypt(urldecode($historia->{"evaluacionNeuro"}), ENCRYPTION_KEY);
            if (trim($historia->{"diagnostico"}) != "") $historia->{"diagnostico"}=decrypt(urldecode($historia->{"diagnostico"}), ENCRYPTION_KEY);
            if (trim($historia->{"tratamiento"}) != "") $historia->{"tratamiento"}=decrypt(urldecode($historia->{"tratamiento"}), ENCRYPTION_KEY);
        }

		return $contenido;
	}
    
    function getAnotaciones($documento_pacie, $idAdmin){
        $query = urlencode('{"documento_pacie":"' . $documento_pacie . '","id_admin":"'.$idAdmin.'"}');
        $url = "https://api.mongolab.com/api/1/databases/prax/collections/anotaciones?apiKey=" . getMongoApiKey() . "&q=" . $query;
        $result = file_get_contents($url);
        $contenido = json_decode($result);
        foreach ($contenido as $anotacion) {
            if (trim($anotacion->{"anotacion"}) != "") $anotacion->{"anotacion"}=decrypt(urldecode($anotacion->{"anotacion"}), ENCRYPTION_KEY);
        }
        
        return $contenido;
    }
    
    function guardarHistoria($docPaciente,$motivo="",$evaluacionMedico="", $evaluacionFami="", $evaluacionPsico="", $evaluacionNeuro="", $diagnostico="", $tratamiento="", $idAdmin){
        $query = urlencode('{"id_paciente":"' . $docPaciente . '","id_admin":"'.$idAdmin.'"}');
        $url = "https://api.mongolab.com/api/1/databases/prax/collections/historia_clinica?apiKey=" . getMongoApiKey() . "&q=" . $query;
        
        $update = new stdClass();
        
        if (!empty($motivo)) $motivo = urlencode(encrypt($motivo, ENCRYPTION_KEY));
        if (!empty($evaluacionMedico)) $evaluacionMedico = urlencode(encrypt($evaluacionMedico, ENCRYPTION_KEY));
        if (!empty($evaluacionFami)) $evaluacionFami = urlencode(encrypt($evaluacionFami, ENCRYPTION_KEY));
        if (!empty($evaluacionPsico)) $evaluacionPsico = urlencode(encrypt($evaluacionPsico, ENCRYPTION_KEY));
        if (!empty($evaluacionNeuro)) $evaluacionNeuro = urlencode(encrypt($evaluacionNeuro, ENCRYPTION_KEY));
        if (!empty($diagnostico)) $diagnostico = urlencode(encrypt($diagnostico, ENCRYPTION_KEY));
        if (!empty($tratamiento)) $tratamiento = urlencode(encrypt($tratamiento, ENCRYPTION_KEY));
        
        $data = new stdClass();
        $data->{"motivo"}=($motivo);
        $data->{"evaluacionMedico"}=($evaluacionMedico);
        $data->{"evaluacionFami"}=($evaluacionFami);
        $data->{"evaluacionPsico"}=($evaluacionPsico);
        $data->{"evaluacionNeuro"}=($evaluacionNeuro);
        $data->{"diagnostico"}=($diagnostico);
        $data->{"tratamiento"}=($tratamiento);
        
        $update->{"\$set"}=$data;
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/json\r\n",
                'method'  => 'PUT',
                'content' => json_encode($update),
            ),
        );
        
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        
        return json_decode($result);
    }
    
    function crearHistoria($docPaciente, $idAdmin){
        $url = "https://api.mongolab.com/api/1/databases/prax/collections/historia_clinica?apiKey=" . getMongoApiKey();
        $data= new stdClass();
        $data->{"id_paciente"}=$docPaciente;
        $data->{"id_admin"}=$idAdmin;
        $data->{"motivo"}="";
        $data->{"evaluacionMedico"}="";
        $data->{"evaluacionFami"}="";
        $data->{"evaluacionPsico"}="";
        $data->{"evaluacionNeuro"}="";
        $data->{"diagnostico"}="";
        $data->{"tratamiento"}="";
        $data->{"anotaciones"}="";
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/json\r\n",
                'method'  => 'POST',
                'content' => json_encode($data),
            ),
        );
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        
        return json_decode($result);
    } 
    
    function guardarAnotaciones($documentoPaciente, $anotaciones, $fechaCreacion, $idAdmin){
        $url = "https://api.mongolab.com/api/1/databases/prax/collections/anotaciones?apiKey=" . getMongoApiKey();
        
        if (!empty($anotaciones)) $anotaciones = urlencode(encrypt($anotaciones, ENCRYPTION_KEY));
        
        $data= new stdClass();
        $data->{"documento_pacie"}=$documentoPaciente;
        $data->{"anotacion"}=$anotaciones;
        $data->{"fecha_creac"}=$fechaCreacion;
        $data->{"fecha_mod"}=$fechaCreacion;
        $data->{"id_admin"}=$idAdmin;
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/json\r\n",
                'method'  => 'POST',
                'content' => json_encode($data),
            ),
        );
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        
        return json_decode($result);
    }
    
    function actualizarAnotacion($id_anotacion,$anotacion,$fecha){
        $query = urlencode('{"_id":{"\$oid":"' . $id_anotacion . '"}}');
        $url = "https://api.mongolab.com/api/1/databases/prax/collections/anotaciones?apiKey=" . getMongoApiKey() . "&q=" . $query;
        
        $anotacion = urlencode(encrypt($anotacion, ENCRYPTION_KEY));
        
        $update = new stdClass();
                
        $data = new stdClass();
        $data->{"anotacion"}=$anotacion;
        $data->{"fecha_mod"}=$fecha;
       
        
        $update->{"\$set"}=$data;
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/json\r\n",
                'method'  => 'PUT',
                'content' => json_encode($update),
            ),
        );
        
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        
        return json_decode($result);
    }
?>