<?php


	require("Owner.php");
	require_once("session.php");
	require_once("class.user.php");
//require 'dbconfig.php';


	$auth_user = new USER();
  $SystemUser=Null;
	$user_id = $_SESSION['user_session'];
	$stmt = $auth_user->runQuery("SELECT * FROM users WHERE user_id=:user_id");
	$stmt->execute(array(":user_id"=>$user_id));
	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
  $db=new Database();
  echo "pass";

if ($userRow['user_level']!='1')
	{
		$auth_user->redirect('home.php');
	}
else if ($userRow['user_level']=='1')
	{
		$SystemUser=Owner::getInstance();
    echo "pass";
	}
  $db_host = 'localhost'; // Server Name
  $db_user = 'newuser'; // Username
  $db_pass = 'password'; // Password
  $db_name = 'dblogin'; // Database Name

  $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
  if (!$conn) {
  	die ('Failed to connect to MySQL: ' . mysqli_connect_error());
  }

  $sql = 'SELECT *
  		FROM users';

  $query = mysqli_query($conn, $sql);

  if (!$query) {
  	die ('SQL Error: ' . mysqli_error($conn));
  }

?>


	      <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	      <html xmlns="http://www.w3.org/1999/xhtml">
	      <head>
	      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	      <title>User review</title>
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
	                    <li><a href="acceptUser.php">Accept User</a></li>
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
          <h1>System Users</h1>
          <table class="data-table">

            <thead>
              <tr>
                <th>NO</th>
                <th>user name</th>
                <th>email</th>
                <th>join date/time</th>
                <th>occupation</th>
              </tr>
            </thead>
            <tbody>
  <?php
            $no 	= 1;
            $total 	= 0;
            while ($row = mysqli_fetch_array($query))
            {
              $amount  = $row['amount'] == 0 ? '' : number_format($row['amount']);
              $occupation="";
              $ulvl=$row['user_level'];
              if($ulvl=='1'){
                $occupation='owner';
              }
              else if($ulvl=='2'){
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
              echo '<tr>
                  <td>'.$no.'</td>
                  <td>'.$row['user_name'].'</td>
                  <td>'.$row['user_email'].'</td>
                  <td>'.$row['joining_date']. '</td>
                  <td>'.$occupation.'</td>
                </tr>';
              $total ++;
              $no++;
            }?>
            </tbody>

          </table>
	     
	  </form>
	 </div>

	 	   </div>



	      </body>
	      </html>
