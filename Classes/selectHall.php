<?php
require_once("session.php");
require('class.class.php');
require_once("class.user.php");
$auth_user = new USER();
$clsname="";
$clsname=$_SESSION['class_name'];

$auth_user_id = $_SESSION['user_session'];

$auth_stmt = $auth_user->runQuery("SELECT * FROM users WHERE user_id=:user_id");
$auth_stmt->execute(array(":user_id"=>$auth_user_id));

$userRow=$auth_stmt->fetch(PDO::FETCH_ASSOC);
if ($userRow['user_level']!='2') {
	$auth_user->redirect('home.php');
}
if ($userRow['user_level']=='2') {
	if($clsname=="") {
    $auth_user->redirect('home.php');
  }
}



$cls=new Classs();
$user = new USER();
$row=$cls->fetchClass($clsname);
if(isset($_POST['btn-delete']))
{
  //echo "<td><a onClick=\"javascript: return confirm('Please confirm deletion');\" href='delete.php?id=".$query2['id']."'>x</a></td><tr>";
  $_SESSION['class_name']="";
  $clsname="";
  $auth_user->redirect("home.php");
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Book hall</title>
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
<link rel="stylesheet" href="style.css" type="text/css"  />
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

							<?php

							if ($userRow['user_level']=='2') { ?>
								<li><a href="sign-up.php">Add user</a></li>
							<?php } ?>
							<?php

							if ($userRow['user_level']=='2') { ?>
								<li><a href="addStudent.php">Add Student</a></li>
                <li class="active"><a href="addClass.php">Add Class</a></li>
							<?php } ?>


	          </ul>
	          <ul class="nav navbar-nav navbar-right">

	            <li class="dropdown">
								<?php  ?>
	              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
				  <span class="glyphicon glyphicon-user"></span>&nbsp;Hi' <?php echo $userRow['user_email']; ?>&nbsp;<span class="caret"></span></a>
	              <ul class="dropdown-menu">
	                <li><a href="profile.php"><span class="glyphicon glyphicon-user"></span>&nbsp;View Profile</a></li>
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
          <?php if($clsname=="") {?>
            <h2 class="form-signin-heading">Book Hall.</h2><hr />
          <?php } else{?>
            <h2 class="form-signin-heading">Select Hall.</h2><hr />
            <?php } ?>
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
                      <i class="glyphicon glyphicon-log-in"></i> &nbsp; Successfully added class<a href='index.php'>Go back</a>
                 </div>
                 <?php
			}
			?>
      <p><font color=#505fff >Class Name :</font> <?php print($row['class_name']) ;?></p>
      <br>
      <div class="form-group">
        <select name="hall">
        <option value="NO">Chose Hall Below</option>
        <option value="11">level-1-a</option>
        <option value="12">level-1-b</option>
        <option value="13">level-1-c</option>
        <option value="14">level-1-d</option>
        <option value="21">level-2-a</option>
        <option value="22">level-2-b</option>
        <option value="23">level-2-c</option>


n>
        </select><br>

      </div>
      <div class="clearfix"></div><hr />
      <div class="form-group">
        <button type="submit" class="btn btn-primary" name="btn-check">
            <i class="glyphicon glyphicon-open-file"></i>&nbsp;Proceed
          </button>
          <?php if($clsname=="") {?>
          <button type="submit" class="" name="btn-cancel">

              <i class="glyphicon glyphicon-open-file"></i>&nbsp;Cancell Booking
              <?php }else{ ?>
                <button type="submit" class="" name="btn-delete">
                <i class="glyphicon glyphicon-open-file"></i>&nbsp;Cancell New Creation
                <?php } ?>
            </button>
      </div>

            <br />
            <?php if($clsname=="") {?>
            <label>want to cancel! <a href="index.php">Cancel</a></label>
            <?php } ?>
        </form>
       </div>
</div>

</div>

</body>
</html>
