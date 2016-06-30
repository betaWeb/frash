<?php
    namespace Composants\Framework\Globals;

    /**
     * Class Session
     * @package Composants\Framework\Globals
     */
    class Session{
        /**
         * @var array
         */
        private static $session_name = [];

        /**
         * @var array
         */
        private static $session_value = [];

        /**
         * Session constructor.
         */
        public function __construct(){
            foreach($_SESSION as $session => $val){
                self::$session_name[] = $session;
                self::$session_value[] = $val;
            }
        }

        /**
         * @param mixed $name
         * @param mixed $value
         */
        public static function setSession($name, $value){
            self::$session_name[] = $name;
            self::$session_value[] = $value;

            $_SESSION[ $name ] = $value;
        }

        /**
         * @param mixed $session
         * @return bool|mixed
         */
        public static function getSession($session){
            if(in_array($session, self::$session_name)){
                $key = array_search($session, self::$session_name);
                return self::$session_value[ $key ];
            }
            else{
                return false;
            }
        }

        /**
         * @param string $session
         */
        public static function unsetSession($session){
            $key = array_search($session, self::$session_name);
            unset(self::$session_name[ $key ]);
            unset(self::$session_value[ $key ]);
        }

        public static function unsetAllSession(){
            self::$session_name = [];
            self::$session_value = [];

            session_unset();
            session_destroy();
        }
    }