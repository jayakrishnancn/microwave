<?php 

if( (!defined("BASEPATH") )   )
		die("no direct script allowed  ");
/**
* 
*/
class error extends controller
{
	public function __construct($value=''){
		parent::__construct();
	}
	  public function view($value='')
	{
		log_message("info","error/view called");
		$this->_404error();
	} 
	public function error($value='')
	{
		log_message("info","error/error called");
		if(isset($value[0]))
		{
			if(!isset($value[1]))
			{
				$value[1]="";
			}
			$this->_error($value[0],$value[1]);
		}
	}
	public function redirt($value='')
	{
		$a=implode('/',$value);
		$this->_error("Redirecting..","Please wait page is redirecting[in a sec].");
		redir($a,1000);
	}
}