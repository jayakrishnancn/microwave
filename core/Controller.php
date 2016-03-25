<?php
if( (!defined("BASEPATH") )   )
		die("no direct script allowed  ");
		
class Controller{   
	private $config=NULL;
	public function __construct(){ 
		global $config;
		$this->config=$config;
		log_message("info","*controller class initialized"); 
	} 

	public function _view($url=[],$data=[])
	{ 
		$title=(!empty($config['title']))?$config['title']:"Microwave";
		if(isset($data))
			foreach ($data as $key => $value) {
				$$key=$value; 
			}
		if(is_array($url))
		foreach ($url as $value)
		{

			if(file_exists($this->config['view'].$value.".php"))
			{ 
				require_once  $this->config['view'].$value.".php";
 			}
			else 
				log_message("error","$value not found");
		}
		else{

			if(file_exists($this->config['view'].$url.".php"))
			{
				require_once $this->config['view'].$url.".php";
 			}
			else 
				log_message("error","$url not found");	
		} 
	}
 
	public function _404error(){ 
		$this->_error('404 Error','Page Not Found Or Moved','#d43f3a');
	}
	public function _autherror(){ 
		$this->_error('401 Error','Page not Foud Or Authentication Problem ','#1d9d74');
	}
	public function _401error(){ 
		$this->_error('401 Error','Page not Foud Or Authentication Problem ');
	}
	public function _400error(){ 
		$this->_error('400 Error','Bad request  ');
	}
	public function _403error(){ 
		$this->_error('400 Error','Page / file Forbidden  ');
	} 
	public function _error($h='',$msg='',$prim_color='#d43f3a'){
		include_once $this->config['view']."default/error.php";
	}
	public function parent_method_exists($object,$method)
	{
	    foreach(class_parents($object) as $parent)
	    {
	        if(method_exists($parent,$method))
	        {
	           return true;
	        }
	    }
	    return false;
	}
	
	 
}