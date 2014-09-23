<?php
    include('config.php');
    session_start();
    
    $psicologo = new stdClass();
    if($_SESSION["rol"]=="psico"){
        $psicologo->{"nombre"}=$_SESSION["nombre"];
        $psicologo->{"apellido"}=$_SESSION["apellido"];
        $psicologo->{"documento"}=$_SESSION["documento"];
        $psicologo->{"sexo"}=$_SESSION["sexo"];
        $psicologo->{"fechnac"}=$_SESSION["fechnac"];
        $psicologo->{"targProfe"}=$_SESSION["targProfe"];
        $psicologo->{"ubicacion"}=$_SESSION["ubicacion"];
        $psicologo->{"ctagmail_usuario"}=$_SESSION["ctagmail_usuario"];
        $psicologo->{"userId"}=$_SESSION["userId"];    
    }else if($_SESSION["rol"]=="admin"){
        $documento=$_GET["psicologo"];
        $sql="SELECT nombre, apellido, documento, sexo, fechnac, targProfe, ubicacion, ctagmail_usuario, isActive, id_adminpsic FROM prax.admin_psico WHERE documento='".$documento."'";
        $result=mysql_query($sql,$link)or die(exit(mysql_error($link)));
        $psico=mysql_fetch_row($result);
        
        $psicologo->{"nombre"}=$psico[0];
        $psicologo->{"apellido"}=$psico[1];
        $psicologo->{"documento"}=$psico[2];
        $psicologo->{"sexo"}=$psico[3];
        $psicologo->{"fechnac"}=$psico[4];
        $psicologo->{"targProfe"}=$psico[5];
        $psicologo->{"ubicacion"}=$psico[6];
        $psicologo->{"ctagmail_usuario"}=$psico[7];
        $psicologo->{"userId"}=$psico[9]; 
    }
    
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
                var sexo = encodeURI(document.getElementById("sexo").value);
                var fechanac = encodeURI(document.getElementById("fechnac").value);
                var tarjeProf = encodeURI(document.getElementById("targProfe").value);
                var ubicac = encodeURI(document.getElementById("searchTextField").value);
                var ctagmail_usuario = encodeURI(document.getElementById("ctagmail_usuario").value);
                var idPsico = encodeURI(document.getElementById("idPsico").value);
                var http = new XMLHttpRequest();
                    http.open("POST", "actualizarAdminPsico", true);
                    http.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                    http.send("nombre=" + nombre +
                                "&apellido=" + apellido + 
                                "&documento=" + doc + 
                                "&sexo=" + sexo + 
                                "&fechnac=" + fechanac + 
                                "&targProfe=" + tarjeProf + 
                                "&ubicacion=" + ubicac + 
                                "&idPsico=" + idPsico +
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
                        setTimeout(function(){
                            location.reload();
                        },100);
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
                document.getElementById("sexo").value = "";
                document.getElementById("fechnac").value = "";
                document.getElementById("targProfe").value = "";
                document.getElementById("searchTextField").value = "";
                document.getElementById("ctagmail_usuario").value = "";
            }
            function verificarform(){
                var nombre = encodeURI(document.getElementById("nombre").value);
                var apellido = encodeURI(document.getElementById("apellido").value);
                var doc = encodeURI(document.getElementById("documento").value);
                var sexo = encodeURI(document.getElementById("sexo").value);
                var fechanac = encodeURI(document.getElementById("fechnac").value);
                var tarjeProf = encodeURI(document.getElementById("targProfe").value);
                var ubicac = encodeURI(document.getElementById("searchTextField").value);
                var ctagmail_usuario = encodeURI(document.getElementById("ctagmail_usuario").value);
                return (nombre != "" && apellido != "" && doc !="" && sexo != "" && fechanac != "" && tarjeProf != "" && ubicac != "" && ctagmail_usuario != "");

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
                    <div class="panel">
                        <div class="header_user">
                            <div class="summary_user">
                                <h2>Editar Psicólogo</h2>                                
                            </div>
                        </div>
                        <div id="tabs">                            
                            <form action="agregarAdminPsico.php" method="post" name="form">
                                <input type="hidden" value="<?php echo $psicologo->{"userId"};?>" id="idPsico"/>
                                <div id="tabs-1">
                                    <p>
                                        <label>Nombre</label>
                                        <input type="text" id="nombre" value="<?php echo $psicologo->{"nombre"};?>" placeholder="Escribe tu nombre completo"></input>
                                        <label class="help">Este campo es requerido</label>
                                    </p>
                                    <p>
                                        <label>Apellidos</label>
                                        <input type="text" id="apellido" value="<?php echo $psicologo->{"apellido"};?>" placeholder="Escribe tus apellidos"></input>
                                        <label class="help">Este campo es requerido</label>
                                    </p>
                                    <p>
                                        <label>Documento de identidad</label>
                                        <input type="text" id="documento" value="<?php echo $psicologo->{"documento"};?>" placeholder="Escribe tu documento de identidad nacional (DNI)"></input>
                                        <label class="help">Este campo es requerido</label>
                                    </p>
                                    <p>
                                        <label>Sexo</label>
                                        <select id="sexo">
                                            <?php $sel=($psicologo->{"sexo"}=="")?'selected="selected"':'';?>
                                            <option <?php echo $sel;?>>Seleccione su sexo</option>
                                            <?php $sel=($psicologo->{"sexo"}=="M")?'selected="selected"':'';?>
                                            <option <?php echo $sel;?> value='M'>Hombre</option>
                                            <?php $sel=($psicologo->{"sexo"}=="F")?'selected="selected"':'';?>
                                            <option <?php echo $sel;?> value='F'>Mujer</option>
                                        </select>
                                        <label class="help">Este campo es requerido</label>
                                    </p>
                                    <p>
                                        <label>Fecha de nacimiento</label>
                                        <input type="text" id="fechnac" value="<?php echo $psicologo->{"fechnac"};?>" placeholder="Escribe tu fecha de nacimiento  (aaaa/mm/dd)"></input>
                                        <label class="help">Este campo es requerido</label>

                                    </p>
                                    <p>
                                        <label>Tarjeta profesional</label>
                                        <input type="text" id="targProfe" value="<?php echo $psicologo->{"targProfe"};?>" placeholder="Registra tarjeta profesional como psicólogo"></input>
                                        <label class="help">Este campo es requerido</label>
                                    </p>
                                    <p>
                                        <label>Ubicación</label>
                                        <input type="text" id="searchTextField" value="<?php echo $psicologo->{"ubicacion"};?>" placeholder="Escribe la dirección del lugar donde vives o trabajas"></input>
                                        <label class="help">Este campo es requerido</label>  
                                    </p>
                                    <p>
                                        <label>Cuenta de gmail</label>
                                        <input type="email" id="ctagmail_usuario" value="<?php echo $psicologo->{"ctagmail_usuario"};?>" placeholder="Escribe tu cuenta de gmail"></input>
                                        <label class="help">Este campo es requerido</label>
                                    </p>
                                    <p>
                                        <input id="validate_form" type="button" value="Guardar" ></input> 
                                    </p>
                                </div>
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
        <script type="text/javascript" src="jquery/jquery_notification_v.1.js"></script>
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
                        //$('input').focus(function(){
                        //    $('#documento').parent().removeClass('error')
                        //});
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
                    if (/^((([a-zA-Z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-zA-Z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/.test(email_validate)){

                        var arrobaa =  email_validate.split('@');
                        var type_email =  arrobaa[1].split('.');
                        if(type_email[0].toLowerCase()=='gmail'){
                           console.log('El correo tiene un formato correcto y es gmail');
                           $('#ctagmail_usuario').parent().removeClass('error_2');
                            return true;
                        }else{
                            alert('El correo debe ser una cuenta gmail');
                            $('#ctagmail_usuario').parent().addClass('error_2');
                            return false;
                        }
                        
                    } else if(email_validate!='') {
                        alert('El formato del correo no es valido');
                        $('#ctagmail_usuario').parent().addClass('error_2');
                        return false;
                    }
                    return false;
                }
        </script>
        <?php mysql_close($link); ?>
    </body>
</html>
