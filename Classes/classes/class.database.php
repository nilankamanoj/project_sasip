<?php
class Database
{
    private $host = "localhost";
    private $dbname = "";
    private $username = "newuser";
    private $password = "password";
    public $conn;

    public function dbConnection($db_name)
	{

	    $this->conn = null;
        try
		{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $db_name, $this->username, $this->password);
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
		catch(PDOException $exception)
		{
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }

    public function getConn($db_name)
    {
      $this->dbname=$db_name;
      $conn1 = new mysqli($this->host, $this->username, $this->password,$this->dbname);
      return $conn1;
    }
}
?>
