<?php
require_once("classes/connecter.php");
session_start();
// Reset to 1
if(isset($_POST['reset'])){unset($_SESSION['number']);}

// Set or increment session number only if button is clicked.
if(empty($_SESSION['number'])){
    $_SESSION['number']=1;
}elseif(isset($_POST['next'])){
    $_SESSION['number']++;
}
elseif(isset($_POST['pre'])){
    $_SESSION['number']--;
}


$con = mysqli_connect('localhost','newuser','password','dbclasses');
$sql = "SELECT * FROM physics17 WHERE id = {$_SESSION['number']}";
$result = mysqli_query($con,$sql);
$record = mysqli_fetch_assoc($result);


//print_r($_POST);
echo $record["first_name"];

//if($con){echo $result}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
	<script type="text/javascript" src="jquery-1.11.3-jquery.min.js"></script>
	<link rel="stylesheet" href="style.css" type="text/css"  />
	<title>welcome - <?php print($userRow['user_email']); ?></title>
</head>
<body>


  <div class="form-group">
    <h1>select a class <br>
    <select name=cls>
      <option value="NO">  Slect Class  </option>
      <?php
      $classs=new classs();

      $array=$classs->fetchAll();
      foreach ($array as &$class_name) {
        echo "<option value=".$class_name.">".$class_name."</option>";
      }?>
    </select><br>
    <form action="" method="POST">
       <input type="submit" name="select" value="Select" id="btn_a" />
    </form>
  </div>

  <form action="" method="POST">
     <input class="big_b" type="submit" name="next" value="Next" id="btn_s" />
     <input class="big_b" type="submit" name="pre" value="Previous" id="btn_p" />
     <input type="submit" name="reset" value="Reset" id="btn_i" />
  </form>


</body>
