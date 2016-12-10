<?php
	namespace LFW\Framework\Template\Extensions;
    use LFW\Framework\Template\DependTemplEngine;

    /**
     * Class ShowVar
     * @package LFW\Framework\Template\Extensions
     */
	class ShowVar{
        /**
         * @var array
         */
		private $params = [];

        /**
         * ShowVar constructor.
         * @param DependTemplEngine $dic_t
         * @param array $params
         */
		public function __construct(DependTemplEngine $dic_t, $params){
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
						$array = (!empty($this->params[ $v ])) ? $this->params[ $v ] : [];
						$param = '[\''.$v.'\']';
					}
					else{
						if(empty($array)){
							$param .= '[\''.$v.'\']';
						}
						elseif(gettype($array) == 'array'){
							$array = $array[ $v ];
							$param .= '[\''.$v.'\']';
						}
						elseif(gettype($array) == 'object'){
							$method = 'get'.ucfirst($v);

							$array = $array->$method();
							$param .= '->'.$method.'()';
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

			return '\'.$this->params'.$param.'.\'';
		}

        /**
         * @param string $variable
         * @return string
         */
		public function parseCondition($variable){
			$param = '';

			if(strstr($variable, '.')){
				$expl = explode('.', $variable);

				foreach($expl as $k => $v){
					if($k == 0){
						$param = $this->params[ $v ];
					}
					else{
						if(gettype($param) == 'object'){
							$meth = 'get'.ucfirst($v);
							$param = $param->$meth();
						}
						elseif(gettype($param) == 'array'){
							$param = $param[ $v ];
						}
					}
				}
			}
			else{
				if(gettype($this->params[ $variable ]) == 'object'){}
				elseif(gettype($this->params[ $variable ]) == 'array'){
					$param = $this->params[ $variable ];
				}
			}

			return $param;
		}

        /**
         * @param string $variable
         * @param string $prefix
         * @return string
         */
		public function parseForeach($variable, $prefix = ''){
			$expl = explode('.', $variable);
			$new_var = ($prefix == '') ? '$'.$expl[0] : '$'.$prefix;
			unset($expl[0]);

			foreach($expl as $v){
				$new_var .= '[\''.$v.'\']';
			}

			return '\'.'.$new_var.'.\'';
		}
	}