<?php
/**
*
*/
require_once('class.database.php');

class Owner
{
  private $userconn;
  private static $instance;

  private function __construct()
  {
    $db=new Database();
    $this->userconn = $db->getConn('dblogin');
  }


  private function __clone()
  {
  }


  public function getInstance()
  {
    if(self::$instance==null){
      self::$instance=new Owner();
    }

    else
    {
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
    if($result->num_rows == 0)
    {
      return(false);
    }
    else

    {
      return(true);
    }

  }


  public function getNewUsers()
  {
    $newUsers=array();
    $result = $this->userconn->query("SELECT user_name,user_email,user_level FROM users WHERE permission is NULL");
    if ($result->num_rows > 0)
    {
      while($row = $result->fetch_assoc())
      {
        array_push($newUsers,$row);
      }
      return($newUsers);
    }
    else
    {
      return false;
    }
  }



  public function AcceptUser($uname)
  {
    echo "method ran";

    $this->userconn->query("UPDATE users SET permission = '1' WHERE user_name='{$uname}'");

  }

  
  public function DeleteUser($uname)
  {
    $this->userconn->query( "DELETE FROM users WHERE user_name='{$uname}'");

  }
}




?>
