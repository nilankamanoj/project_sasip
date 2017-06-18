<?php
/**
 *
 */
require_once('class.database.php');
class Owner
{
  //private $conn;
  private $userconn;
  private static $instance;

  private function __construct()
  {
    $db=new Database();

  //$mysqli = new mysqli('localhost', 'newuser', 'password', 'dblogin');
  //$this->conn=$mysqli;
    //$database = new Dbconnection();
	$this->userconn = $db->getConn('dblogin');

  //  $this->conn=new Dbconnection('dblogin');
  }
  private function __clone(){

  }
 public function getInstance(){
   if(self::$instance==null){
     self::$instance=new Owner();
   }
   else {
     echo "also created";
   }
   return(self::$instance);
 }
 public function getName()
 {
   return("Owner");
 }
 public function hasNewUsers()
{


$result = $this->userconn->query("SELECT user_name FROM users WHERE permission is NULL");
//$result=$result1->execute();
if($result->num_rows == 0) {
     return(false);
}
else

{
    return(true);
}
//$mysqli->close();

 }
 public function getNewUsers()
 {
   $newUsers=array();
   //echo "in_gnu";
  $result = $this->userconn->query("SELECT user_name,user_email,user_level FROM users WHERE permission is NULL");
//echo "in_gnu3";
   if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
          array_push($newUsers,$row);
          //echo "pass_user";
      }
      return($newUsers);
   } else {
      return false;
   }
 }
 public function AcceptUser($uname)
 {
   echo "method ran";

   $this->userconn->query("UPDATE users SET permission = '1' WHERE user_name='{$uname}'");
   //header("Location: acceptUser.php");
 }
 public function DeleteUser($uname)
 {
   //"DELETE FROM `users` WHERE `user_name`='{$uname}'"
   $this->userconn->query( "DELETE FROM users WHERE user_name='{$uname}'");
 }
}




 ?>
