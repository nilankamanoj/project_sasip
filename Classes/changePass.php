<?php

require_once("session.php");
require_once("classes/connecter.php");



$auth_user = new USER();
$SystemUser=Null;

$user_id = $_SESSION['user_session'];

$stmt = $auth_user->runQuery("SELECT * FROM users WHERE user_id=:user_id");
$stmt->execute(array(":user_id"=>$user_id));

$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

$uname=$userRow['user_name'];

if(isset($_POST['btn-signup']))
{
  $upass1 = strip_tags($_POST['txt_upass1']);
  $upass2_1 = strip_tags($_POST['txt_upass2_1']);
  $upass2_2 = strip_tags($_POST['txt_upass2_2']);

  if($upass2_1!=$upass2_2)	{
    $error[] = "password confirmation error";
  }
  else if(strlen($upass2_2) < 6){
    $error[] = "Password must be atleast 6 characters";
  }
  else
  {
    try
    {
      if($auth_user->changePassword($uname,$upass1,$upass2_1))
      {
        $auth_user->redirect('changePass.php?changed');
      }
      else {
        $error[]="Current Password Incorrect!";
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
  <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
  <link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
  <script type="text/javascript" src="jquery-1.11.3-jquery.min.js"></script>
  <link rel="stylesheet" href="style.css" type="text/css"  />
  <title>change password- <?php print($userRow['user_email']); ?></title>
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
              <?php } ?>

              <?php

              if ($userRow['user_level']=='3') { ?>
                <li><a href="addStudent.php">Add Student</a></li>
                <?php } ?>
                <?php

                if ($userRow['user_level']=='1') { ?>
                  <li><a href="acceptUser.php">Accept User</a></li>
                  <li><a href="freeCard.php">Offer Free Card</a></li>
                  <li ><a href="selectHall.php">Book A Hall</a></li>
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
                      <h2 class="form-signin-heading">Change Password.</h2><hr />
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
                      else if(isset($_GET['changed']))
                      {
                        ?>
                        <div class="alert alert-info">
                          <i class="glyphicon glyphicon-log-in"></i> &nbsp; Successfully Changed Password<a href='index.php'>Go back</a>
                        </div>
                        <?php
                      }
                      ?>

                      <div class="form-group">
                        <input type="password" class="form-control" name="txt_upass1" placeholder="Enter Current Password" />
                      </div>
                      <div class="form-group">
                        <input type="password" class="form-control" name="txt_upass2_1" placeholder="Enter New Password" />
                      </div>
                      <div class="form-group">
                        <input type="password" class="form-control" name="txt_upass2_2" placeholder="Confirm New Password" />
                      </div>

                      <div class="clearfix"></div><hr />
                      <div class="form-group">
                        <button type="submit" class="btn btn-primary" name="btn-signup">
                          <i class="glyphicon glyphicon-open-file"></i>&nbsp;Proceed
                        </button>
                      </div>
                      <br />
                      <label>want to cancel! <a href="index.php">Cancel</a></label>
                    </form>
                  </div>
                </div>

              </div>

              <script src="bootstrap/js/bootstrap.min.js"></script>

            </body>
            </html>
