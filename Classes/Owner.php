<?php
/**
 *
 */
class Owner
{

  private static $instance;

  private function __construct()
  {
    echo "newly consructed";
  }
  private function __clone(){

  }
 public function getInstance(){
   if(self::$instance==null){
     self::$instance=new Owner();
   }
   else {
     echo "also created";
   }
   return(self::$instance);
 }
}




 ?>
