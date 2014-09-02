<?php

	function imprimir_respuesta($estado,$mensaje){
		$respuesta = new stdClass();
        $respuesta->{"estado"} = $estado;
        $respuesta->{"message"} = $mensaje;

        exit(json_encode($respuesta));
	}


?>