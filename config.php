<?php
use google\appengine\api\users\User;
use google\appengine\api\users\UserService;

$dbhost = ":/cloudsql/lively-shelter-687:praxassist"; // Servidor
$dbuser = "root"; // Usuario
$dbpass = ""; // Contraseña
$dbname = "prax"; // Tabla

// Creando conexion.
$link = mysql_connect($dbhost,$dbuser,$dbpass)or die(mysql_error($link));
		mysql_select_db($dbname,$link)or die(mysql_error($link));
/*use google\appengine\api\users\User;
use google\appengine\api\users\UserService;

	$dbhost = "localhost"; // Servidor
	$dbuser = "root"; // Usuario
	$dbpass = ""; // Contraseña
	$dbname = "prax"; // Tabla

	if (isset($_SERVER['SERVER_SOFTWARE']) &&
	  strpos($_SERVER['SERVER_SOFTWARE'],'Google App Engine') !== false) {
		$dbhost = ":/cloudsql/lively-shelter-687:praxassist"; // Servidor
		$dbuser = "root"; // Usuario
		$dbpass = ""; // Contraseña
		$dbname = "prax"; // Tabla
	}
		
// Creando conexion.
	$link = mysqli_connect($dbhost,$dbuser,$dbpass)or die(mysqli_error($link));
		mysqli_select_db($link, $dbname)or die(mysqli_error($link));*/

?>