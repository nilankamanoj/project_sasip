<?php
$servername = "localhost";
$username = "newuser";
$password = "password";
$dbname = "dblogin";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
   die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, firstname, lastname FROM MyGuests";
$result = $conn->query($sql);


function getrow($username){
  $sql="SELECT user_id, user_name, user_email, user_pass, joining_date, user_level FROM users WHERE user_name=$username";
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
  return($row["user_email"]);

}
$sql="SELECT user_id, user_name, user_email, user_pass, joining_date, user_level FROM users WHERE user_name='user1'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
echo $row["user_email"];


if ($result->num_rows > 0) {
   // output data of each row
   while($row = $result->fetch_assoc()) {
       echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
   }
} else {
   echo "0 results";
}
$conn->close();
?>
