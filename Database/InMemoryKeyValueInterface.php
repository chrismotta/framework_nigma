<?php

	namespace Aff\Framework\Database;


	interface InMemoryKeyValueInterface extends InMemoryInterface
	{

		public function expireAt ( $key, $timestamp );

		public function ttl ( $key, $seconds = null );

	}
	
?>