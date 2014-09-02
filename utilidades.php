<?php

	function imprimir_respuesta($estado,$mensaje,$codigoerror){
		$respuesta = new stdClass();
        $respuesta->{"estado"} = $estado;
        $respuesta->{"message"} = $mensaje;
        $respuesta->{"codigoerror"} =$codigoerror;

        exit(json_encode($respuesta));
	}


?>