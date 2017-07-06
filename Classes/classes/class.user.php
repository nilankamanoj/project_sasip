<?php

require_once('class.database.php');

class USER
{

	private $conn;
	private $u__name="default";
	private $sysuser="";
	private $dbase;

	public function __construct()
	{
		$database = new Database();
		$this->dbase=$database;
		$db = $database->dbConnection("dblogin");
		$this->conn = $db;

	}


	public function runQuery($sql)
	{
		$stmt = $this->conn->prepare($sql);

		return $stmt;
	}

	public function register($uname,$umail,$upass,$ulevel)
	{
		try
		{
			$new_password = password_hash($upass, PASSWORD_DEFAULT);

			$stmt = $this->conn->prepare("INSERT INTO users(user_name,user_email,user_pass,user_level)
			VALUES(:uname, :umail, :upass, :ulevel)");

			$stmt->bindparam(":uname", $uname);
			$stmt->bindparam(":umail", $umail);
			$stmt->bindparam(":upass", $new_password);
			$stmt->bindparam(":ulevel", $ulevel);

			$stmt->execute();

			return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}


	public function doLogin($uname,$umail,$upass)
	{
		try
		{
			$stmt = $this->conn->prepare("SELECT user_id, user_name, user_email, user_pass, user_level,permission FROM users WHERE user_name=:uname OR user_email=:umail ");
			$stmt->execute(array(':uname'=>$uname, ':umail'=>$umail));
			$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

			if($stmt->rowCount() == 1)
			{
				if($userRow['permission']!='1')
				{
					return false;
				}
				else if(password_verify($upass, $userRow['user_pass']))
				{
					$_SESSION['user_session'] = $userRow['user_id'];
					$this->level=$userRow['user_level'];
					$rec=$this->dbase->getConn("dbsyslog");
					$rec->query("INSERT INTO syslog(user_name,activity_description) VALUES('{$userRow['user_name']}','logged in')");
					$rec->close();
					return true;
				}
				else
				{
					$rec=$this->dbase->getConn("dbsyslog");
					$rec->query("INSERT INTO syslog(user_name,activity_description) VALUES('{$userRow['user_name']}','invalid password used')");
					$rec->close();
					return false;
				}
			}
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}

	public function is_loggedin()
	{
		if(isset($_SESSION['user_session']))
		{
			return true;
		}
	}

	public function redirect($url)
	{

		header("Location: $url");
	}

	public function doLogout()
	{
		session_destroy();
		unset($_SESSION['user_session']);
		return true;
	}

	public function fetchAll()
	{

		$result =$this->conn->prepare("SELECT user_id, user_name, user_email, user_pass, user_level,joining_date FROM users");
		$result->execute();
		$array = $result->fetchAll(PDO::FETCH_ASSOC);
		return $array;

	}
	public function changePassword($uname,$upass1,$upass2)
	{
		try
		{
			$stmt = $this->conn->prepare("SELECT user_pass FROM users WHERE user_name=:uname");
			$stmt->execute(array(':uname'=>$uname));
			$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

			if(password_verify($upass1, $userRow['user_pass']))
			{

				$new_password = password_hash($upass2, PASSWORD_DEFAULT);

				$stmt = $this->conn->prepare("UPDATE users SET user_pass=:upass WHERE user_name=:uname");

				$stmt->bindparam(":uname", $uname);
				$stmt->bindparam(":upass", $new_password);

				$stmt->execute();

				$rec=$this->dbase->getConn("dbsyslog");
				$rec->query("INSERT INTO syslog(user_name,activity_description) VALUES('{$uname}','password changed')");
				$rec->close();

				//echo "changed";

				return true;
			}
			else
			{
				return false;
				//echo "wrong pass";
			}
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}





}
?>
