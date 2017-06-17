<?php
	require("Owner.php");
	require_once("session.php");

	require_once("class.user.php");
	$auth_user = new USER();
  $SystemUser=Null;


	$user_id = $_SESSION['user_session'];

	$stmt = $auth_user->runQuery("SELECT * FROM users WHERE user_id=:user_id");
	$stmt->execute(array(":user_id"=>$user_id));

	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

if ($userRow['user_level']!='1')
	{
		$auth_user->redirect('home.php');
	}
else if ($userRow['user_level']=='1')
	{
		$SystemUser=Owner::getInstance();
    echo "pass";
	}
	if($SystemUser->hasNewUsers()){
	  $newUsers=$SystemUser->getNewUsers();
	}
	$num=0;
	if(isset($_POST['btn-signup']))
	{

	  $user_name=$newUsers[$num]['user_name'];
	  $SystemUser->AcceptUser($user_name);
		$auth_user->redirect('acceptUser.php?joined');


	}
	if(isset($_POST['btn-delete']))
	{

		$user_name=$newUsers[$num]['user_name'];
		$SystemUser->DeleteUser($user_name);
		$auth_user->redirect('acceptUser.php');


	}

	?>


	      <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	      <html xmlns="http://www.w3.org/1999/xhtml">
	      <head>
	      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	      <title>Accept User</title>
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
	                    <li class="active"><a href="acceptUser.php">Accept User</a></li>
											<li><a href="freeCard.php">Offer Free Card</a></li>
											<li ><a href="selectHall.php">Book A Hall</a></li>
											<li><a href="deleteStudent.php">Remove Student</a></li>

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
	                  <h2 class="form-signin-heading">Accept User</h2><hr />
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
	                            <i class="glyphicon glyphicon-log-in"></i> &nbsp; Successfully Accepted <a href='index.php'>Go back</a>
	                       </div>
	                       <?php
	      			}


	$arrlength = count($newUsers);
	if($arrlength!=0){


	?>
	      <div class="form-group">
					<?php
					$occupation="";
					$ulvl=$newUsers[$num]['user_level'];
					if($ulvl=='2'){
						$occupation='Staff Upper';
					}
					else if($ulvl=='3'){
						$occupation='Staff Lower';
					}
					else if($ulvl=='4'){
						$occupation='Teacher';
					}
					else if($ulvl=='5'){
						$occupation='Card Marker';
					}
					 ?>
	      <li><font color =#ooooff size=4>Name :</font><?php print($newUsers[$num]['user_name']); ?></li>
	      <li><font color =#ooooff size=4>Email:</font><?php print($newUsers[$num]['user_email']); ?></li>
	      <li><font color =#ooooff size=4>Occupation:</font><?php print($occupation); ?></li>
	      <?php $user_name=$newUsers[$num]['user_name']; ?>



	      <div class="clearfix"></div><hr />
	      <div class="form-group">
	        <button  type="submit" class="btn btn-primary" name="btn-signup">
	            <i class="glyphicon glyphicon-open-file"></i>&nbsp;Confirm User
	          </button>
						<button  type="submit" background-color=#ffff00 name="btn-delete">
		            <i class=""></i>&nbsp;Delete User
		          </button>
	      </div>
	      <br />
	      <label>want to cancel! <a href="index.php">Cancel</a></label>
	  </form>
	 </div>
	 <?php }
	 else { ?>
	 	<label>No New Users           <a href="index.php">Go Back</a></label>
	 <?php } ?>



	      </div>

	      </div>

	      </body>
	      </html>
