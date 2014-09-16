<?php
include("../../config.php");
include("../../config_mongo.php");

$sql = "SELECT nombre, apellido FROM prax.paciente";
$result = mysql_query($sql, $link) or die(imprimir_respuesta(false,mysql_error($link),"ErrorMysql"));
$paciente = mysql_fetch_row($result);

$result = mysql_query("SELECT descripcion FROM prax.evaluacion", $link)or die(imprimir_respuesta(false,mysql_error($link),"ErrorMysql"));
$evaluacion = utf8_encode(mysql_fetch_row($result)[0]); 

$historia = getHistoriaClinica()[0];

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: Removing Header and Footer
 * @author Nicola Asuni
 * @since 2008-03-04
 */

// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 002');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

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
$pdf->Image('images/logo45.png', 150, 5, 40, 20, 'PNG', '', '', false, 150, '', false, false, 1, false, false, false);

// Titulo
$txTitulo=<<<EOD
Historia Clinica
EOD;
$pdf->SetFillColor(176, 176, 176);
$pdf->Cell(0, 0, $txTitulo, 0, 1, 'C', 0, '', 0);	
$pdf->Ln(53);

// Imagen paciente
$pdf->Image('images/avatar-def.jpg', 80, 35, 50, 50, 'JPG', '', '', false, 150, '', false, false, 0, false, false, false);
$pdf->Ln(15);

// Nombre
$txtNobre=<<<EOD
Nombre: $paciente[0]
EOD;
$pdf->SetFillColor(176, 176, 176);
$pdf->MultiCell(180, 0, $txtNobre, 0, 'L', 1, 0, '', '', true, 0, false, true, 0);
$pdf->Ln(10);

// Apellido
$txtApellido=<<<EOD
Apellido: $paciente[1]
EOD;
$pdf->SetFillColor(176, 176, 176);
$pdf->MultiCell(180, 0, $txtApellido, 0, 'L', 1, 0, '', '', true, 0, false, true, 0);
$pdf->Ln(10);

// Motivo consulta
$motivo = $historia->{"motivo"};
$txtMotivo_consulta=<<<EOD
Motivo de consulta: $motivo
EOD;
$numL = $pdf->getStringHeight(180, $txtMotivo_consulta);
$pdf->SetFillColor(176, 176, 176);
$pdf->MultiCell(180, 0, $txtMotivo_consulta, 0, 'L', 1, 0, '', '', true, 0, false, true, 0);
$pdf->Ln($numL + 4);

// Evaluacion
$txtEvaluacion=<<<EOD
Evaluacion: $evaluacion 
EOD;
$pdf->SetFillColor(176, 176, 176);
$pdf->MultiCell(180, 0, $txtEvaluacion, 0, 'L', 1, 0, '', '', true, 0, false, true, 0);
$pdf->Ln(10);

//Diagnostico
$diagnostico = $historia->{"diagnostico"};
$txtDiagnostico=<<<EOD
Diagnostico: $diagnostico 
EOD;
$numL = $pdf->getStringHeight(180, $txtDiagnostico);
$pdf->SetFillColor(176, 176, 176);
$pdf->MultiCell(180, 0, $txtDiagnostico, 0, 'L', 1, 0, '', '', true, 0, false, true, 0);
$pdf->Ln($numL + 4);

//Tratamiento
$tratamiento = $historia->{"tratamiento"};
$txtTratamiento=<<<EOD
Tratamiento: $tratamiento 
EOD;
// Hace salto de linea y sin importar el tamaño del texto concerva las margenes
$numL = $pdf->getStringHeight(180, $txtTratamiento);
$pdf->SetFillColor(176, 176, 176);
$pdf->MultiCell(180, 0, $txtTratamiento, 0, 'L', 1, 0, '', '', true, 0, false, true, 0);
$pdf->Ln($numL + 4);


//Anotaciones
$anotaciones = $historia->{"anotaciones"};
$txtAnotaciones=<<<EOD
Anotaciones: $anotaciones   
EOD;
$numL = $pdf->getStringHeight(180, $txtAnotaciones);
$pdf->SetFillColor(176, 176, 176);
$pdf->MultiCell(180, 0, $txtAnotaciones, 0, 'L', 1, 0, '', '', true, 0, false, true, 0);
$pdf->Ln($numL + 4);




// print a block of text using Write()
/*$pdf->Write(0, $txtNobre, '', 0, 'A', true, 0, false, false, 0);
$pdf->Write(0, $txtApellido, '', 0, 'A', true, 0, false, false, 0);
$pdf->Write(0, $txtMotivo_consulta, '', 0, 'A', true, 0, false, false, 0);
$pdf->Write(0, $txtEvaluacion, '', 0, 'A', true, 0, false, false, 0);
$pdf->Write(0, $txtDiagnostico, '', 0, 'A', true, 0, false, false, 0);
$pdf->Write(0, $txtTratamiento, '', 0, 'A', true, 0, false, false, 0);
$pdf->Write(0, $txtAnotaciones, '', 0, 'A', true, 0, false, false, 0);*/

// ---------------------------------------------------------
$pdf->lastPage();
//Close and output PDF document
$pdf->Output('example_002.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
mysql_close($link);
?>