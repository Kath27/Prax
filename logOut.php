<?php
    session_start();
    
    unset($_SESSION["googleUserId"]);
    unset($_SESSION["nombre"]);
    unset($_SESSION["apellido"]);
    unset($_SESSION["documento"]);
    unset($_SESSION["sexo"]);
    unset($_SESSION["fechnac"]);
    unset($_SESSION["targProfe"]);
    unset($_SESSION["ubicacion"]);
    unset($_SESSION["ctagmail_usuario"]);
    unset($_SESSION["userId"]);
    unset($_SESSION["rol"]);
    unset($_SESSION["isActive"]);
    unset($_SESSION['access_token']);    
    session_destroy();
    
    header('Location: https://www.google.com/accounts/Logout?continue=https://appengine.google.com/_ah/logout?continue=https://lively-shelter-687.appspot.com');  
?>