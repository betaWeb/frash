<?php
	namespace LFW\Framework\Template\Extensions;

	class FormatVar{
		private $dic_t;
		private $params = [];

		public function __construct($dic_t, $params){
			$this->dic_t = $dic_t;
			$this->params = $params['params'];
		}

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
				elseif(gettype($this->params[ $variable ]) == 'array'){
					$param = '[\''.$variable.'\']';
				}
			}

			return $param;
		}
	}