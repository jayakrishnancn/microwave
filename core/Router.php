<?php
/**
 *  class Router for Routing
 *  Functions included
 *    from(x,y) to return url as y when x is the url
 */


class Router {
	public $url=array();
	public $permanenturl=array();
	private $prio=0;
	private $maxprio=0;

	public function __construct( $url='' ) {
		$this->permanenturl=$url;
		$this->prio=0;
		$this->maxprio=0;
		/*
		*		array filering
		*/
		if ( empty( $this->permanenturl[2] ) ) {
			unset( $this->permanenturl[2] );
		}
		/*
		*	unset if view
		*//*
		if ( $this->permanenturl[1]=="view" )
			unset( $this->permanenturl[1] );
		*/
		$this->permanenturl=array_filter( $this->permanenturl );
		$this->url=$this->permanenturl;

	}
	private function redirect_to( $case='strict', $from=NULL, $to=NULL , $prio=0 , $redir=false ) {
		$from=explode( '/', $from );
		$from=array_filter( $from );
		$this->prio=( $prio==0 )?sizeof( $from ):$prio;

		if ( !isset( $from[0] ) ||$from[0]==" " ) {
			$from[0]="welcome";
		}
		if ( !isset( $from[1] ) ) {
			$from[1]="view";
		}
		switch ( $case ) {
		case 'similar':
			log_message( "info" , "case 'similar' invoked" );

			foreach ( $from as $key => $value ) {
				if ( !isset( $this->permanenturl[$key] ) ) {
					log_message( "info", "permanenturl not set &  matching from [2]" );
					return false;
				}

				if ( preg_match( '[\\[[a-zA-Z0-9_]*\\]]', $value ) ) {

					$to=str_replace( $value, $this->permanenturl[$key], $to );
					$from[$key]=$this->permanenturl[$key];


				}
				if ( $from[$key]!=$this->permanenturl[$key] ) {
					log_message( "info", "not matching [1]" );
					return false;
				}
			}


			break;
			/*
				*	case from strict check case
				 */
		case 'from' :
		case 'redir':

			log_message( "info" , "case 'from' invoked" );
			foreach ( $from as $key => $value ) {
				if ( !isset( $this->permanenturl[$key] ) ) {
					log_message( "info", "permanenturl not set &  matching from [2]" );
					return false;
				}
				if ( preg_match( '[\\[[a-zA-Z0-9_]*\\]]', $value ) ) {

					$to=str_replace( $value, $this->permanenturl[$key], $to );
					$from[$key]=$this->permanenturl[$key];

				}
			}

			if ( $this->permanenturl!=$from ) {
				log_message( "info", "not matching [1]" );
				return false;
			}
			break;
			/*
			*	default no case so error and return
			 */
		default:
			log_message( "info" , "default case invoked" );
			log_message( "error", "no case found To Route" );
			return false;
			break;
		}


		if ( $redir ) {
			if ( filter_var( $to, FILTER_VALIDATE_URL ) === false )
				$backword="./".str_repeat( '../', sizeof( $from )-1 );
			else $backword="";

			redir( $backword.$to, 0, "Redirecting! please Wait... " );
			return true;
		}

		if ( !is_string( $this->prio )    ) {
			if  ( $this->prio<$this->maxprio ) {
				log_message( "info", "less priority check " );
				return false;
			}
		}
		else if ( $this->prio!="max" ) {
				log_message( "error", "String not max Route prio" );
				return false;
			}
		$this->maxprio=$this->prio;
		$To=$this->seperateslash( $to );


		$this->url=array_slice( $this->url, $key+1 );

		$this->url=array_merge( $To, $this->url );
		/*
			$this->url=array_replace( $this->url, $To );
		 */
	}

	/*
	*	usage
	* 	$route->from('home/view','author/name');
	*
	*
	 */
	public function similar( $from=NULL, $to=NULL , $prio=0 ) {
		$this->redirect_to( 'similar', $from, $to, $prio );

	}
	public function from( $from=NULL, $to=NULL , $prio=0 ) {


		$this->redirect_to( 'from', $from, $to, $prio );


	}
	protected function seperateslash( $url ='' ) {
		$url=explode( '/', filter_var( rtrim( $url."/", FILTER_SANITIZE_URL ) ) );
		$url=array_filter( $url );
		return $url;
	}



	public function db( $config='' ) {
		// Create connection
		log_message( "info", "checking database for link Routes" );
		$conn = new mysqli( $config['servername'], $config['username'], $config['password'], $config['dbname'] );
		// Check connection
		if ( $conn->connect_error ) {
			log_message( "Connection failed: " . $conn->connect_error );
			return false;
		}
		if ( !isset( $config['prio'] ) )$p=' ';
		else $p=" , ".$config['prio']." ";

		$sql = "SELECT ".$config['from'].",".$config['to']." ".$p." FROM ".$config['table']." ";
		$result = $conn->query( $sql );

		if ( $result->num_rows > 0 ) {
			while ( $row = $result->fetch_assoc() ) {
				/*
				*	Have to find a better way
				 */
				if ( isset( $config['prio'] ) )
					$this->from( $row[$config['from']] , $row[$config['to']], $row[$config['prio']]     );
				else
					$this->from( $row[$config['from']] , $row[$config['to']], 0 );


			}
		}
	}
	public function redirect( $from='', $to='', $prio='' ) {

		$this->redirect_to( 'redir', $from, $to, $prio, true );
	}

}
