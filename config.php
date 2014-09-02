<?php
use google\appengine\api\users\User;
use google\appengine\api\users\UserService;

$dbhost = ":/cloudsql/lively-shelter-687:praxassist"; // Servidor
$dbuser = "root"; // Usuario
$dbpass = ""; // Contraseña
$dbname = "prax"; // Tabla

// Creando conexion.
$link = mysql_connect($dbhost,$dbuser,$dbpass)or die(mysql_error());
		mysql_select_db($dbname,$link)or die(mysql_error());

?>

