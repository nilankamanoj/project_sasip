<?php
/**
 *
 */
//require('dbconnection.php');
class Owner
{
  //private $conn;
  private $conn;
  private static $instance;

  private function __construct()
  {
    echo "newly consructed";
    $mysqli = new mysqli('localhost', 'newuser', 'password', 'dblogin');
    $this->conn=$mysqli;
    //$database = new Dbconnection();
		//$this->conn = $database;
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


$result = $this->conn->query("SELECT user_name FROM users WHERE permission is NULL");
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
  $result = $this->conn->query("SELECT user_name,user_email,user_level FROM users WHERE permission is NULL");
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

   $this->conn->query("UPDATE users SET permission = '1' WHERE user_name='{$uname}'");
   //header("Location: acceptUser.php");
 }
 public function DeleteUser($uname)
 {
   //"DELETE FROM `users` WHERE `user_name`='{$uname}'"
   $this->conn->query( "DELETE FROM users WHERE user_name='{$uname}'");
 }
}




 ?>
