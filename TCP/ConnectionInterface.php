<?php

	namespace Aff\Framework\TCP;
	


	interface ConnectionInterface
	{		        

		public function getSourceIp ( );
		
		public function getSourcePort ( );
		
		public function getDestinationIp ( );
		
		public function getDestinationPort ( );		

		public function getSourceHostname ( );
		
		public function getDestinationHostname ( );		

	}

?>