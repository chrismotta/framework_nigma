<?php

	namespace Aff\Framework\Database\Redis;

	use Aff\Framework;


	interface ClientInterface extends Framework\Database\KeyValueInterface, Framework\Database\InMemoryKeyValueInterface 
	{

		// SORTED SETS

		public function addToSortedSet ( $key, $score, $value );

		public function removeFromSortedSet ( $key, $value );

		public function removeFromSortedSetByScore ( $key, $min, $max );

		public function getSortedSetLength ( $key );

		public function countSortedSetByScore ( $key, $min, $max );

		public function getSortedSet( $key, $start = 0, $stop = -1 );

		public function getSortedSetByLex ( $key, $min, $max, $start = 0, $stop = -1 );

		public function getSortedSetByScore ( $key, $min, $max, $start = 0, $stop = -1, $retrieve_scores = false );



		// GEO ITEMS

		public function addGeoItem ( $key, $lat, $lng, $value );

		public function getGeoItemsDistance ( $key, $value1, $value2, $unit = 'm' );

		public function getGeoItemHash ( $key, $value );

		public function getGeoItemsPosition ( $key, $values );

	}
	
?>