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
            if(is_array($this->gets[ $spec ])){
                if($key === false){
                    return $this->gets[ $spec ];
                }
                else{
                    return $this->gets[ $spec ][ $key ];
                }
            }

            return ($this->gets[ $spec ]) ? $this->gets[ $spec ] : false;
        }

        /**
         * @return array
         */
        public function getAll(){
            return $this->gets;
        }
    }