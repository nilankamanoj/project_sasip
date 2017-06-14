<?php
class TempUser{
private $u__name;
public function __construct($u_name)
{
  $this->u__name=$u_name;
}
public function getName()
{
  return($this->u__name);
}
}
?>
