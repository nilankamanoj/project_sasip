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


	}
	public function markCard($cls,$idno)
	{
		try
		{
			/*$now = new DateTime();
			$date = $now->format('Ymd');*/
			$date = getdate();
			$date1= $date['year'].$date['mon'].$date['mday']."d";

			$col = $this->conn->query("SELECT {$date1} FROM {$cls}");


			if (!$col){
				$this->conn->query("ALTER TABLE {$cls} ADD $date1 TINYINT(1) NULL DEFAULT NULL");
				$this->conn->query("UPDATE {$cls} SET {$date1} = 0");
			}

			$stmt=$this->conn->query("SELECT * FROM {$cls} WHERE identity_no ='{$idno}'");
			$row = $stmt->fetch_assoc();


			if(mysqli_num_rows($stmt)!= 0){
				$this->conn->query("UPDATE {$cls} SET {$date1} = 1 WHERE identity_no ='{$idno}'");

				return $row;
			}

			else{
				return false;
			}
			/*if($row['num_rows']=='0'){
			return true;
		}
		else{

	}*/



}
catch(PDOException $e)
{
	echo $e->getMessage();

}

}
public function addFee($cls,$idno)
{
	try
	{
		/*$now = new DateTime();
		$date = $now->format('Ymd');*/
		$date = getdate();
		$date1= $date['year'].$date['mon']."m";

		$col = $this->conn->query("SELECT {$date1} FROM {$cls}");


		if (!$col){
			$this->conn->query("ALTER TABLE {$cls} ADD $date1 TINYINT(1) NULL DEFAULT NULL");
			$this->conn->query("UPDATE {$cls} SET {$date1} = 0");
		}

		$stmt=$this->conn->query("SELECT * FROM {$cls} WHERE identity_no ='{$idno}'");
		$row = $stmt->fetch_assoc();


		if(mysqli_num_rows($stmt)!= 0){
			$this->conn->query("UPDATE {$cls} SET {$date1} = 1 WHERE identity_no ='{$idno}'");

			return $row;
		}

		else{
			return false;
		}
		/*if($row['num_rows']=='0'){
		return true;
	}
	else{

}*/



}
catch(PDOException $e)
{
echo $e->getMessage();

}

}



}
?>
