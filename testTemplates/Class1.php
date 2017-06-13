<?php
/**
 *
 */
/**
 *
 */
class Class1
{
  private $d=0;
  private Static $count =0;

  public function __construct($idin)
  {
    $this->id=$idin;
    self::$count++;
  }

  public function getId(){
    return($this->id);
  }

  public static function getCount(){
    return(self ::$count);
  }
}



 ?>
