<?php
	$m = new MongoClient();
	if($m){
		$bd= $m->prax;
		$collection = $bd->historia_clinic;
		//Añadir registro
		$document = array( "nombre" => "Prueba 2", "apellido" => "Prueba", "motivo" => "Cualquier cosa..." , "evaluacion" => 0, "Cualquier cosa...","evaluacion" => "Cualquier cosa.." , "diagnostico" => "Cualquier cosa..." , "tratamiento" => "Cualquier cosa" , "anotaciones" => "Cualquier cosa...	");
		$collection->insert($document);
			echo "Save";

			//Encontrar lo que este en la colleccion
		$cursor = $collection->find();
	}
	else{
		echo "Fail";
	}
?>




