<?php
use google\appengine\api\users\User;
use google\appengine\api\users\UserService;

$user = UserService::getCurrentUser();
if ($user) {
    header('Location: ' . UserService::createLogoutURL($_SERVER['REQUEST_URI']));
}
else{
    session_start();
    $_SESSION["googleUserId"] = "";
    $_SESSION["nombre"] = "";
    $_SESSION["apellido"] = "";
    $_SESSION["documento"] = "";
    $_SESSION["sexo"] = "";
    $_SESSION["fechnac"] = "";
    $_SESSION["targProfe"] = "";
    $_SESSION["ubicacion"] = "";
    $_SESSION["ctagmail_usuario"] = "";
    $_SESSION["userId"] = "";
    $_SESSION["rol"] = "";    
    session_destroy();
    header('Location: /');
}  
    
?>