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
        private $gets = [];

        /**
         * @param array $gets
         */
        public function set($gets){
            $this->gets = $gets;
        }

        /**
         * @param mixed $spec
         * @return mixed
         */
        public function get($spec){
            return $this->gets[ $spec ];
        }

        /**
         * @return array
         */
        public function getAll(){
            return $this->gets;
        }
    }