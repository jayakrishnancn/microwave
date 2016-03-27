<?php

define('MLCACHE','1.0');

class cache{
	private $cachedir;
	private $dbdir;
	private $cachetime;
	private $cacheext;
	private $white_list;
	private $page;
	private $cachefile;
	private $ignore_page;

	public function __construct($arr='')
	{
		$this->cachedir=isset($arr['dir'])?$arr['dir']:'./cache/'; //dir to cache files

		$this->cachetime=isset($arr['time'])?$arr['time']:600; //seconds to cache files for

		$this->cacheext  =isset($arr['ext'])?$arr['ext']:'htm'; //extension to give cached files

		$this->dbext=isset($arr['dbext'])?$arr['dbext']:'db';
		// white & black list 
		$this->white_list=array( );
		$this->black_list=array( );
		//script
		$this->page='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

		$this->cachefile=$this->cachedir.md5($this->page).".".$this->cacheext;  //chache file to load or create 

		$this->ignore_page=false;
	}
	public function _get($value='')
	{
		return $this->$value;
	}
	public function thispage($value='')
	{
		if($value==='')
			return false;
		$this->page=strtolower($value);
	}
	public function start_cache($funstart='',$funend='')
	{

		for($i=0;$i<count($this->black_list);$i++)
		{ 
			if($this->page===$this->black_list[$i])
			{
				$this->ignore_page=true;
				break;
			}
			else{
					$b_link=explode('/',filter_var(rtrim($this->black_list[$i], FILTER_SANITIZE_URL)));
					$b_link=array_filter($b_link); 

					$t_link=explode('/',filter_var(rtrim($this->page, FILTER_SANITIZE_URL)));
					$t_link=array_filter($t_link); 
					if($t_link[0]===$b_link[0])
					{
						if(!isset($b_link[1]))
						{
							$this->ignore_page=true;
							break;
						}
						else
						{
							if($t_link[1]==$b_link[1]){ 
							$this->ignore_page=true;
							break;
							}
						}
					}

				}

			}

		$this->cachefile_created=((file_exists($this->cachefile)) and ($this->ignore_page===false))?filemtime($this->cachefile):0;

		clearstatcache(); 
		if(time()-$this->cachetime<$this->cachefile_created)
		{
			log_message("cache","Cached copy");
			if($funstart!=='')
			{
				$r=$funstart();
			
			log_message("cache","callback function fun start in start_cache finished");
			}//ob_start('ob_gzhandler');
			readfile($this->cachefile);
			//ob_end_flush();
			$r=0;
			
			if($funend!=='')
			{ 
				$funend();
				log_message("cache","callback function fun end in start_cache finished");
			}	
			log_message("cache","start_cache finished Stoping activities");
			die();
		}
		ob_start();
		log_message("cache","ob started");
	}
	public function end_cache()
	{
		if($this->ignore_page==false)
		{ 
			$this->write_file($this->cachefile,ob_get_contents());
			ob_end_flush();
		}
		log_message("cache","ob ob ended");

	} 
	public function delete_cache($file=null,$ext='cache',$hash=true)
	{
		if($handle=opendir($this->cachedir))
		{
			if($file==null)
			{
				while (false!==($file=readdir($handle))) 
				{
					if($file!='.' and $file!='..')
					{
						echo $file.'deleted.<br/>';
						unlink($this->cachedir."/".$file);
					}
				}
			}
			else{
				if(is_array($file))
				{
					foreach ($file as $key => $value) {
						if(file_exists($this->cachedir."/".md5($file[$key]).".".$ext))
							unlink($this->cachedir."/".md5($file[$key]).".".$ext);
					}
				}
				else
				{
						if(file_exists($this->cachedir."/".md5($file).".".$ext))
							unlink($this->cachedir."/".md5($file).".".$ext);
				}
			}

			closedir($handle);
		}
	}
	public function whitelisturl($value)
	{
		$this->white_list=array_map('strtolower', $value);
	}
	public function blacklisturl($value)
	{
		$this->black_list=array_map('strtolower', $value);
	}
	public function cache_sql($sql='')
	{
		if($sql==='')
		{
			return false;
		}
		$filepath=$this->cachedir.md5($sql).time().".".$this->dbext;

		if (FALSE === ($cachedata = @file_get_contents($filepath)))
		{
			return FALSE;
		}
		return unserialize($cachedata);
	}
	public function write_sql($sql, $object)
	{
		@log_message("info","inside cache write_sql");
		$filepath=$this->cachedir.md5($sql).time().".".$this->dbext;

		if ($this->write_file($filepath, serialize($object)) === FALSE)
		{
			return FALSE;
		}

		chmod($filepath, 0640);
		return TRUE;
	}
	public function delete_sql($file='')
	{
		$this->delete_cache($file,$this->dbext);		
	}
	public function write_file($path='',$str='')
	{
		if($path===''|| $str==='')
			return false;

		$fp=fopen($path,'w');
		fwrite($fp,$str);
		fclose($fp);

		return true;
	}


}
