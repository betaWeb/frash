<?php
    namespace Composants\Framework\ORM\PGSQL\Request;

    /**
     * Class Functions
     * @package Composants\Framework\ORM\PGSQL\Request
     */
    class Functions{
        /**
         * @param object $pdo
         * @param array $array
         * @return string
         */
        public static function concat($pdo, $array){
            $arr = [];

            foreach($array as $v){
                if(substr($v, 0, 2) == 'c '){
                    $arr[] = substr($v, 2);
                }
                elseif(substr($v, 0, 1) == ':'){
                    $arr[] = "$v::text";
                }
                else{
                    $arr[] = $pdo->quote($v);
                }
            }

            return 'CONCAT('.implode(', ', $arr).')';
        }
    }