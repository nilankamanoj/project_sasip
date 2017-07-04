<?php

require_once("session.php");
require_once("classes/connecter.php");



$auth_user = new USER();
$SystemUser=Null;

$final_id="";

$user_id = $_SESSION['user_session'];

$stmt = $auth_user->runQuery("SELECT * FROM users WHERE user_id=:user_id");
$stmt->execute(array(":user_id"=>$user_id));

$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

if ($userRow['user_level']!='1')
{
	if ($userRow['user_level']!='4')
	{
		$auth_user->redirect('home.php');
	}
}
else if ($userRow['user_level']=='1')
{
	$SystemUser=Owner::getInstance();
	echo "pass";
}
$cls=new Classs();
$array=$cls->fetchTeacher($userRow['user_name']);
if(isset($_POST['btn-signup']))
{
	$cls=$_POST['cls'];
	$idno = strip_tags($_POST['txt_idno']);

	if($cls=="NO")	{
		$error[] = "provide class to offer free card!";
	}

	else if($idno=="")	{
		$error[] = "provide student id !";
	}
	else if(strlen($idno)!=6)	{
		$error[] = "provide valid student id !";
	}
	else if(ctype_digit($idno)=="")	{
		$error[] = "provide valid student id !";
	}
	else {
		$stu=new Student();

		$row= $stu->fetchStudent($idno,$cls);

		if($row['identity_no']!=$idno) {
			$error[] = "sorry identity invalid id !";

		}
		else {
			$final_id=$idno;
		}


	}


}
if(isset($_POST['btn-confirm']))
{
	$stu=new Student();
	$stu->makeFree();
	$auth_user->redirect('freeCard.php?joined');
}
if(isset($_POST['btn-another']))
{

	$auth_user->redirect('freeCard.php');
}


?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Offer Free Card</title>
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

					<?php
					if ($userRow['user_level']=='1') { ?>
						<li><a href="acceptUser.php">Accept User</a></li>
						<div class="dropdown">
							<button class="dropbtn">Other Options</button>
							<div class="dropdown-content">
								<a href="userTable.php">view/remove users</a>
								<a href="overolReport.php">get Overoll report</a>

							</div>
						</div>
						<?php } ?>

						<li class="active"><a href="freeCard.php">Offer Free Card</a></li>
						<li ><a href="selectHall.php">Book A Hall</a></li>
						<li><a href="deleteStudent.php">Remove Student</a></li>



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
						<?php if($final_id==""){?>
							<h2 class="form-signin-heading">Select Student</h2><hr />
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
									<i class="glyphicon glyphicon-log-in"></i> &nbsp; Free Card Offered !<a href='index.php'>Go back</a>
								</div>
								<?php
							}?>
							<div class="form-group">
								<select name=cls>
									<option value="NO">  Select Class  </option>
									<?php
									$classs=new Classs();

									//$array=$classs->fetchAll();
									foreach ($array as &$class_name) {
										echo "<option value=".$class_name.">".$class_name."</option>";
									}?>
								</select><br>
							</div>
							<div class="form-group">

								<input type="text" class="form-control" name="txt_idno" placeholder="Enter Id Number" value="<?php if(isset($error)){echo $idno;}?>" />
							</div>
							<div class="clearfix"></div><hr />
							<div class="form-group">
								<button type="submit" class="btn btn-primary" name="btn-signup">
									<i class="glyphicon glyphicon-open-file"></i>&nbsp;Check Student
								</button>
							</div>
							<br />
							<?php }else{ ?>
								<h2 class="form-signin-heading">Offer Free Card</h2><hr />

								<div class="form-group">
									<li><font color =#ooooff size=4>Name :</font><?php print($row['first_name']);print("  ");print($row['last_name'])?></li>
									<li><font color =#ooooff size=4>Id number:</font><?php print($row['identity_no']); ?></li>
									<li><font color =#ooooff size=4>School:</font><?php print($row['school_name']); ?></li>


									<div class="clearfix"></div><hr />
									<div class="form-group">
										<button  type="submit" class="btn btn-primary" name="btn-confirm">
											<i class="glyphicon glyphicon-open-file"></i>&nbsp;Offer free card
										</button>
										<button  type="submit" background-color=#ffff00 name="btn-another">
											<i class=""></i>&nbsp;Search Again
										</button>
									</div>
									<br />

									<?php } ?>
									<label>want to cancel! <a href="index.php">Cancel</a></label>
								</form>
							</div>

						</div>



						<script src="bootstrap/js/bootstrap.min.js"></script>

					</body>
					</html>
