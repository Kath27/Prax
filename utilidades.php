<?php

	function imprimir_respuesta($estado,$mensaje,$codigoerror="",$objResponse="{}"){
		$respuesta = new stdClass();
        $respuesta->{"estado"} = $estado;
        $respuesta->{"message"} = $mensaje;
        $respuesta->{"codigoerror"} =$codigoerror;
        $respuesta->{"objResponse"} =$objResponse;

        if (isset($link)) @mysql_close($link);
        exit(json_encode($respuesta));
	}


?>