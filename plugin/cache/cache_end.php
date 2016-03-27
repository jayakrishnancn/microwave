<?php
if(isset($this->cache) &&  empty($_POST)  &&  (! isset($_SESSION['log']))  )
{  
	$this->cache->end_cache();
	die;
}
else{
	ob_end_flush(); 
}