<?php
require_once("classes/connecter.php");
require_once("session.php");
// Reset to 1
$auth_user = new USER();
$auth_user_id = $_SESSION['user_session'];
$auth_stmt = $auth_user->runQuery("SELECT * FROM users WHERE user_id=:user_id");
$auth_stmt->execute(array(":user_id"=>$auth_user_id));
$userRow=$auth_stmt->fetch(PDO::FETCH_ASSOC);
if($_SESSION['class']!=NULL){
  $class=$_SESSION['class'];
}

if ($userRow['user_level']!='3'){
  $auth_user->redirect('home.php');
}
if(isset($_POST['btn-signup']))
{
  if($_POST['cls']=="NO")	{
    $error[] = "provide a class to Student !";
  }
  else{
    $class=$_POST['cls'];
    $_SESSION['class']=$class;
  }
}
if(isset($_POST['btn-pay']))
{
  if (strlen($_POST['s_id'])!=6) {
    $error[] = "The student ID length must be six";
  }
  elseif (ctype_digit($_POST['s_id'])=="") {
    $error[] = "Input a valid ID";
  }
  else {
    $student = new Student();

    $rec = $student->addFee($class,$_POST['s_id']);

    if($rec){

    }
    else{
      $error[] = "This student do not exist";
    }

  }
}
else if(isset($_POST['btn-another']))
{
  $_SESSION['class']=NULL;
  $auth_user->redirect('classFees.php');



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
  <nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="home.php">Home</a>
      </div>
      <div id="navbar" class="navbar-collapse collapse">
        <ul class="nav navbar-nav">
          <li><a href="home.php">Home</a></li>
          <li><a href="profile.php">Profile</a></li>
          <li><a href="addStudent.php">Add Student</a></li>
          <li class="active"><a href="classFees.php">class fees</a></li>


        </ul>
        <ul class="nav navbar-nav navbar-right">

          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
              <span class="glyphicon glyphicon-user"></span>&nbsp;Hi' <?php echo $userRow['user_email']; ?>&nbsp;<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="profile.php"><span class="glyphicon glyphicon-user"></span>&nbsp;View Profile</a></li>
                <li><a href="changePass.php"><span class="glyphicon glyphicon-user"></span>&nbsp;Change Password</a></li>
                <li><a href="logout.php?logout=true"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Sign Out</a></li>

              </ul>
            </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
    <div class="signin-form">
      <div class="container">

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
          if(!isset($class))
          {
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
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-primary" name="btn-signup">
                <i class="glyphicon glyphicon-open-file"></i>&nbsp;Select Class
              </button>
            </div>
            <?php }
            ?>
            <?php if(isset($class))
            {?>
              <label>Fees Paying For <?php echo $class; ?></label>
              <br>
              <div class="form-group">
                <div class="form-group">
                  <input type="text" class="form-control" name="s_id" placeholder="Enter student ID" />
                </div>
                <div class="clearfix"></div><hr />
                <div class="form-group">
                  <button type="submit" class="btn btn-primary" name="btn-pay">
                    <i class="glyphicon glyphicon-open-file"></i>&nbsp;Pay Fee
                  </button>
                  <button  type="submit" background-color=#ffff00 name="btn-another">
                    <i class=""></i>&nbsp;End/ Submit finish
                  </button>
                </div>
                <br />
                <?php } ?>
                <?php
                if(!isset($error)){
                  if($rec['first_name']){
                    print_r("Student ".$rec['first_name']." ".$rec['identity_no']."Paid");}} ?><br><br>

                    <label>want to cancel! <a href="index.php">Cancel</a></label>
                  </form>
                </div>
                <script src="bootstrap/js/bootstrap.min.js"></script>
              </body>
