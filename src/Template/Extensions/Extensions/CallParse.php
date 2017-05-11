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
			$content = $call->$action();
		} else {
			if(!strstr($this->infos['params']['match'][3], ' ')){
				return $this->infos['params']['dic']->load('exception')->publish('Call in templating : No request method');
			}

			list($method, $url) = explode(' ', $this->infos['params']['match'][3]);

			if(substr($this->infos['params']['match'][3], 4) != 'http' && substr($this->infos['params']['match'][3], 3) != 'www'){
				$road = explode('/', $url);

	            foreach($road as $r){
	                if(!empty($r) && $r[0] == '@'){
	                    $url = str_replace($r, $this->dic_t->extension('ShowVarSimple')->parse(ltrim($r, '@')), $url);
	                }
	            }
			}

			$content = $this->infos['params']['dic']->load('browser')->route($url)->method($method)->go()->getContent();
		}

		$this->infos['tpl'] = str_replace($this->infos['params']['match'][0], $content, $this->infos['tpl']);
	}
}