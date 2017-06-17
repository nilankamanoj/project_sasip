<?php

/**
 *
 */
 require 'dbconfig.php';
class Teacher
{
  private $name;
  private $classconn;

  function __construct($Uname)
  {
    $this->name=$Uname;
    $db=new Database();
    $this->classconn = $db->getConn('dbclasses');
  }
  public function getClasses()
  {

    $stmt=$this->classconn->query("SELECT class_name FROM classes WHERE teacher_name= '{$this->name}'");
    $array = Array();
while($result = $stmt->fetch_assoc()){
    $array[] = $result['class_name'];
}

return $array;
  }
  public function getName()
  {
    return $this->name;
  }
}














 ?>
