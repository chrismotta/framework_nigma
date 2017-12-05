<?php

	namespace Aff\Framework\TCP\HTTP;

	use Aff\Framework\TCP;		


	interface ConnectionInterface
	{

		public function getHeader ( $name );
				
		public function getHeaders ( ); // return associative Array
		
		public function getContentType ( );
				
		public function getCookies ( ); // return associative Array
		
		public function getCookie ( $name );				

	}
	
?>