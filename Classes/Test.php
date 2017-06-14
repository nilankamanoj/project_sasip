<?php
require('Owner.php');
echo "ok1";
$SystemUser=Owner::getInstance();
echo "pass2";
if($SystemUser->hasNewUsers()){
  echo "has";
}
else {
  echo "no";
}


?>
