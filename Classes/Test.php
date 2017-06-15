<?php
require 'class.class.php';

$cls=new Classs();
$row=$cls->fetchClass('phy16');

echo $row['class_name'];
echo $row['teacher_name'];
//$cls->createClass('phy16','mon','7','30','4','amith');
//echo "pass";
//echo $cls->checkClass('phy18');






 ?>
