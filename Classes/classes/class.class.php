<?php


require_once('class.database.php');

class Classs
{

	private $conn;


	public function __construct()
	{
		$database = new Database();
		$db = $database->dbConnection("dbclasses");
		$this->conn = $db;
	}

	public function runQuery($sql)
	{
		$stmt = $this->conn->prepare($sql);

		return $stmt;
	}


	public function createClass($name,$day,$hour,$minit,$duration,$teacher)
	{
		try
		{

			$count='0';

			$stmt = $this->conn->prepare("INSERT INTO classes(class_name,class_day,class_time_hour,class_time_minit,duration,teacher_name,stu_count)
			VALUES(:name,:day,:hour,:minit,:duration,:teacher,:count)");

			$stmt->bindparam(":name", $name);
			$stmt->bindparam(":day", $day);
			$stmt->bindparam(":hour", $hour);
			$stmt->bindparam(":minit", $minit);
			$stmt->bindparam(":duration", $duration);
			$stmt->bindparam(":teacher", $teacher);
			$stmt->bindparam(":count", $count);



			$stmt->execute();

			$sql = "CREATE TABLE IF NOT EXISTS $name(
				id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
				identity_no VARCHAR(6) NOT NULL,
				first_name VARCHAR(15) NOT NULL,
				last_name VARCHAR(15),
				phone_number VARCHAR(10),
				school_name VARCHAR(20),
				added_by VARCHAR(20),
				free VARCHAR(1),
				`joining_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
			)";
			$nameTBabs=$name.'abs';
			$sql2 = "CREATE TABLE IF NOT EXISTS $nameTBabs(
				id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
				identity_no VARCHAR(6) NOT NULL,
				first_name VARCHAR(15) NOT NULL,
				last_name VARCHAR(15),
				phone_number VARCHAR(10),
				school_name VARCHAR(20),
				added_by VARCHAR(20),
				free VARCHAR(1),
				`joining_date` timestamp NOT NULL
			)";

			$this->conn->query($sql);
			$this->conn->query($sql2);
			return $stmt;
		}

		catch(PDOException $e)
		{
			echo $e->getMessage();
		}

	}


	public function checkClass($name)
	{

		$stmt1=$this->conn->query("SELECT  class_name FROM classes WHERE class_name ='{$name}'");
		$row = $stmt1->fetch(PDO::FETCH_ASSOC);

		if($row['class_name']==$name)
		{
			return(false);
		}

		else
		{
			return(true);
		}
	}


	public function fetchClass($name)
	{

		$stmt1=$this->conn->query("SELECT  class_name,class_day,class_time_hour,class_time_minit,duration,teacher_name,stu_count FROM classes WHERE class_name ='{$name}'");
		$row = $stmt1->fetch(PDO::FETCH_ASSOC);
		return($row);
	}


	public function setHall($name,$hall)
	{
		$this->conn->query("UPDATE classes SET hall='{$hall}' WHERE class_name='{$name}'");
	}


	public function deleteClass($name)
	{
		$this->conn->query("DELETE FROM classes  WHERE class_name = '{$name}' ");
		$this->conn->query("DROP TABLE $name");
	}


	public function fetchAll()
	{
		$result =$this->conn->prepare("SELECT class_name FROM classes");
		$result->execute();
		$array = $result->fetchAll(PDO::FETCH_COLUMN);
		return $array;

	}


	public function fetchTeacher($teacher)
	{
		$result =$this->conn->prepare("SELECT class_name FROM classes WHERE teacher_name='{$teacher}'");
		$result->execute();
		$array = $result->fetchAll(PDO::FETCH_COLUMN);
		return $array;
	}

}
?>
