<?php
namespace Frash\Template\Extensions\Extensions\Variable;
use Frash\Template\DependTemplEngine;
use Frash\Template\Extensions\Extend\ExtensionParseForeach;

/**
 * Class ShowParseForeach
 * @package Frash\Template\Extensions\Extensions\Variable
 */
class ShowParseForeach extends ExtensionParseForeach{
    /**
     * @var array
     */
	private $params = [];

    /**
     * ShowParseForeach constructor.
     * @param DependTemplEngine $dic_t
     * @param array $params
     */
	public function __construct(DependTemplEngine $dic_t, array $params){
		$this->params = $params['params'];
	}

	public function parse(){
		$ltrim = ltrim($this->infos['params']['match'][4], '!');
		$k = $this->infos['params']['params_foreach']['k'];
		$v = $this->infos['params']['params_foreach']['v'];

		if(substr($ltrim, 0, strlen($k)) == $k){
            $prefix = $k;
        } elseif(substr($ltrim, 0, strlen($v)) == $v) {
            $prefix = $v;
        }

		$expl = explode('.', $ltrim);
		$new_var = '$'.$expl[0];
		unset($expl[0]);

		foreach($expl as $v){
			$new_var .= '[\''.$v.'\']';
		}

		$variable = '\'.'.$new_var.'.\'';

		$this->infos['content'] = $variable;
		$this->infos['tpl'] = str_replace($this->infos['params']['match'][0], $variable, $this->infos['tpl']);
	}

	public function route(){
		$ltrim = $this->infos['params']['match'];
		$k = $this->infos['params']['params_foreach']['k'];
		$v = $this->infos['params']['params_foreach']['v'];

		if(substr($ltrim, 0, strlen($k)) == $k){
            $prefix = $k;
        } elseif(substr($ltrim, 0, strlen($v)) == $v) {
            $prefix = $v;
        }

		$expl = explode('.', $ltrim);
		$new_var = '$'.$expl[0];
		unset($expl[0]);

		foreach($expl as $v){
			$new_var .= '[\''.$v.'\']';
		}

		$variable = '\'.'.$new_var.'.\'';

		$this->infos['content'] = $variable;
		$this->infos['tpl'] = str_replace($this->infos['params']['match'], $variable, $this->infos['tpl']);
	}
}