<?php
require_once("session.php");
require("class.student.php");
require_once("class.user.php");
echo "pass1";
$auth_user = new USER();


$auth_user_id = $_SESSION['user_session'];

$auth_stmt = $auth_user->runQuery("SELECT * FROM users WHERE user_id=:user_id");
$auth_stmt->execute(array(":user_id"=>$auth_user_id));

$userRow=$auth_stmt->fetch(PDO::FETCH_ASSOC);
if ($userRow['user_level']!='2') {
  if ($userRow['user_level']!='3') {
  	$login->redirect('home.php');
  }
}



//$student = new Student();
$student = new Student();
if(isset($_POST['btn-signup']))
{
  $idno = strip_tags($_POST['txt_idno']);
	$fname = strip_tags($_POST['txt_fname']);
	$lname = strip_tags($_POST['txt_lname']);
	$pnum = strip_tags($_POST['txt_pnum']);
	$schname = strip_tags($_POST['txt_schname']);
  $addedby=$userRow['user_name'];

  if($idno=="")	{
		$error[] = "provide student id !";
	}
  if(strlen($idno)!=6)	{
		$error[] = "provide valid student id !";
	}
  else if(ctype_digit($idno)=="")	{
		$error[] = "provide valid student id !";
	}
	else if($fname=="")	{
		$error[] = "provide first name!";
	}
	else if($pnum=="")	{
		$error[] = "provide a phone number !";
	}
  else if(strlen($pnum)!=10){
		$error[] = "provide a valid phone number !";
	}
  else if(ctype_digit($pnum)==""){
		$error[] = "provide a valid phone number !";
	}
  else if($schname=="")	{
		$error[] = "provide school Name !";
	}
	else
	{
		try
		{
      $stmt = $student->runQuery("SELECT identity_no FROM students WHERE identity_no=:idno");
			$stmt->execute(array(':idno'=>$idno));
			$row=$stmt->fetch(PDO::FETCH_ASSOC);

			if($row['identity_no']==$idno) {
				$error[] = "sorry identity card already taken !";
      }

      			else
      			{
              $addedby=$userRow['user_name'];
      				if($student->register($idno,$fname,$lname,$pnum,$schname,$addedby)){
      					$auth_user->redirect('addStudent.php?joined');
      				}
      			}
      		}
      		catch(PDOException $e)
      		{
      			echo $e->getMessage();
      		}
      	}
      }

      ?>


      <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
      <html xmlns="http://www.w3.org/1999/xhtml">
      <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <title>Add student</title>
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
        							<li class="active"><a href="addStudent.php">Add Student</a></li>
                      <li><a href="addClass.php">Add Class</a></li>
        						<?php } ?>

        						<?php

        						if ($userRow['user_level']=='3') { ?>
        							<li class="active"><a href="addStudent.php">Add Student</a></li>
        						<?php } ?>

      	          </ul>
      	          <ul class="nav navbar-nav navbar-right">

      	            <li class="dropdown">
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
                  <h2 class="form-signin-heading">Add Student.</h2><hr />
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

                  <input type="text" class="form-control" name="txt_idno" placeholder="Enter Id Number" value="<?php if(isset($error)){echo $idno;}?>" />
                  </div>
                  <div class="form-group">
                  <input type="text" class="form-control" name="txt_fname" placeholder="Enter first Name" value="<?php if(isset($error)){echo $fname;}?>" />
                  </div>
      						<div class="form-group">
                  <input type="text" class="form-control" name="txt_lname" placeholder="Enter Last Name" value="<?php if(isset($error)){echo $lname;}?>" />
                  </div>
                  <div class="form-group">
                  <input type="text" class="form-control" name="txt_pnum" placeholder="Enter Phone Number" value="<?php if(isset($error)){echo $pnum;}?>" />
                  </div>
                  <div class="form-group">
                  <input type="text" class="form-control" name="txt_schname" placeholder="Enter School" value="<?php if(isset($error)){echo $schname;}?>" />
                  </div>

                  <div class="clearfix"></div><hr />
                  <div class="form-group">
                  	<button type="submit" class="btn btn-primary" name="btn-signup">
                      	<i class="glyphicon glyphicon-open-file"></i>&nbsp;Confirm Student
                      </button>
                  </div>
                  <br />
                  <label>want to cancel! <a href="index.php">Cancel</a></label>
              </form>
             </div>
      </div>

      </div>

      </body>
      </html>
