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

    function getParameter($keyCode){
        if (empty($_POST[$keyCode])) return "";
        return $_POST[$keyCode];
    }
    
    function dominioEsGmail($dominio){
        $mxr = array();
        getmxrr($dominio, $mxr);
        $isGmail = false; 
        foreach ($mxr as $mxhost){
            if (stristr($mxhost,"google"))
                $isGmail = true;
        }
        return $isGmail;
    }
	
	function isReal($number){
		if (!preg_match('/[0-9]+/', $number)){
		    return false;
		}
		return true;
	}
	
	function isTextOnly($myString){
		if (preg_match('/[0-9]+/', $myString)){
		    return false;
		}
		return true;
	}
?>