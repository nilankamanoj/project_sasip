<?php
require_once("classes/connecter.php");
require('fpdf181/fpdf.php');
$db = new Database();
$conn1=$db->getConn('dbclasses');
$result1 = $conn1->query("SELECT class_name,teacher_name,hall FROM classes");
$pdf = new FPDF();
$pdf->AddPage();

foreach($result1 as $row) {
	$pdf->SetFont('Arial','',12);
	$pdf->Ln();
	foreach($row as $column)
		$pdf->Cell(20,12,$column,1);
}
$pdf->Output();
?>
