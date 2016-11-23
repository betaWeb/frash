<?php
	namespace LFW\Framework\Template\Extensions;
	use LFW\Framework\Template\Parsing\ParseCondition;

	class ConditionParse{
		private $dic_t;
		private $params;

		public function __construct($dic_t, $params){
			$this->dic_t = $dic_t;
			$this->params = $params;
		}

		public function parse($condition, $tpl){
			$treatment = '';
			$name_condition = $condition[0]['condition'];
			$implode = [];

			$count = count($condition) - 1;
			for($i = 0; $i <= $count; $i++){
				if($condition[ $i ]['type'] != 'end' && $condition[ $i ]['type'] != 'else'){
					if($condition[ $i + 1 ]['type'] == 'end'){
						preg_match('/\['.$condition[ $i ]['condition'].'\](.*)\[\/condition\]/Us', $tpl, $value_cond);
					}
					else{
						preg_match('/\['.$condition[ $i ]['condition'].'\](.*)\['.$condition[ $i + 1 ]['condition'].'\]/Us', $tpl, $value_cond);
					}

					preg_match('/(.*) (.*) (.*) (.*)/', $condition[ $i ]['condition'], $split_cond);
					$implode[] = '['.$condition[ $i ]['condition'].']';
					$implode[] = $value_cond[1];

					if($split_cond[2][0] == '@'){
						$split_cond[2] = ltrim($split_cond[2], '@');
					}

					if($split_cond[4] == '!empty'){
						$treatment .= $split_cond[1].'(!empty($this->params'.$this->dic_t->load('FormatVar')->parse($split_cond[2]).')){'."\n";
						$treatment .= '				return \''.trim($value_cond[1]).'\';'."\n";
						$treatment .= '			}'."\n";
					}
					elseif($split_cond[4] == 'empty'){
						$treatment .= $split_cond[1].'(empty($this->params'.$this->dic_t->load('FormatVar')->parse($split_cond[2]).')){'."\n";
						$treatment .= '				return \''.trim($value_cond[1]).'\';'."\n";
						$treatment .= '			}'."\n";
					}
				}
				elseif($condition[ $i ]['type'] == 'else'){
					preg_match('/\[else\](.*)\[\/condition\]/Us', $tpl, $value_cond);

					$implode[] = '[else]';
					$implode[] = $value_cond[1];

					$treatment .= 'else{'."\n";
					$treatment .= '				return \''.trim($value_cond[1]).'\';'."\n";
					$treatment .= '			}'."\n";
				}
			}

			$treatment .= "\n".'			return \'\';';
			$implode[] = '[/condition]';

			$code = '		public function condition'.md5($name_condition).'(){'."\n";
			$code .= '			'.$treatment."\n";
			$code .= '		}'."\n\n";

			return [
				'code' => $code,
				'name' => 'condition'.md5($name_condition),
				'replace' => implode('', $implode)
			];
		}
	}