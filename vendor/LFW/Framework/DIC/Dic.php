<?php
    namespace LFW\Framework\DIC;

    /**
     * Class Dic
     * @package LFW\Framework\DIC
     */
    class Dic{
        /**
         * @var array
         */
        private $dependencies = [];

        /**
         * @var array
         */
        private $open = [];

        /**
         * Dic constructor.
         */
        public function __construct(){
            $this->dependencies = json_decode(file_get_contents('vendor/LFW/Configuration/dependencies.json'), true);
        }

        /**
         * @param string $key
         * @param mixed $param
         * @return mixed
         */
        public function load($key, $param = ''){
            if(array_key_exists($key, $this->dependencies)){
                $path = str_replace('.', '\\', $this->dependencies[ $key ]);

                $class = new $path($param);
                $this->open[ $key ] = $class;

                return $class;
            }
        }

        /**
         * @param string $key
         * @return object
         */
        public function open($key){
            if(array_key_exists($key, $this->open)){
                return $this->open[ $key ];
            }
        }
    }