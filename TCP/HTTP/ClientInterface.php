<?php

	namespace Aff\Framework\TCP\HTTP;	


	interface ClientInterface
	{

		public function send ( Client\RequestInterface $request ); // return Client\ResponseInterface
		
		public function sendMultiple ( Client\RequestCollection $requests ); // return ResponseCollection
		
		public function getLastResponseData ( );
        
        public function getError ( );
		
		public function reset ( );				

	}
	
?>