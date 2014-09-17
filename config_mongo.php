<?php
	function getMongoApiKey(){
		$mongoApiKey = "hSMEv-JIwBocqxY_-q9CKCd0fHoQcgMi";
		return $mongoApiKey;
	}

	function getHistoriaClinica($idPaciente){
	    $query = urlencode('{"id_paciente" : ' . $idPaciente . '}');
		$url = "https://api.mongolab.com/api/1/databases/prax/collections/historia_clinica?apiKey=" . getMongoApiKey() . "&q=" . $query;
		$contenido = json_decode(file_get_contents($url));
		return $contenido;
	}
    function guardarHistoria($idPaciente,$motivo="",$evaluacionMedico="", $evaluacionFami="", $evaluacionPsico="", $evaluacionNeuro="", $diagnostico="", $tratamiento="", $anotaciones=""){
        $query = urlencode('{"id_paciente" : ' . $idPaciente . '}');
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
        $data->{"anotaciones"}=$anotaciones;
        
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