<?php
include("../../config.php");
include("../../config_mongo.php");
include("../../utilidades.php");
session_start();
if (!isset($_SESSION["userId"])) header('Location: /');
if($_SESSION["isActive"]=="F"){ header('Location: '.'/userInactivo'); exit; }

$id_paciente = $_GET["paciente"];
$sql = "SELECT nombre, apellido, documento, fechnac, ubicacion, tel_fijo, tel_movil, ctagmail, id_paciente FROM prax.paciente WHERE documento='" . $id_paciente . "' ";
if($_SESSION["rol"]=="psico"){
    $sql.=" AND id_adminpsic='".$_SESSION["userId"]."'";
}else if($_SESSION["rol"]=="admin"){
    $sql.=" AND id_admin='".$_SESSION["userId"]."'";
}
$result = mysql_query($sql, $link) or die(imprimir_respuesta(false,mysql_error($link),"ErrorMysql"));
if (mysql_num_rows($result) == 0) header('Location: /');
$paciente = mysql_fetch_row($result);
$idP = $paciente[8];

$sql = "SELECT pc.nombre, pc.apellido, pc.documento, pc.fechnac, pc.ubicacion, pc.tel_fijo, pc.tel_movil, pc.ctagmail, tr.descripcion" . 
	" FROM prax.paciente_contac pc " .
	" LEFT JOIN tipo_relacion tr ON tr.idtipo_relacion=pc.tipo_relacion " .
	" WHERE id_paciente=" . $idP . "";
$result = mysql_query($sql, $link) or die(imprimir_respuesta(false,mysql_error($link),"ErrorMysql"));
$contacto = array("","","","","","","","","");
if (mysql_num_rows($result) > 0) $contacto = mysql_fetch_row($result);

$id_admin = ($_SESSION["rol"] == "admin")? "a" : "p";
$id_admin .= $_SESSION["userId"];

$historia = getHistoriaClinica($id_paciente, $id_admin);
$historia = $historia[0];

$anotaciones = getAnotaciones($id_paciente, $id_admin);

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: Removing Header and Footer
 * @author Nicola Asuni
 * @since 2008-03-04
 */

// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');

class MYPDF extends TCPDF {
	public function Header() {
        $image_file = K_PATH_IMAGES.'logo_example.jpg';
        $this->Image('images/logo.png', PDF_MARGIN_LEFT, 5, 36, 15, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        $this->SetFont('helvetica', '', 10);
        $this->Cell(0, 15, 'Página: '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'M', 'M');
    }
	
    public function Footer() {
        $this->SetY(-15);
        $this->SetFont('helvetica', '', 10);
        $this->Cell(0, 10, 'Información Confidencial', 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('QTAG Technologies');
$pdf->SetTitle('Historia Clinica');
$pdf->SetSubject('Historia Clinica del paciente');
$pdf->SetKeywords('Historia, Clinica, Paciente, Prax');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('dejavusans', '', 14, '', true);

// add a page
$pdf->AddPage();
//$pdf->Image('images/prax.png', PDF_MARGIN_LEFT, 5, 48, 20, 'PNG', '', '', false, 150, '', false, false, 0, false, false, false);

// Titulo
$pdf->Ln(10);
$txTitulo=<<<EOD
Historia Clinica Psicologica
EOD;
$pdf->setFontSize(20);
$pdf->SetFillColor(176, 176, 176);
$pdf->Cell(0, 0, $txTitulo, 0, 1, 'L', 0, '', 0);	
$pdf->Ln(1);

$noFoundMSG = "Sin información disponible";

$nombre = $paciente[0]." ".$paciente[1];
if (trim($nombre) == "") $nombre = $noFoundMSG;
// Nombre
$txtNombre=<<<EOD
$nombre
EOD;
$pdf->setFontSize(24);
$pdf->SetFillColor(176, 176, 176);
$pdf->Cell(0, 0, $txtNombre, 0, 1, 'L', 0, '', 0);	
$pdf->Ln(1);

// Creado el #fecha
date_default_timezone_set('America/Lima');
$fecha = date("Y-m-d H:i:s");
$txtFecha=<<<EOD
Descargado el $fecha
EOD;
$pdf->setFontSize(11);
$pdf->SetFillColor(176, 176, 176);
$pdf->Cell(0, 0, $txtFecha, 0, 1, 'L', 0, '', 0);	
$pdf->Ln(25);

// Datos de identificación
$txtLabel=<<<EOD
1. Datos de identificación
EOD;
$pdf->SetFillColor(176, 176, 176);
$pdf->MultiCell(180, 0, $txtLabel, 0, 'L', 1, 0, '', '', true, 0, false, true, 0);
$pdf->Ln(10);

$documento = (trim($paciente[2]) == "")? $noFoundMSG : $paciente[2];
$fechaNac = (trim($paciente[3]) == "")? $noFoundMSG : $paciente[3];
$dirPacien = (trim($paciente[4]) == "")? $noFoundMSG : $paciente[4];
$telFijo = (trim($paciente[5]) == "")? $noFoundMSG : $paciente[5];
$telCel = (trim($paciente[6]) == "")? $noFoundMSG : $paciente[6];
$email = (trim($paciente[7]) == "")? $noFoundMSG : $paciente[7];

$table = "<table width=\"100%\" border=\"1\" cellpadding=\"8\">" .
		"<tr>" .
			"<td width=\"50%\">Documento de identidad</td>" .
			"<td width=\"50%\">$documento</td>" .
		"</tr>" .  
		
		"<tr>" .
			"<td width=\"50%\">Nombre</td>" .
			"<td width=\"50%\">$nombre</td>" .
		"</tr>" . 
		
		"<tr>" .
			"<td width=\"50%\">Fecha de nacimiento</td>" .
			"<td width=\"50%\">$fechaNac</td>" .
		"</tr>" .
		
		"<tr>" .
			"<td width=\"50%\">Dirección del paciente</td>" .
			"<td width=\"50%\">$dirPacien</td>" .
		"</tr>" . 
		
		"<tr>" .
			"<td width=\"50%\">Teléfono fijo</td>" .
			"<td width=\"50%\">$telFijo</td>" .
		"</tr>" .
		
		"<tr>" .
			"<td width=\"50%\">Teléfono movil</td>" .
			"<td width=\"50%\">$telCel</td>" .
		"</tr>" .
		
		"<tr>" .
			"<td width=\"50%\">Email</td>" .
			"<td width=\"50%\">$email</td>" .
		"</tr>" .
	"</table>";

$txtIden=<<<EOD
$table
EOD;
$pdf->setFontSize(12);
$pdf->SetFillColor(176, 176, 176);
$pdf->writeHTML($txtIden, true, false, false, false, L);

// Datos de persona de contacto
$txtDatosContacto=<<<EOD
Datos de persona de contacto
EOD;
$pdf->SetFillColor(176, 176, 176);
$pdf->Cell(0, 0, $txtDatosContacto, 0, 1, 'L', 0, '', 0);
$pdf->Ln(5);	

$nombre = $contacto[0]." ".$contacto[1];
if (trim($nombre) == "") $nombre = $noFoundMSG;
$documento = (trim($contacto[2]) == "")? $noFoundMSG : $contacto[2];
$fechaNac = (trim($contacto[3]) == "")? $noFoundMSG : $contacto[3];
$dirPacien = (trim($contacto[4]) == "")? $noFoundMSG : $contacto[4];
$telFijo = (trim($contacto[5]) == "")? $noFoundMSG : $contacto[5];
$telCel = (trim($contacto[6]) == "")? $noFoundMSG : $contacto[6];
$email = (trim($contacto[7]) == "")? $noFoundMSG : $contacto[7];
$relacion = (trim($contacto[8]) == "")? $noFoundMSG : $contacto[8];

$table = "<table width=\"100%\" border=\"1\" cellpadding=\"8\">" .
		"<tr>" .
			"<td width=\"50%\">Documento de identidad</td>" .
			"<td width=\"50%\">$documento</td>" .
		"</tr>" .  
		
		"<tr>" .
			"<td width=\"50%\">Nombre</td>" .
			"<td width=\"50%\">$nombre</td>" .
		"</tr>" . 
		
		"<tr>" .
			"<td width=\"50%\">Fecha de nacimiento</td>" .
			"<td width=\"50%\">$fechaNac</td>" .
		"</tr>" .
		
		"<tr>" .
			"<td width=\"50%\">Dirección del contacto</td>" .
			"<td width=\"50%\">$dirPacien</td>" .
		"</tr>" . 
		
		"<tr>" .
			"<td width=\"50%\">Teléfono fijo</td>" .
			"<td width=\"50%\">$telFijo</td>" .
		"</tr>" .
		
		"<tr>" .
			"<td width=\"50%\">Teléfono movil</td>" .
			"<td width=\"50%\">$telCel</td>" .
		"</tr>" .
		
		"<tr>" .
			"<td width=\"50%\">Email</td>" .
			"<td width=\"50%\">$email</td>" .
		"</tr>" .
		
		"<tr>" .
			"<td width=\"50%\">Tipo de relación</td>" .
			"<td width=\"50%\">$relacion</td>" .
		"</tr>" .
	"</table>";

$txtIden=<<<EOD
$table
EOD;
$pdf->setFontSize(12);
$pdf->SetFillColor(176, 176, 176);
//$pdf->writeHTMLCell(180, 0, PDF_MARGIN_LEFT, 185, $txtIden, 0, 'L');
$pdf->writeHTML($txtIden, true, false, false, false, L);
$pdf->Ln(5);

// Blank
$blank=<<<EOD

EOD;
$pdf->SetFillColor(176, 176, 176);
$pdf->Cell(180, 0, $blank, 0, 'L', 1, 0, '', '', true, 0, false, true, 0);
$pdf->Ln(10);

// Motivo de consulta
$txtMotivoC=<<<EOD
2. Motivo de consulta
EOD;
$pdf->SetFillColor(176, 176, 176);
$pdf->MultiCell(180, 0, $txtMotivoC, 0, 'L', 1, 0, '', '', true, 0, false, true, 0);
$pdf->Ln(10);

$motivo = $historia->{"motivo"};
if (trim($motivo) == "") $motivo = $noFoundMSG;
$table = "<table width=\"100%\" border=\"1\" cellpadding=\"8\">" .
		"<tr>" .
			"<td>$motivo</td>" .
		"</tr>" .  
	"</table>";

$txtIden=<<<EOD
$table
EOD;
$pdf->setFontSize(12);
$pdf->SetFillColor(176, 176, 176);
$pdf->writeHTML($txtIden, true, false, false, false, L);

// Evaluaciones
$txtMotivoC=<<<EOD
3. Evaluaciones
EOD;
$pdf->setFontSize(11);
$pdf->SetFillColor(176, 176, 176);
$pdf->MultiCell(180, 0, $txtMotivoC, 0, 'L', 1, 0, '', '', true, 0, false, true, 0);
$pdf->Ln(10);

$evaluacionMedico = $historia->{"evaluacionMedico"};
$evaluacionFami = $historia->{"evaluacionFami"};
$evaluacionPsico = $historia->{"evaluacionPsico"};
$evaluacionNeuro = $historia->{"evaluacionNeuro"};

if (trim($evaluacionMedico) == "") $evaluacionMedico = $noFoundMSG;
if (trim($evaluacionFami) == "") $evaluacionFami = $noFoundMSG;
if (trim($evaluacionPsico) == "") $evaluacionPsico = $noFoundMSG;
if (trim($evaluacionNeuro) == "") $evaluacionNeuro = $noFoundMSG;

$table = "<table width=\"100%\" border=\"1\" cellpadding=\"8\">" .
		"<tr>" .
			"<td width=\"50%\">Aspectos médicos</td>" .
			"<td width=\"50%\">$evaluacionMedico</td>" .
		"</tr>" .  
		
		"<tr>" .
			"<td width=\"50%\">Aspectos familiares</td>" .
			"<td width=\"50%\">$evaluacionFami</td>" .
		"</tr>" .  
		
		"<tr>" .
			"<td width=\"50%\">Aspectos psicologicos</td>" .
			"<td width=\"50%\">$evaluacionPsico</td>" .
		"</tr>" .  
		
		"<tr>" .
			"<td width=\"50%\">Aspectos neuropsicológicos</td>" .
			"<td width=\"50%\">$evaluacionNeuro</td>" .
		"</tr>" .  
	"</table>";

$txtIden=<<<EOD
$table
EOD;
$pdf->setFontSize(12);
$pdf->SetFillColor(176, 176, 176);
$pdf->writeHTML($txtIden, true, false, false, false, L);

// Diagnostico
$txtMotivoC=<<<EOD
4. Diagnóstico
EOD;
$pdf->setFontSize(11);
$pdf->SetFillColor(176, 176, 176);
$pdf->MultiCell(180, 0, $txtMotivoC, 0, 'L', 1, 0, '', '', true, 0, false, true, 0);
$pdf->Ln(10);

$diagnostico = $historia->{"diagnostico"};
if (trim($diagnostico) == "") $diagnostico = $noFoundMSG;

$table = "<table width=\"100%\" border=\"1\" cellpadding=\"8\">" .
		"<tr>" .
			"<td>$diagnostico</td>" .
		"</tr>" .  
	"</table>";

$txtIden=<<<EOD
$table
EOD;
$pdf->setFontSize(12);
$pdf->SetFillColor(176, 176, 176);
$pdf->writeHTML($txtIden, true, false, false, false, L);

// Tratamiento
$txtMotivoC=<<<EOD
5. Tratamiento
EOD;
$pdf->setFontSize(11);
$pdf->SetFillColor(176, 176, 176);
$pdf->MultiCell(180, 0, $txtMotivoC, 0, 'L', 1, 0, '', '', true, 0, false, true, 0);
$pdf->Ln(10);

$tratamiento = $historia->{"tratamiento"};
if (trim($tratamiento) == "") $tratamiento = $noFoundMSG;

$table = "<table width=\"100%\" border=\"1\" cellpadding=\"8\">" .
		"<tr>" .
			"<td>$tratamiento</td>" .
		"</tr>" .  
	"</table>";

$txtIden=<<<EOD
$table
EOD;
$pdf->setFontSize(12);
$pdf->SetFillColor(176, 176, 176);
$pdf->writeHTML($txtIden, true, false, false, false, L);


// Anotaciones
$txtMotivoC=<<<EOD
6. Anotaciones
EOD;
$pdf->setFontSize(11);
$pdf->SetFillColor(176, 176, 176);
$pdf->MultiCell(180, 0, $txtMotivoC, 0, 'L', 1, 0, '', '', true, 0, false, true, 0);
$pdf->Ln(10);


$table = '<table width="100%" border="1" cellpadding="8">' . 
    '<tr>' .
        '<td style="width: 50%">Anotación</td>' .
        '<td style="width: 25%">Creación</td>' .
        '<td style="width: 25%">Ult. modificación</td>' .
    '</tr>';
        foreach ($anotaciones as $anotacion){
        	$anot = $anotacion->{"anotacion"};
			$fechC = $anotacion->{"fecha_creac"};
			$fechM = $anotacion->{"fecha_mod"};

			if (trim($anot) == "") $anot = $noFoundMSG;
			if (trim($fechC) == "") $fechC = $noFoundMSG;
			if (trim($fechM) == "") $fechM = $noFoundMSG;

            $table .= '<tr>' . 
                '<td style="width: 50%">' . $anot. '</td>' . 
                '<td style="width: 25%">' . $fechC . '</td>' .
                '<td style="width: 25%">' . $fechM . '</td>' .
            '</tr>';
        }
$table .= '</table>';

$txtIden=<<<EOD
$table
EOD;
$pdf->setFontSize(12);
$pdf->SetFillColor(176, 176, 176);
$pdf->writeHTML($txtIden, true, false, false, false, L);


// ---------------------------------------------------------
$pdf->lastPage();
//Close and output PDF document
$pdf->Output('Historia clínica de ' . $id_paciente . ' Prax Assis ' . $fecha . '.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
mysql_close($link);
?>