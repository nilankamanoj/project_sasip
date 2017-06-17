<?php
/**
 *
 */
class Dbconnection
{
  private $conn;
  function __construct($db)
  {
    //new mysqli(SERVER, DBUSER, DBPASS, DATABASE);
        $this->conn= new mysqli('localhost', 'newuser', 'password',$db);
        echo "ran cns";
        return $conn;

  }

}





 ?>
