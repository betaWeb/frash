<?php
    namespace Composants\ORM\Request;

    /**
     * Class Limit
     * @package Composants\ORM\Request
     */
    class Limit{
        /**
         * Limit constructor.
         * @param $limit
         */
        public function __construct($limit){
            if(!is_array($limit)){
                return 'LIMIT '.$limit;
            }
        }
    }