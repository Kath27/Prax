<?php
	include('config.php');
    session_start();
    if (!isset($_SESSION["userId"])){ header('Location: /'); }
	
	$sql = "SELECT nombre, apellido, documento, sexo, fechnac, targProfe, ubicacion, ctagmail_usuario, isActive, id_adminpsic, ciudad FROM prax.admin_psico";
    $psicologos = mysql_query($sql,$link)or die(exit(mysql_error($link)));
	
	$totalPsico = mysql_num_rows($psicologos);
	$psicoM = 0;
	$psicoF = 0;
	$psicoN = 0;
	
	$ciudades = array();
	while ($list = mysql_fetch_array(($psicologos))){
		if ($list[3] == "M") $psicoM++; else if ($list[3] == "F") $psicoF++; else $psicoN++;
		
		$added = false;
		foreach ($ciudades as $c){
			if ($c->{"name"} == $list[10]){
				$c->{"amount"} += 1;
				$added = true;
			}
		}
		
		if (!$added){
			$c = new stdClass();
			$c->{"name"} = $list[10];
			$c->{"amount"} = 1;
			
			$ciudades[sizeof($ciudades)] = $c;
		}
	}
?>
<!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Reporte usuarios</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/font.css">
        <link href="css/CSSTableGenerator.css" type="text/css" rel="stylesheet"/>
        <link href="css/jquery_notification.css" type="text/css" rel="stylesheet"/>
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
            	<h3>Reporte de Usuarios</h3>
            	<div>
            		<table>
	            		<tr><td style="width: 200px;"><strong>Psicólogos activados: </strong></td><td> <?php echo $totalPsico; ?></td></tr>
            		</table>
            	</div>
            	<div id="chart_div_gender" style="display: inline-block; width: 500px; vertical-align: top;"></div>
            	<div style="display: inline-block; width: 800px; vertical-align: top;">
	            	<div style="text-align: center">
	            		Buscar psicologos registrados en el año: 
	            		<select onchange="drawPsicoYear(this.value)" style="border: 1px solid #e0e6f0; -webkit-border-radius: 5px; border-radius: 5px; width: 200px; padding: 10px; color: #484848;">
	            			<?php
	            				$year1 = 2014;
	            				$year2 = (real)date("Y");
								
								for ($i=$year1;$i<=$year2+1;$i++){ ?>
									<?php $sel = ($i==$year2)? "selected=selected" : ""; ?>
									<option <?php echo $sel; ?> value=<?php echo $i; ?>><?php echo $i; ?></option>
							<?php } ?>
	            		</select>
	            	</div>
	            	<div id="chart_div_register"></div>
            	</div>
            	<div><h3>Psicologos por ciudad</h3></div>
            	<div class="CSSTableGenerator">
            		<table>
            			<tr>
            				<td style="width: 50%">Ciudad</td>
            				<td style="width: 25%">Cantidad</td>
            				<td style="width: 25%">Porcentaje</td>
            			</tr>
            			
            			<?php foreach ($ciudades as $c){ ?>
            				<?php
            					$per = ($c->{"amount"} / $totalPsico * 100);
								$per = round($per * 100) / 100;
            				?>
	            			<tr>
	            				<td><?php echo $c->{"name"}; ?></td>
	            				<td><?php echo $c->{"amount"}; ?></td>
	            				<td><?php echo $per; ?>%</td>
	            			</tr>
            			<?php } ?>
            		</table>
            	</div>
            	<div style="height: 100px;">&nbsp;</div>
            </article>
        </section>
        <footer><span style="position: absolute; left:10px;"><a style="color: #a21218; font-size: 12px; text-decoration: none" target="_blank" href="http://www.prax.com.co/praxone/politicas-de-uso">Condiciones de uso</a></span> S.A.S 2014 - <span class="ano_current"></span>Prax S.A.S 2014 - <span class="ano_current"></span>. Todos los derechos reservados. Medellín - Colombia.</footer>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?libraries=places"></script>
        <script>window.jQuery || document.write('<script src="js/jquery-1.10.2.min.js"><\/script>')</script>
        <script src="js/jquery-ui.js"></script>
        <script src="js/plugins.js"></script>
        <script src="js/jquery.filter_input.js"></script>
        <script type="text/javascript" src="jquery/jquery_notification_v.1.js"></script>
        <script src="js/main.js"></script>
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
        <script type="text/javascript">
			google.load('visualization', '1.0', {'packages':['corechart']});
			google.setOnLoadCallback(drawCharts);
	
			function drawGenderChart(){
				var data = new google.visualization.DataTable();
		        data.addColumn('string', 'Topping');
		        data.addColumn('number', 'Usuarios');
		        data.addRows([
		          ['Hombres', <?php echo $psicoM; ?>],
		          ['Mujeres', <?php echo $psicoF; ?>],
		          ['No especificado', <?php echo $psicoN; ?>]
		        ]);
		
		        var options = {'title':'Psicólogos por sexo',
		                       'width':500,
		                       'height':500};
		
		        var chart = new google.visualization.PieChart(document.getElementById('chart_div_gender'));
		        chart.draw(data, options);
			}
			
			function drawPsicoYear(year) {
				var http = new XMLHttpRequest();
                    http.open("POST", "getUsersByYear", true);
                    http.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                    http.send("year=" + year);               
                http.onreadystatechange = function(){
                    if (http.readyState == 4 && http.status == 200) {
                        var respuesta = JSON.parse(http.responseText);
                        if (respuesta.estado){
                        	var users = respuesta.objResponse;
                        	
                            var data = google.visualization.arrayToDataTable([
								['Mes', 'Usuarios'],
								['Enero',  users[0]],
								['Febrero',  users[1]],
								['Marzo',  users[2]],
								['Abril',  users[3]],
								['Mayo',  users[4]],
								['Junio',  users[5]],
								['Julio',  users[6]],
								['Agosto',  users[7]],
								['Septiembre',  users[8]],
								['Octubre',  users[9]],
								['Noviembre',  users[10]],
								['Diciembre',  users[11]]
						  	]);
						
						  	var options = {
						    	title: 'Usuarios registrados en el año ' + year,
						    	hAxis: {title: 'Mes'},
						    	width: 800,
						    	height: 500
						  	};
						
						  	var chart = new google.visualization.ColumnChart(document.getElementById('chart_div_register'));
						
						  	chart.draw(data, options);
                        }else{
                            showNotification({message: respuesta.message, type: "error"});
                            setTimeout(closeNotification, 3000);
                        }
                    }else if (http.readyState == 4){
                        showNotification({message: "Ocurrio un error", type: "error"});
                        setTimeout(closeNotification, 3000);
                    }
                }
			}
			
		    function drawCharts() {
		    	drawGenderChart();
		    	drawPsicoYear(<?php echo $year2; ?>);
		    }
	    </script>
        <?php mysql_close($link); ?>
    </body>
</html>
