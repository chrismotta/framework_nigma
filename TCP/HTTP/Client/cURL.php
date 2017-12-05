<?php

	namespace Aff\Framework\TCP\HTTP\Client;
	
	use Aff\Framework;		


	
	
	class cURL extends Framework\ObjectAbstract implements Framework\TCP\HTTP\ClientInterface
	{

		protected $_singleHandler;
		protected $_multiHandler;
		protected $_info;
        protected $_error;


		public function __construct( )
		{
			parent::__construct();
            
            $this->_error = false;
		}


		public function reset ( )
		{
			$this->_info = null;
            $this->_error = false;
            \curl_reset ( $this->_singleHandler );
		}		
		

		public function send ( Framework\TCP\HTTP\Client\RequestInterface $request )
		{			
            
            if ( !$request instanceof RequestInterface )
            {
                throw new Exception( 'Argument must implement Framework\TCP\HTTP\Client\RequestInterface'  );
            }

			if ( !$this->_singleHandler )
			{
				$this->_singleHandler = \curl_init( $request->getURL() );			
			}		

            $this->_setOptions( $request, $this->_singleHandler );
            
            if ( $this->_info )
            {
                $this->reset();
            }            

			$response = \curl_exec ( $this->_singleHandler );                        
            
			if ( $response )
			{
				$this->_info = $this->_readInfo ( $response, $this->_singleHandler );
                
				\curl_close( $this->_singleHandler );
                
				return new cURL\Response( $this );
			}
            
            $e = array(
                'message' => \curl_error( $this->_singleHandler ),
                'code' => \curl_errno( $this->_singleHandler )
            );
            
            if ( $e['message'] || $e['code'] )
            {
                $this->_error = $e;
            }

            \curl_close( $this->_singleHandler );
            
			return false;
		}


		private function _readInfo ( $response, $handler )
		{
			$headers = array();
            $cookies = array();
            $local_ip = null;
            $local_port = null;
            $remote_ip = null;
            $remote_port = null;            

			$headerSize = \curl_getinfo( $handler, \CURLINFO_HEADER_SIZE );						
			$headerParts = \preg_split( "(/n)", \substr( $response, 0, $headerSize ) );
			$headers['status'] = $headerParts[0];            
			
			\array_shift( $headers );
			
			foreach ( $headerParts as $header )
			{
				$half = \preg_split ( "(:)", $header );
				$name = \str_replace( ' ', '', $half[0] );
				$value = \str_replace( ' ', '', $half[1] );
				
				$headers[$name] = $value;
			}

			if ( isset( $headers['cookie'] ) )
			{
				$cookieParts = \preg_split( "(;)", $headers['cookie'] );
				
				foreach ( $cookieParts as $cookie )
				{
					$half = \preg_split( "(:)", $cookie );
					$name = \str_replace( ' ', '', $half[0] );
					$value = \str_replace( ' ', '', $half[1] );
					
					$cookies[$name] = $value;
				}
			}

            if ( defined( '\CURLINFO_PRIMARY_IP' ) )
            {
                $remote_ip = \curl_getinfo( $handler, \CURLINFO_PRIMARY_IP );
            }
            
            if ( defined( '\CURLINFO_PRIMARY_PORT' ) )
            {
                $remote_port = \curl_getinfo( $handler, \CURLINFO_PRIMARY_PORT );
            }        

            if ( defined( '\CURLINFO_LOCAL_IP' ) )
            {
                $local_ip = \curl_getinfo( $handler, \CURLINFO_LOCAL_IP );                
            }
            
            if ( defined( '\CURLINFO_LOCAL_PORT' ) )
            {
                $local_port = \curl_getinfo( $handler, \CURLINFO_LOCAL_PORT );
            }              
            
			return array(                                
				'local_ip' => $local_ip,
				'local_port' => $local_port,
				'remote_ip' => $remote_ip,
				'remote_port' => $remote_port,
				'time_total' => \curl_getinfo( $handler, \CURLINFO_TOTAL_TIME ),
				'time_connecting' => \curl_getinfo( $handler, \CURLINFO_CONNECT_TIME ),
				'time_name_lookup' => \curl_getinfo( $handler, \CURLINFO_NAMELOOKUP_TIME ),
				'time_pretransfer' => \curl_getinfo( $handler, \CURLINFO_PRETRANSFER_TIME ),
				'time_redirecting' => \curl_getinfo( $handler, \CURLINFO_REDIRECT_TIME ),
				'download_size' => \curl_getinfo( $handler, \CURLINFO_SIZE_DOWNLOAD ),
				'download_speed' => \curl_getinfo( $handler, \CURLINFO_SPEED_DOWNLOAD ),
				'upload_size' => \curl_getinfo( $handler, \CURLINFO_SIZE_UPLOAD ),
				'upload_speed' => \curl_getinfo( $handler, \CURLINFO_SPEED_UPLOAD ),
				'redirect_count' => \curl_getinfo( $handler, \CURLINFO_REDIRECT_COUNT ),
				'ssl_verify_result' => \curl_getinfo( $handler, \CURLINFO_SSL_VERIFYRESULT ),
				'header_size' => $headerSize,
				'headers' => $headers,
				'cookies' => $cookies,
				'body' => substr( $response, $headerSize )
			);		
		}


		public function sendMultiple ( RequestCollection $requests )
		{
			if ( !$this->_multiHandler )
			{
				$this->_multiHandler = \curl_multi_init();
			}

			foreach ( $requests as $request )
			{
				$resource = \curl_init( $reguest->getUrl() );
				
				$this->_setOptions( $request, $resource );
				\curl_multi_add_handle( $this->_curlHandler, $resource );			
			}

			do 
			{
				$status = \curl_multi_exec( $this->handle, $active );
				
				if ( $state = \curl_multi_info_read( $this->handle ) )
				{
					$info = \curl_getinfo( $state['handle'] );
				
					$callback( \curl_multi_getcontent( $state['handle'] ), $info );
					\curl_multi_remove_handle( $this->handle, $state['handle'] );
				}

				Packages\Script\Helper::delay( 10000 );
			}
			while ( $status === \CURLM_CALL_MULTI_PERFORM || $active );
		}


		private function _setOptions( Request $request, $handler ) 
		{
			\curl_setopt ( $handler, \CURLOPT_URL, $request->getURL() );
			\curl_setopt ( $handler, \CURLOPT_RETURNTRANSFER, true );
			\curl_setopt ( $handler, \CURLOPT_VERBOSE, 1 );
			\curl_setopt ( $handler, \CURLOPT_HEADER, 1 );	
			
			if ( $request->getMethod() == 'POST')
			{	
                $data = $request->getData();
				\curl_setopt ( $handler, \CURLOPT_POST, true );                
                             
                if ( Packages\Type\Helper::isArray( $data ) )
                {
                    \curl_setopt ( $handler, \CURLOPT_POSTFIELDS, Packages\Type\ArrayHelper::toHttpQueryString( $data ) );
                }
                else if ( Packages\Type\Helper::isObject( $data ) )
                {
                    \curl_setopt ( $handler, \CURLOPT_POSTFIELDS, Packages\Object\Helper::toHttpQueryString( $data ) );
                }                
                else
                {
                    \curl_setopt ( $handler, \CURLOPT_POSTFIELDS, $data );
                }
			}

			if ( $request->getContentType() )
			{				
				$this->_headers[] = 'Content-Type: ' . $request->getContentType();
			}
            
            if ( $request->verifySSLCertificate() )
            {                
                //\curl_setopt ( $handler, \CURLOPT_SSL_VERIFYSTATUS, 1 );
                \curl_setopt ( $handler, \CURLOPT_SSL_VERIFYPEER, 1 );
                \curl_setopt ( $handler, \CURLOPT_SSL_VERIFYHOST, 2);
                
                if ( $request->getSSLCertificatePath() )
                {
                    \curl_setopt($ch, \CURLOPT_CAINFO, $request->getSSLCertificatePath() );
                }
            }
            else
            {
                //\curl_setopt ( $handler, \CURLOPT_SSL_VERIFYSTATUS, 0 );
                \curl_setopt ( $handler, \CURLOPT_SSL_VERIFYPEER, 0 );
            }

			$cookies = $request->getCookies();
			if ( $cookies && !Packages\Type\ArrayHelper::isEmpty( $cookies ) )
			{
				$cookieHeader = '';

				foreach ( $cookies as $name => $value )
				{
					if ( $cookieHeader == '' )
					{
						$cookieHeader = $name . '=' . $value;
					}
					else
					{
						$cookieHeader = ';' . $name . '=' . $value;
					}
				}

				\curl_setopt ( $this->_curlHandler, \CURLOPT_COOKIE, $cookieHeader );
			}

			if ( $request->getTimeout() > 0 )
			{
				\curl_setopt ( $handler, \CURLOPT_CONNECTTIMEOUT, $request->getTimeout() );	
				\curl_setopt ( $handler, \CURLOPT_TIMEOUT, $request->getTimeout()+1 );
			}

			if ( $request->getUsername() )
			{
				\curl_setopt ( $handler, \CURLOPT_USERPWD, $request->getUsername() . ':' . $request->getPassword() );		
			}

			if ( $request->getLowSpeedLimit() > 0 )
			{
				\curl_setopt ( $handler, \CURLOPT_LOW_SPEED_LIMIT, $request->getLowSpeedLimit() );
			}							

			if ( $request->getMaxTransferTime() > 0 )
			{
				\curl_setopt ( $handler, \CURLOPT_LOW_SPEED_TIME, $request->getMaxTransferTime() );				
			}

			if ( $request->getUserAgent() )
			{
				\curl_setopt ( $handler, \CURLOPT_USERAGENT, $request->getUserAgent() );			
			}			

			$headers = $request->getHeaders();
            
			if ( !empty( $headers  ) )
			{
                $curlHeaders = array();
                
                foreach ( $headers as $name => $value )
                {
                    $curlHeaders[] = $name . ': ' . $value;
                }
                
				\curl_setopt( $handler, \CURLOPT_HTTPHEADER, $curlHeaders );
			}
		}


		public function getLastResponseData ( )
		{
			return $this->_info;
		}
        
        
        public function getError ( )
        {
            return $this->_error;
        }


	}
	
?>