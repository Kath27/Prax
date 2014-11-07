<?php
	include('config.php');
	include('config_mongo.php');
    session_start();
    if (!isset($_SESSION["userId"])){ header('Location: /'); }
	
	$id_admin = ($_SESSION["rol"] == "admin")? "a" : "p";
	$id_admin .= $_SESSION["userId"];
	
	$sql = "SELECT documento, nombre, apellido, fechnac, ubicacion, tel_fijo, tel_movil, ctagmail, sexo, fecha_crea, fecha_mod, ciudad FROM prax.paciente";
    if($_SESSION["rol"]=="psico"){
    	
        $sql.=" WHERE id_adminpsic='".$_SESSION["userId"]."'";
    }
	
    $pacientes = mysql_query($sql,$link)or die(exit(mysql_error($link)));
	
	$totalPaci = mysql_num_rows($pacientes);
	$paciM = 0;
	$paciF = 0;
	$paciN = 0;
	
	$historia = getHistoriasTotales($id_admin);
	$anotaciones = getAnotacionesTotales($id_admin);
	
	$historiaClinica = array(0,0,0,0,0,0,0);
	$ciudades = array();
	
	while ($list = mysql_fetch_array(($pacientes))){
		if ($list[8] == "M") $paciM++; else if ($list[8] == "F") $paciF++; else $paciN++;
		
		foreach ($historia as $h){
			if ($h->{"id_paciente"} == $list[0]){
				if (($h->{"motivo"}) != "") $historiaClinica[0] += 1;
		        if (($h->{"evaluacionMedico"}) != "") $historiaClinica[1] += 1;
		        if (($h->{"evaluacionFami"}) != "") $historiaClinica[2] += 1;
		        if (($h->{"evaluacionPsico"}) != "") $historiaClinica[3] += 1;
		        if (($h->{"evaluacionNeuro"}) != "") $historiaClinica[4] += 1;
		        if (($h->{"diagnostico"}) != "") $historiaClinica[5] += 1;
		        if (($h->{"tratamiento"}) != "") $historiaClinica[6] += 1;
			}
		}
		
		$added = false;
		foreach ($ciudades as $c){
			if ($c->{"name"} == $list[11]){
				$c->{"amount"} += 1;
				$added = true;
			}
		}
		
		if (!$added){
			$c = new stdClass();
			$c->{"name"} = $list[11];
			$c->{"amount"} = 1;
			
			$ciudades[sizeof($ciudades)] = $c;
		}
	}
?>
<!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Reporte pacientes</title>
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
            	<h3>Reporte de pacientes</h3>
            	<div>
            		<table>
            			<?php $promANot = round((sizeof($anotaciones) / $totalPaci) * 100) / 100; ?>
	            		<tr><td style="width: 200px;"><strong>Pacientes activados:</strong></td><td> <?php echo $totalPaci; ?></td></tr>
	            		<tr><td><strong>Cantidad de anotaciones:</strong></td><td> <?php echo sizeof($anotaciones); ?></td></tr>
	            		<tr><td><strong>Promedio de anotaciones:</strong></td><td> <?php echo $promANot; ?></td></tr>
            		</table>
        		</div>
            	<div id="chart_div_gender" style="display: inline-block; width: 500px; vertical-align: top;"></div>
            	<div id="chart_div_register" style="display: inline-block; width: 800px; vertical-align: top;"></div>
            	<div><h3>Pacientes por ciudad</h3></div>
            	<div class="CSSTableGenerator">
            		<table>
            			<tr>
            				<td style="width: 50%">Ciudad</td>
            				<td style="width: 25%">Cantidad</td>
            				<td style="width: 25%">Porcentaje</td>
            			</tr>
            			
            			<?php foreach ($ciudades as $c){ ?>
            				<?php
            					$per = ($c->{"amount"} / $totalPaci * 100);
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
		          ['Hombres', <?php echo $paciM; ?>],
		          ['Mujeres', <?php echo $paciF; ?>],
		          ['No especificado', <?php echo $paciN; ?>]
		        ]);
		
		        var options = {'title':'Pacientes por sexo',
		                       'width':500,
		                       'height':300};
		
		        var chart = new google.visualization.PieChart(document.getElementById('chart_div_gender'));
		        chart.draw(data, options);
			}
			
			function drawPaciHistoria() {
                var data = google.visualization.arrayToDataTable([
					['Historías clínicas', 'Usuarios'],
					['Motivos de consulta',  <?php echo $historiaClinica[0]; ?>],
					['Evaluación medica', <?php echo $historiaClinica[1]; ?>],
					['Evaluación familiar',  <?php echo $historiaClinica[2]; ?>],
					['Evaluación psicológica',  <?php echo $historiaClinica[3]; ?>],
					['Evaluación neuropsicológica',  <?php echo $historiaClinica[4]; ?>],
					['Diagnóstico',  <?php echo $historiaClinica[5]; ?>],
					['Tratamiento',  <?php echo $historiaClinica[6]; ?>]
			  	]);
			
			  	var options = {
			    	title: '¿Que elementos se han desarrollado en las historias clínicas?',
			    	hAxis: {title: 'Historías clínicas'},
			    	width: 800,
			    	height: 500
			  	};
			
			  	var chart = new google.visualization.ColumnChart(document.getElementById('chart_div_register'));
			
			  	chart.draw(data, options);
			}
			
		    function drawCharts() {
		    	drawGenderChart();
		    	drawPaciHistoria();
		    }
	    </script>
        <?php mysql_close($link); ?>
    </body>
</html>
