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
    
    function getmxrr($hostname, &$mxhosts){
        $mxhosts = array();
        exec('%SYSTEMDIRECTORY%\\nslookup.exe -q=mx '.escapeshellarg($hostname), $result_arr);
        foreach($result_arr as $line)
        {
          if (preg_match("/.*mail exchanger = (.*)/", $line, $matches))
              $mxhosts[] = $matches[1];
        }
        return( count($mxhosts) > 0 );
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
?>