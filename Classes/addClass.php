<?php

require_once("session.php");
require_once("classes/connecter.php");

$auth_user = new USER();
$auth_user_id = $_SESSION['user_session'];
$auth_stmt = $auth_user->runQuery("SELECT * FROM users WHERE user_id=:user_id");
$auth_stmt->execute(array(":user_id"=>$auth_user_id));
$userRow=$auth_stmt->fetch(PDO::FETCH_ASSOC);


if ($userRow['user_level']!='2')
{
	$auth_user->redirect('home.php');
}


$cls=new Classs();
$user = new USER();
$clz="";


if(isset($_POST['btn-signup']))
{
	$name = strip_tags($_POST['txt_name']);
	$teacher=$_POST['teacher'];
	$day=$_POST['week_day'];
	$hour=$_POST['hour'];
	$minit=$_POST['minit'];
	$duration=$_POST['duration'];


	if($day=="NO")
	{
		$error[] = "provide day !";
	}
	else if($hour=="NO")
	{
		$error[] = "provide hour !";
	}
	else if($minit=="NO")
	{
		$error[] = "provide minuits !";
	}
	else if($duration=="NO")
	{
		$error[] = "provide duration !";
	}
	else if($teacher=="NO")
	{
		$error[] = "provide a techer name !";
	}
	else if($name=="")
	{
		$error[] = "provide a class name !";
	}


	else
	{

		if($cls->checkClass($name))
		{
			//$cls->createClass($name,$day,$hour,$minit,$duration,$teacher);
			$_SESSION['class_name'] = $name;

            $_SESSION['class_day'] = $day;
            $_SESSION['class_hour'] = $hour;
            $_SESSION['class_minit'] = $minit;
            $_SESSION['class_duration'] = $duration;
            $_SESSION['class_teacher'] = $teacher;
			$auth_user->redirect('selectHall.php');
		}

		else
		{
			$error[]="provide different class name !";
		}
	}

}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Add Class</title>
	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
	<script type="text/javascript" src="jquery-1.11.3-jquery.min.js"></script>
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
					<li><a href="sign-up.php">Add user</a></li>
					<li><a href="addStudent.php">Add Student</a></li>
					<li class="active"><a href="addClass.php">Add Class</a></li>
                    <?php
                    if ($userRow['user_level']=='2') { ?>
                        <li><a href="hallChange.php">Hall Changes</a></li>
                    <?php } ?>

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
					<h2 class="form-signin-heading">Add New Class.</h2><hr />
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
					}?>
					<?php
					if(isset($_GET['cancelled']))
					{
						?>
						<div class="alert alert-danger">
							<i class="glyphicon glyphicon-log-in"></i> &nbsp; Cancelled Operation !<a href='index.php'>Go back</a>
						</div>
						<?php
					}?>


					<?php if($clz=="") {?>
						<div class="form-group">
							<input type="text" class="form-control" name="txt_name" placeholder="Enter Class Name" value="<?php if(isset($error)){echo $name;}?>" />
						</div>
						<div class="form-group">
							<select name="week_day">
								<option value="NO">Chose Day Below</option>
								<option value="Sunday">Sunday</option>
								<option value="Monday">Monday</option>
								<option value="Tuesday">Tuesday</option>
								<option value="Wednesday">Wednesday</option>
								<option value="Thursday">Thursday</option>
								<option value="Friday">Friday</option>
								<option value="Saturday">Saturday</option>
							</select><br>

						</div>
						<div class="form-group">
							<select name="hour">
								<option value="NO">Select Hour</option>
								<option value="6">06</option>
								<option value="7">07</option>
								<option value="8">08</option>
								<option value="9">09</option>
								<option value="10">10</option>
								<option value="11">11</option>
								<option value="12">12</option>
								<option value="13">13</option>
								<option value="14">14</option>
								<option value="15">15</option>
								<option value="16">16</option>
								<option value="17">17</option>
								<option value="18">18</option>
								<option value="19">19</option>
								<option value="20">20</option>
							</select>
							<select name="minit">
								<option value="NO">Select Minutes</option>
								<option value="0">00</option>
								<option value="30">30</option>

							</select>
							<select name="duration">
								<option value="NO">Select Duration</option>
								<option value="1">01</option>
								<option value="2">02</option>
								<option value="3">03</option>
								<option value="4">04</option>
								<option value="5">05</option>

							</select><br>

						</div>
						<div class="form-group">
							<select name="teacher">
								<option value="NO">Select teacher</option>
								<?php

								$db=new Database();
								$conn=$db-> dbConnection('dblogin');
								$result = $conn->prepare("SELECT user_name FROM users WHERE user_level='1' OR user_level='4'");
								$result->execute();
								$array = $result->fetchAll(PDO::FETCH_COLUMN);
								foreach ($array as &$user_name) {


									echo "<option value=".$user_name.">".$user_name."</option>";

								}

								?>

							</select><br>
						</div>

						<div class="clearfix"></div><hr />
						<div class="form-group">
							<button type="submit" class="btn btn-primary" name="btn-signup">
								<i class="glyphicon glyphicon-open-file"></i>&nbsp;Proceed
							</button>
						</div>
						<?php } ?>
						<br />
						<label>want to cancel! <a href="index.php">Cancel</a></label>
					</form>
				</div>
			</div>

		</div>
		<script src="bootstrap/js/bootstrap.min.js"></script>
	</body>
	</html>
