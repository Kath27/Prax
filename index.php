<?php
include('config.php');
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
        <script type="text/javascript">
            function registroAdmin(){
                var nombre = encodeURI(document.getElementById("nombre").value);
                var apellido = encodeURI(document.getElementById("apellido").value);
                var doc = encodeURI(document.getElementById("documento").value);
                var sexo = encodeURI(document.getElementById("sexo").value);
                var fechanac = encodeURI(document.getElementById("fechnac").value);
                var tarjeProf = encodeURI(document.getElementById("targProfe").value);
                var ubicac = encodeURI(document.getElementById("searchTextField").value);
                var ctagmail_usuario = encodeURI(document.getElementById("ctagmail_usuario").value);
                var http = new XMLHttpRequest();
                    http.open("POST", "agregarAdmin", true);
                    http.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                    http.send("nombre=" + nombre +
                                "&apellido=" + apellido + 
                                "&documento=" + doc + 
                                "&sexo=" + sexo + 
                                "&fechnac=" + fechanac + 
                                "&targProfe=" + tarjeProf + 
                                "&ubicacion=" + ubicac + 
                                "&ctagmail_usuario=" + ctagmail_usuario
                                );
               
                http.onreadystatechange = function(){
                if (http.readyState == 4 && http.status == 200) {
                    var respuesta = JSON.parse(http.responseText);
                    if (respuesta.estado){
                    alert(respuesta.message);
                    limpiarform();
                    }else{
                    alert(respuesta.message);
                    }
                }else if (http.readyState == 4){
                    alert("Ocurrio un error");
                }
            };
            }
            function limpiarform(){
                document.getElementById("nombre").value = "";
                document.getElementById("apellido").value = "";
                document.getElementById("documento").value = "";
                document.getElementById("sexo").value = "";
                document.getElementById("fechnac").value = "";
                document.getElementById("targProfe").value = "";
                document.getElementById("searchTextField").value = "";
                document.getElementById("ctagmail_usuario").value = "";
            }

        </script>
    </head>
    <body>
        <header>
            <div id="logo">
                <img src="img/logo.png" title="Prax" alt="Prax">
                <span>Assist</span>
            </div>
            <button type="button" id="open_close_aside"></button>
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
                    <div class="panel">
                        <div class="header_user">
                            <!--<div class="cont_avatar">
                                <div class="avatar">
                                    <div class="icon_upload"></div>
                                    <img id="open_upload_avatar" src="img/avatar-def.jpg">
                                    <input type="file" id="upload_avatar" />
                                </div>
                            </div>
                            <div class="summary_user">
                                <h2>Nombres y apellidos</h2>
                                <p class="email_sumary">info@informacion.com</p>
                                <a href="#" id="on_off_user"><span class="on"></span> Usuario Activo</a>
                            </div>-->
                        </div>
                        <div id="tabs"> 
                            <ul>
                                <li><a href="#tabs-1">Datos Generales</a></li>
                                <!--<li><a href="#tabs-2">Motivo de consulta</a></li>
                                <li><a href="#tabs-3">Evaluación</a></li>
                                <li><a href="#tabs-4">Diagnóstico</a></li>
                                <li><a href="#tabs-5">Tratamiento</a></li>
                                <li><a href="#tabs-6">Anotaciones</a></li>-->
                            </ul>
                            <form action="agregarAdmin.php" method="post" name="form">
                                <div id="tabs-1">
                                    <p>
                                        <label>Nombre</label>
                                        <input type="text" id="nombre" placeholder="Escribe tu nombre completo"></input>
                                        <label class="help">Este campo es requerido</label>
                                    </p>
                                    <p>
                                        <label>Apellidos</label>
                                        <input type="text" id="apellido" placeholder="Escribe tus apellidos"></input>
                                        <label class="help">Este campo es requerido</label>
                                    </p>
                                    <p>
                                        <label>Documento de identidad</label>
                                        <input type="text" id="documento" placeholder="Escribe tu documento de identidad nacional (DNI)"></input>
                                        <label class="help">Este campo es requerido</label>
                                    </p>
                                    <p>
                                        <label>Sexo</label>
                                        <select id="sexo">
                                            <option>Seleccione su sexo</option>
                                            <option value='M'>Hombre</option>
                                            <option value='F'>Mujer</option>
                                        </select>
                                        <label class="help">Este campo es requerido</label>
                                    </p>
                                    <p>
                                        <label>Fecha de nacimiento</label>
                                        <input type="text" id="fechnac" placeholder="Escribe su fecha de nacimiento  (aaaa/mm/dd)"></input>
                                        <label class="help">Este campo es requerido</label>

                                    </p>
                                    <p>
                                        <label>Tarjeta profesional</label>
                                        <input type="text" id="targProfe" placeholder="Registra tarjeta profesional como psicólogo"></input>
                                        <label class="help">Este campo es requerido</label>
                                    </p>
                                    <p>
                                        <label>Ubicación</label>
                                        <input type="text" id="searchTextField" placeholder="Escribe la dirección del lugar donde vives o trabajas"></input>
                                        <label class="help">Este campo es requerido</label>  
                                    </p>
                                    <p>
                                        <label>Cuenta de gmail</label>
                                        <input type="email" id="ctagmail_usuario" placeholder="Escribe tu cuenta de gmail"></input>
                                        <label class="help">Este campo es requerido</label>
                                    </p>
                                    <p>
                                        <input id="validate_form" type="button" value="Guardar" ></input> 
                                    </p>
                                </div>
                                <!--<div id="tabs-2">
                                    <textarea></textarea>
                                </div>
                                <div id="tabs-3">
                                    <textarea></textarea>
                                </div>
                                <div id="tabs-4">
                                    <textarea></textarea>
                                </div>
                                <div id="tabs-5">
                                    <textarea></textarea>
                                </div>
                                <div id="tabs-6">
                                    <textarea></textarea>
                                </div>-->
                            </form>
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
        <script>
            (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
            function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
            e=o.createElement(i);r=o.getElementsByTagName(i)[0];
            e.src='//www.google-analytics.com/analytics.js';
            r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
            ga('create','UA-6685323-21');ga('send','pageview');
        </script>

        <script type="text/javascript">

        $(document).on('ready',function(){ 
            $('#validate_form').on('click',validateForm);
        });


                function validateForm() {
                    var email_validate = $.trim($('#ctagmail_usuario').val());
                    var nombre = $.trim($('#nombre').val());
                    var apellido = $.trim($('#apellido').val());
                    var doc = $.trim($('#documento').val());
                    var sexo = $.trim($('#sexo').val());
                    var fechanac = $.trim($('#fechnac').val());
                    var tarjeProf = $.trim($('#targProfe').val());
                    var ubicac = $.trim($('#searchTextField').val());
                    validate_required = true;

                    if(email_validate==''){
                        $('#ctagmail_usuario').parent().addClass('error');
                        validate_required = false;
                    }else{
                        validate_required = false;
                        if(validateEmailGmail(email_validate)){
                           $('#ctagmail_usuario').parent().removeClass('error');
                           validate_required = true;
                        } 
                    }

                    if(nombre==''){
                        $('#nombre').parent().addClass('error');
                        validate_required = false;
                    }else{
                        
                        $('#nombre').parent().removeClass('error');
                    }

                    if(apellido==''){
                        $('#apellido').parent().addClass('error');
                        validate_required = false;
                    }else{
                        $('#apellido').parent().removeClass('error');
                    }

                    if(doc==''){
                        $('#documento').parent().addClass('error');
                        validate_required = false;
                    }else{
                        $('#documento').parent().removeClass('error');
                    }

                    if(sexo==''){
                        $('#sexo').parent().addClass('error');
                        validate_required = false;
                    }else{
                        $('#sexo').parent().removeClass('error');
                    }

                    if(fechanac==''){
                        $('#fechnac').parent().addClass('error');
                        validate_required = false;
                    }else{
                        $('#fechnac').parent().removeClass('error');
                    }

                    if(tarjeProf==''){
                        $('#targProfe').parent().addClass('error');
                        validate_required = false;
                    }else{
                        $('#targProfe').parent().removeClass('error');
                    }

                    if(ubicac==''){
                        $('#searchTextField').parent().addClass('error');
                        validate_required = false;
                    }else{
                        $('#searchTextField').parent().removeClass('error');
                    }

                    if(!validate_required){
                        return false;
                    }

                    registroAdmin();                 
                   
                }


                function validateEmailGmail(email_validate){
                    if (/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/.test(email_validate)){

                        var arrobaa =  email_validate.split('@');
                        var type_email =  arrobaa[1].split('.');
                        if(type_email[0].toLowerCase()=='gmail'){
                           console.log('El correo tiene un formato correcto y es gmail');
                            return true;
                        }else{
                            alert('El correo debe ser una cuenta gmail');
                            return false;
                        }
                        
                    } else if(email_validate!='') {
                                function not1(){
                        notif({
                            msg: "<b>Success:</b> In 5 seconds i'll be gone",
                            type: "success"
                            });
                        }
                        return false;
                    }
                    return false;
                }
        </script>

    </body>
</html>
