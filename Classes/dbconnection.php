<?php
/**
 *
 */
class Dbconnection
{
  private $conn;
  function __construct()
  {
    //new mysqli(SERVER, DBUSER, DBPASS, DATABASE);
        $this->conn= new mysqli('localhost', 'newuser', 'password', 'dblogin');
        echo "ran cns";
        return $conn

  }


  function dbQuery()
  {
    echo "start query";
    $result = $conn->query("SELECT user_name FROM users WHERE permission is NULL");
    return($result);
  }


}





 ?>
