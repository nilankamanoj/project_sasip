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


 $teacher = new Teacher($userRow['user_name']);
 $t_cls = $teacher->getClasses();

 $m=date("Y",strtotime("last month")).intval(date("m",strtotime("last month")))."m";
 $mon=date("Y-m",strtotime("last month"));

 $pdf = new FPDF();
 $pdf->AddPage();
 $pdf->SetFont('Arial','B',15);
 $pdf->Cell(90,12,' Report on '.$mon,1,1);
 $pdf->Ln();

 foreach($t_cls as $cls) {
   $result3 = $conn1->query("SELECT identity_no,first_name,school_name FROM $cls WHERE $m=1");
   $pdf->SetFont('Arial','B',20);
   $pdf->Cell(90,12,'fees paid in '.$cls);
   $pdf->Ln();
   $pdf->SetFont('Arial','B',12);
   $pdf->Cell(30,12,'identity_no',1);
   $pdf->Cell(30,12,'first_name',1);
   $pdf->Cell(30,12,'school_name',1);
   $no_of_ab=0;
   foreach($result3 as $row) {
     $no_of_ab=$no_of_ab+1;
     $pdf->SetFont('Arial','',12);
     $pdf->Ln();
     foreach($row as $column)
     $pdf->Cell(30,12,$column,1);
   }
   $pdf->SetFont('Arial','',10);
   $pdf->Cell(90,12,'No of fees paid'.$cls."  ".$no_of_ab);
   $pdf->Ln();

 }


foreach($t_cls as $cls){
 $stmt=$conn1->query("SELECT joining_date FROM $cls ");
 $array = Array();

 while($result = $stmt->fetch_assoc())
 {
   $array[] = $result['joining_date'];
 }
$count=0;
 foreach($array as $ow){
    if(date("m",strtotime($ow))== date("m",strtotime("last month"))){
      $count=$count+1;
    }

}

$pdf->SetFont('Arial','',10);
$pdf->Cell(90,12,'No of new registrations '.$cls."  ".$count);
$pdf->Ln();
}

$pdf->Output();
 ?>
