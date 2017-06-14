<?php

require_once('dbconfig.php');

class Student
{

	private $conn;


	public function __construct()
	{
		$database = new Database();
		$db = $database->dbConnection("students");
		$this->conn = $db;
    }

	public function runQuery($sql)
	{
		$stmt = $this->conn->prepare($sql);

		return $stmt;
	}
  /*identity_no
  first_name
  last_name
  phone_number
  school_name
  added_by`*/

	public function register($idno,$fname,$lname,$pnum,$schname,$addedby)
	{
		try
		{
			//$new_password = password_hash($upass, PASSWORD_DEFAULT);

			$stmt = $this->conn->prepare("INSERT INTO students(identity_no,first_name,last_name,phone_number,school_name,added_by)
		                                               VALUES(:idno,:fname,:lname,:pnum,:schname,:addedby)");

			$stmt->bindparam(":idno", $idno);
			$stmt->bindparam(":fname", $fname);
			$stmt->bindparam(":lname", $lname);
			$stmt->bindparam(":pnum", $pnum);
      $stmt->bindparam(":schname", $schname);
      $stmt->bindparam(":addedby", $addedby);

			$stmt->execute();

			return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}

	}

public function fetchStudent($idno)
{

	$stmt1=$this->conn->query("SELECT  identity_no,first_name,last_name,phone_number,school_name,added_by FROM students WHERE identity_no ='{$idno}'");
	$this->conn->query("INSERT INTO pointers(student_id) VALUES('{$idno}')");
	$row = $stmt1->fetch(PDO::FETCH_ASSOC);

	return($row);
}

public function makeFree()
{
	$stmt1=$this->conn->query("SELECT student_id FROM pointers ORDER by id DESC LIMIT 1");
	$row1=$stmt1->fetch(PDO::FETCH_ASSOC);
	$idno=$row1['student_id'];
$this->conn->query("UPDATE students SET free = '1' WHERE identity_no='{$idno}'");
}


}
//INSERT INTO users(user_name,user_email,user_pass,user_level) VALUES('user2','user2@com.com','password2',2);
?>
