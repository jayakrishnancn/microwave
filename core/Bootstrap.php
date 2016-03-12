<?php

/**
 * Bootstrap
 */
class Bootstrap extends Core
{
	private $url=NULL;
	private $guard=NULL;
	protected $config=NULL;
	function __construct() {
		log_message( "info", "Bootstrap initialized" );
		global $config;
		$this->config=$config;

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
		if ( file_exists( $config['core']."Security.php" )  ) {
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
		if ( file_exists( $config['security']."Security.php" )  ) {
				$security=&$this->guard;
				require_once $config['security']."Security.php";
				log_message( "info", "apps/Security.php  included" );
			} 


			if ( !$this->guard->chkipallowed( $config['ip'] ) ) {
				log_message( "Ip denied" );
				return false;
			}

			/*
			*/

			log_message( "info", "security added" );
		}


	}


}
?>
