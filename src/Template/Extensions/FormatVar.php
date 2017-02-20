<?php
namespace Frash\Template\Extensions;
use Frash\Template\DependTemplEngine;

/**
 * Class FormatVar
 * @package Frash\Template\Extensions
 */
class FormatVar{
    /**
     * @var DependTemplEngine
     */
	private $dic_t;

    /**
     * @var array
     */
	private $params = [];

    /**
     * FormatVar constructor.
     * @param DependTemplEngine $dic_t
     * @param array $params
     */
	public function __construct(DependTemplEngine $dic_t, array $params){
		$this->dic_t = $dic_t;
		$this->params = $params['params'];
	}

    /**
     * @param string $variable
     * @return string
     */
	public function parse(string $variable): string{
		$param = '';

		if(strstr($variable, '.')){
			$expl = explode('.', $variable);
            $array = [];

			foreach($expl as $k => $v){
				if($k == 0){
					$array = $this->params[ $v ];
					$param = '[\''.$v.'\']';
				} else {
					if(gettype($array) == 'object'){
						$method = 'get'.ucfirst($v);

						$array = $array->$method();
						$param .= '->'.$method.'()';
					} elseif(gettype($array) == 'array') {
						$array = $array[ $v ];
						$param .= '[\''.$v.'\']';
					}
				}
			}
		} else {
			if(gettype($this->params[ $variable ]) == 'object'){
			} else {
				$param = '[\''.$variable.'\']';
			}
		}

		return $param;
	}
}