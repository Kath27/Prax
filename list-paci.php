<?php include('config.php'); ?>
<?php
    session_start();
    $sql = "SELECT documento, nombre, apellido, fechnac, ubicacion, tel_fijo, tel_movil, ctagmail, sexo FROM prax.paciente";
    if($_SESSION["rol"]="psico"){
        $sql.=" WHERE id_adminpsic='".$_SESSION["userId"]."'";
    }
    $result = mysql_query($sql,$link)or die(exit(mysql_error($link)));       
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
        <link rel="stylesheet" href="css/font.css">
        <link href="css/jquery_notification.css" type="text/css" rel="stylesheet"/>
        <script type="text/javascript" charset="utf-8">
            function filtrarUsuarios(busqueda){
                $(".aBloqueUsuario").each(function(){
                   var usuario = $(this);
                   var criterio = usuario.find("#hidcriteriosbusqueda").val();
                   if(criterio.toLowerCase().indexOf(busqueda)== -1){
                       usuario.hide();
                   }
                   else{
                       usuario.show();
                   }                                       
                });
            }
        </script>
    </head>
    <body>
          <header>
            <div id="logo">
                <img src="img/logo.png" title="Prax" alt="Prax">
                <span>Assist</span>
            </div>
            <button type="button" id="open_close_aside" class="icon-grid"></button>
            <div id="profile_welcom_header">
                <div class="cont_avatar">
                    <div class="avatar">
                        <img src="img/avatar-def.jpg">
                    </div>
                </div>
            </div>
            <div class="tootip_header">
                <div id="profile_welcom_header_tootip">
                    <div class="cont_avatar">
                        <div class="avatar">
                            <img src="img/avatar-def.jpg">
                        </div>
                    </div>
                    <div class="cont_welcom">
                        <h3>Nombre Usuario</h3>
                        <p>usuario@usuario.com</p>
                    </div> 
                </div>
                <button type="button" id="logut">Salir de la Plataforma</button>
            </div>
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
                        <p>Administrador Psicólogo</p>
                    </div>
                </div>
                <nav>
                    <?php include("menu.php"); ?>
                </nav>
            </aside>
            <article>
                <div class="row">
                    <div class="panel" id="cosa">
                        <h2 class="title_panel">Lista de Pacientes</h2>
                        <div class="cont_search_user">
                            <input class="search" id="search" type="search" placeholder="Escriba un criterio de búsqueda"></input>
                            <button class="icon-search3" data-sort="name" ></button>
                        </div>
                        <a href="indexPaciente" class="add_user">
                            <div class="cont_avatar">
                                <div class="avatar">
                                    <img src="img/avatar-def.jpg">
                                </div>
                            </div>
                            <div class="cont_user_list">
                                <h2>Agregar Nuevo Paciente</h2>
                                <div class="description_list_user">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras sagittis massa vel est scelerisque, id cursus ligula elementum. Vivamus in justo ex.</div>
                            </div>
                        </a>
                        <ul id="list_users">
                            <?php while ($psico = mysql_fetch_array($result)) { ?>
                                <a class="aBloqueUsuario" href="historiaClinica?paciente=<?php echo $psico[0]; ?>">
                                    <li>
                                        <div class="cont_avatar">
                                            <div class="avatar">
                                                <span class="status_user_list on"></span>
                                                <img src="img/avatar-def.jpg">
                                            </div>
                                        </div>
                                        <div class="cont_user_list">
                                            <input type="hidden" id="hidcriteriosbusqueda" value="<?php echo $psico[0] ." ". $psico[1] .";". $psico[2] .";". $psico[7];?>"/>
                                            <h2 class="name"><?php echo $psico[1] ." ". $psico[2];?></h2>
                                            <div class="description_list_user"><?php echo $psico[7];?></div>
                                        </div>
                                    </li>
                                </a>
                            <?php } ?>
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
        <script type="text/javascript" src="jquery/jquery_notification_v.1.js"></script>
        <script src="js/main.js"></script>
        <script type="text/javascript" charset="utf-8">
            $("#search").keydown(function (){
                var texto = $(this);
                setTimeout(function(){
                    filtrarUsuarios(texto.val().toLowerCase());
                }, 50);
            });
        </script>
        <?php mysql_close($link); ?>
    </body>
</html>
