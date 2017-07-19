<?php
require_once("session.php");
require("classes/connecter.php");


$auth_user = new USER();
$clsname="";
$clsname=$_SESSION['class_name'];

$auth_user_id = $_SESSION['user_session'];

$auth_stmt = $auth_user->runQuery("SELECT * FROM users WHERE user_id=:user_id");
$auth_stmt->execute(array(":user_id"=>$auth_user_id));

$userRow=$auth_stmt->fetch(PDO::FETCH_ASSOC);
if ($userRow['user_level']!='2') {
	if ($userRow['user_level']!='4') {
		if ($userRow['user_level']!='1') {
			$auth_user->redirect('home.php');
		}
	}
}
if ($userRow['user_level']=='2') {
	if($clsname=="") {
		$auth_user->redirect('home.php');
	}
}


$cls=new Classs();
$user = new USER();
$array=$cls->fetchTeacher($userRow['user_name']);
$row=$cls->fetchClass($clsname);

$hall=new Hall();
$arrayHalls=$hall->fetchHall();
$class_day=$_SESSION['class_day'];
$class_time_hour=$_SESSION['class_hour'];
$class_time_minit=$_SESSION['class_minit'];
$duration=$_SESSION['class_duration'];
echo "ok..";

foreach ($arrayHalls as $hall_array){
    echo "ok..";
    $hall_arrayStr[]=strval(".$hall_array->hall_name");
}
$hall1=new Hall();
foreach ($hall_arrayStr as $hall_array1){
    echo "ok..";
    $check=true;
    $check=$hall1->check_hall_availability("$hall_array1","$class_day","$class_time_hour","$class_time_minit","$duration");
    echo "ok..";
    if ($check==(true)){
        $arrayHall[]=$hall_array1;
    }
}
$arrayHall=$hall->fetchHall();


if(isset($_POST['btn-delete']))
{
	//$cls->deleteClass($clsname);
	$_SESSION['class_name']="";
	$clsname="";
	$auth_user->redirect("addClass.php?cancelled");
}
if(isset($_POST['btn-check']))
{
	$hallS=strip_tags($_POST['halls']);
	if($hallS=="NO"){
		$error[] = "provide hall !";
	}
	else{
        $cls->createClass($_SESSION['class_name'], $_SESSION['class_day'], $_SESSION['class_hour'], $_SESSION['class_minit'], $_SESSION['class_duration'], $_SESSION['class_teacher']);
        $cls->setHall($clsname, $hallS);
        $hall->insert_hall($hallS,$_SESSION['class_name'],$_SESSION['class_day'],$_SESSION['class_hour'],$_SESSION['class_minit'],$_SESSION['class_duration'],$_SESSION['class_teacher']);

        $_SESSION['class_name'] = "";

        $_SESSION['class_day'] = "";
        $_SESSION['class_hour'] = "";
        $_SESSION['class_minit'] = "";
        $_SESSION['class_duration'] = "";
        $_SESSION['class_teacher'] = "";
        $clsname = "";
        $auth_user->redirect("addClass.php?joined");
	$hall=strip_tags($_POST['halls']);
	if($hall=="NO"){
		$error[] = "provide hall !";
	}
	else{
            $cls->createClass($_SESSION['class_name'], $_SESSION['class_day'], $_SESSION['class_hour'], $_SESSION['class_minit'], $_SESSION['class_duration'], $_SESSION['class_teacher']);
            $cls->setHall($clsname, $hall);
            $_SESSION['class_name'] = "";

            $_SESSION['class_day'] = "";
            $_SESSION['class_hour'] = "";
            $_SESSION['class_minit'] = "";
            $_SESSION['class_duration'] = "";
            $_SESSION['class_teacher'] = "";
            $clsname = "";
            $auth_user->redirect("addClass.php?joined");

	}
}
if(isset($_POST['btn-cancel']))
{
	$auth_user->redirect("home.php");
}
if(isset($_POST['btn-book']))
{
	$hall=$_POST['hall'];
	$cls_name=$_POST['cls_name'];

	if($cls_name=="NO"){
		$error[] = "select class !";
	}
	else if($hall=="NO"){
		$error[] = "provide hall !";
	}


}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Book hall</title>
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

					if ($userRow['user_level']=='2') { ?>
						<li><a href="sign-up.php">Add user</a></li>
						<?php } ?>
						<?php

						if ($userRow['user_level']=='2') { ?>
							<li><a href="addStudent.php">Add Student</a></li>
							<li class="active"><a href="addClass.php">Add Class</a></li>
							<?php } ?>
							<?php

							if ($userRow['user_level']=='1') { ?>
								<li><a href="acceptUser.php">Accept User</a></li>
								<li ><a href="freeCard.php">Offer Free Card</a></li>
								<li class="active"><a href="selectHall.php">Book A Hall</a></li>
								<li><a href="deleteStudent.php">Remove Student</a></li>
								<div class="dropdown">
									<button class="dropbtn">Other Options</button>
									<div class="dropdown-content">
										<a href="userTable.php">view/remove users</a>
										<a href="overolReport.php">get Overoll report</a>

									</div>
								</div>


								<?php } ?>

								<?php

								if ($userRow['user_level']=='4') { ?>

									<li><a href="freeCard.php">Offer Free Card</a></li>
									<li class='active'><a href="selectHall.php">Book A Hall</a></li>
									<li><a href="deleteStudent.php">Remove Student</a></li>
									<?php } ?>
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
											<?php

											if ($userRow['user_level']!='2') { ?>
												<div class="form-group">
													<select name=cls>
														<option value="NO">  Select Class  </option>
														<?php
														$classs=new Classs();

														foreach ($array as &$class_name) {
															echo "<option value=".$class_name.">".$class_name."</option>";
														}?>
													</select><br>
												</div>
												<div class="form-group">
													<select name="date">
														<option value="NO">Date</option>
														<option value="0">0</option>
														<option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option>
														<option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option>
														<option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option>
														<option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option>
														<option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option>
														<option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option>
														<option value="31">31</option>



													</select>
													<select name="month">
														<option value="NO">Month</option>
														<option value="1">jan</option>
														<option value="2">feb</option>
														<option value="3">mar</option>
														<option value="4">aprl</option>
														<option value="5">may</option>
														<option value="6">june</option>
														<option value="7">july</option>
														<option value="8">aug</option>
														<option value="9">sep</option>
														<option value="10">oct</option>
														<option value="11">nov</option>
														<option value="13">dec</option>

													</select>
													<br>


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

												<?php }


												else{?>
													<p><font color=#505fff >Class Name :</font> <?php echo $_SESSION['class_name'];/*print($row['class_name']) ;*/?></p>
													<?php } ?>
													<br>
													<div class="form-group">
														<select name="halls">
															<option value="NO">Chose Hall Below</option>

                                                            <?php foreach ($arrayHall as $hall_name):?>

                                                                <option value="<?php echo $hall_name;?>"><?php echo $hall_name?></option>

                                                                <option value="<?php echo $hall_name->hall_name;?>"><?php echo $hall_name->hall_name;?></option>

                                                            <?php endforeach;?>

														</select><br>

													</div>
													<?php if($clsname=="") {?>
														<div class="clearfix"></div><hr />
														<div class="form-group">
															<button type="submit" class="btn btn-primary" name="btn-book">
																<i class="glyphicon glyphicon-open-file"></i>&nbsp;Check Availability
															</button>

															<button type="submit" class="" name="btn-cancel">

																<i class="glyphicon glyphicon-open-file"></i>&nbsp;Cancel Booking
																<?php }


																else{ ?>
																	<div class="clearfix"></div><hr />
																	<div class="form-group">
																		<button type="submit" class="btn btn-primary" name="btn-check">
																			<i class="glyphicon glyphicon-open-file"></i>&nbsp;Proceed
																		</button>
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
														<script src="bootstrap/js/bootstrap.min.js"></script>
													</body>
													</html>
