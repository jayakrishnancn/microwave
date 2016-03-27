<?php

/**
 * Bootstrap
 */
class Bootstrap extends Core
{
	private    $url			="welcome/view";
	private    $guard		=NULL;
	protected  $Config  	=NULL;
	public 		$cache 		=NULL;
	protected  $controller  ="welcome"; 
	protected  $method="view"; 


	function __construct() {

		log_message( "info", "Bootstrap initialized" );
		global $config;
		$this->config=$config;
		$this->addplugin('initilizeadd',$this->config['plugin']."addplugin.php");

		if ( $this->putplugin( 'initilizeadd' ) )
			log_message( "info", "plugin initilizeadd added" );
		/*
		*	parsed url
		*	declared in Core
		*/
		$this->url=$this->parseurl();


		/*
		*	plugin include -0
		*	declared in Core
		*	initilized in Config.php by user
		*/
		if ( $this->putplugin( 0 ) )
			log_message( "info", "plugin added" );



		/*
		*	include Routers
		*	Router defined in Core/Router.php
		*	Used by user in apps/Router/Router.php
		*/
		if ( file_exists( $config['core']."Router.php" ) && file_exists( $config['router']."Router.php" ) ) {
			require_once $config['core']."Router.php";
			log_message( "info", "Router.php included" );
			/*
			*	$this->url is an array
			*
			*/
			$route=new Router( $this->url );

			require_once $config['router']."Router.php";
			log_message( "info", "apps/Router.php included" );

			$this->url=$route->url;

			$this->url=$this->arraytourl( $this->url );

			/*
			*/
			log_message( "info", "Routers added" );
		}


		/*
		*	plugin include -1
		*	declared in Core
		*	initilized in Config.php by user
		*/
		if ( $this->putplugin( 1 ) )
			log_message( "info", "plugin added" );

		/*
		*	include Security
		*	stores in $this->guard varaible
		*/
		if ( file_exists( $config['core']."Security.php" )  ) 
		{
			require_once $config['core']."Security.php";
			log_message( "info", "Security.php included" );

			if ( !isset( $config['ip'] )|| ( empty( $config['ip'] ) ) )
				$config['ip']="deniedips.txt";

			$this->guard=new Security();
			$this->guard->validategetpost();

			$this->guard->setiptxt( $config['ip'] );
			/*
			*	$this->guard->ipdeny();
			*	$this->guard->ipallow();
			*
			*/

			/*
				additional securiy in apps/security
				use $security to access the methods in $this->guard
			*/
			if ( file_exists( $config['security']."Security.php" )  ) 
			{
				$security=&$this->guard;
				require_once $config['security']."Security.php";
				log_message( "info", "apps/Security.php  included" );
			}


			if ( !$this->guard->chkipallowed( $config['ip'] ) ) 
			{
				log_message( "Ip denied" );
				return false;
			}

			/*
			can echo Security::get_csrf_token();
			and Security::check_csrf_token($a);
			*/

		}

		if(file_exists($config['controller'].$this->url[0].'.php'))
		{
			$this->controller=$this->url[0];
		} 
		else{
			$this->controller='error'; 
		}
		unset($this->url[0]);

		require_once $config['core'].'Controller.php';
		require_once $config['controller'].$this->controller.'.php';
		log_message("info","$this->controller included");

		$thispageurl=[$this->controller]; 
		$this->controller=new $this->controller;
		log_message("info","controller object created");
 

		if(isset($this->url[1]))
		{ 

			if(strtolower($this->url[1])!="__construct")
			{
				if(! (method_exists($this->controller,$this->url[1]) && $this->parent_method_exists($this->controller,$this->url[1])) )
				{
					if(method_exists($this->controller,$this->url[1]))
					{
						$this->method=$this->url[1];
						log_message("info","{$this->method} exist  in {controller} ");
					}
					else{
						$this->method="_404error";
					}
				}
					else{
						$this->method="_404error";
					}
			}
			else
			{ 
				$this->method="_404error";
				log_message("info","__construct may exist but not alloweded as  controller/method ");
			}
		}
		else{

				$this->method="_404error";
				log_message("info","no method passed");				
		}
			array_push($thispageurl,$this->method);
			unset($this->url[1]);

 
		$this->url=array_filter($this->url);
		$thispageurl=array_merge($thispageurl,$this->url);
		$this->param=$this->url?array_values($this->url):[];
 		$this->thispageurl=$thispageurl;
 

 		/*
 		* cache.php start here 
 		*/ 
if ( $this->putplugin( "cache/cache_start" ) )
			log_message( "info", "plugin [cache_end] added" );

 

		$this->controller->{$this->method}($this->param);


if ( $this->putplugin( "cache/cache_end" ) )
			log_message( "info", "plugin [cache_end] added" );

		/* cache ends here*/
$this->putplugin();
	}//_constructor end

}
