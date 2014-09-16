<?php include('config.php'); ?>
<?php
use google\appengine\api\users\User;
use google\appengine\api\users\UserService;
# Looks for current Google account session

$user = UserService::getCurrentUser();
session_start();
$_SESSION["getUserId"] = $user->getUserId();
if ($user) {
  /*echo ' NickName, ' . htmlspecialchars($user->getNickname());
  echo ' - '.' Id, ' . htmlspecialchars($user->getUserId());
  echo ' - '.' Email'.htmlspecialchars($user->getEmail()); */
  header('Location: '.'/contarregistros?userId=' . $user->getUserId());/*Reemplazar contarregistro por la pagina de inicio*/
}
else {
  header('Location: ' . UserService::createLoginURL($_SERVER['REQUEST_URI']));
}
?>
<?php mysql_close($link); ?>
