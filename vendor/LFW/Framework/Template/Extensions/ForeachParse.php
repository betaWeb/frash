<?php
	namespace LFW\Framework\Template\Extensions;
	use LFW\Framework\Template\DependTemplEngine;
	use LFW\Framework\Template\Parsing\ParseArray;

	class ForeachParse extends ParseArray{
		private $dic_t;
		private $params;

		public function __construct($dic_t, $params){
			$this->dic_t = $dic_t;
			$this->params = $params;
		}

		public function parse($foreach, $value){
			$foreach_origine = $foreach;

			list($array, $p) = explode(' :: ', $foreach);
			list($k, $v) = explode(', ', $p);
			$treatment = 'foreach($this->params[\''.$array.'\'] as $'.$k.' => $'.$v.'){'."\n";

			$list_methods = [];
			$level_escape = 0;

			preg_match_all('/\[(\/?)(([a-zA-Z]*)?\s?([a-zA-Z\/@_!=:,\.\s]*))\]/', $value, $match_all, PREG_SET_ORDER);
			foreach($match_all as $key => $tag){
				switch(true){
					case $level_escape == 0:
						switch(true){
							case preg_match($this->parsing['route'], $tag[0]):
								$value = str_replace($match_all[ $key ][0], $this->dic_t->load('Route')->parseForeach($match_all[ $key ][4], $k, $v), $value);
								break;
							case preg_match($this->parsing['show_var_for'], $tag[0]):
								$value = str_replace($match_all[ $key ][0], $this->dic_t->load('ShowVar')->parseForeach(ltrim($match_all[ $key ][4], '!')), $value);
								break;
							case preg_match($this->parsing['show_var'], $tag[0]):
								break;
						}

						break;
				}
			}

			$treatment .= '				$implode[] = \''.trim($value).'\';'."\n";
			$treatment .= '			}'."\n\n";

			$code = '		public function foreach'.md5($foreach_origine).'(){'."\n";
			$code .= '			$implode = [];'."\n\n";
			$code .= '			'.$treatment;
			$code .= '			return implode(\'\', $implode);'."\n"; 
			$code .= '		}'."\n\n";

			return $code;
		}
	}