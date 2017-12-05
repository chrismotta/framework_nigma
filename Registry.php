<?php

	namespace Aff\Framework;


	class Registry extends ObjectAbstract
	{

		protected $_vars;


		public function __construct ( )
		{						
			parent::__construct();
			
			$this->_vars = array();
		}


		public function __set ( $index, $value )
		{
			$this->_vars[$index] = $value;
		}


		public function __get ( $index )
		{
			if ( isset( $this->_vars[$index] ) )
			{
				return $this->_vars[$index];
			}
			
			return null;
		}

	}

?>