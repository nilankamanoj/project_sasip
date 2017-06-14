<?php
require 'Owner.php';
$SystemUser=Owner::getInstance();
echo "pass1";
$SystemUser->DeleteUser('user4');
echo "pass2";

 ?>
