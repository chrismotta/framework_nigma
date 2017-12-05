<?php

	namespace Aff\Framework;


	
	interface CollectionInterface
	{

		public function append ( $value );

        public function set ( $value, $position );

		public function getElementByPosition ( $position );

		public function remove ( $position );		

		public function getLastPosition ( );

		public function removeFirst ( );

		public function removeLast ( );

		public function removeAll ( );

        public function first ( );
		
		public function last ( );                
		
		public function count ( );
        
        public function length ( );
		
		public function shuffle ( );
		
		public function reverse ( );
		
		public function toArray ( );
		
		public function isEmpty ( );

	}
	
?>