<?php

	namespace Aff\Framework\TCP;	


	interface ClientConnectionInterface
	{

		public function setDestinationPort ( $portNumber );
		
		public function setDestinationHostname ( $hostname );
	}

?>