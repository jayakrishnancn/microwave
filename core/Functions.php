<?php

if ( ( !defined( "BASEPATH" ) ) || ( !defined( "ABSPATH" ) ) )
	die( "no direct script allowed  " );
/*

common public core  functions

*/

function redir( $to, $time=0, $msg=false ) {
	echo "<script>setTimeout(\"location.href='{$to}'\",{$time});</script>";
	if ( $msg )
		echo "Redirecting .. please wait.";
}
/*$a=array(['log_message']);*/
function log_message( $info='info', $msg='', $var='', $disp=true ) {
	global $config;
	/*global $a;*/
	if ( isset( $config['DEBUG'] ) && isset( $config['SHOWLOG'] ) && ( isset( $info ) ) && ( isset( $msg ) ) ) {
		if ( $config['DEBUG'] && $config['SHOWLOG'] ) {
			if ( $disp ) {
				$info=strtoupper( $info );
				switch ( strtoupper( $info ) ) {
				case 'INFO':
					echo "<b style='color:#1fa67b'>[".$info ."]</b> ";
					break;
				case 'ERROR':
					echo "<b style='color:#f46d57'>[".$info ."]</b> ";
					break;
				case 'TIME':
					echo "<b style='color:#3366cc'>[".$info ."]</b> ";
					break;
				case 'CACHE':
					echo "<b style='color:#F34FFF'>[".$info ."]</b> ";
					break;
				default:
					echo "<b style='color:#555555'>[".$info ."]</b> ";
					break;
				}
				$trace=debug_backtrace()[0];
				echo "<b>".$msg."</b> <i style='color:#6F3F9F'>{ ";
				echo $trace['file'];
				echo " :[";
				echo $trace['line'];
				echo "] }</i>";
				echo "<br/><br/>\n";
			}
			/*			array_push($a,[$info=>$msg]);*/

		}
	}
}
