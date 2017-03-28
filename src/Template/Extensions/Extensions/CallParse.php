<?php
namespace Frash\Template\Extensions\Extensions;
use Frash\Template\DependTemplEngine;
use Frash\Template\Extensions\Extend\ExtensionParseSimple;

/**
 * Class CallParse
 * @package Frash\Template\Extensions\Extensions
 */
class CallParse extends ExtensionParseSimple{
    /**
     * @var DependTemplEngine
     */
	private $dic_t;

    /**
     * @var array
     */
	private $params = [];

    /**
     * CallParse constructor.
     * @param DependTemplEngine $dic_t
     * @param array $params
     */
	public function __construct(DependTemplEngine $dic_t, array $params){
		$this->dic_t = $dic_t;
		$this->params = $params;
	}

	public function parse(){
		if(strstr($this->infos['params']['match'][3], ':')){
			list($bundle, $controller, $action) = explode(':', $this->infos['params']['match'][3]);

			$path = 'Bundles\\'.$bundle.'\Controllers\\'.$controller;
			$call = new $path($this->infos['params']['dic']);
			$call->$action();
		}
	}
}