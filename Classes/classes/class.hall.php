<?php


require_once('class.database.php');

class Hall
{

	private $conn;

	public function __construct()
	{
		$database = new Database();
		$db = $database->getConn("dbhalls");
		$this->conn = $db;
	}

	public function checkAvailability($table_name){
		$query="SHOW TABLES LIKE '$table_name'";
		$result=$this->conn->query($query);
		if ($result->num_rows==1){
			return (false);
		}
		return (true);
	}

	public function add_hall($hall_name)
    {
        $table = 'halls';

        $query = "INSERT INTO $table(hall_name)
                VALUES ('$hall_name')";

        $result = $this->conn->query($query);

        return $result;

    }

	public function create_hall($hall_name){
        $query = "CREATE TABLE IF NOT EXISTS $hall_name
				(id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
				class_name varchar(12) NOT NULL,
  				class_day varchar(12) NOT NULL,
  				class_time_hour varchar(2) NOT NULL,
  				class_time_minit varchar(2) NOT NULL,
  				duration varchar(2) NOT NULL,
  				teacher_name varchar(12) NOT NULL)";

        $result=$this->conn->query($query);
        return $result;
	}

	public function checkHall($hall_name){
        $query = "SELECT * FROM halls WHERE hall_name='$hall_name'";

        $result = $this->conn->query($query);

        $obj = $result->fetch_object();

        if($obj->hall_name==$hall_name)
        {
            return(false);
        }
		return(true);

	}

	public function create_hall_book($hall_name_book)
    {
    	$hall_name=$hall_name_book."_book";


        $query = "CREATE TABLE IF NOT EXISTS $hall_name
				(id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
				class_name varchar(12) NOT NULL,
  				class_date varchar(12) NOT NULL,
  				class_month varchar(12) NOT NULL,
  				class_time_hour varchar(2) NOT NULL,
  				class_time_minit varchar(2) NOT NULL,
  				duration varchar(2) NOT NULL,
  				teacher_name varchar(12) NOT NULL)";

        $result = $this->conn->query($query);
        return $result;
    }

    public function fetchHall()
    {
        $query = "SELECT * FROM halls";

        $result = $this->conn->query($query);

        while ($obj = $result->fetch_object()) {
            $results[] = $obj;
        }

        return $results;
    }

}
?>
