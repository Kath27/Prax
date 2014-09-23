<?php
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
        <script type="text/javascript">
            function registroAdmin(){
                var nombre = encodeURI(document.getElementById("nombre").value);
                var apellido = encodeURI(document.getElementById("apellido").value);
                var doc = encodeURI(document.getElementById("documento").value);
                var ctagmail_usuario = encodeURI(document.getElementById("ctagmail_usuario").value);
                var http = new XMLHttpRequest();
                    http.open("POST", "agregarAdminAdmin", true);
                    http.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                    http.send("nombre=" + nombre +
                                "&apellido=" + apellido + 
                                "&documento=" + doc +                                
                                "&ctagmail_usuario=" + ctagmail_usuario
                                );               
                http.onreadystatechange = function(){
                if (http.readyState == 4 && http.status == 200) {
                    var respuesta = JSON.parse(http.responseText);
                    if (respuesta.estado){
                        showNotification({
                            message: respuesta.message,
                                type: "success"
                        });
                        limpiarform();
                    }else{
                        if(respuesta.codigoerror=="ErrorCorreo")
                            $('#ctagmail_usuario').parent().addClass('error_2');
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
            };
            }
            function limpiarform(){
                document.getElementById("nombre").value = "";
                document.getElementById("apellido").value = "";
                document.getElementById("documento").value = "";
                document.getElementById("ctagmail_usuario").value = "";
            }
            function verificarform(){
                var nombre = encodeURI(document.getElementById("nombre").value);
                var apellido = encodeURI(document.getElementById("apellido").value);
                var doc = encodeURI(document.getElementById("documento").value);
                var ctagmail_usuario = encodeURI(document.getElementById("ctagmail_usuario").value);
                return (nombre != "" && apellido != "" && doc !="" && ctagmail_usuario != "");

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
            <article>
                <div class="row">
                    <div class="panel">
                        <div class="header_user">
                            <div class="summary_user">
                                <h2>Tu pre inscripción ha sido realizada con éxito, cuando sea activado el sistema te enviaremos un correo electrónico.</h2> 
                                    <h2> Fecha prevista de activación: Septiembre de 2014.</h2>                                
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
