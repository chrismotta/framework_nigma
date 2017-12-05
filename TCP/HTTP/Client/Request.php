<?php

	namespace Aff\Framework\TCP\HTTP\Client;
	
	use Aff\Framework;		


	
	class Request extends Framework\ObjectAbstract  implements RequestInterface
	{
		protected $_url;
		protected $_method;
		protected $_data;
		protected $_agent;
		protected $_timeout;
		protected $_lowSpeedLimit;
		protected $_maxTransferTime;
		protected $_contentType;
		protected $_headers;
		protected $_ip;
		protected $_hostname;
		protected $_port;
        protected $_username;
        protected $_password;
        protected $_cookies;
        protected $_sslVerify;
        protected $_crtPath;
		

		public function __construct( )
		{
			parent::__construct();
			
			$this->_init();
		}


		protected function _init ()
		{
			$this->_method = 'GET';
			$this->_timeout = 0;
			$this->_lowSpeedLimit = 0;
			$this->_maxTransferTime = 0;
			$this->_headers = array();
			$this->_data = array();
            $this->_cookies = array();
            $this->_sslVerify = true;
		}
		
		
		public function setMethod( $method )
		{
			$m = strtoupper($method);
			
			switch ( $m )
			{
				case 'GET':
				case 'POST':				
				case 'PUT':				
				case 'DELETE':
					$this->_method = $m;
				break;
				default:
					throw new Exception( 'Unrecognized HTTP method' );
				break;
			}			
		}
        
        
        public function setURL ( $url )
        {
            $this->_url = $url;
        }
        
        
        public function getURL ( )
        {
            return $this->_url;
        }
        
        
		public function setUsername ( $username )
        {
            $this->_username = $username;
        }

        
		public function setPassword ( $password )
        {
            $this->_password = $password;
        }
        
        
        public function getPassword ( )
        {
            return $this->_password;
        }
        
        
        public function getUsername ( )
        {
            return $this->_username;
        }
		
		
		public function setContentType ( $contentType )
		{
			$this->_contentType = $contentType;
		}

		
		public function getContentType (  )
		{
			return $this->_contentType;			
		}
		
		
		public function setHeader ( $name, $value )
		{
			$this->_headers[$name] = $value;
		}
		
		
		public function hasHeader ( $name )
		{
			if ( isset( $this->_headers[$name] ) )
			{
				return true;
			}
			
			return false;
		}
		
		
		public function getHeaders ( )
		{
			return $this->_headers;
		}
		
		
		public function getHeader ( $name )
		{
			if ( $this->_headers[$name] )
			{
				return $this->_headers[$name];
			}
			
			throw new Exception('Undefined HTTP header: ' . $name);
		}
        
        
		public function setCookie ( $name, $value )
		{
			$this->_cookies[$name] = $value;
		}
		
		
		public function hasCookie ( $name )
		{
			if ( isset( $this->_cookies[$name] ) )
			{
				return true;
			}
			
			return false;
		}
		
		
		public function getCookies ( )
		{
			return $this->_cookies;
		}
		
		
		public function getCookie ( $name )
		{
			if ( isset( $this->_cookies[$name] ) )
			{
				return $this->_cookies[$name];
			}
			
			throw new Exception('Undefined cookie: ' . $name);
		}        
		

		public function removeCookie ( $name )
		{
			unset( $this->_cookies[$name] );
		}		
		

		public function removeHeader ( $name )
		{
			unset( $this->_headers[$name] );
		}		
		
		
		public function getMethod ( )
		{
			return $this->_method;
		}
		
		
		public function setBody ( $body )
		{
			$this->_data = $body;
		}
		
		
		public function getBody ( )
		{
			return $this->_data;
		}          
		
		
		public function setUserAgent ( $userAgent )
		{
			$this->_agent = $userAgent;
		}
		
		
		public function getUserAgent ( )
		{
			return $this->_agent;
		}
		
		
		public function getLifetime ( )
		{
			return $this->_timeout;
		}
		
		
		public function setTimeout( $seconds )
		{
			if ( !is_integer( $seconds ) || $seconds < 0 )
			{
				throw new Exception( 'Could not set timeout: argument must be an integer greater or equal than 0' );
			}
			
			$this->_timeout = $seconds;
		}
		
		
		public function getTimeout ( )
		{
			return $this->_timeout;
		}		
		
		
		public function setLowSpeedLimit ( $bytesPerSecond )
		{
			if ( !is_integer( $bytesPerSecond ) || $bytesPerSecond < 0 )
			{
				throw new Exception( 'Could not set low speed limit: argument must be an integer greater or equal than 0' );
			}
			
			$this->_lowSpeedLimit = $bytesPerSecond;
		}
		
		
		public function getLowSpeedLimit ( )
		{
			return $this->_lowSpeedLimit;
		}
		
		
		public function setMaxTransferTime ( $seconds )
		{
			if ( !is_integer( $bytesPerSecond ) || $bytesPerSecond < 0 )
			{
				throw new Exception( 'Could not set max transfer time: argument must be an integer greater or equal than 0' );
			}
			
			$this->_maxTransferTime = $bytesPerSecond;
		}


		public function getMaxTransferTime ( )
		{
			return $this->_maxTransferTime;
		}


		public function getSourceIp ( )
		{
			return $_SERVER['SERVER_ADDR'];
		}


		public function getSourceHostname ( )
		{
			return $_SERVER['HOSTNAME'];
		}


		public function getSourcePort ( )
		{
			return $_SERVER['SERVER_PORT'];
		}


		public function setDestinationIp ( $address )
		{
			$this->_ip = $address;
		}


		public function setDestinationPort ( $portNumber )
		{
			$this->_port = $portNumber;
		}


		public function setDestinationHostname ( $hostname )
		{
			$this->_hostname = $hostname;
		}


		public function getDestinationIp ( )
		{
			return $this->_ip;
		}


		public function getDestinationPort ( )
		{
			return $this->_port;
		}


		public function getDestinationHostname ( )
		{
			return $this->_hostname;
		}


        public function verifySSLCertificate ( $state = null )
        {
            if ( $state === null )
            {
                return $this->_sslVerify;
            }
            
            $this->_sslVerify = $state;
        }


        public function setSSLCertificatePath ( $path )
        {
            $this->_crtPath = $path;
        }


        public function getSSLCertificatePath ( )
        {
            return $this->_crtPath;
        }
	
	}
	
?>