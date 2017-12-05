<?php

	namespace Aff\Framework\TCP\HTTP;



	interface RequestInterface extends ConnectionInterface
	{

        public function getHeader ( $name );

        public function getHeaders ( ); // RETURN associative array
        
        public function getCookie ( $name );     

        public function getCookies ( ); // RETURN associative Array

		public function getUsername ( );
		
		public function getPassword ( );
	
		public function getMethod ( );

		public function getBody ( );
		
		public function getUserAgent ( );

	}
	
?>