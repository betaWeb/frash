<?php
    namespace Composants\ORM\MySQL\Request;

    /**
     * Class Functions
     * @package Composants\ORM\MySQL\Request
     */
    class Functions{
        /**
         * @param array $array
         * @return string
         */
        public static function concat($array){
            $arr = [];

            foreach($array as $v){
                $arr[] = $v;
            }

            return 'CONCAT('.implode(', ', $arr).')';
        }
    }