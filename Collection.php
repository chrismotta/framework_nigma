<?php

	namespace Aff\Framework;
	

	class Collection extends ObjectAbstract implements CollectionInterface, \Countable, \Iterator 
	{

		protected $_elements;


		public function __construct (  )
		{
			$this->_elements = array();
		}


		public function append ( $value )
		{
            $this->_elements[] = $value;
		}


        public function set ( $value, $position )
        {
            if ( !\is_integer( $position ) || $position< 0 )
			{
				throw new Exception( 'Second argument must be an integer greater than 0' );
			}
            
            $this->_elements[$position] = $value;
        }


		public function getElementByPosition ( $position )
		{            
			if ( isset( $this->_elements[$position] ) )
			{
				return $this->_elements[$position];
			}

			return null;
		}


		public function remove ( $position )
		{
			unset( $this->_elements[$position] );
		}
		
		
		public function removeLast ( )
		{
			$k = \end( $this->_elements );
			unset( $this->_elements[$k] );
		}
		
		
		public function removeFirst ( )
		{
			return \array_shift( $this->_elements );
		}
		
		
		public function removeAll ( )
		{
			$this->_elements = array();
		}


		public function count ( ) 
		{
			return \count( $this->_elements );
		}
        
        
		public function length ( ) 
		{
			return \count( $this->_elements );
		}         


		public function current ( )
		{
			return \current( $this->_elements );
		}


		public function key ( ) 
		{
			return \key( $this->_elements );
		}


		public function next ( )
		{
			return \next( $this->_elements );
		}


		public function rewind ( )
		{
			return \rewind ( $this->_elements );
		}


		public function valid ( )
		{
			return $this->_elements != false;
		}
		
		
		public function first ( )
		{
			if ( empty( $this->_elements ) )
			{
				return $this->_elements[0];
			}

			return null;
		}
		
		
		public function last ( )
		{
			return end( $this->_elements );
		}
		
		
		public function shuffle ( )
		{
			return shuffle( $this->_elements );
		}
				
		
		public function reverse ( )
		{
			$this->_elements = \reverse( $this->_elements );
		}
		
		
		public function toArray ( )
		{
			return $this->_elements;
		}
		
		
		public function isEmpty ( )
		{
			return empty( $this->_elements );
		}

		
		public function lastKey ( )
		{
			$length = count( $this->_elements );

			if (  $length < 1 )
			{
				return false;
			}
			else
			{
				return $length-1;
			}
		}

		
	}

?>