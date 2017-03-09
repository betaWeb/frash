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
		$variable = $this->infos['params']['variable'];
		$array = [];
		$param = '';

		if(strstr($variable, '.')){
			$expl = explode('.', $variable);

			foreach($expl as $k => $v){
				if($k == 0){
					$array = (!empty($this->params[ $v ])) ? $this->params[ $v ] : [];
					$param = '[\''.$v.'\']';
				} else {
					if(empty($array)){
						$param .= '[\''.$v.'\']';
					} elseif(gettype($array) == 'array') {
						$array = $array[ $v ];
						$param .= '[\''.$v.'\']';
					} elseif(gettype($array) == 'object') {
						$method = 'get'.ucfirst($v);

						$array = $array->$method();
						$param .= '->'.$method.'()';
					}
				}
			}
		} else {
			if(gettype($this->params[ $variable ]) == 'object'){
			} else {
				$param = '[\''.$variable.'\']';
			}
		}

		$this->infos['tpl'] = str_replace($this->infos['params']['match'], '\'.$this->params'.$param.'.\'', $this->infos['tpl']);
	}

    /**
     * @param string $variable
     * @return string
     */
	public function parseFunction(string $variable): string{
		$array = [];
		$param = '';

		if(strstr($variable, '.')){
			$expl = explode('.', $variable);

			foreach($expl as $k => $v){
				if($k == 0){
					$array = (!empty($this->params[ $v ])) ? $this->params[ $v ] : [];
					$param = $v;
				} else {
					if(empty($array)){
						$param .= '[\''.$v.'\']';
					} elseif(gettype($array) == 'array') {
						$array = $array[ $v ];
						$param .= '[\''.$v.'\']';
					} elseif(gettype($array) == 'object') {
						$method = 'get'.ucfirst($v);

						$array = $array->$method();
						$param .= '->'.$method.'()';
					}
				}
			}
		} else {
			$param = $variable;
		}

		return '\'.$'.$param.'.\'';
	}
}