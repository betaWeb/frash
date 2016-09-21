<?php
    namespace Composants\Framework\DIC;
    use Composants\Yaml\Yaml;

    /**
     * Class Dic
     * @package Composants\Framework\DIC
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
        public function __construct($prefix = false){
            $path = ($prefix === false) ? '' : $prefix;
            $this->dependencies = Yaml::parse(file_get_contents($path.'Composants/Configuration/dependencies.yml'));
        }

        /**
         * @param string $key
         * @return object
         */
        public function load($key){
            if(array_key_exists($key, $this->dependencies)){
                $path = str_replace('.', '\\', $this->dependencies[ $key ]);

                $class = new $path();
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