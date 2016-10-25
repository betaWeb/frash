<?php
    namespace LFW\Framework\Globals;

    /**
     * Class Get
     * @package LFW\Framework\Globals
     */
    class Get{
        /**
         * @var array
         */
        private $gets = [];

        /**
         * @param mixed $name
         * @param mixed $value
         */
        public function set($name, $value){
            $this->gets[ $name ] = $value;
        }

        /**
         * @param mixed $spec
         * @param mixed $key
         * @return mixed
         */
        public function get($spec, $key = false){
            if(isset($this->gets[ $spec ])){
                if($key === false){
                    return $this->gets[ $spec ];
                }
                else{
                    return (isset($this->gets[ $spec ][ $key ])) ? $this->gets[ $spec ][ $key ] : '';
                }
            }

            return false;
        }

        /**
         * @return array
         */
        public function getAll(){
            return $this->gets;
        }
    }