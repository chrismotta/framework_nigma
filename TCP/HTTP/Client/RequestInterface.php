<?php

	namespace Aff\Framework\TCP\HTTP\Client;

	use Aff\Framework\TCP\HTTP;




	interface RequestInterface extends HTTP\RequestInterface
	{
	
		public function getURL ( );
		
		public function setURL ( $url );

		public function setMethod ( $method );
		
		public function setBody ( $body );
		
		public function setHeader ( $name, $value );
		
		public function removeHeader ( $name );

		public function setCookie ( $name, $value );

		public function removeCookie ( $name );

		public function setUserAgent ( $userAgent );

		public function setTimeout ( $seconds );		
		
		public function setLowSpeedLimit ( $bytesPerSecond );
		
		public function getLowSpeedLimit ( );
		
		public function setMaxTransferTime ( $seconds );
		
		public function getMaxTransferTime ( );
		
		public function setContentType ( $mimeType );
		
		public function setUsername ( $username );

		public function setPassword ( $password );
		
		public function setDestinationPort ( $portNumber );
		
		public function setDestinationHostname ( $hostname );
        
        public function verifySSLCertificate ( $state = null );
        
        public function setSSLCertificatePath ( $path );
        
        public function getSSLCertificatePath ( );

	}
	
?>