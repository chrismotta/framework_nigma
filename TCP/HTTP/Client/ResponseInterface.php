<?php

	namespace Aff\Framework\TCP\HTTP\Client;

	use Aff\Framework\TCP\HTTP;




	interface ResponseInterface extends HTTP\ResponseInterface
	{		        			

		public function getStatus ( );
        
        public function getBody ( );

		public function getTransactionTime ( );
		
		public function getUploadedBytes ( );
		
		public function getDownloadedBytes ( );
		
		public function getAverageDownloadSpeed ( );
		
		public function getAverageUploadSpeed ( );		

	}
	
?>