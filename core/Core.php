<?php

/**
 * Core
 */
class Core {
	public $plugins=array( array() );

	protected function parseurl( $string=NULL ) {
		if ( $string==NULL )$string="welcome/view";
		$url=isset( $_GET['url'] )? strip_tags( $_GET['url'] ) :$string;
		$url=$this->seperateslash( $url );
		$url[1]=isset( $url[1] )?$url[1]:"view";//method
		$url[2]=isset( $url[2] )?$url[2]:[];// arg
		return $url;
	}
	protected function arraytourl( $value=NULL ) {
		if ( $value==NULL||( !is_array( $value ) ) )
			$value=array( 'welcome', 'view' );
		array_filter( $value );
		if ( !isset( $value[0] ) )
			$value[0]="welcome";
		if ( !isset( $value[1] ) )
			$value[1]="view";
		if ( !isset( $value[2] ) )
			$value[2]=array();
		return $value;

	}

	protected function seperateslash( $url ) {

		$url=explode( '/', filter_var( rtrim( $url."/", FILTER_SANITIZE_URL ) ) ); 
		$url=array_filter( $url ); 
		return $url;
	}
	public function parent_method_exists( $object, $method ) {
		foreach ( class_parents( $object ) as $parent ) {
			if ( method_exists( $parent, $method ) ) {
				return true;
			}
		}
		return false;
	}
	/* distructor */
	public function __destruct() {
		log_message( "info", "Core dead" );
	}

	/*
	*	To incude plugins in each point
	 */

	public function addplugin( $index=NULL, $link=NULL ) {
		if ( ( $link==NULL )||( $index==NULL ) )
			return false;
		array_push( $this->plugins[$index], $link );
		return true;
	}
	public function putplugin( $index=NULL ) {
		if ( $index==NULL )
			return false;
		$ret=false;
		if ( !isset( $this->plugins[$index] ) )
			return false;
		foreach ( $this->plugins[$index] as $key => $value ) {
			if ( file_exists( $value ) ) {
				$ret=true;
				include "$value";
				log_message( "info", " {$value} included " );
			}
			else {
				log_message( "error", "file {$value} not found not included" );
			}
		}
		return $ret;
	}


}
