<?php

	namespace Aff\Framework\Object;

	use Aff\Framework;
	


	class Collection extends Framework\Collection implements CollectionInterface
	{

		protected $_class;


        public function __construct ( $class )
		{    
			$this->_class = $class;
		}


		public function getClass ( )
		{
			return $this->_class;
		}


		public function append ( $value )
		{            
			if ( !is_object( $value ) )
			{
				throw new Exception( 'First argument must be an object' );
			}
			else if ( !$value instanceof $this->_class )
			{
				throw new Exception( 'First argument must be an instance of ' . $this->_class );
			}

			return parent::append( $value );
		}
        
        
		public function set ( $value, $position )
		{            
			if ( !Packages\Type\Helper::isObject( $value ) )
			{
				throw new Exception( 'First argument must be an object' );
			}
			else if ( !$value instanceof $this->_class )
			{
				throw new Exception( 'First argument must be an instance of ' . $this->_class );
			}

			return parent::append( $value, $position );
		}        


		public function find ( $value )
		{
			if ( !Packages\Type\Helper::isObject( $value ) )
			{
				new Packages\Exception\Logic\InvalidArgumentsException( 'Argument must be an object', '0' );
			}
			else if ( !Helper::isInstanceOf( $value, $this->_class ) )
			{
				new Packages\Exception\Logic\InvalidArgumentsException( 'Argument must be an instance of ' . $this->_class, '0' );
			}

			return parent::find( $value );
		}

	}

?>