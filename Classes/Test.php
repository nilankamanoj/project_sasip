<html>
<body>
<select name="teachers">
<<option value="NO">Select teacher</option>
<?php
require 'dbconfig.php';
$db=new Database();
$conn=$db-> dbConnection('dblogin');
$result = $conn->prepare("SELECT user_name FROM users WHERE user_level='1' OR user_level='4'");
$result->execute();
$array = $result->fetchAll(PDO::FETCH_COLUMN);
foreach ($array as &$user_name) {
  echo "<option value=".$user_name.">".$user_name."</option>";
}

?>

  </select>
</body>
</html>
