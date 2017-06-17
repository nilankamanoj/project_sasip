<?php
	require("Owner.php");
	require_once("session.php");
	require 'class.class.php';

	require_once("class.user.php");
	$auth_user = new USER();
	$SystemUser=Null;


	$user_id = $_SESSION['user_session'];

	$stmt = $auth_user->runQuery("SELECT * FROM users WHERE user_id=:user_id");
	$stmt->execute(array(":user_id"=>$user_id));

	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

if ($userRow['user_level']=='1')
	{
		$SystemUser=Owner::getInstance();
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
<title>Profile- <?php print($userRow['user_email']); ?></title>
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
            <li class="active"><a href="profile.php">Profile</a></li>
						<?php

						if ($userRow['user_level']=='2') { ?>
							<li><a href="sign-up.php">Add user</a></li>
						<?php } ?>
						<?php

						if ($userRow['user_level']=='2') { ?>
							<li><a href="addStudent.php">Add Student</a></li>
						<?php } ?>

						<?php

						if ($userRow['user_level']=='3') { ?>
							<li><a href="addStudent.php">Add Student</a></li>
						<?php } ?>
						<?php

						if ($userRow['user_level']=='1') { ?>
							<li><a href="acceptUser.php">Accept User</a></li>
							<li ><a href="freeCard.php">Offer Free Card</a></li>
							<li ><a href="selectHall.php">Book A Hall</a></li>
							<li><a href="deleteStudent.php">Remove Student</a></li>
						<?php } ?>
						<?php

						if ($userRow['user_level']=='4') { ?>

							<li ><a href="freeCard.php">Offer Free Card</a></li>
							<li ><a href="selectHall.php">Book A Hall</a></li>
							<li><a href="deleteStudent.php">Remove Student</a></li>

						<?php } ?>

						<?php
						if ($userRow['user_level']=='2') { ?>
							<li><a href="addClass.php">Add Class</a></li>
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

	<div class="clearfix"></div>

    <div class="container-fluid" style="margin-top:80px;">

    <div class="container">


        <hr />
				<meta charset="utf-8" />
				<meta name="viewport" content="width=device-width, initial-scale=1" />
				<!--[if lte IE 8]><script src="assets/js/html5shiv.js"></script><![endif]-->
				<link rel="stylesheet" href="assets/css/main.css" />
				<!--[if lte IE 9]><link rel="stylesheet" href="assets/css/ie9.css" /><![endif]-->
				<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
				<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
			</head>


				<!-- Wrapper -->
					<div id="wrapper">

						<!-- Main -->
							<section id="main">
								<header>
									<span class="avatar"><img src="images/avatar.jpg" alt="" /></span>
									<h1><?php print($userRow['user_name']); ?></h1>
									<p><?php print($userRow['user_email']); ?></p>
									<p>Join : <?php print($userRow['joining_date']); ?></p>



									<?php
									if ($userRow['user_level']=='1'){
										echo "<p>State : Owner/Teacher</p>";
									}if ($userRow['user_level']=='2'){
										echo "<p>State : Staff(High level)</p>";
									}
									if ($userRow['user_level']=='3'){
										echo "<p>State : Staff(Low level)</p>";
									}
									if ($userRow['user_level']=='4'){
										echo "<p>State : Teacher</p>";
									}
									if ($userRow['user_level']=='5'){
										echo "<p>State : Card marker</p>";
									}

									if (($userRow['user_level']=='4') ||($userRow['user_level']=='1')){
										$cls=new Classs();
										$array=$cls->fetchTeacher($userRow['user_name']);
										echo "<p>Classes :";
										foreach ($array as &$class_name) {
											echo " &nbsp;".$class_name."";
										}
										echo "</p>";
									} ?>





								</header>

								<footer>

								</footer>
							</section>

						<!-- Footer -->


					</div>

				<!-- Scripts -->
					<!--[if lte IE 8]><script src="assets/js/respond.min.js"></script><![endif]-->
					<script>
						if ('addEventListener' in window) {
							window.addEventListener('load', function() { document.body.className = document.body.className.replace(/\bis-loading\b/, ''); });
							document.body.className += (navigator.userAgent.match(/(MSIE|rv:11\.0)/) ? ' is-ie' : '');
						}
					</script>

    <p class="blockquote-reverse" style="margin-top:200px;">
    some footer here<br /><br />
    <a href="">Option4</a>
    </p>

    </div>

</div>




<script src="bootstrap/js/bootstrap.min.js"></script>

</body>
</html>
