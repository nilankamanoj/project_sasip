<?php
require_once("classes/connecter.php");
require('fpdf181/fpdf.php');
$db = new Database();
$conn1=$db->getConn('dbclasses');
$conn2=$db->getConn('dblogin');
$result1 = $conn1->query("SELECT class_name,teacher_name,hall,class_day FROM classes");
$result2 = $conn2->query("SELECT user_name,user_email,user_level,joining_date FROM users");

$pdf = new FPDF();
$pdf->AddPage();

$pdf->SetFont('Arial','B',20);
$pdf->Cell(90,12,'overoll report');
$pdf->Ln();

$pdf->SetFont('Arial','B',15);
$pdf->Cell(90,12,'classes');
$pdf->Ln();


$pdf->SetFont('Arial','B',12);
$pdf->Cell(25,12,'clas name',1);
$pdf->Cell(25,12,'teacher',1);
$pdf->Cell(25,12,'hall',1);
$pdf->Cell(25,12,'day',1);
foreach($result1 as $row) {
  $pdf->SetFont('Arial','',12);
  $pdf->Ln();
  foreach($row as $column)
  $pdf->Cell(25,12,$column,1);
}

$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('Arial','B',15);
$pdf->Cell(90,12,'users');
$pdf->Ln();
$pdf->SetFont('Arial','B',12);
$pdf->Cell(25,12,'user name',1);
$pdf->Cell(45,12,'email',1);
$pdf->Cell(25,12,'occupation',1);
$pdf->Cell(45,12,'join date/time',1);

foreach($result2 as $row) {
  $pdf->SetFont('Arial','',12);
  $pdf->Ln();
  $pdf->Cell(25,12,$row['user_name'],1);
  $pdf->Cell(45,12,$row['user_email'],1);
  $pdf->Cell(25,12,getOccupation($row['user_level']),1);
  $pdf->Cell(45,12,$row['joining_date'],1);
}

$pdf->Output();

function getOccupation($ulevel)
{
  $occ="";
  if($ulevel=='1'){
    $occ="owner";
  }
  if($ulevel=='2'){
    $occ="staff(upper)";
  }
  if($ulevel=='3'){
    $occ="staff(lower)";
  }
  if($ulevel=='4'){
    $occ="teacher";
  }
  if($ulevel=='5'){
    $occ="card marker";
  }
  return $occ;
}
?>
