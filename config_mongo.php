<?php
	function getMongoApiKey(){
		$mongoApiKey = "hSMEv-JIwBocqxY_-q9CKCd0fHoQcgMi";
		return $mongoApiKey;
	}

	function getHistoriaClinica($idPaciente){
	    $query = urlencode('{"id_paciente":"' . $idPaciente . '"}');
		$url = "https://api.mongolab.com/api/1/databases/prax/collections/historia_clinica?apiKey=" . getMongoApiKey() . "&q=" . $query;
        $result = file_get_contents($url);
		$contenido = json_decode($result);
		return $contenido;
	}
    
    function getAnotaciones($documento_pacie){
        $query = urlencode('{"documento_pacie":"' . $documento_pacie . '"}');
        $url = "https://api.mongolab.com/api/1/databases/prax/collections/anotaciones?apiKey=" . getMongoApiKey() . "&q=" . $query;
        $result = file_get_contents($url);
        $contenido = json_decode($result);
        return $contenido;
    }
    
    function guardarHistoria($docPaciente,$motivo="",$evaluacionMedico="", $evaluacionFami="", $evaluacionPsico="", $evaluacionNeuro="", $diagnostico="", $tratamiento=""){
        $query = urlencode('{"id_paciente":"' . $docPaciente . '"}');
        $url = "https://api.mongolab.com/api/1/databases/prax/collections/historia_clinica?apiKey=" . getMongoApiKey() . "&q=" . $query;
        
        $update = new stdClass();
                
        $data = new stdClass();
        $data->{"motivo"}=$motivo;
        $data->{"evaluacionMedico"}=$evaluacionMedico;
        $data->{"evaluacionFami"}=$evaluacionFami;
        $data->{"evaluacionPsico"}=$evaluacionPsico;
        $data->{"evaluacionNeuro"}=$evaluacionNeuro;
        $data->{"diagnostico"}=$diagnostico;
        $data->{"tratamiento"}=$tratamiento;
        
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
    
    function crearHistoria($docPaciente){
        $url = "https://api.mongolab.com/api/1/databases/prax/collections/historia_clinica?apiKey=" . getMongoApiKey();
        $data= new stdClass();
        $data->{"id_paciente"}=$docPaciente;
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
    
    function guardarAnotaciones($documentoPaciente, $anotaciones, $fechaCreacion){
        $url = "https://api.mongolab.com/api/1/databases/prax/collections/anotaciones?apiKey=" . getMongoApiKey();
        $data= new stdClass();
        $data->{"documento_pacie"}=$documentoPaciente;
        $data->{"anotacion"}=$anotaciones;
        $data->{"fecha_creac"}=$fechaCreacion;
        $data->{"fecha_mod"}=$fechaCreacion;
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