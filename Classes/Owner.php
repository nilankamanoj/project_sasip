<?php
/**
 *
 */
//require('dbconnection.php');
class Owner
{
  //private $conn;

  private static $instance;

  private function __construct()
  {
    echo "newly consructed";
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

$mysqli = new mysqli('localhost', 'newuser', 'password', 'dblogin');
$result = $mysqli->query("SELECT user_name FROM users WHERE permission is NULL");
if($result->num_rows == 0) {
     return(false);
}
else

{
    return(true);
}
$mysqli->close();

 }
}




 ?>
