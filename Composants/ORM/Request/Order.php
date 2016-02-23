<?php
    namespace Composants\ORM\Request;

    /**
     * Class Order
     * @package Composants\ORM\Request
     */
    class Order{
        /**
         * @var
         */
        private $order;

        /**
         * @param $order
         * @param bool $dir
         */
        public function __construct($order, $dir = false){
            if(!empty($dir)){
                $this->order = 'ORDER BY '.$order.' '.$dir;
            }
            else{
                $this->order = 'ORDER BY '.$order;
            }
        }

        /**
         * @return mixed
         */
        public function getOrder(){
            return $this->order;
        }
    }