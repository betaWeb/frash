<?php
    namespace Composants\Framework\Session;

    /**
     * Class Session
     * @package Composants\Framework\Session
     */
    class Session{
        /**
         * @var array
         */
        private $session_name = [];

        /**
         * @var array
         */
        private $session_value = [];

        /**
         * Session constructor.
         */
        public function __construct(){
            foreach($_SESSION as $session => $val){
                $this->session_name[] = $session;
                $this->session_value[] = $val;
            }
        }

        /**
         * @param string $name
         * @param mixed $value
         */
        public function setSession($name, $value){
            $_SESSION[ $name ] = $value;
        }

        /**
         * @param mixed $session
         * @return bool|mixed
         */
        public function getSession($session){
            if(in_array($session, $this->session_name)){
                $key = array_search($session, $this->session_name);
                return $this->session_value[ $key ];
            }
            else{
                return false;
            }
        }

        /**
         * @param string $session
         */
        public function unsetSession($session){
            $key = array_search($session, $this->session_name);
            unset($this->session_name[ $key ]);
            unset($this->session_value[ $key ]);
        }

        public function unsetAllSession(){
            $this->session_name = [];
            $this->session_value = [];

            session_unset();
            session_destroy();
        }
    }