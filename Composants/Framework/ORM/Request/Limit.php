<?php
    namespace Composants\Framework\ORM\Request;

    /**
     * Class Limit
     * @package Composants\Framework\ORM\Request
     */
    class Limit{
        /**
         * @var string
         */
        private $limit = '';

        /**
         * Limit constructor.
         * @param $limit
         */
        public function __construct($limit){
            if(!is_array($limit)){
                $this->limit = 'LIMIT '.$limit;
            }
        }

        /**
         * @return mixed
         */
        public function getLimit(){
            return $this->limit;
        }
    }