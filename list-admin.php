<?php include('config.php');
session_start();
if (!isset($_SESSION["userId"]) || $_SESSION["rol"] != "admin"){ header('Location: /'); }
?>
<?php
    $sql = "SELECT nombre, apellido, documento, ctagmail_usuario, isActive FROM prax.admin_admin";
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
            function activarAdmin(event, documento, psicoElement){
                var activar = ($(psicoElement).hasClass("off"))? "T" : "F";
                var http = new XMLHttpRequest();
                    http.open("POST", "activarAdmin", true);
                    http.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                    http.send("documento=" + documento +
                                "&activar=" + activar
                                );               
                http.onreadystatechange = function(){
                    if (http.readyState == 4 && http.status == 200) {
                        var respuesta = JSON.parse(http.responseText);
                        if (respuesta.estado){
                            showNotification({
                                message: respuesta.message,
                                    type: "success"
                            });
                            
                            if (activar == "T"){
                                $(psicoElement).removeClass("off");
                                $(psicoElement).addClass("on");
                                $(psicoElement)[0].title = "Activar";
                            }else{
                                $(psicoElement).removeClass("on");
                                $(psicoElement).addClass("off");
                                $(psicoElement)[0].title = "Desactivar";
                            }
                        }else{
                            showNotification({
                                message: respuesta.message,
                                    type: "error"
                            });
                        }
                    }else if (http.readyState == 4){
                        showNotification({
                            message: "Ocurrio un error",
                                    type: "error"
                        });
                    }
                }
                
                event.stopPropagation();
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
                <?php include("perfilHeader.php");?>
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
                    <?php include('perfilAside.php');?>
                </div>
                <nav>
                    <?php include("menu.php"); ?>
                </nav>
            </aside>
            <article>
                <div class="row">
                    <div class="panel" id="cosa">
                        <h2 class="title_panel">Lista de Administradores</h2>
                        <div class="cont_search_user">
                            <input class="search" id="search" type="search" placeholder="Escriba un criterio de búsqueda"></input>
                            <button class="icon-search3" data-sort="name" ></button>
                        </div>
                        <?php if(mysql_num_rows($result)<=0) { ?>
                        <a href="AdminPsico" class="add_user">
                            <div class="cont_avatar">
                                <div class="avatar">
                                    <img src="img/avatar-def.jpg">
                                </div>
                            </div>
                            <div class="cont_user_list">
                                <h2>Agregar Nuevo Administrador</h2>
                            </div>
                        </a>
                        <?php } ?>
                        <ul id="list_users">
                            <?php while ($psico = mysql_fetch_array($result)) { ?>
                                    <li class="aBloqueUsuario">
                                        <div class="cont_avatar">
                                            <div class="avatar">
                                                <?php if ($psico[4] == "T"){?>
                                                    <span style="cursor: pointer" class="status_user_list on" title="Desactivar" onclick="activarAdmin(event, '<?php echo $psico[2] ?>', this);"></span>
                                                <?php }
                                                else{?>
                                                    <span style="cursor: pointer" class="status_user_list off" title="Activar" onclick="activarAdmin(event, '<?php echo $psico[2] ?>', this);"></span>
                                                <?php }?>
                                                <img src="img/avatar-def.jpg">
                                            </div>
                                        </div>
                                        <div class="cont_user_list">
                                            <input type="hidden" id="hidcriteriosbusqueda" value="<?php echo $psico[0] ." ". $psico[1] .";". $psico[2] .";". $psico[3];?>"/>
                                            <h2 class="name"><?php echo $psico[0] ." ". $psico[1];?></h2>
                                            <div class="description_list_user"><?php echo $psico[3];?></div>
                                        </div>
                                    </li>
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