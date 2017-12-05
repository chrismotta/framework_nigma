<?php

	namespace Aff\Framework\TCP\HTTP\Client;

	use Aff\Framework;
	


	class RequestCollection extends Framework\Object\Collection
	{	

		public function __construct ( $class )
		{
			parent::__construct( 'Framework\TCP\HTTP\Client\RequestInterface' );
		}

	}

?>