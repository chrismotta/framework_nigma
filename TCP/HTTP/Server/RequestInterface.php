<?php

	namespace Aff\Framework\TCP\HTTP\Server;

	use Aff\Framework\TCP\HTTP;


	interface RequestInterface extends HTTP\RequestInterface
	{

		public function getContentType ( );     
        
		public function getBrowserData ( );     
                        
        public function getPathElement ( $position );

        public function getPathElements ( );

        public function getURI ( ); 

        public function getQueryString ( );    

	}
	
?>