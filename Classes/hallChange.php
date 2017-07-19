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


$hall=new Hall();
$user = new USER();
$clz="";


if(isset($_POST['btn-signup']))
{
	$name = strip_tags($_POST['txt_name']);
    if($name=="")
	{
		$error[] = "provide a class name !";
	}


	else {
            if($hall->checkHall($name))
            {
                $hall->create_hall($name);

                if (!$hall->checkAvailability($name)){
                    $hall->create_hall_book($name);
                    $hall->add_hall($name);
                    $user->redirect('hallChange.php?joined');
                }else{
                    $error[]="Invalid hall name. Please look example !";
                }


                $_SESSION['class_name'] = $name;
            }

            else
            {
                $error[]="provide different hall name !";
            }

    }

}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Hall Changes</title>
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
					<li ><a href="addClass.php">Add Class</a></li>
                    <?php
                    if ($userRow['user_level']=='2') { ?>
                        <li class="active"><a href="hallChange.php">Hall Changes</a></li>
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
					<h2 class="form-signin-heading">Add New Hall.</h2><hr />
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
							<i class="glyphicon glyphicon-log-in"></i> &nbsp; Successfully added hall.<a href='index.php'>Go back</a>
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
							<input type="text" class="form-control" name="txt_name" placeholder="Enter Hall Name" value="<?php if(isset($error)){echo $name;}?>" />
                            <p>
                            </p>
                            <p>
                                Ex:-"level_1_a"  or  "Hall Name"
                            </p>
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
