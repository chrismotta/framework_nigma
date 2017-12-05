<?php

	namespace Aff\Framework\TCP\Geolocation\Source;
	
	use Aff\Framework,
		Aff\Framework\TCP\Geolocation;


	class IP2Location extends Framework\ObjectAbstract implements Geolocation\SourceInterface
	{

		private $_db;
		private $_data;


		public function __construct( $path )
		{
			parent::__construct();

			$this->_db = new \IP2Location\Database( $path, \IP2Location\Database::FILE_IO );
		}


		public function detect ( $ip, array $params = null )
		{
			$this->_data = $this->_db->lookup( 
				$ip, 
				array(
					\IP2Location\Database::MOBILE_CARRIER_NAME,
					\IP2Location\Database::COUNTRY_CODE
				)
			);
		}


		public function getConnectionType ( )
		{
			if( !$this->_data['mobileCarrierName'] || $this->_data['mobileCarrierName']=='-' )
				return 'wifi';
			else
				return 'mobile';
		}


		public function getCountryCode ( )
		{
			if ( $this->_data['countryCode'] == '-')
				return null;

			return strtolower($this->_data['countryCode']);
		}


		public function getMobileCarrier ( )
		{
			if ( $this->_data['mobileCarrierName'] == '-')
				return null;

			return $this->_data['mobileCarrierName'];
		}


		public function getIpNumber ( )
		{

		}


		public function getIpVersion ( )
		{

		}


		public function getCountryName ( )
		{

		}


		public function getRegionName ( )
		{

		}


		public function getCityName ( )
		{

		}


		public function getLatitude ( )
		{

		}


		public function getLongitude ( )
		{

		}


		public function getAreaCode ( )
		{

		}


		public function getIDDCode ( )
		{

		}


		public function getWheatherStationCode ( )
		{

		}


		public function getWheatherStationName ( )
		{

		}


		public function getMCC ( )
		{

		}


		public function getMNC ( )
		{

		}


		public function getUsageType ( )
		{

		}


		public function getElevation ( )
		{

		}


		public function getNetworkSpeed ( )
		{

		}


		public function getTimezone ( )
		{

		}


		public function getZipCode ( )
		{

		}


		public function getDomainName ( )
		{

		}


		public function getISPName ( )
		{

		}


	}

?>