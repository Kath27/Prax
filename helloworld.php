<?php
use google\appengine\api\users\User;
use google\appengine\api\users\UserService;
# Looks for current Google account session
$user = UserService::getCurrentUser();
if ($user) {
  echo ' NickName, ' . htmlspecialchars($user->getNickname());
  echo ' - '.' Id, ' . htmlspecialchars($user->getUserId());
  echo ' - '.' Email'.htmlspecialchars($user->getEmail()); 
}
else {
  header('Location: ' . UserService::createLoginURL($_SERVER['REQUEST_URI']));
}
?>