<?php

require_once('class.database.php');

class Student
{

	private $conn;


	public function __construct()
	{
		$database = new Database();
		$db = $database->getConn("dbclasses");
		$this->conn = $db;
	}

	public function runQuery($sql)
	{
		$stmt = $this->conn->query($sql);

		return $stmt;
	}



	public function register($idno,$fname,$lname,$pnum,$schname,$addedby,$cls)
	{
		try
		{


			$this->conn->query("INSERT INTO {$cls}(identity_no,first_name,last_name,phone_number,school_name,added_by)
			VALUES('{$idno}','{$fname}','{$lname}','{$pnum}','{$schname}','{$addedby}')");
			$count=$this->getCount($cls);
			$this->setCount($cls,$count);

		}
		catch(PDOException $e)
		{
			echo $e->getMessage();

		}

	}

	public function fetchStudent($idno,$cls)
	{

		$stmt1=$this->conn->query("SELECT  identity_no,first_name,last_name,phone_number,school_name,added_by,joining_date FROM {$cls} WHERE identity_no ='{$idno}'");
		$this->conn->query("INSERT INTO pointers(student_id,class) VALUES('{$idno}','{$cls}')");
		$row = $stmt1->fetch_assoc();

		return($row);
	}

	public function makeFree()
	{
		$stmt1=$this->conn->query("SELECT student_id,class FROM pointers ORDER by id DESC LIMIT 1");
		$row1 = $stmt1->fetch_assoc();
		$idno=$row1['student_id'];
		$cls=$row1['class'];
		$this->conn->query("UPDATE {$cls} SET free = '1' WHERE identity_no='{$idno}'");
	}

	public function Delete()
	{
		$stmt1=$this->conn->query("SELECT student_id,class FROM pointers ORDER by id DESC LIMIT 1");
		$row1 = $stmt1->fetch_assoc();
		$idno=$row1['student_id'];
		$cls=$row1['class'];
		$this->conn->query("DELETE FROM {$cls} WHERE identity_no='{$idno}'");
		$count=$this->getCount($cls);
		$this->setCount($cls,$count);


	}

	public function getCount($class)
	{

		$stmtc=$this->conn->query("SELECT * FROM phy18");
		$cnt = mysqli_num_rows($stmtc);
		return $cnt;

	}

	public function setCount($class,$count)
	{
		$this->conn->query("UPDATE classes SET stu_count = {$count} WHERE class_name='{$class}'");
	}





}
?>
