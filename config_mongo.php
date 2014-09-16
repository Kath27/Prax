<?php
	function getMongoApiKey(){
		$mongoApiKey = "hSMEv-JIwBocqxY_-q9CKCd0fHoQcgMi";
		return $mongoApiKey;
	}

	function getHistoriaClinica(){
		$url = "https://api.mongolab.com/api/1/databases/prax/collections/historia_clinica?apiKey=" . getMongoApiKey();
		$contenido = json_decode(file_get_contents($url));
		return $contenido;
	}
?>