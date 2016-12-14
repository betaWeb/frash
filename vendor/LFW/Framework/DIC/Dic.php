<?php
    namespace LFW\Framework\DIC;
    use LFW\Framework\FileSystem\Json;

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
            $this->dependencies = Json::importDependenciesArray();
        }

        /**
         * @param string $key
         * @param mixed $param
         * @return object
         */
        public function load($key, $param = ''){
            if(array_key_exists($key, $this->open)){
                return $this->open[ $key ];
            }
            elseif(array_key_exists($key, $this->dependencies)){
                $path = str_replace('.', '\\', $this->dependencies[ $key ]);

                $class = new $path($this, $param);
                $this->open[ $key ] = $class;

                return $class;
            }
        }
    }