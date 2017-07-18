<?php
require_once("classes/connecter.php");
require_once("session.php");
// Reset to 1
$auth_user = new USER();
$auth_user_id = $_SESSION['user_session'];
$auth_stmt = $auth_user->runQuery("SELECT * FROM users WHERE user_id=:user_id");
$auth_stmt->execute(array(":user_id"=>$auth_user_id));
$userRow=$auth_stmt->fetch(PDO::FETCH_ASSOC);



if ($userRow['user_level']!='3'){
  $auth_user->redirect('home.php');
}
elseif($_POST['cls']=="NO")	{
  $error[] = "provide a class to Student !";
}
elseif (strlen($_POST['s_id'])!=6) {
  $error[] = "The student ID length must be six";
}
elseif (ctype_digit($_POST['s_id'])=="") {
  $error[] = "Input a valid ID";
}
else {
  $student = new Student();

  $rec = $student->addFee($_POST['cls'],$_POST['s_id']);

  if($rec){
    //print_r($rec);
  }
  else{
    $error[] = "This student do not exist";
  }

}





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


    <form method="post" class="form-signin">
      <h2 class="form-signin-heading">Student Entrance.</h2><hr />
      <?php
      if(isset($error))
      {
        foreach($error as $error)
        {
          ?>
          <div class="alert alert-danger">
            <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?>
          </div>
          <?php
        }
      }
      else if(isset($_GET['joined']))
      {
        ?>
        <div class="alert alert-info">
          <i class="glyphicon glyphicon-log-in"></i> &nbsp; Successfully registered <a href='index.php'>Go back</a>
        </div>
        <?php
      }
      ?>
      <div class="form-group">
        <select name=cls>
          <option value="NO">  Slect Class  </option>
          <?php
          $classs=new classs();

          $array=$classs->fetchAll();
          foreach ($array as &$class_name) {
            echo "<option value=".$class_name.">".$class_name."</option>";
          }?>
        </select><br>
       <br>
      <div class="form-group">
        <div class="form-group">
          <input type="text" class="form-control" name="s_id" placeholder="Enter student ID" />
        </div>
        <div class="clearfix"></div><hr />
        <div class="form-group">
          <button type="submit" class="btn btn-primary" name="btn-signup">
            <i class="glyphicon glyphicon-open-file"></i>&nbsp;Enter
          </button>
        </div>
        <br />

        <?php
        if(!isset($error)){
        print_r("Student ".$rec['first_name']." ".$rec['identity_no']."Paid");} ?><br><br>

        <label>want to cancel! <a href="index.php">Cancel</a></label>
      </form>
  </div>

</body>
