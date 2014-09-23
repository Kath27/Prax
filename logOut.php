<?php
use google\appengine\api\users\User;
use google\appengine\api\users\UserService;

$user = UserService::getCurrentUser();
if ($user) {
    header('Location: ' . UserService::createLogoutURL($_SERVER['REQUEST_URI']));
}
else{
    header('Location: /');
}  
    
?>