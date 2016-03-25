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
  		$data=['title'=>"IEEE SCTCE  | Home"];
      $view_location="views";
  		$this->_view($view_location,$data);
  	}
	 
	
}