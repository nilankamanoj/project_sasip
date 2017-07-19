<?php
require_once("classes/connecter.php");
require('fpdf181/fpdf.php');
require_once("session.php");

$auth_user = new USER();
$SystemUser=Null;
$user_id = $_SESSION['user_session'];
$stmt = $auth_user->runQuery("SELECT * FROM users WHERE user_id=:user_id");
$stmt->execute(array(":user_id"=>$user_id));
$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

if (!($userRow['user_level']!='4'||$userRow['user_level']!='1') )
{
	$auth_user->redirect('home.php');
}
$db=new database();
$conn1=$db->getConn('dbclasses');
$conn2=$db->getConn('dblogin');
$result2 = $conn2->query("SELECT user_name,user_email,user_level,joining_date FROM users");

$teacher = new Teacher($userRow['user_name']);

$t_cls = $teacher->getClasses();
$date = getdate();
$date1= $date['year'].$date['mon'].$date['mday']."d";
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',15);
$pdf->Cell(90,12,'Daily Report on '.$date['year']."-".$date['mon']."-".$date['mday'],1,1);
$pdf->Ln();

foreach($t_cls as $cls) {
  $result3 = $conn1->query("SELECT identity_no,first_name,school_name FROM {$cls} WHERE {$date1}=1");
  $pdf->SetFont('Arial','B',20);
  $pdf->Cell(90,12,'Absent students of '.$cls);
  $pdf->Ln();
  $pdf->SetFont('Arial','B',12);
  $pdf->Cell(30,12,'identity_no',1);
  $pdf->Cell(30,12,'first_name',1);
  $pdf->Cell(30,12,'school_name',1);
  $no_of_ab=0;
  foreach($result3 as $row) {
		$pdf->SetFont('Arial','',12);
    $no_of_ab=$no_of_ab+1;

    $pdf->Ln();
    foreach($row as $column){
    $pdf->Cell(30,12,$column,1);
		}
  }
  $pdf->SetFont('Arial','',10);
  $pdf->Cell(90,12,'No of absent students in'.$cls."  ".$no_of_ab);
  $pdf->Ln();

}
$pdf->Output();
/*$result3 = $conn1->query("SELECT first_name FROM {$t_cls['0']} WHERE $date1=1");
$result4 = $conn1->query("SELECT free FROM {$t_cls['0']} WHERE $date1=1");


$pdf->SetFont('Arial','B',20);
$pdf->Cell(90,12,'overoll report of '.$t_cls['0']);
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('Arial','B',15);
$pdf->Cell(90,12,'absent free sudents on '.$date['year']."-".$date['mon']."-".$date['mday'],1,1);


$no_of_ab=0;
while($raw=mysqli_fetch_assoc($result3 )){
  $no_of_ab=$no_of_ab+1;
  if(mysqli_fetch_assoc($result4 )['free']=="Y"){
  $pdf->SetFont('Arial','',12);

  $pdf->Cell(0,12,$raw['first_name'],0,1);

}
}
$pdf->SetFont('Arial','B',15);
$pdf->Cell(40,12,'no of absent students:-',0,0);


$pdf->SetFont('Arial','B',15);
$pdf->Cell(40,12,"               ".$no_of_ab,0,1);
$pdf->Ln();
$pdf->Output();*/

?>
