<?php
require('Class1.php');
echo Class1::getCount();
$obj = new Class1(5);
$obj1 = new Class1(50);
echo Class1::getCount();
$obj2 = new Class1(6);
$obj3 = new Class1(7);
echo Class1::getCount();


echo $obj->getId();
echo $obj1->getId();
echo $obj2->getId();
echo $obj3->getId();
echo Class1::getCount();



 ?>
