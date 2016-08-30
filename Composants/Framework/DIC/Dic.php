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
        public function __construct(){
            $this->dependencies = Yaml::parse(file_get_contents('Composants/Configuration/dependencies.yml'));
        }

        /**
         * @param string $key
         * @return object
         */
        public function load($key){
            if(array_key_exists($key, $this->dependencies)){
                if(isset($this->open[ $key ])){}
                else{
                    array_push($this->open, [ $key => $this->dependencies[ $key ] ]);

                    $path = str_replace('.', '\\', $this->dependencies[ $key ]);
                    return new $path();
                }
            }
        }
    }