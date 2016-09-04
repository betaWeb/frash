<?php
    namespace Composants\Framework\Globals;

    /**
     * Class Get
     * @package Composants\Framework\Globals
     */
    class Get{
        /**
         * @var array
         */
        private static $gets = [];

        /**
         * @param mixed $name
         * @param mixed $value
         */
        public static function set($name, $value){
            self::$gets[ $name ] = $value;
        }

        /**
         * @param mixed $spec
         * @param mixed $key
         * @return mixed
         */
        public static function get($spec, $key = false){
            if(is_array(self::$gets[ $spec ])){
                if($key === false){
                    return self::$gets[ $spec ];
                }
                else{
                    return self::$gets[ $spec ][ $key ];
                }
            }

            return (self::$gets[ $spec ]) ? self::$gets[ $spec ] : false;
        }

        /**
         * @return array
         */
        public static function getAll(){
            return self::$gets;
        }
    }