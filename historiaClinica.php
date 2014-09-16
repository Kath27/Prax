<?php
include('config.php');
include('config_mongo.php');

$historia = getHistoriaClinica();

$sql = "SELECT nombre, apellido, documento, fechnac, ubicacion, tel_fijo, tel_movil, ctagmail FROM prax.paciente";
$result = mysql_query($sql, $link) or die(imprimir_respuesta(false,mysql_error($link),"ErrorMysql"));
$paciente = mysql_fetch_row($result);

$sql2 = "SELECT nombre, apellido, documento, fechnac, ubicacion, tel_fijo, tel_movil, ctagmail FROM prax.paciente_contac";
$result2 = mysql_query($sql2, $link) or die(imprimir_respuesta(false,mysql_error($link),"ErrorMysql"));
$paciente_contact = mysql_fetch_row($result2);

?>
<!DOCTYPE html>
    <head>
        <meta charset="utf8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/main.css">
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
                            <div class="cont_avatar">
                                <div class="avatar">
                                    <div class="icon_upload"></div>
                                    <img id="open_upload_avatar" src="img/avatar-def.jpg">
                                    <input type="file" id="upload_avatar" />
                                </div>
                            </div>
                            <div class="summary_user">
                                <h2><?php echo($paciente[0]);?> <?php echo($paciente[1]);?></h2>
                                <p class="email_sumary"><?php echo($paciente[7]);?></p>
                                <a href="#" id="on_off_user"><span class="on"></span> Usuario Activo</a>
                            </div>
                        </div>
                        <div id="tabs"> 
                            <ul>
                                <li><a href="#tabs-1">Datos de paciente</a></li>
                                <li><a href="#tabs-2">Motivo de consulta</a></li>
                                <li><a href="#tabs-3">Evaluación</a></li>
                                <li><a href="#tabs-4">Diagnóstico</a></li>
                                <li><a href="#tabs-5">Tratamiento</a></li>
                                <li><a href="#tabs-6">Anotaciones</a></li>
                                <li><a href="#tabs-7">Datos de contacto</a></li>
                            </ul>
                            <form action="agregarAdminPsico.php" method="post" name="form">
                                <div id="tabs-1">
                                    <p>
                                        <label>Nombre</label>
                                        <input type='text' name='nombre' id='nombre' value= "<?php echo($paciente[0]);?>" readonly="readonly"/>
                                    </p>
                                    <p>
                                        <label>Apellidos</label>
                                        <input type="text" id="apellido"value= "<?php echo($paciente[1]);?>" readonly="readonly"/>
                                    </p>
                                    <p>
                                        <label>Documento de identidad</label>
                                        <input type="text" id="apellido"value= "<?php echo($paciente[2]);?>" readonly="readonly"/>
                                    </p>
                                    <p>
                                        <label>Fecha de nacimiento</label>
                                        <input type="text" id="apellido"value= "<?php echo($paciente[3]);?>" readonly="readonly"/>
                                    </p>
                                    <p>
                                        <label>Ubicación</label>
                                        <input type="text" id="apellido"value= "<?php echo($paciente[4]);?>" readonly="readonly"/>
                                    </p>
                                    <p>
                                        <label>Teléfono fíjo</label>
                                        <input type="text" id="apellido"value= "<?php echo($paciente[5]);?>" readonly="readonly"/>
                                    </p>
                                    <p>
                                        <label>Teléfono movil</label>
                                        <input type="text" id="apellido"value= "<?php echo($paciente[6]);?>" readonly="readonly"/>
                                    </p>
                                    <p>
                                        <label>Correo electronico</label>
                                        <input type="text" id="apellido"value= "<?php echo($paciente[7]);?>" readonly="readonly"/>
                                    </p>
                                    <p>
                                        <a href="descarga" class="button">Descarga historia clínica</a> 
                                    </p>
                                </div>    
                                <div id="tabs-2">                                    
                                	<?php foreach ($historia as $document) { ?>
                                       <textarea name="motivo" id="motivo" value="motivo" rows="10" cols="40"><?php echo $document->{"motivo"} ?></textarea>
                                   <?php } ?>                                     
                                </div>
                                <div id="tabs-3">
                                    <p>Evaluación de aspectos médicos</p>
                                    <?php foreach ($historia as $document) { ?>
                                       <textarea name="evaluacionMedico" id="evaluacionMedico" value="evaluacionMedico" rows="10" cols="40"><?php echo $document->{"evaluacionMedico"} ?></textarea>
                                   <?php } ?> 
                                        
                                    <p>Evaluación de aspectos familiares</p>
                                    <?php foreach ($historia as $document) { ?>
                                       <textarea name="evaluacionFami" id="evaluacionFami" value="evaluacionFami" rows="10" cols="40"><?php echo $document->{"evaluacionFami"} ?></textarea>
                                   <?php } ?> 
                                   
                                    <p>Evaluación de aspectos psicológicos</p>
                                    <?php foreach ($historia as $document) { ?>
                                       <textarea name="evaluacionPsico" id="evaluacionPsico" value="evaluacionPsico" rows="10" cols="40"><?php echo $document->{"evaluacionPsico"} ?></textarea>
                                   <?php } ?>
                                   
                                    <p>Evaluación de aspectos neuropsicológicos</p>
                                    <?php foreach ($historia as $document) { ?>
                                       <textarea name="evaluacionNeuro" id="evaluacionNeuro" value="evaluacionNeuro" rows="10" cols="40"><?php echo $document->{"evaluacionNeuro"} ?></textarea>
                                   <?php } ?>
                                </div>
                                <div id="tabs-4">
                                    <?php foreach ($historia as $document) { ?>
                                       <textarea name="diagnostico" id="diagnostico" value="diagnostico" rows="10" cols="40"><?php echo $document->{"diagnostico"} ?></textarea>
                                   <?php } ?> 
                                </div>
                                <div id="tabs-5">
                                    <?php foreach ($historia as $document) { ?>
                                       <textarea name="tratamiento" id="tratamiento" value="tratamiento" rows="10" cols="40"><?php echo $document->{"tratamiento"} ?></textarea>
                                   <?php } ?> 
                                </div>
                                <div id="tabs-6">
                                    <?php foreach ($historia as $document) { ?>
                                       <textarea name="anotaciones" id="anotaciones" value="anotaciones" rows="10" cols="40"><?php echo $document->{"anotaciones"} ?></textarea>
                                   <?php } ?>
                                </div>
                                <div id="tabs-7">
                                    <p>
                                        <label>Nombre</label>
                                        <input type='text' name='nombre_cont' id='nombre' value= "<?php echo($paciente_contact[0]);?>" readonly="readonly"/>
                                    </p>
                                    <p>
                                        <label>Apellidos</label>
                                        <input type="text" id="apellido_cont"value= "<?php echo($paciente_contact[1]);?>" readonly="readonly"/>
                                    </p>
                                    <p>
                                        <label>Documento de identidad</label>
                                        <input type="text" id="doc_cont"value= "<?php echo($paciente_contact[2]);?>" readonly="readonly"/>
                                    </p>
                                    <p>
                                        <label>Fecha de nacimiento</label>
                                        <input type="text" id="fechnac_cont"value= "<?php echo($paciente_contact[3]);?>" readonly="readonly"/>
                                    </p>
                                    <p>
                                        <label>Ubicación</label>
                                        <input type="text" id="ubicacion_cont"value= "<?php echo($paciente_contact[4]);?>" readonly="readonly"/>
                                    </p>
                                    <p>
                                        <label>Teléfono fíjo</label>
                                        <input type="text" id="tel_fijo_cont"value= "<?php echo($paciente_contact[5]);?>" readonly="readonly"/>
                                    </p>
                                    <p>
                                        <label>Teléfono movil</label>
                                        <input type="text" id="tel_mo_cont"value= "<?php echo($paciente_contact[6]);?>" readonly="readonly"/>
                                    </p>
                                    <p>
                                        <label>Correo electronico</label>
                                        <input type="text" id="mail_cont"value= "<?php echo($paciente_contact[7]);?>" readonly="readonly"/>
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
                    if (/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/.test(email_validate)){

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