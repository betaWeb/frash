<?php
namespace Frash\Template;
use Frash\Template\Extensions\CallExtension;

/**
 * Class DependTemplEngine
 * @package Frash\Template
 */
class DependTemplEngine{
    const EXTENSIONS = 'Frash.Template.Extensions.Extensions';

    /**
     * @var array
     */
	private $dependencies = [
	    'extensions' => [
            'default' => [
                'Ajax' => self::EXTENSIONS.'.AjaxParse',
                'BundleParse' => self::EXTENSIONS.'.Bundle.BundleParse',
                'BundleTplParent' => self::EXTENSIONS.'.Bundle.BundleTplParent',
                'CallParse' => self::EXTENSIONS.'.CallParse',
                'ConditionParse' => self::EXTENSIONS.'.Condition.ConditionParse',
                'EscapeHtmlParse' => self::EXTENSIONS.'.Escape.Html.EscapeHtmlParse',
                'EscapeTpl' => self::EXTENSIONS.'.EscapeTpl',
                'ForeachParse' => self::EXTENSIONS.'.Loop.ForeachLoop.ForeachParse',
                'FormatVar' => self::EXTENSIONS.'.Variable.FormatVar',
                'Func' => self::EXTENSIONS.'.Functions',
                'Part' => self::EXTENSIONS.'.Part',
                'Public' => self::EXTENSIONS.'.PublicDir',
                'Route' => self::EXTENSIONS.'.Route.Route',
                'RouteForeach' => self::EXTENSIONS.'.Route.RouteForeach',
                'RouteParent' => self::EXTENSIONS.'.Route.RouteParent',
                'RouteTplParent' => self::EXTENSIONS.'.Route.RouteTplParent',
                'ShowVarParse' => self::EXTENSIONS.'.Variable.ShowParse',
                'ShowVarParseForeach' => self::EXTENSIONS.'.Variable.ShowParseForeach',
                'ShowVarSimple' => self::EXTENSIONS.'.Variable.ShowSimple'
            ],
            'custom' => []
        ],
        'filters' => [
            'default' => [],
            'custom' => []
        ]
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
	public function extension(string $key){
		if(array_key_exists($key, $this->open)){
            return $this->open[ $key ];
        } elseif(array_key_exists($key, $this->dependencies['extensions']['default'])) {
            $path = str_replace('.', '\\', $this->dependencies['extensions']['default'][ $key ]);

            $class = new $path($this, $this->params);
            $this->open[ $key ] = $class;

            return $class;
        }
	}

    public function callExtension(){
        return new CallExtension($this, $this->params);
    }

    /**
     * @param string $name
     * @param string $namespace
     */
	public function setCustomExtension(string $name, string $namespace){
	    $this->dependencies['extensions']['custom'][ $name ] = $namespace;
    }

    /**
     * @param string $name
     * @param string $namespace
     */
	public function setCustomFilter(string $name, string $namespace){
	    $this->dependencies['filters']['custom'][ $name ] = $namespace;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function get(string $name){
        return $this->params[ $name ];
    }

    /**
     * @param string $name
     * @param mixed $param
     */
	public function set(string $name, $param){
		$this->params[ $name ] = $param;
	}

    /**
     * @param array $params
     */
    public function sets(array $params){
        foreach($params as $name => $param){
            $this->params[ $name ] = $param;
        }
    }

    /**
     * @param string $name
     */
	public function unset(string $name){
		unset($this->params[ $name ]);
	}
}