<?php
namespace Frash\Template;

/**
 * Class DependTemplEngine
 * @package Frash\Template
 */
class DependTemplEngine{
    const EXTENSIONS = 'Frash.Template.Extensions';

    /**
     * @var array
     */
	private $dependencies = [
        'default' => [
    		'Bundle' => self::EXTENSIONS.'.Bundle',
    		'Condition' => self::EXTENSIONS.'.ConditionParse',
    		'Escape' => self::EXTENSIONS.'.Escape',
    		'Foreach' => self::EXTENSIONS.'.ForeachParse',
    		'FormatVar' => self::EXTENSIONS.'.FormatVar',
            'Func' => self::EXTENSIONS.'.Functions',
    		'Part' => self::EXTENSIONS.'.Part',
            'Public' => self::EXTENSIONS.'.Public',
    		'Route' => self::EXTENSIONS.'.Route',
    		'ShowVar' => self::EXTENSIONS.'.ShowVar'
        ],
        'custom' => []
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
        } elseif(array_key_exists($key, $this->dependencies['default'])) {
            $path = str_replace('.', '\\', $this->dependencies['default'][ $key ]);

            $class = new $path($this, $this->params);
            $this->open[ $key ] = $class;

            return $class;
        }
	}

    /**
     * @param string $name
     * @return mixed
     */
    public function getParam(string $name){
        return $this->params[ $name ];
    }

    /**
     * @param string $name
     * @param mixed $param
     */
	public function setParam(string $name, $param){
		$this->params[ $name ] = $param;
	}

    /**
     * @param array $params
     */
    public function setParams(array $params){
        foreach($params as $name => $param){
            $this->params[ $name ] = $param;
        }
    }

    /**
     * @param string $name
     */
	public function unsetParams(string $name){
		unset($this->params[ $name ]);
	}
}