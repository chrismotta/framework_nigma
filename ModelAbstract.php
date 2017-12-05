<?php

	namespace Aff\Framework;


	abstract class ModelAbstract extends ObjectAbstract implements ModelInterface
	{

        protected $_registry;


		public function __construct ( Registry $registry )
		{
			parent::__construct( );

            $this->_registry = $registry;
		} 
       

	}

?>