<?php
use google\appengine\api\users\User;
use google\appengine\api\users\UserService;
# Looks for current Google account session

$user = UserService::getCurrentUser();

if ($user) {
  /*echo ' NickName, ' . htmlspecialchars($user->getNickname());
  echo ' - '.' Id, ' . htmlspecialchars($user->getUserId());
  echo ' - '.' Email'.htmlspecialchars($user->getEmail()); */
  /*session_start();
  $_SESSION["getUserId"] = $user->getUserId();
  header('Location: '.'/index');/*Reemplazar contarregistro por la pagina de inicio*/
  $email = $user->getEmail();
  include("config.php");
  $rol = "admin";
  $sql = "SELECT documento, nombre, apellido, ctagmail_usuario, id_admin FROM prax.admin_admin WHERE ctagmail_usuario='".$email."'";
  $result = mysql_query($sql,$link)or die(exit(mysql_error($link)));
  
  if(mysql_num_rows($result)==0){
      $rol = "psico";
      $sql = "SELECT nombre, apellido, documento, sexo, fechnac, targProfe, ubicacion, ctagmail_usuario, id_adminpsic FROM prax.admin_psico WHERE ctagmail_usuario='".$email."'";
      $result = mysql_query($sql,$link)or die(exit(mysql_error($link)));
      if(mysql_num_rows($result)==0){
          $rol="";
          header('Location: ' . UserService::createLogoutURL($_SERVER['REQUEST_URI']));
      }
  }
  
  mysql_close($link);
  
  if($rol=="admin"){
    $admin = mysql_fetch_row($result);  
    session_start(); 
    $_SESSION["googleUserId"] = $user->getUserId();  
    $_SESSION["documento"] = $admin[0];
    $_SESSION["nombre"] = $admin[1];
    $_SESSION["apellido"] = $admin[2];
    $_SESSION["ctagmail_usuario"] = $admin[3];
    $_SESSION["userId"] = $admin[4];
    $_SESSION["rol"] = "admin";
    header('Location: '.'/list-user');
  }
  else if($rol == "psico"){
    $psico = mysql_fetch_row($result);
    session_start();    
    $_SESSION["googleUserId"] = $user->getUserId();
    $_SESSION["nombre"] = $psico[0];
    $_SESSION["apellido"] = $psico[1];
    $_SESSION["documento"] = $psico[2];
    $_SESSION["sexo"] = $psico[3];
    $_SESSION["fechnac"] = $psico[4];
    $_SESSION["targProfe"] = $psico[5];
    $_SESSION["ubicacion"] = $psico[6];
    $_SESSION["ctagmail_usuario"] = $psico[7];
    $_SESSION["userId"] = $psico[8];
    $_SESSION["rol"] = "psico";    
    header('Location: '.'/list-paci');
  }
}
else {
  header('Location: ' . UserService::createLoginURL($_SERVER['REQUEST_URI']));
}
?>



