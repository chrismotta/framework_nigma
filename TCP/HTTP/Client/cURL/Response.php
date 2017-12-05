<?php

	namespace Aff\Framework\TCP\HTTP\Client\cURL;
	
	use Aff\Framework;		

	
	
	class Response extends Framework\ObjectAbstract implements Framework\TCP\HTTP\Client\ResponseInterface
	{
	
		protected $_data;


		public function __construct ( Framework\TCP\HTTP\Client\cURL $client )
		{
			parent::__construct();

			$this->_data = $client->getLastResponseData( );

			if ( !$this->_data )
			{
				throw new Exception( 'Error creating HTTP client (cURL) response, server has made no requests.' );
			}
		}
		
		
		public function getHeader ( $name )
		{
			if ( !isset( $this->_data['headers'][$name] ) )
			{
				return null;
			}
			
			return $this->_data['headers'][$name];
		}
		
		
		public function getHeaders ( )
		{
			return $this->_data['headers'];
		}
		
		
		public function getCookies ( )
		{
			return $this->_data['cookies'];
		}


		public function getCookie ( $name )
		{
			if ( isset( $this->_data['cookies'][$name] ) )
			{
				return $this->_data['cookies'][$name];
			}
			
			return null;
		}		


		public function hasCookie ( $name )
		{
			if ( isset( $this->_data['cookies'][$name] ) )
			{
				return true;
			}
			
			return false;
		}		
		

		public function hasHeader ( $name )
		{
			if ( isset( $this->_data['headers'][$name] ) )
			{
				return true;
			}
			
			return false;
		}	
		

		public function getStatus ( )
		{
			return $this->_data['http_code'];
		}	
		

		public function getUserAgent ( )
		{
			return $this->_data['user_agent'];
		}		
		

		public function getContentType ( )
		{
			return $this->_data['content_type'];
		}
		
		
		public function getSourceIp ( )
		{
			return $this->_data['primary_ip'];
		}
		
		
		public function getSourcePort ( )
		{
			return $this->_data['primary_port'];
		}			
		

		public function getDestinationIp ( )
		{
			return $this->_data['local_ip'];
		}		
		

		public function getDestinationPort ( )
		{
			return $this->_data['local_port'];
		}	
		

		public function getTransactionTime ( )
		{
			return $this->_data['total_time'];
		}	
		
		
		public function getDownloadedBytes ( )
		{
			return $this->_data['size_download'];
		}		
		
		
		public function getUploadedBytes ( )
		{
			return $this->_data['size_upload'];
		}				
		
		
		public function getAverageDownloadSpeed ( )
		{
			return $this->_data['speed_download'];
		}				
		

		public function getAverageUploadSpeed ( )	
		{
			return $this->_data['speed_upload'];
		}


		public function getHeaderSize ( )
		{
			return $this->_data['header_size'];
		}
		
		
		public function getRequestSize ( )
		{
			return $this->_data['request_size'];
		}

		
		public function getNameLookupTime ( )
		{
			return $this->_data['name_lookup_time'];
		}
		
		
		public function getDestinationHostname ( )
		{
			return $_SERVER['HOSTNAME'];
		}


		public function getSourceHostname ( )
		{
			return \gethostbyaddr ( $this->getSourceIp() );
		}
        
        
        public function getBody ( )
        {
            return $this->_data['body'];
        }

	}
?>