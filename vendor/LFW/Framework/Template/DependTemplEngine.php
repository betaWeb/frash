<?php
	namespace LFW\Framework\Template;

    /**
     * Class DependTemplEngine
     * @package LFW\Framework\Template
     */
	class DependTemplEngine{
        /**
         * @var array
         */
		private $dependencies = [
			'Bundle' => 'LFW.Framework.Template.Extensions.Bundle',
			'Condition' => 'LFW.Framework.Template.Extensions.ConditionParse',
			'Escape' => 'LFW.Framework.Template.Extensions.Escape',
			'Foreach' => 'LFW.Framework.Template.Extensions.ForeachParse',
			'FormatVar' => 'LFW.Framework.Template.Extensions.FormatVar',
			'Part' => 'LFW.Framework.Template.Extensions.Part',
			'Route' => 'LFW.Framework.Template.Extensions.Route',
			'ShowVar' => 'LFW.Framework.Template.Extensions.ShowVar'
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
		public function load($key){
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
		public function setParams($name, $param){
			$this->params[ $name ] = $param;
		}

        /**
         * @param string $name
         */
		public function unsetParams($name){
			unset($this->params[ $name ]);
		}
	}