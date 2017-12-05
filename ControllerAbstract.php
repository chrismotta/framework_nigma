<?php

	namespace Aff\Framework;


	abstract class ControllerAbstract extends ObjectAbstract implements ControllerInterface
	{

        protected $_registry;


		public function __construct ( Registry $registry )
		{
			parent::__construct( );

            $this->_registry = $registry;
		}           

		abstract public function render ( $view );
		

		abstract public function route();
	}

?>