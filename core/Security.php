<?php
defined( 'BASEPATH' ) or exit( 'No direct script access allowed' );
/**
 *  Security
 */
class Security {
	private $iptxt='deniedips.txt';


	function __construct() {
		log_message( "info", "in Security.php" );
		if (session_status() == PHP_SESSION_NONE) {
			session_start();
			log_message("info","session started");
		}
	}

/*
*	to filter all get and post variables
*	xss security measures
*/
	public function validategetpost() {
		foreach ( $_GET as $key => $value ) {
			$_GET[$key]=htmlspecialchars( $_GET[$key], ENT_QUOTES, "UTF-8" );
		}
		foreach ( $_POST as $key => $value ) {
			$_POST[$key]=htmlspecialchars( $_POST[$key], ENT_QUOTES, "UTF-8" );
		}
	}
/*
*
*	ip related functions 
*
*
*
*/




	/*
	* Function to get the client IP address
	*/
	private function get_client_ip() {
		$ipaddress = '';
		if ( isset( $_SERVER['HTTP_CLIENT_IP'] ) )
			$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
		else if ( isset( $_SERVER['HTTP_X_FORWARDED_FOR'] ) )
				$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		else if ( isset( $_SERVER['HTTP_X_FORWARDED'] ) )
				$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
		else if ( isset( $_SERVER['HTTP_FORWARDED_FOR'] ) )
				$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
		else if ( isset( $_SERVER['HTTP_FORWARDED'] ) )
				$ipaddress = $_SERVER['HTTP_FORWARDED'];
		else if ( isset( $_SERVER['REMOTE_ADDR'] ) )
				$ipaddress = $_SERVER['REMOTE_ADDR'];
		else
			$ipaddress = 'UNKNOWN';
		return $ipaddress;
	}
	/*
	*	to check ip address id allowd in ipdeny.txt file
	*/
	public function chkipallowed( $file=NULL ) {
				log_message("ip checking");
 		if($file===NULL)
 			$file=$this->iptxt;

		if ( !file_exists( $file ) )
			if(!fopen($file, "w"))
				return false;

		$o=explode(',', file_get_contents( $file) ); 

			if(in_array($this->get_client_ip(),$o))
			{
				log_message("ip found to deny");
			return false;
			}
			else
				return true;
	}
	/*
	 *to deny current ip
	 */
	public function ipdeny($file=NULL,$ip=NULL)	
	{
				log_message("ip checking for deny");
 		
 		if($file===NULL)
 			$file=$this->iptxt;

 		if($ip===NULL)
 			$ip=$this->get_client_ip();
		file_put_contents($file,$ip.",");
	}
	/*
	*	to set ipdeny txt file path 
	*/

	public function setiptxt($value='deniedips.txt')
	{
		$this->iptxt=$value;
	}
	/* 
	*	to allow current,specified ip address
	*/



	public function ipallow($file=NULL,$ip=NULL)
	{
				log_message("ip checking for allow");
 		if($file===NULL)
 			$file=$this->iptxt;

 	if($this->chkipallowed($file))
 		return true;
 		if($ip===NULL)
 			$ip=$this->get_client_ip();
 		$inp=file_get_contents($file);
 		$inp=str_replace($ip.","," ", $inp);
 		var_dump($inp);
 		log_message("info","ip allowed");
 		
		file_put_contents($file,$inp);  
	}


	/*
	*    csrf protectoin follows
	*
	*
	*
	*/
/*
*	uses sha1
*	use Security::get_csrf_token() to generete csrf token
*/
	private static function generate_csrf_token()
	{
		return $_SESSION['csrf_token']=sha1(openssl_random_pseudo_bytes(32));
	}
	public static function get_csrf_token()
	{
		if(!isset($_SESSION['csrf_token']))
		{
			self::generate_csrf_token();
			log_message("info","csrf generated");
		}
		return $_SESSION['csrf_token'];
	}
	public static function check_csrf_token($value=NULL)
	{
		if( (isset($_SESSION['csrf_token'])) && ($value===$_SESSION['csrf_token']))
		{
			unset($_SESSION['csrf_token']);
		log_message("info","csrf token matchig");
		log_message("info","csrf token unseted");
			return true;
		}
		log_message("error","csrf token missing");
		return false;
	}





}
