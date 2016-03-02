<?php
    namespace Composants\ORM\Request;

    /**
     * Class Limit
     * @package Composants\ORM\Request
     */
    class Limit{
        /**
         * @var
         */
        private $limit;

        /**
         * Limit constructor.
         * @param $limit
         */
        public function __construct($limit){
            if(!is_array($limit)){
                $this->limit = $limit;
            }
        }

        /**
         * @return mixed
         */
        public function getLimit(){
            return $this->limit;
        }
    }