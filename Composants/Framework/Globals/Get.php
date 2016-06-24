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
         * @param array $gets
         */
        public static function set($gets){
            self::$gets = $gets;
        }

        /**
         * @param mixed $spec
         * @return mixed
         */
        public static function get($spec){
            return self::$gets[ $spec ];
        }

        /**
         * @return array
         */
        public static function getAll(){
            return self::$gets;
        }
    }