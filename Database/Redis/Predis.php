<?php

	namespace Aff\Framework\Database\Redis;

	use Aff\Framework;

	require_once( '..'.\DIRECTORY_SEPARATOR.'vendor'.\DIRECTORY_SEPARATOR.'autoload.php');

	class Predis extends Framework\ObjectAbstract implements ClientInterface
	{

		private $_predis;


		public function __construct ( $params = null, $options = null )
		{
			$this->_predis = new \Predis\Client( $params, $options );
		}


		public function useDatabase ( $id )
		{
			$this->_predis->select( $id );
		}


		public function expireAt ( $key, $timestamp )
		{
			$this->_predis->expireat( $key,  $timestamp );
		}


		public function ttl ( $key, $seconds = null )
		{
			if ( $timestamp )
				$this->_predis->expire( $key,  $timestamp );
			else
				$this->_predis->ttl( $key,  $timestamp );
		}


		public function flush ( )
		{
			$this->_predis->flushall();
		}


		public function flushDb ( )
		{
			$this->_predis->flushdb();
		}	



		// VALUES

		public function set ( $key, $value )
		{
			$this->_predis->set( $key, $value );
		}


		public function get ( $key )
		{
			return $this->_predis->get( $key );
		}



		public function exists ( $key )
		{
			return $this->_predis->exists( $key );
		}		


		public function increment ( $key, $val = null )
		{
			if ( $val )
			{
				if ( \is_float($val) )
					$this->_predis->executeRaw(['INCRBYFLOAT', $key, $val]);
				else
					$this->_predis->incrby( $key, $val );
			}
			else
				$this->_predis->incr( $key );
		}


		public function decrement ( $key, $val = null )
		{
			if ( $val )
				$this->_predis->decrby( $key, $val );
			else
				$this->_predis->decr( $key );
		}


		public function remove ( $key )
		{
			$this->_predis->set( $key, $value );
		}



		// LISTS

		public function getList ( $key, $start = 0, $stop = -1 )
		{
			return $this->_predis->lrange( $key, $start, $stop );
		}


		public function getListElementByPosition ( $key, $pos )
		{
			return $this->_predis->lindex( $key, $pos );
 		}


		public function appendToList ( $key, $value )
		{
			$this->_predis->rpush( $key, $value );
		}


		public function prependToList ( $key, $value )
		{
			$this->_predis->lpush( $key, $value );
		}


		public function getListLength ( $key )
		{
			return $this->_predis->llen( $key );
		}


	
		// MAPS

		public function setMap ( $key, array $data )
		{
			$this->_predis->hmset( $key, $data );
		}


		public function setMapField ( $key, $field, $value )
		{
			$this->_predis->hset( $key, $field, $value );	
		}


		public function getMapField ( $key, $field )
		{
			return $this->_predis->hget( $key, $field );	
		}


		public function mapFieldExists ( $key, $field )
		{
			return $this->_predis->hexists( $key, $field );
		}


		public function getMap ( $key )
		{
			return $this->_predis->hgetall( $key );
		}


		public function getMapFieldCount ( $key )
		{
			return $this->_predis->hlen( $key );
		}


		public function incrementMapField ( $key, $field, $by = 1 )
		{
			if ( is_float($by) )
				$this->_predis->hincrbyfloat( $key, $field, $by );
			else
				$this->_predis->hincrby( $key, $field, $by );
		}


		public function removeMapField ( $key, $field )
		{
			$this->_predis->hget( $key, $field );
		}


		public function getMapFieldLength ( $key, $field )
		{
			return $this->_predis->hstrlen( $key, $field );
		}



		// SETS

		public function getSet ( $key )
		{
			return $this->_predis->smembers( $key );
		}


		public function addToSet ( $key, $value )
		{
			$this->_predis->sadd ( $key, $value );
		}


		public function isInSet ( $key, $value )
		{
			return $this->_predis->sismember( $key, $value );
		}


		public function removeFromSet ( $key, $value )
		{
			$this->_predis->srem( $key, $value );
		}


		public function getSetLength ( $key )
		{
			return $this->_predis->scard( $key );
		}



		// SORTED SETS

		public function addToSortedSet ( $key, $score, $value )
		{
			$this->_predis->zadd ( $key, $score, $value );
		}


		public function removeFromSortedSet ( $key, $value )
		{
			$this->_predis->zrem( $key, $value );
		}


		public function removeFromSortedSetByScore ( $key, $min, $max )
		{
			$this->_predis->zremrangebyscore( $key, $min, $max );
		}

		public function getSortedSetLength ( $key )
		{
			return $this->_predis->zcard( $key );
		}		


		public function countSortedSetByScore ( $key, $min, $max )
		{
			return $this->_predis->zcount( $key );
		}


		public function getSortedSet( $key, $start = 0, $stop = -1 )
		{
			return $this->_predis->zrange( $key, $start, $stop );
		}


		public function getSortedSetByLex ( $key, $min, $max, $start = 0, $stop = -1 )
		{
			return $this->_predis->zrangebylex( $key,  $min, $max, $start, $stop );
		}


		public function getSortedSetByScore ( 
			$key, 
			$min, 
			$max, 
			$start = 0, 
			$stop = -1, 
			$retrieve_scores = false 
		)
		{
			return $this->_predis->zrangebyscore( 
				$key,  
				$min, 
				$max, 
				[
					'WITHSCORES' => $retrieveScores, 
					'LIMIT' => [$start, $stop] 
				]
			);
		}



		// GEO

		public function addGeoItem ( $key, $lat, $lng, $value )
		{
			$this->_predis->geoadd( $key, $lng, $lat, $value );
		}


		public function getGeoItemsDistance ( $key, $value1, $value2, $unit = 'm' )
		{
			return $this->_predis->geodist( $key, $value1, $value2, $unit );
		}


		public function getGeoItemHash ( $key, $value )
		{
			return $this->_predis->geohash( $key, $value );
		}


		public function getGeoItemsPosition ( $key, $values )
		{
			return $this->_predis->geopos( $key, $values );
		}


	}
	
?>