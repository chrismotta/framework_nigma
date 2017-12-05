<?php

	namespace Aff\Framework\AdServing\FraudDetection;

	use Aff\Framework;


	class Forensiq extends Framework\ObjectAbstract implements Framework\AdServing\FraudDetectionInterface
	{

		protected $_httpClient;
		protected $_httpRequest;
		protected $_urlBase;
		protected $_result;


		public function __construct ( 
			Framework\TCP\HTTP\ClientInterface  $httpClient,
			Framework\TCP\HTTP\Client\RequestInterface  $httpRequest,
			$clientKey 
		)
		{
			$this->_httpClient  = $httpClient;
			$this->_httpRequest = $httpRequest;
			$this->_clientKey   = $clientKey;
			$this->_urlBase		= 'http://2pth.com/check?';
		}


		public function analize ( array $params, array $options = null )
		{
			if ( isset( $params['request_type'] ) )
			{
				switch ( $params['request_type'] )
				{
					case 'display':
					case 'click':
					case 'action':
					break;
					default:
						throw new \Exception ( 'Invalid request type' );
					break;
				}
			}
			else
			{
				throw new \Exception ( 'Param required: request_type' );			
			}

			if ( !isset( $params['ip_address'] ) )
				throw new \Exception ( 'Param required: ip_address' );

			if ( !isset( $params['session_id'] ) )
				throw new \Exception ( 'Param required: session_id' );							

			if ( !isset( $params['source_id'] ) )
				throw new \Exception ( 'Param required: source_id' );

			$url = $this->_urlBase . 'ck='.$this->_clientKey.'&output=JSON&rt='.$params['request_type'].'&ip='.$params['ip_address'].'&s='.$params['session_id'].'&p='.$params['source_id'];

			if ( isset( $params['campaign_id'] ) )
				$url .= '&cmp='. $params['campaign_id'];

			$this->_httpRequest->setUrl( $url );
			$response = $this->_httpClient->send( $this->_httpRequest );

			$this->_result = \json_decode( $response->getBody(), true );

			if ( $this->_result )					
				return true;
			else
				return false;
		}


		public function getRiskLevel ( )
		{

			if ( $this->_result )
			{
				return (float)$this->_result['items'][0]['riskScore'];
			}

			return null;
		}
	}

?>