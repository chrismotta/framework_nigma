<?php

	namespace Aff\Framework\Device;

	
	interface DetectionInterface
	{
                public function detect ( $userAgent, array $params = null );

                public function getType ( ); // returns: mobile, desktop, tablet, console, other

                public function getBrand ( );

                public function getModel ( );

                public function getOS ( );

                public function getOSVersion ( );

                public function getBrowser ( );

                public function getBrowserVersion ( );

	}
	
?>