<?php
/**
* 
*/

class MlCache 
{
	private $cache;
	private $config;
	private $whitelist;
	private $mlcachepath;
	private $dir;
	private $iscached=false;
	function __construct($path='./mlcache/cache.php',$dir='./cache/')
	{
		global $config;
		$this->config=$config;
		$this->cache=null; 
		$this->mlcachepath=$path;
		$this->dir=$dir; 
		$this->blacklist=['admin','deletecache'];

	}
	public function start($url,$fun='')
	{
		if((!isset($_SESSION['log']))  && ((!isset($_POST))||(empty($_POST)) ) )
		{
			require_once $this->mlcachepath;
			$url=implode('/', $url);
			
			$this->cache=new cache(['time'=>600,'dir'=>$this->dir]);
 			 
			$this->cache->blacklisturl(['deletecache']);
			$this->cache->thispage($url);
			$this->cache->start_cache($fun);
		}
	}
	public function end()
	{
		if($this->cache!=null)
		{ 
			$this->cache->end_cache(); 
		}
	}
	public function whitelist($value)
	{
		$this->white_list=$value;
	}
}