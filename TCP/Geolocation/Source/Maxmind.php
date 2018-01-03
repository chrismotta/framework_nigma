<?php

	namespace Aff\Framework\TCP\Geolocation\Source;
	
	use Aff\Framework,
		Aff\Framework\TCP\Geolocation,
		GeoIp2,
		GeoIp2\Database\Reader;


	class Maxmind extends Framework\ObjectAbstract implements Geolocation\SourceInterface
	{

		private $_connTypeReader;
		private $_ISPReader;
		private $_countryReader;

		private $_exception;

		private $_connTypeRecord;
		private $_ISPRecord;
		private $_countryRecord;		


		public function __construct( array $params )
		{
			parent::__construct();

			$this->_connTypeReader = new Reader( $params['path_conn_type'] );
			$this->_ISPReader 	   = new Reader( $params['path_isp'] );
			$this->_countryReader  = new Reader( $params['path_country'] );
		}


		public function detect ( $ip, array $params = null )
		{
			if ( $this->_countryRecord )
				unset( $this->_countryRecord );

			if ( $this->_connTypeRecord )
				unset( $this->_connTypeRecord );			

			if ( $this->_ISPRecord )
				unset( $this->_ISPRecord );

			if ( $this->_exception )
				unset( $this->_exception );							

			try
			{
				$this->_countryRecord  = $this->_countryReader->country($ip);
				$this->_ISPRecord 	   = $this->_ISPReader->isp($ip);
				$this->_connTypeRecord = $this->_connTypeReader->connectionType($ip);
			}
			catch ( GeoIp2\Exception\AddressNotFoundException $e )
			{
				$this->_exception  = $e;
			}
		}


		public function getException ( )
		{
			return $this->_exception;
		}


		public function getConnectionType ( )
		{
			if ( $this->_connTypeRecord )
			{
				switch ( \strtolower($this->_connTypeRecord->connectionType) )
				{
					case 'cellular':
						return 'carrier';
					break;
					/*
					case 'corporate':
					case 'dialup':
					case 'cable/dsl':
						return 'wifi';
					break;
					*/
					default:
						return 'wifi';
					break;
				}
			}

			return 'wifi';
		}


		public function getCountryCode ( )
		{
			if ( $this->_countryRecord )
				return $this->_countryRecord->country->isoCode;

			return null;
		}


		public function getMobileCarrier ( )
		{
			/*
			var_dump($this->_ISPRecord->organization);echo '<br><br>';
			var_dump($this->_ISPRecord->isp);echo '<br><br>';
			var_dump($this->_ISPRecord->raw['autonomous_system_organization']);echo '<br><br>';die();
			*/
			if ( isset( $this->_ISPRecord->raw['autonomous_system_organization'] ) )
				return $this->_ISPRecord->raw['autonomous_system_organization'];

			return null;
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