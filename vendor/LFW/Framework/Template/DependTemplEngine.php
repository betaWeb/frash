<?php
    namespace LFW\Framework\Template;

    /**
     * Class DependTemplEngine
     * @package LFW\Framework\Template
     */
    class DependTemplEngine{
        const EXTENSIONS = 'LFW.Framework.Template.Extensions';

        /**
         * @var array
         */
        private $dependencies = [
            'Bundle' => self::EXTENSIONS.'.Bundle',
            'Condition' => self::EXTENSIONS.'.ConditionParse',
            'Escape' => self::EXTENSIONS.'.Escape',
            'Foreach' => self::EXTENSIONS.'.ForeachParse',
            'FormatVar' => self::EXTENSIONS.'.FormatVar',
            'Part' => self::EXTENSIONS.'.Part',
            'Route' => self::EXTENSIONS.'.Route',
            'ShowVar' => self::EXTENSIONS.'.ShowVar'
        ];

        /**
         * @var array
         */
        private $open = [];

        /**
         * @var array
         */
        private $params = [];

        /**
         * @param string $key
         * @return object
         */
        public function load(string $key){
            if(array_key_exists($key, $this->open)){
                return $this->open[ $key ];
            }
            elseif(array_key_exists($key, $this->dependencies)){
                $path = str_replace('.', '\\', $this->dependencies[ $key ]);

                $class = new $path($this, $this->params);
                $this->open[ $key ] = $class;

                return $class;
            }
        }

        /**
         * @param string $name
         * @param mixed $param
         */
        public function setParams(string $name, $param){
            $this->params[ $name ] = $param;
        }

        /**
         * @param string $name
         */
        public function unsetParams(string $name){
            unset($this->params[ $name ]);
        }
    }