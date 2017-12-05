<?php

	namespace Aff\Framework\AdServing;

	use Aff\Framework;


	interface FraudDetectionInterface
	{

		public function analize ( array $params, array $options = null );

		public function getRiskLevel ( ); // float range 0-100

	}
	
?>