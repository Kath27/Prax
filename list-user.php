<?php //include('config.php'); ?>
<!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/font.css">
        <link href="css/jquery_notification.css" type="text/css" rel="stylesheet"/>
    </head>
    <body>
        <header>
            <div id="logo">
                <img src="img/logo.png" title="Prax" alt="Prax">
                <span>Assist</span>
            </div>
            <button type="button" id="open_close_aside" class="icon-grid"></button>
        </header>
        <section>
            <aside>
                <div id="profile_welcom">
                    <div class="cont_avatar">
                        <div class="avatar">
                            <img src="img/avatar-def.jpg">
                        </div>
                    </div>
                    <div class="cont_welcom">
                        <h3>Bienvenido</h3>
                        <p>Administrador Admin</p>
                    </div>
                </div>
                <nav>
                    <ul>
                        <a href="#"><li class="active">Lorem ipsum </li></a>
                        <a href="#"><li>Lorem ipsum </li></a>
                        <a href="#"><li>Lorem ipsum </li></a>
                        <a href="#"><li>Lorem ipsum </li></a>
                        <a href="#"><li>Lorem ipsum </li></a>
                        <a href="#"><li>Lorem ipsum </li></a>
                    </ul>
                </nav>
            </aside>
            <article>
                <div class="row">
                    <div class="panel" id="cosa">
                        <h2 class="title_panel">Lista de Usuarios</h2>
                        <div class="cont_search_user">
                            <input class="search" type="search" placeholder="Escriba un criterio de búsqueda"></input>
                            <button class="icon-search3" data-sort="name" ></button>
                        </div>
                        <a href="#" class="add_user">
                            <div class="cont_avatar">
                                <div class="avatar">
                                    <img src="img/avatar-def.jpg">
                                </div>
                            </div>
                            <div class="cont_user_list">
                                <h2>Agregar Nuevo Usuario</h2>
                                <div class="description_list_user">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras sagittis massa vel est scelerisque, id cursus ligula elementum. Vivamus in justo ex.</div>
                            </div>
                        </a>
                        <ul id="list_users">
                            <a href="#">
                                <li>
                                    <div class="cont_avatar">
                                        <div class="avatar">
                                            <span class="status_user_list on"></span>
                                            <img src="img/avatar-def.jpg">
                                        </div>
                                    </div>
                                    <div class="cont_user_list">
                                        <h2 class="name">Fabián Zapata Henao</h2>
                                        <div class="description_list_user">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras sagittis massa vel est scelerisque, id cursus ligula elementum. Vivamus in justo ex.</div>
                                    </div>
                                </li>
                            </a>
                            <a href="#">
                                <li>
                                    <div class="cont_avatar">
                                        <div class="avatar">
                                            <span class="status_user_list off"></span>
                                            <img src="img/avatar-def.jpg">
                                        </div>
                                    </div>
                                    <div class="cont_user_list">
                                        <h2 class="name">Pedrito Perez Gonzales</h2>
                                        <div class="description_list_user">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras sagittis massa vel est scelerisque, id cursus ligula elementum. Vivamus in justo ex.</div>
                                    </div>
                                </li>
                            </a>
                            <a href="#">
                                <li>
                                    <div class="cont_avatar">
                                        <div class="avatar">
                                            <span class="status_user_list off"></span>
                                            <img src="img/avatar-def.jpg">
                                        </div>
                                    </div>
                                    <div class="cont_user_list">
                                        <h2 class="name">Persona con Algun Nombre</h2>
                                        <div class="description_list_user">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras sagittis massa vel est scelerisque, id cursus ligula elementum. Vivamus in justo ex.</div>
                                    </div>
                                </li>
                            </a>
                        </ul>
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
        <script src="js/jquery.filter_input.js"></script>
        <script src="js/list.js"></script>
        <script type="text/javascript" src="jquery/jquery_notification_v.1.js"></script>
        <script src="js/main.js"></script>
        <?php //mysql_close($link); ?>
    </body>
</html>
