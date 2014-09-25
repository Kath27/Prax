<?php
use google\appengine\api\users\User;
use google\appengine\api\users\UserService;

$user = UserService::getCurrentUser();
if ($user) {
    header('Location: ' . UserService::createLogoutURL($_SERVER['REQUEST_URI']));
}

include('config.php');
session_start();

 ?>
<!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/main.css">
        <link href="css/jquery_notification.css" type="text/css" rel="stylesheet"/>
    </head>
    <body>
        <section>
            <article>
                <div class="row">
                    <div class="panel">
                        <div class="header_user">
                            <div class="summary_user">
                                <h2>El usuario con el que ha intentado acceder se encuentra inactivo.</h2>                                
                            </div>
                        </div>
                        
                    </div>
                </div>            
            </article>
        </section>
        <footer>Prax S.A.S 2014 - <span class="ano_current"></span>. Todos los derechos reservados. Medellín - Colombia.</footer>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script src="http://maps.googleapis.com/maps/api/js?libraries=places"></script>
        <script>window.jQuery || document.write('<script src="js/jquery-1.10.2.min.js"><\/script>')</script>
        <script src="js/jquery-ui.js"></script>
        <script src="js/plugins.js"></script>
        <script src="js/main.js"></script>
        <script src="js/jquery.filter_input.js"></script>
        <script type="text/javascript" src="jquery/jquery_notification_v.1.js"></script>
        
    </body>
</html>
