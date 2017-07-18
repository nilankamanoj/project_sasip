<?php
require_once("classes/connecter.php");
$stu=new student();
echo "pass";
$num=$stu->getCount("phy18");
$stu->setCount('phy18',1);
?>
