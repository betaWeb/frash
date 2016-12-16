<?php
    namespace LFW\ORM\MySQL\Request;

    /**
     * Class Functions
     * @package LFW\ORM\MySQL\Request
     */
    class Functions{
        /**
         * @param array $array
         * @return string
         */
        public static function concat(array $array): string{
            $arr = [];

            foreach($array as $v){
                $arr[] = $v;
            }

            return 'CONCAT('.implode(', ', $arr).')';
        }
    }