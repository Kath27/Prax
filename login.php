<?php
    session_start();
    
    require_once 'Google/Client.php';
    require_once 'Google/Service/Plus.php';
    
    $client_id = '137217388434-ebvon1u2v110tm8vg0m9rce45ugq1ph6.apps.googleusercontent.com';
    $client_secret = 'Ul76ZPiOzkf5aBJKCVMBzV0V';
    $redirect_uri = 'https://lively-shelter-687.appspot.com/';
    
    $client = new Google_Client();
    $client->setClientId($client_id);
    $client->setClientSecret($client_secret);
    $client->setRedirectUri($redirect_uri);
    $client->addScope("https://www.googleapis.com/auth/plus.login");
    $client->addScope("https://www.googleapis.com/auth/userinfo.email");
    
    if (isset($_GET['code'])) {
      $client->authenticate($_GET['code']);
      $_SESSION['access_token'] = $client->getAccessToken();
    }
    
    if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
      $client->setAccessToken($_SESSION['access_token']);
    } else {
      $authUrl = $client->createAuthUrl();
    }
    
    if(isset($authUrl)){
        header('Location: ' . $authUrl);    
    }else{
        $plus = new Google_Service_Plus($client);
        $me = $plus->people->get('me');
        $email = $me['emails'][0]['value'];
        
      include("config.php");
      $rol = "admin";
      $sql = "SELECT documento, nombre, apellido, ctagmail_usuario, id_admin, isActive FROM prax.admin_admin WHERE ctagmail_usuario='".$email."'";
      $result = mysql_query($sql,$link)or die(exit(mysql_error($link)));
      
      $userId =-1;
      if(mysql_num_rows($result)==0){
          $rol = "psico";
          $sql = "SELECT nombre, apellido, documento, sexo, fechnac, targProfe, ubicacion, ctagmail_usuario, id_adminpsic, isActive FROM prax.admin_psico WHERE ctagmail_usuario='".$email."'";
          $result = mysql_query($sql,$link)or die(exit(mysql_error($link)));
          if(mysql_num_rows($result)==0){
              $sql="INSERT INTO prax.admin_psico (nombre, apellido,ctagmail_usuario) values ('".$me['name']['givenName']."','".$me['name']['familyName']."','".$email."')";
              $result2 = mysql_query($sql,$link)or die(exit(mysql_error($link)));
              $rol = "psico2";
              if($result2){
                  $sql = "SELECT last_insert_id()";
                  $result3 = mysql_query($sql,$link)or die(exit(mysql_error($link)));
                  $userId = mysql_fetch_row($result3);
                  $userId = $userId[0];
                  
                  include("mailToAdminPsico.php");
                  mailToPsico($email);
              }
          }
      }
  
  mysql_close($link);
  
  if($rol=="admin"){
    $admin = mysql_fetch_row($result);  
    if($admin[5]=="F"){
        header('Location: '.'/userInactivo');
        exit;
    }
    
    $_SESSION["googleUserId"] = $me['id'];  
    $_SESSION["documento"] = $admin[0];
    $_SESSION["nombre"] = $admin[1];
    $_SESSION["apellido"] = $admin[2];
    $_SESSION["ctagmail_usuario"] = $admin[3];
    $_SESSION["userId"] = $admin[4];
    $_SESSION["rol"] = "admin";
    $_SESSION["img"]=$me['image']['url'];
    header('Location: '.'/list-user');
  }
  else if($rol == "psico"){
    $psico = mysql_fetch_row($result);
    if($psico[9]=="F"){
        header('Location: '.'/userInactivo');
        exit;
    }
    
    $_SESSION["googleUserId"] = $me['id'];
    $_SESSION["nombre"] = $psico[0];
    $_SESSION["apellido"] = $psico[1];
    $_SESSION["documento"] = $psico[2];
    $_SESSION["sexo"] = $psico[3];
    $_SESSION["fechnac"] = $psico[4];
    $_SESSION["targProfe"] = $psico[5];
    $_SESSION["ubicacion"] = $psico[6];
    $_SESSION["ctagmail_usuario"] = $psico[7];
    $_SESSION["userId"] = $psico[8];
    $_SESSION["img"]=$me['image']['url'];
    $_SESSION["rol"] = "psico";    
    header('Location: '.'/list-paci');/*list-paci-> este se pone cuando ese listo el software*/
  }
else  if($rol == "psico2"){
    
    $_SESSION["googleUserId"] = $me['id'];
    $_SESSION["nombre"] = $me['name']['givenName'];
    $_SESSION["apellido"] = $me['name']['familyName'];
    $_SESSION["documento"] = "";
    $_SESSION["sexo"] = "";
    $_SESSION["fechnac"] = "";
    $_SESSION["targProfe"] = "";
    $_SESSION["ubicacion"] = "";
    $_SESSION["ctagmail_usuario"] = $email;
    $_SESSION["userId"] = $userId;
    $_SESSION["img"]=$me['image']['url'];
    $_SESSION["rol"] = "psico";    
    header('Location: '.'/edicionPsico');
}
        
    }
    
?>