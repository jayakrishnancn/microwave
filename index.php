<?php 

$start_time=microtime( true );

define( 'BASEPATH', "" );

define( 'HTTPPATH', "http://$_SERVER[HTTP_HOST]/microwave/" );

define( 'ABSPATH', dirname( __FILE__ ) );

if ( !file_exists( "./core/config.php" ) or ( !file_exists( "./core/functions.php" ) ) )
	exit( "Config not found" );

require_once './core/Functions.php';
require_once './core/Config.php';
require_once './core/Core.php';
require_once './core/Bootstrap.php';

$bootstrap=new  Bootstrap;



//time calculation
$end_time=microtime( true );
$total_time=$end_time-$start_time;
log_message( "TIME", $total_time );

/*
*
*	htmlspecialchars($string,ENT_QUOTES,"UTF-8");
*
*
*
 */
