<?php
namespace Frash\Template\Extensions\Extensions\Variable;
use Frash\Template\DependTemplEngine;
use Frash\Template\Extensions\Extend\ExtensionParseSimple;

/**
 * Class ShowParse
 * @package Frash\Template\Extensions\Extensions\Variable
 */
class ShowParse extends ExtensionParseSimple{
    /**
     * @var array
     */
	private $params = [];

    /**
     * ShowParse constructor.
     * @param DependTemplEngine $dic_t
     * @param array $params
     */
	public function __construct(DependTemplEngine $dic_t, array $params){
		$this->params = $params['params'];
	}

	public function parse(){
		$variable = rtrim($this->infos['params']['variable']);
		$array = [];
		$param = '';

		if(strstr($variable, '.')){
			$expl = explode('.', $variable);

			foreach($expl as $k => $v){
				if($k == 0){
					$array = (!empty($this->params[ $v ])) ? $this->params[ $v ] : [];
					$param .= '[\''.$v.'\']';
				} else {
					if(empty($array)){
						$param .= '[\''.$v.'\']';
					} elseif(gettype($array) == 'array') {
						$array = $array[ $v ];
						$param .= '[\''.$v.'\']';
					} elseif(gettype($array) == 'object') {
						$array = (substr($v, -1) == ')') ? $array->$v() : $array->$v;
						$param .= '->'.$v;
					}
				}
			}

			$return = '$this->params'.$param;
		} else {
			if(gettype($this->params[ $variable ]) == 'object'){
				$param .= '->'.$variable;
			} else {
				$param .= '[\''.$variable.'\']';
			}

			$return = '$this->params'.$param;
		}

		$this->infos['tpl'] = str_replace($this->infos['params']['match'], '\'.'.$return.'.\'', $this->infos['tpl']);
	}
}