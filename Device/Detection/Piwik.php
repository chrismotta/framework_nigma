<?php

	namespace Aff\Framework\Device\Detection;

	use Aff\Framework;

	use DeviceDetector\DeviceDetector,
	       DeviceDetector\Parser\Device\DeviceParserAbstract;	

	class Piwik extends Framework\ObjectAbstract implements Framework\Device\DetectionInterface
	{

                private $_pwk;
                private $_os;
                private $_cl;


        	public function __construct ( )
        	{
        		parent::__construct( );

        		$this->_pwk = new DeviceDetector();
        	} 


                public function detect ( $userAgent, array $params = null )
                {
                        $this->_pwk->setUserAgent( $userAgent );
                	$this->_pwk->parse();

			$this->_os = $this->_pwk->getOs();
			$this->_cl = $this->_pwk->getClient();
                }


                public function getType ( )
                {
                	return $this->_pwk->getDeviceName();
                }


                public function getBrand ( )
                {
                	return $this->_pwk->getBrandName();
                }


                public function getModel ( )
                {
                	return $this->_pwk->getModel();
                }


                public function getOS ( )
                {
                        if ( isset( $this->_os['name']) )
                	       return $this->_os['name'];
                        else
                                return null;
                }


                public function getOSVersion ( )
                {
                        if ( isset( $this->_os['name']) )
                	       return $this->_os['version'];
                        else
                                return null;

                }


                public function getBrowser ( )
                {
                        if ( isset( $this->_os['name']) )
                	       return $this->_cl['name'];
                        else
                                return null;

                }


                public function getBrowserVersion ( )
                {
                        if ( isset( $this->_os['name']) )
                	       return $this->_cl['version'] ;
                        else
                                return null;
                        
                }

	}

?>