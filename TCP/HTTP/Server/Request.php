<?php

    namespace Aff\Framework\TCP\HTTP\Server;

    use Aff\Framework;


    class Request extends Framework\ObjectAbstract implements RequestInterface
    {

        protected $_timestamp;
        protected $_data;
        protected $_headers;
        protected $_cookies;

        protected $_path;
        protected $_referer;
        protected $_agent;
        protected $_method;
        protected $_sourceIp;
        protected $_sourceHost;
        protected $_sourcePort;
        protected $_destinationIp;
        protected $_destinationHost;
        protected $_destinationPort;
        protected $_user;
        protected $_pass;
        protected $_uri;
        protected $_query;        
        protected $_pathElements;
        protected $_body;


        public function __construct ( )
        {
            parent::__construct();

            $this->_init();
        }


        protected function _init ( )
        {
            if ( \function_exists('getallheaders') ) 
            {
                $this->_headers = \getallheaders();
            }
            else
            {
                $this->_headers = [];

                foreach ( $_SERVER as $name => $value ) 
                {
                    if ( substr($name, 0, 5) == 'HTTP_' ) 
                    {
                        $this->_headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
                    }
                }               
            }

            $this->_timestamp = $_SERVER['REQUEST_TIME'];
            $this->_cookies = $_COOKIE;
            $this->_query = $_SERVER['QUERY_STRING'];            
            $this->_method = strtoupper( $_SERVER['REQUEST_METHOD'] );
            $this->_sourceIp = $_SERVER['REMOTE_ADDR'];
            $this->_sourcePort = $_SERVER['REMOTE_PORT'];
            $this->_destinationIp = $_SERVER['SERVER_ADDR'];
            $this->_destinationHost = $_SERVER['SERVER_NAME'];
            $this->_destinationPort = $_SERVER['SERVER_PORT'];
            $this->_uri = $_SERVER['REQUEST_URI'];

            $this->_pathElements = \preg_split( '(\/|\?)', $this->_uri, -1 );


            $finalElement = \end($this->_pathElements);
            if ( $finalElement=='' || ($this->_query && $this->_query == $finalElement) )
            {
                \array_pop($this->_pathElements);
            }

            if ( $this->_pathElements[0] == '' )
                \array_shift($this->_pathElements);

            if ( isset($_SERVER['HTTP_REFERER']) )
                $this->_referer = $_SERVER['HTTP_REFERER'];

            if ( isset($_SERVER['HTTP_USER_AGENT']) )
            {
                $this->_agent = $_SERVER['HTTP_USER_AGENT'];
            }     

            if ( isset($_SERVER['REMOTE_HOST']) )
            {
                $this->_sourceHost = $_SERVER['REMOTE_HOST'];
            }     

            if ( isset($_SERVER['PATH_INFO']) )
            {
                $this->_path = $_SERVER['PATH_INFO'];
            }            
            
            if ( isset($_SERVER['PHP_AUTH_USER']) )
            {
                $this->_user = $_SERVER['PHP_AUTH_USER'];
            }            
            
            if ( isset($_SERVER['PHP_AUTH_PW']) )
            {
                $this->_pass = $_SERVER['PHP_AUTH_PW'];
            }               


            $this->_body = \file_get_contents("php://input");

            switch ( $this->getHeader('Content-Type') )
            {
                case 'application/x-www-form-urlencoded':
                case 'multipart/form-data':
                case null:
                    switch( $this->getMethod() )
                    {
                        case 'POST':
                        case 'post':
                            $this->_data = $_POST;
                        break;
                        case 'GET':
                        case 'get':
                            $this->_data = $_GET;
                        break;
                        default:
                            $data = array();
                            
                            \parse_str( $this->_body, $data );                  
                            $this->_data = $data;
                        break;
                    }                  
                break;
            }
            
        }


        public function isHttps ( )
        {
            if ( isset($_SERVER['https']) )
                return true;

            return false;
        }
        
        
        public function getHeader ( $name )
        {
            if ( isset( $this->_headers[$name] ) )
            {
                return $this->_headers[$name];
            }
            
            return null;
        }
        
        
        public function getHeaders ( )
        {
            return $this->_headers;
        }
                

        public function getCookie ( $name )
        {
            if ( isset($this->_cookies[$name]) )
            {
                return $this->_cookies[$name];
            }
            
            return null;
        }


        public function getCookies ( )
        {
            return $this->_cookies;
        }       


        public function getData ( )
        {
            return $this->_data;
        }
     


        public function getParam ( $name )
        {                       
            if ( isset( $this->_data[$name] ) )
            {                
                return $this->_data[$name];
            }
                         
            return null;
        }

        public function getBody ( )
        {
            return $this->_body;
        }


        public function getTimestamp ( )
        {
            return $this->_timestamp;
        }
        
                
        public function getUserAgent ( )
        {
            return $this->_agent;
        }
        
        public function getReferer ( )
        {
            return $this->_referer;
        }
        
        public function getMethod ( )
        {
            return $this->_method;
        }
        
        
        public function getSourceIp ( )
        {
            return $this->_sourceIp;            
        }
        
        
        public function getSourceHostname ( )
        {
            return $this->_sourceHost;          
        }
        
        
        public function getSourcePort ( )
        {
            return $this->_sourcePort;          
        }


        public function getDestinationIp ( )
        {
            return $this->_destinationIp;
        }


        public function getDestinationHostname ( )
        {
            return $this->_destinationHost;
        }


        public function getDestinationPort ( )
        {
            return $this->_destinationPort;
        }


        public function getBrowserData ( )
        {
            return \get_browser( $this->_agent, true );
        }


        public function getUsername ( )
        {
            return $this->_user;
        }
        
        
        public function getQueryString ( )
        {
            return $this->_query;
        }


        public function getPassword ( )
        {
            return $this->_pass;
        }


        public function getURI ( )
        {
            return $this->_uri;
        }
        
        
        public function getContentType ( )
        {
            return $this->getHeader( 'Content-Type' );
        }


        public function getPathElements ( )
        {
            return $this->_pathElements;
        }


        public function getPathElement( $position )
        {            
            if ( isset( $this->_pathElements[$position] ) )
            {
                return $this->_pathElements[$position];
            }
            
            return null;
        }

    }

?>