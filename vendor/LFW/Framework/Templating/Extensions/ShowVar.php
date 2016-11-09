<?php
	namespace LFW\Framework\Templating\Extensions;

	class ShowVar{
		private static $params = [];

		public static function setParams($params){
			self::$params = $params;
		}

		public static function parse($variable){
			if(strstr($variable, '.')){
				$expl = explode('.', $variable);
				$param = [];

				foreach($expl as $k => $v){
					if($k == 0){
						$param = self::$params[ $v ];
					}
					else{
						$param = $param[ $v ];
					}
				}

				return $param;
			}
			else{
				return self::$params[ $variable ];
			}
		}
	}