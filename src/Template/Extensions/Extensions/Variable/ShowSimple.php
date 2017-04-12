<?php
namespace Frash\Template\Extensions\Extensions\Variable;
use Frash\Template\DependTemplEngine;

/**
 * Class ShowParse
 * @package Frash\Template\Extensions\Extensions\Variable
 */
class ShowSimple{
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

	public function parse(string $parameter){
		$variable = rtrim($this->params[ $parameter ]);
		$array = [];
		$param = '';

		if(strstr($parameter, '.')){
			$expl = explode('.', $parameter);

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
		} elseif($parameter[0] == '$') {
			preg_match('/\$(\w+)/', $parameter, $match);

			if(!empty($match[1])){
				$var = $parameter;
				$var = str_replace($match[1], 'this->params[\''.$match[1].'\']', $var);
				$return = $var;
			}
		} else {
			if(gettype($this->params[ $parameter ]) == 'object'){
				$param .= '->'.$parameter;
			} else {
				$param .= '[\''.$parameter.'\']';
			}

			$return = '$this->params'.$param;
		}

		return '\'.'.$return.'.\'';
	}
}