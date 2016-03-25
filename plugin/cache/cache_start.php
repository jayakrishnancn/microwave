<?php
global $config; 

if(( empty($_POST) ) && (! isset($_SESSION['log']))){
  
	log_message("info","not a post or  session not log");
	if(file_exists($config['plugin'].'/cache/mlcache.php'))
	{ 
		require_once $config['plugin'].'/cache/mlcache.php';

		$thispage=$this->thispageurl; 

		$thispage=implode('/', $thispage);

		$this->cache=new cache(['time'=>600,'dir'=>$config['cache']]);
		
		$this->cache->thispage($thispage); 

		$this->cache->blacklisturl(['deletecache']); 

		$this->cache->start_cache(function(){
			global $start_time;
			$end_time=microtime( true );
			$total_time=$end_time-$start_time;
			log_message( "TIME", $total_time );
		});
	 
	}

}