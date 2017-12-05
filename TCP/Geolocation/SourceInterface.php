<?php

	namespace Aff\Framework\TCP\Geolocation;

	
	interface SourceInterface
	{

		public function detect ( $ip, array $params = null );

		public function getConnectionType ( ); // return wifi, 3g, etc...

		public function getCountryCode ( );

		public function getMobileCarrier ( );

		public function getIpNumber ( );

		public function getIpVersion ( );

		public function getCountryName ( );

		public function getRegionName ( );

		public function getCityName ( );

		public function getLatitude ( );

		public function getLongitude ( );

		public function getAreaCode ( );

		public function getIDDCode ( );

		public function getWheatherStationCode ( );

		public function getWheatherStationName ( );

		public function getMCC ( );

		public function getMNC ( );

		public function getUsageType ( );

		public function getElevation ( );

		public function getNetworkSpeed ( );

		public function getTimezone ( );

		public function getZipCode ( );

		public function getDomainName ( );

		public function getISPName ( );

	}


?>