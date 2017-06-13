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




}
//INSERT INTO users(user_name,user_email,user_pass,user_level) VALUES('user2','user2@com.com','password2',2);
?>
