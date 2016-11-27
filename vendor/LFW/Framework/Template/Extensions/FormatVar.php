<?php
	namespace LFW\Framework\Template\Extensions;
    use LFW\Framework\Template\DependTemplEngine;

    /**
     * Class FormatVar
     * @package LFW\Framework\Template\Extensions
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
		public function __construct(DependTemplEngine $dic_t, $params){
			$this->dic_t = $dic_t;
			$this->params = $params['params'];
		}

        /**
         * @param string $variable
         * @return string
         */
		public function parse($variable){
			$array = [];
			$param = '';

			if(strstr($variable, '.')){
				$expl = explode('.', $variable);

				foreach($expl as $k => $v){
					if($k == 0){
						$array = $this->params[ $v ];
						$param = '[\''.$v.'\']';
					}
					else{
						if(gettype($array) == 'object'){
							$method = 'get'.ucfirst($v);

							$array = $array->$method();
							$param .= '->'.$method.'()';
						}
						elseif(gettype($array) == 'array'){
							$array = $array[ $v ];
							$param .= '[\''.$v.'\']';
						}
					}
				}
			}
			else{
				if(gettype($this->params[ $variable ]) == 'object'){}
				else{
					$param = '[\''.$variable.'\']';
				}
			}

			return $param;
		}
	}