<?php
    namespace Composants\Framework\ORM\MySQL\Request;

    /**
     * Class Order
     * @package Composants\Framework\ORM\MySQL\Request
     */
    class Order{
        /**
         * @var string
         */
        private $order = '';

        /**
         * @param $order
         * @param $dir
         */
        public function __construct($order, $dir){
            $this->order = 'ORDER BY '.$order.' '.$dir;
        }

        /**
         * @return string
         */
        public function getOrder(){
            return $this->order;
        }
    }