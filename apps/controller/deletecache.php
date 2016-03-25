<?php

/**
* 
*/
class deletecache extends controller
{
	
	function __construct()
	{
		global $config;
		$this->config=$config;
		include_once $config['plugin'].'/cache/mlcache.php';
		log_message("info","in deletecache __construct ");
	}
	public function view($value=NULL)
	{
		$this->cache=new cache(['time'=>600,'dir'=>$this->config['cache']]);
		$this->cache->delete_cache($value);
	}
}