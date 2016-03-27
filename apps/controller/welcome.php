<?php if( (!defined("BASEPATH") )   )
		die("no direct script allowed  ");
/**
* 
*/
class welcome extends controller
{


  private $actmodel;
  public function __construct()
  {
    parent::__construct(); 
      log_message("info","public model included "); 
  }
  
	public function view($value='')
	{
  		log_message("info","entered in home welcome view"); 
  		$data=['title'=>"Title"]; 
  		$this->_view(["common_start","public_nav","common_end"],$data);
  	}
	 
	
}