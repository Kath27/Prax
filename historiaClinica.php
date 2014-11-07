<?php
include('config.php');
include('config_mongo.php');
include('utilidades.php');
session_start();
if (!isset($_SESSION["userId"])){ header('Location: /'); }

$id_paciente = $_GET["paciente"];
$idAdmin = ($_SESSION["rol"]=="admin")?"id_admin":"id_adminpsic";
$sql = "SELECT id_paciente FROM prax.paciente WHERE documento='".$id_paciente."' AND ".$idAdmin."=".$_SESSION["userId"];
$result = mysql_query($sql, $link)or die(imprimir_respuesta(false,mysql_error($link),"ErrorMysql"));
if(mysql_num_rows($result)==0){
    header('Location: /');
}

if($_SESSION["rol"]=="admin"){
   $columnaAdmin =  "id_admin";
}
else{
    $columnaAdmin = "id_adminpsic";
}

$id_admin = ($_SESSION["rol"] == "admin")? "a" : "p";
$id_admin .= $_SESSION["userId"];

$historia = getHistoriaClinica($id_paciente, $id_admin);
$historia = $historia[0];

$anotaciones = getAnotaciones($id_paciente, $id_admin);


$sql = "SELECT nombre, apellido, documento, fechnac, ubicacion, tel_fijo, tel_movil, ctagmail, id_paciente, fecha_mod, sexo FROM prax.paciente WHERE documento='".$id_paciente."' AND " . $columnaAdmin."=".$_SESSION["userId"];
$result = mysql_query($sql, $link) or die(imprimir_respuesta(false,mysql_error($link),"ErrorMysql"));
$paciente = mysql_fetch_row($result);

$sql2 = "SELECT nombre, apellido, documento, fechnac, ubicacion, tel_fijo, tel_movil, ctagmail, tipo_relacion FROM prax.paciente_contac WHERE id_paciente='".$paciente[8]."'";
$result2 = mysql_query($sql2, $link) or die(imprimir_respuesta(false,mysql_error($link),"ErrorMysql"));
$paciente_contact = mysql_fetch_row($result2);

$sql3 = "SELECT idtipo_relacion, descripcion FROM prax.tipo_relacion";
$result3 = mysql_query($sql3, $link) or die(imprimir_respuesta(false,mysql_error($link),"ErrorMysql"));

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
        <link rel="stylesheet" href="css/font.css">
        <link href="css/jquery_notification.css" type="text/css" rel="stylesheet"/>
        <link href="css/CSSTableGenerator.css" type="text/css" rel="stylesheet"/>
        <script type="text/javascript" charset="utf-8">
        	function getPlaceCity(){
        		var city = "Indefinido";
        		if ($("#searchTextField").val() != "" && googleAddressAutocomplete.getPlace()){
        			var components = googleAddressAutocomplete.getPlace().address_components;
        			for (var i=0;i<components.length;i++){
        				if (components[i].types[0] == "locality")
        					city = components[i].long_name;
        			}
        		}
        		
        		return city;
        	}
        	
            function registroHistoria(){
                var motivo = encodeURI(document.getElementById("motivo").value);
                var evaluacionMedico = encodeURI(document.getElementById("evaluacionMedico").value);
                var evaluacionFami = encodeURI(document.getElementById("evaluacionFami").value);
                var evaluacionPsico = encodeURI(document.getElementById("evaluacionPsico").value);
                var evaluacionNeuro = encodeURI(document.getElementById("evaluacionNeuro").value);
                var diagnostico = encodeURI(document.getElementById("diagnostico").value);
                var tratamiento = encodeURI(document.getElementById("tratamiento").value);
                var nombre = encodeURI(document.getElementById("nombre").value);
                var apellido = encodeURI(document.getElementById("apellido").value);
                var documento = encodeURI(document.getElementById("documento").value);
                var fechanac = encodeURI(document.getElementById("fechanac").value);
                var ubicacion = encodeURI(document.getElementById("searchTextField").value);
                var sexo = encodeURI(document.getElementById("sexo").value);
                var city = encodeURI(getPlaceCity());
                var telFijo = encodeURI(document.getElementById("telFijo").value);
                var telMovil = encodeURI(document.getElementById("telMovil").value);
                var mail = encodeURI(document.getElementById("mail").value);
                var nombre_cont = encodeURI(document.getElementById("nombre_cont").value);
                var apellido_cont = encodeURI(document.getElementById("apellido_cont").value);
                var documento_cont = encodeURI(document.getElementById("documento_cont").value);
                var fechanac_cont = encodeURI(document.getElementById("fechanac_cont").value);
                var ubicacion_cont = encodeURI(document.getElementById("ubicacion_cont").value);
                var telFijo_cont = encodeURI(document.getElementById("telFijo_cont").value);
                var telMovil_cont = encodeURI(document.getElementById("telMovil_cont").value);
                var mail_cont = encodeURI(document.getElementById("mail_cont").value);
                var tipo_relacion = encodeURI(document.getElementById("tipo_relacion").value);
                var http = new XMLHttpRequest();
                    http.open("POST", "AgregarHistoria", true);
                    http.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                    http.send("id_paciente=<?php echo $paciente[8]; ?>" + 
                                "&motivo=" + motivo +
                                "&evaluacionMedico=" + evaluacionMedico + 
                                "&evaluacionFami=" + evaluacionFami + 
                                "&evaluacionPsico=" + evaluacionPsico + 
                                "&evaluacionNeuro=" + evaluacionNeuro + 
                                "&diagnostico=" + diagnostico + 
                                "&tratamiento=" + tratamiento + 
                                "&nombre=" + nombre +
                                "&apellido=" + apellido +
                                "&documento=" + documento +
                                "&fechanac=" +  fechanac +
                                "&ubicacion=" + ubicacion +
                                "&sexo=" + sexo +
                                "&telFijo=" +  telFijo +
                                "&telMovil=" + telMovil+
                                "&mail=" + mail+
                                "&nombre_cont=" + nombre_cont+
                                "&apellido_cont=" + apellido_cont+
                                "&documento_cont=" + documento_cont+
                                "&fechanac_cont=" + fechanac_cont+
                                "&ubicacion_cont=" + ubicacion_cont+
                                "&telFijo_cont=" + telFijo_cont+
                                "&telMovil_cont=" + telMovil_cont+
                                "&mail_cont=" +mail_cont +
                                "&tipo_relacion=" + tipo_relacion +
                                "&cityChanged=" + ((cityChanged)? 'T' : 'F') +
                                "&city=" + city
                                ); 
                    http.onreadystatechange = function(){
                        if (http.readyState == 4 && http.status == 200) {
                            var respuesta = JSON.parse(http.responseText);
                            if (respuesta.estado){
                                $("#guardado").html("Actualizado: " + respuesta.objResponse.updated);
                                $("#guardado").css("color","#000");
                                $("#nombreCabeza").html($("#nombre").val()+" "+$("#apellido").val());
                                $("#mailCabeza").html($("#mail").val());
                            }else{
                                showNotification({
                                    message: respuesta.message,
                                    type: "error"
                                });
                                
                                $("#guardado").html(lastUpdate);
                                setTimeout(closeNotification, 3000);
                            }
                        }else if (http.readyState == 4){
                            showNotification({
                                message: "Ocurrio un error",
                                type: "error"
                            });
                            
                            $("#guardado").html(lastUpdate);
                            setTimeout(closeNotification, 3000);
                        }
                    };        
                }
                function guardarAnotacion(){
                    
                    var anotaciones = encodeURI(document.getElementById("anotaciones").value);
                    var documento = encodeURI(document.getElementById("documento").value);
                    
                    var http = new XMLHttpRequest();
                    http.open("POST", "AgregarHistoria", true);
                    http.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                    http.send("id_paciente=<?php echo $paciente[8]; ?>" + 
                                "&anotaciones=" + anotaciones +
                                "&documento=" + documento 
                                ); 
                    http.onreadystatechange = function(){
                        if (http.readyState == 4 && http.status == 200) {
                            var respuesta = JSON.parse(http.responseText);
                            if (respuesta.estado){
                                $("#guardado").html("Actualizado: " + respuesta.objResponse.updated);
                                
                                var anotaciones = document.getElementById("anotaciones").value;
                                if (anotaciones == null || anotaciones.trim() == "") return;
                                
                                $("#anotaciones").html("");
                                $("#anotaciones").val("");
                                crearAnotacion(anotaciones,respuesta.objResponse._id["$oid"],respuesta.objResponse.fecha_creac);
                            }else{
                                showNotification({
                                    message: respuesta.message,
                                    type: "error"
                                });
                                setTimeout(closeNotification, 3000);
                            }
                        }else if (http.readyState == 4){
                            showNotification({
                                message: "Ocurrio un error",
                                type: "error"
                            });
                            setTimeout(closeNotification, 3000);
                        }
                    };        
                }
                                
                function crearAnotacion(anotacion,anotId,fecha){
                    var fila = document.createElement("tr");
                    var anot = document.createElement("td"); 
                    var fecCrea = document.createElement("td");
                    var fecMod = document.createElement("td");
                    var savingIcon = document.createElement("div");
                    
                    var label = document.createElement("label");
                    var textArea = document.createElement("textarea");
                    var hidden = document.createElement("input");
                    
                    var button = document.createElement("button");
                    
                    label.innerHTML = anotacion;
                    label.className = "lbledita";
                    
                    button.type="button";
                    button.className = "icon-pencil5";
                    label.appendChild(button);
                    
                    textArea.value = anotacion;
                    textArea.className = "editanotacion";
                    textArea.style.display = "none";
                    textArea.style.width = "95%";
                    
                    hidden.value = anotId;
                    hidden.type = "hidden";
                    
                    savingIcon.className = "SavingIcon";
                    savingIcon.innerHTML = "Guardando...";
                    savingIcon.style.display = "none";
                    
                    anot.appendChild(label);
                    anot.appendChild(textArea);
                    anot.appendChild(hidden);
                    anot.appendChild(savingIcon);
                    
                    fecCrea.innerHTML=fecha;
                    fecMod.innerHTML=fecha;
                    
                    anot.className = "lblAnotacion";
                    
                    fila.appendChild(anot);
                    fila.appendChild(fecCrea);
                    fila.appendChild(fecMod);  
                    
                    document.getElementById("tbl_anotaciones").appendChild(fila);
                    
                    prepararAnotacionesParaEdicion();
                }      
                function generateBoundary() { 
                  return "AJAX-----------------------" + (new Date).getTime(); 
                }
                
                function actualizarAnotacion(label, anotacion,id_anotacion){
                    var http = new XMLHttpRequest();
                    http.open("POST", "actualizarAnotacion", true);
                    http.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                    http.send("anotacion="+ encodeURI(anotacion.val()) + 
                                "&id_anotacion="+id_anotacion); 
                    http.onreadystatechange = function(){
                        if (http.readyState == 4 && http.status == 200) {
                            var respuesta = JSON.parse(http.responseText);
                            if (respuesta.estado){
                                var button = document.createElement("button");
                                button.type="button";
                                button.className = "icon-pencil5";
                                
                                label.html(anotacion.val());
                                label[0].appendChild(button);
                                
                                label.parent().next().next().html(respuesta.objResponse);
                                label.parent().find(".SavingIcon").css("display","none");
                            }else{
                                showNotification({
                                    message: respuesta.message,
                                    type: "error"
                                });
                                setTimeout(closeNotification, 3000);
                            }
                        }else if (http.readyState == 4){
                            showNotification({
                                message: "Ocurrio un error",
                                type: "error"
                            });
                            setTimeout(closeNotification, 3000);
                        }
                    }; 
                }
                
                function OpenInNewTab(url) {
				  var win = window.open(url, '_blank');
				  win.focus();
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
                        <img src="<?php echo $_SESSION["img"];?>"/>
                    </div>
                </div>
            </div>
            <div class="tootip_header">
                <?php include("perfilHeader.php");?>
            </div>
        </header>
        <section>
            <aside>
                <nav>
                    <?php include("menu.php"); ?>
                </nav>
            </aside>
            <article>
                <div class="row">
                    <div class="panel">
                        <div class="header_user">
                            <div class="cont_avatar">
                                <div class="avatar">
                                    <div class="icon_upload icon-upload4"></div>
                                    <img id="open_upload_avatar" src="<?php echo "/imageProxy?paciente=" . $paciente[2] . "&idAdmin=" . $id_admin; ?>">
                                    <iframe name="iframeAvatar" id="iframeAvatar" style="display: none;"></iframe>
                                    <?php
                                        require_once 'google/appengine/api/cloud_storage/CloudStorageTools.php';
                                        use google\appengine\api\cloud_storage\CloudStorageTools;
                                        
                                        $options = array('gs_bucket_name' => 'imagespacientes');
                                        $upload_url = CloudStorageTools::createUploadUrl('/uploadImage?paciente=' . $paciente[2] . '&idAdmin=' . $id_admin, $options);
                                    ?>
                                    <form id="frmAvatar" target="iframeAvatar" action="<?php echo $upload_url; ?>" method="POST" enctype="multipart/form-data">
                                        <input type="file" id="uploadAvatar" name="uploadAvatar" />
                                    </form>
                                    <div id="fileuploader"></div>
                                </div>
                            </div>
                            <div class="summary_user">
                                <h2 id="nombreCabeza" style="display: inline-block;"><?php echo($paciente[0]);?> <?php echo($paciente[1]);?></h2>
                                <h2 style="display: inline-block;"><button type="button" class="icon-file6" onclick="javascript:OpenInNewTab('descarga?paciente=<?php echo $id_paciente; ?>')"></button></h2>
                                <p id="mailCabeza" class="email_sumary"><?php echo($paciente[7]);?></p>
                                <div id="guardado">Actualizado: <?php echo $paciente[9]; ?></div>
                                <div id="guardado">Por confidencialidad con tu paciente evita registrar información sensible donde se identifiquen personas o hechos.</div>
                            </div>
                        </div>
                        <div id="tabs"> 
                            <ul>
                                <li><a href="#tabs-1">Datos de identificación</a></li>
                                <li><a href="#tabs-2">Motivo de consulta</a></li>
                                <li><a href="#tabs-3">Evaluación</a></li>
                                <li><a href="#tabs-4">Diagnóstico</a></li>
                                <li><a href="#tabs-5">Tratamiento</a></li>
                                <li><a href="#tabs-6">Anotaciones</a></li>
                                <li><a href="#tabs-7">Datos de persona de contacto</a></li>
                            </ul>
                            <form action="agregarAdminPsico.php" method="post" name="form">
                                <div id="tabs-1">
                                    <p>
                                        <label>Nombre</label>
                                        <input type='text' name='nombre' id='nombre' value= "<?php echo($paciente[0]);?>"/>
                                    </p>
                                    <p>
                                        <label>Apellidos</label>
                                        <input type="text" id="apellido"value= "<?php echo($paciente[1]);?>"/>
                                    </p>
                                    <p>
                                        <label>Documento de identidad</label>
                                        <input type="text" id="documento"value= "<?php echo($paciente[2]);?>"/>
                                    </p>
                                    <p>
                                        <label>Fecha de nacimiento</label>
                                        <input type="text" id="fechanac" value= "<?php echo($paciente[3]);?>"/>
                                    </p>
                                    <p>
                                        <label>Ubicación</label>
                                        <input type="text" id="searchTextField"value= "<?php echo($paciente[4]);?>"/>
                                    </p>
                                    <p>
                                        <label>Teléfono fíjo</label>
                                        <input type="text" id="telFijo"value= "<?php echo($paciente[5]);?>"/>
                                    </p>
                                    <p>
                                        <label>Teléfono movil</label>
                                        <input type="text" id="telMovil"value= "<?php echo($paciente[6]);?>"/>
                                    </p>
                                    <p>
                                        <label>Correo electronico</label>
                                        <input type="text" id="mail"value= "<?php echo($paciente[7]);?>"/>
                                    </p>
                                    <p>
                                    	<?php $sexM = ($paciente[10] == "M")? 'selected="selected"' : ""; ?>
                                    	<?php $sexF = ($paciente[10] == "F")? 'selected="selected"' : ""; ?>
                                        <label>Sexo</label>
                                        <select id="sexo">
                                            <option>Seleccione su sexo</option>
                                            <option <?php echo $sexM; ?> value='M'>Hombre</option>
                                            <option <?php echo $sexF; ?> value='F'>Mujer</option>
                                        </select>
                                    </p>
                                </div>    
                                <div id="tabs-2">
                                     <textarea id="motivo" placeholder="Escribe el motivo de consulta del paciente. Recuerda describir fielmente las razones por las cuales el paciente consulta, evita realizar interpretaciones o análisis en está sección, si quieres comentar algo utiliza la sección de anotaciones."><?php echo $historia->{"motivo"};?></textarea>                                     
                                </div>
                                <div id="tabs-3">
                                    <p>Evaluación de aspectos médicos</p>
                                    <textarea id="evaluacionMedico" placeholder="Escribe tus hallazgos más relevantes sobre los aspectos que evalues, recuerda que debe ser información relevante para el motivo de consulta o comprobación de tu hipótesis diagnóstica"><?php echo $historia->{"evaluacionMedico"};?></textarea> 
                                        
                                    <p>Evaluación de aspectos familiares</p>
                                    
                                    <textarea id="evaluacionFami" placeholder="Escribe tus hallazgos más relevantes sobre los aspectos que evalues, recuerda que debe ser información relevante para el motivo de consulta o comprobación de tu hipótesis diagnóstica"><?php echo $historia->{"evaluacionFami"};?></textarea>
                                   
                                    <p>Evaluación de aspectos psicológicos</p>
                                    <textarea id="evaluacionPsico" placeholder="Escribe tus hallazgos más relevantes sobre los aspectos que evalues, recuerda que debe ser información relevante para el motivo de consulta o comprobación de tu hipótesis diagnóstica"><?php echo $historia->{"evaluacionPsico"};?></textarea>
                                   
                                    <p>Evaluación de aspectos neuropsicológicos</p>
                                    <textarea id="evaluacionNeuro" placeholder="Escribe tus hallazgos más relevantes sobre los aspectos que evalues, recuerda que debe ser información relevante para el motivo de consulta o comprobación de tu hipótesis diagnóstica"><?php echo $historia->{"evaluacionNeuro"};?></textarea>
                                </div>
                                <div id="tabs-4">
                                    <textarea id="diagnostico" placeholder="Escribe el diagnóstico de tu paciente"><?php echo $historia->{"diagnostico"};?></textarea>
                                </div>
                                <div id="tabs-5">
                                    <textarea id="tratamiento" placeholder="Basado en el diagnóstico de tu paciente formula los objetivos y el protocolo de intervención que vas a seguir"><?php echo $historia->{"tratamiento"};?></textarea>
                                </div>
                                <div id="tabs-6">
                                    <textarea id="anotaciones"></textarea>
                                    <p><a class="button" style="cursor: pointer" onclick="guardarAnotacion()">Guardar anotación</a> 
                                    <div class="CSSTableGenerator">
                                        <table id="tbl_anotaciones">
                                            <tr>
                                                <td>Anotación</td>
                                                <td>Fecha de creación</td>
                                                <td>Fecha de modificación</td>
                                            </tr>
                                            <?php 
                                                foreach ($anotaciones as $anotacion){
                                                    ?>
                                                    <tr>
                                                        <td class="lblAnotacion" style="width: 50%">
                                                            <label class="lbledita"><?php echo $anotacion->{"anotacion"}; ?><button type="button" class="icon-pencil5"></button></label>
                                                            <textarea class="editanotacion" style="display: none; width: 95%;"><?php echo $anotacion->{"anotacion"}; ?></textarea>
                                                            <input type="hidden" value="<?php echo $anotacion->{"_id"}->{"\$oid"}; ?>"/>
                                                            <div class="SavingIcon" style="display: none">Guardando...</div>
                                                        </td>
                                                        <td style="width: 25%"><?php echo $anotacion->{"fecha_creac"}; ?></td>
                                                        <td style="width: 25%"><?php echo $anotacion->{"fecha_mod"}; ?></td>
                                                    </tr>   
                                                    <?php
                                                }
                                            ?>
                                        </table> 
                                    </div>
                                </div>
                                <div id="tabs-7">
                                    <p>
                                        <label>Nombre</label>
                                        <input type='text' name='nombre_cont' id='nombre_cont' placeholder="Escriba el nombre completo de la persona de contacto" value= "<?php echo($paciente_contact[0]);?>"/>
                                    </p>
                                    <p>
                                        <label>Apellidos</label>
                                        <input type="text" id="apellido_cont" placeholder="Escriba el apelldio de la persona de contacto" value= "<?php echo($paciente_contact[1]);?>"/>
                                    </p>
                                    <p>
                                        <label>Documento de identidad</label>
                                        <input type="text" id="documento_cont" placeholder="Escriba el documento de identidad nacional de la persona de contacto (DNI)" value=  "<?php echo($paciente_contact[2]);?>"/>
                                    </p>
                                    <p>
                                        <label>Fecha de nacimiento</label>
                                        <input type="text" id="fechanac_cont" placeholder="Escriba su fecha de nacimiento en el formato dd / mm / aaaa" value="<?php echo($paciente_contact[3]);?>"/>
                                    </p>
                                    <p>
                                        <label>Ubicación</label>
                                        <input type="text" id="ubicacion_cont" placeholder="Escriba el lugar de residencia de la persona de contacto" value="<?php echo($paciente_contact[4]);?>"/>
                                    </p>
                                    <p>
                                        <label>Teléfono fíjo</label>
                                        <input type="text" id="telFijo_cont" placeholder="Escriba el número de teléfono + código de país y área" value= "<?php echo($paciente_contact[5]);?>"/>
                                    </p>
                                    <p>
                                        <label>Teléfono movil</label>
                                        <input type="text" id="telMovil_cont" placeholder="Escriba el número de teléfono + código de país y área" value= "<?php echo($paciente_contact[6]);?>"/>
                                    </p>
                                    <p>
                                        <label>Tipo de relación</label>
                                        <select id="tipo_relacion">
                                            <?php while($tipo_relacion = mysql_fetch_array($result3)){?>
                                                <?php
                                                    $check = "";
                                                    if ($tipo_relacion[0] == $paciente_contact[8])
                                                        $check = 'selected="selected"';
                                                ?>
                                                <option <?php echo $check; ?> placeholder="" value='<?php echo($tipo_relacion[0]);?>'><?php echo($tipo_relacion[1]);?></option>
                                            <?php }?>
                                        </select>
                                        <label class="help">Este campo es requerido</label>
                                    </p>
                                    <p>
                                        <label>Correo electronico</label>
                                        <input type="text" id="mail_cont" placeholder="Escriba la dirección de email de la persona de contacto" value= "<?php echo($paciente_contact[7]);?>"/>
                                    </p>
                                </div>    
                            </form>
                        </div>
                    </div>
                </div>            
            </article>
        </section>
        <footer><span style="position: absolute; left:10px;"><a style="color: #a21218; font-size: 12px; text-decoration: none" target="_blank" href="http://www.prax.com.co/praxone/politicas-de-uso">Condiciones de uso</a></span> S.A.S 2014 - <span class="ano_current"></span>Prax S.A.S 2014 - <span class="ano_current"></span>. Todos los derechos reservados. Medellín - Colombia.</footer>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?libraries=places"></script>
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
                
                setTimeout(function(){
                    var input = document.getElementById('ubicacion_cont');
                    if (input) new google.maps.places.Autocomplete(input);
                },100);
                $('#documento,#documento_cont,#telFijo,#telMovil,#telFijo_cont,#telMovil_cont').filter_input({regex:'[0-9]'});
                $('#fechanac,#fechanac_cont').filter_input({regex:'[0-9\-]'});
            });
            

                function validateForm() {
                    var email_validate = $.trim($('#ctagmail_usuario').val());
                    var nombre = $.trim($('#nombre').val());
                    var apellido = $.trim($('#apellido').val());
                    var doc = $.trim($('#documento').val());
                    var sexo = $.trim($('#sexo').val());
                    var fechanac = $.trim($('#fechanac').val());
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
                
                var temp_guadado, lastUpdate;
                function autoSave(){
                    if($(this).hasClass("editanotacion")){
                        return;
                    }
                    if ($(this).attr("id") == "anotaciones") return;
                    
                    if(temp_guadado != null)
                        clearTimeout(temp_guadado);
                        
                    temp_guadado = setTimeout(function(){
                        lastUpdate = $("#guardado").html();
                        $("#guardado").html("Guardando...");
                        $("#guardado").css("color","#a21218");
                        setTimeout(function(){
                            registroHistoria();
                        }, 2000);
                    }, 3000);
                }
                $("textarea,input[type=text],#sexo").keydown(autoSave);
                $("textarea,input[type=text],#sexo").change(autoSave);
                $("#uploadAvatar").change(function(){
                    var form = $("#frmAvatar")[0]
                    form.submit();
                    
                    $("#open_upload_avatar").attr("src", "img/ajax-loader.gif");
                    
                    uploadAvatarCallback();
                });
                
                function uploadAvatarCallback(){
                    var respuesta = $("#iframeAvatar").contents().find("pre").html();
                    
                    if(respuesta && respuesta != ""){
                        try{
                            var json = JSON.parse(respuesta);
                            
                            if(json.estado){
                                var d = (new Date()).getTime();
                                $("#open_upload_avatar").attr("src", "<?php echo "/imageProxy?paciente=" . $paciente[2] . "&idAdmin=" . $id_admin; ?>&time=" + d);
                            }else{
                                showNotification({
                                    message: json.message,
                                    type: "error"
                                });
                                setTimeout(closeNotification, 3000);
                                $("#open_upload_avatar").attr("src", "<?php echo "/imageProxy?paciente=" . $paciente[2] . "&idAdmin=" . $id_admin; ?>&time=" + d);
                            }
                        }catch (e){
                            showNotification({
                                message: "Ocurrio un error",
                                type: "error"
                            });
                            setTimeout(closeNotification, 3000);
                        }
                        
                        $("#iframeAvatar").contents().find("body").html("");
                    }else{
                        setTimeout(uploadAvatarCallback,500);
                    }
                }
                
                function prepararAnotacionesParaEdicion(){
                     $(".lblAnotacion").click(function(event){
                        $(".editanotacion").each(function(){ $(this).hide(); $(this).off("keydown"); });
                        $(".lbledita").each(function(){ $(this).show(); });
                        
                        var lbl = $(this).find("label");
                        var txt = $(this).find("textarea");
                        var hdn = $(this).find("input").val();
                        var saving = $(this).find(".SavingIcon");
                        
                        lbl.hide();
                        txt.show();
                        
                        txt.keydown(function(){
                            if(temp_guadado != null)
                                clearTimeout(temp_guadado);
                            temp_guadado = setTimeout(function(){
                                saving.css("display","inline-block");
                                actualizarAnotacion(lbl,txt,hdn);
                            }, 3000);
                        });
                        
                        event.stopPropagation();
                    });
                }
                prepararAnotacionesParaEdicion();
                
                $(document).click(function(){
                    $(".editanotacion").each(function(){ $(this).hide(); $(this).off("keydown"); });
                    $(".lbledita").each(function(){ $(this).show(); });
                });
                
                var cityChanged = false;
		        $("#searchTextField").change(function(){
		        	cityChanged = true;
		        });
        </script>

        <?php mysql_close($link); ?>

    </body>
</html>
