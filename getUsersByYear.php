<?php
	include ("config.php");
	include ("utilidades.php");
	include("mailToAdminPsico.php");
	session_start();
	
	if (!empty($_POST["year"])){
		$year = (real)$_POST["year"];
		$year1 = $year . "-01-01 00:00:00";
		$year2 = ($year + 1) . "-01-01 00:00:00";
		
		$sql = "SELECT id_adminpsic, fechregistro FROM admin_psico WHERE fechregistro>='" . $year1 . "' AND fechregistro<'" . $year2 . "'";
		$result = mysql_query($sql, $link);
		
		$ret = array(0,0,0,0,0,0,0,0,0,0,0,0);
		while ($list = mysql_fetch_array($result)){
			$d = new DateTime($list[1]);
			$mes = ((real)$d->format("m")) - 1;
			
			$ret[$mes] += 1;
		}
		
		mysql_close($link);
		imprimir_respuesta(true,"Tu pre inscripción ha sido realizada con éxito, cuando sea activado el sistema te enviaremos un correo electrónico." . "\n" ." Fecha prevista de activación: Septiembre de 2014.", "", $ret);
	}

	mysql_close($link);
?>