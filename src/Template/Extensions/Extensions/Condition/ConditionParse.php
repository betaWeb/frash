<?php
namespace Frash\Template\Extensions\Extensions\Condition;
use Frash\Template\DependTemplEngine;
use Frash\Template\Extensions\Extend\ExtensionParseSimple;

/**
 * Class ConditionParse
 * @package Frash\Template\Extensions\Extensions\Condition
 */
class ConditionParse extends ExtensionParseSimple{
    /**
     * @var DependTemplEngine
     */
	private $dic_t;

    /**
     * @var array
     */
	private $params = [];

    /**
     * ConditionParse constructor.
     * @param DependTemplEngine $dic_t
     * @param array $params
     */
	public function __construct(DependTemplEngine $dic_t, array $params){
		$this->dic_t = $dic_t;
		$this->params = $params;
	}

	public function typeIf(){
		$this->infos['level']['condition']++;
        $this->infos['condition'][ $this->infos['level']['condition'] ][] = [ 'type' => 'if', 'condition' => $this->infos['params']['condition'] ];
	}

	public function typeEnd(){
		$level_condition = $this->infos['level']['condition'];
        $this->infos['condition'][ $level_condition ][] = [ 'type' => 'end', 'condition' => 'end_if' ];

		$treatment = '';
		$start = '{{ '.$this->infos['condition'][ $level_condition ][0]['condition'].' }}';
		$name_condition = md5($this->infos['condition'][ $level_condition ][0]['condition']);
		$count = count($this->infos['condition']) - 1;

		for($i = 0; $i <= $count; $i++){
			if($this->infos['condition'][ $level_condition ][ $i ]['type'] != 'end' && $this->infos['condition'][ $level_condition ][ $i ]['type'] != 'else'){
				if($this->infos['condition'][ $level_condition ][ $i + 1 ]['type'] == 'end'){
					preg_match('/\{\{ '.$this->infos['condition'][ $level_condition ][ $i ]['condition'].' \}\}(.*)\{\{ end_if \}\}/Us', $this->infos['tpl'], $value_cond);
				} else {
					preg_match('/\{\{ '.$this->infos['condition'][ $level_condition ][ $i ]['condition'].' \}\}(.*)\{\{ '.$this->infos['condition'][ $level_condition ][ $i + 1 ]['condition'].' \}\}/Us', $this->infos['tpl'], $value_cond);
				}

				preg_match('/(\w+) (.*\S) (.*\S) (.*\S)/', $this->infos['condition'][ $level_condition ][ $i ]['condition'], $split_cond);

				if($split_cond[2][0] == '@'){
					$split_cond[2] = ltrim($split_cond[2], '@');
				}

				if($split_cond[4] == '!empty'){
					$treatment .= $split_cond[1].'(!empty($this->params'.$this->dic_t->extension('FormatVar')->parse($split_cond[2]).')){'."\n";
					$treatment .= '			return \''.trim($value_cond[1]).'\';'."\n";
					$treatment .= '		}'."\n";
				} elseif($split_cond[4] == 'empty') {
					$treatment .= $split_cond[1].'(empty($this->params'.$this->dic_t->extension('FormatVar')->parse($split_cond[2]).')){'."\n";
					$treatment .= '			return \''.trim($value_cond[1]).'\';'."\n";
					$treatment .= '		}'."\n";
				} elseif($split_cond[4][0] == '"' || preg_match('/(\d)/', $split_cond[4])) {
					$treatment .= $split_cond[1].'($this->params'.$this->dic_t->extension('FormatVar')->parse($split_cond[2]).' '.$split_cond[3].' '.$split_cond[4].'){'."\n";
					$treatment .= '			return \''.trim($value_cond[1]).'\';'."\n";
					$treatment .= '		}'."\n";
				} elseif($split_cond[4][0] == '@') {
					$treatment .= $split_cond[1].'($this->params'.$this->dic_t->extension('FormatVar')->parse($split_cond[2]).' '.$split_cond[3].' $this->params'.$this->dic_t->extension('FormatVar')->parse($split_cond[4]).'){'."\n";
					$treatment .= '			return \''.trim($value_cond[1]).'\';'."\n";
					$treatment .= '		}'."\n";
				}
			} elseif($condition[ $i ]['type'] == 'else') {
				preg_match('/\{\{ else \}\}(.*)\{\{ end_if \}\}/Us', $tpl, $value_cond);

				$treatment .= 'else{'."\n";
				$treatment .= '			return \''.trim($value_cond[1]).'\';'."\n";
				$treatment .= '		}'."\n";
			}
		}

		$treatment .= "\n".'		return \'\';';

		$code = '	public function condition'.$name_condition.'(){'."\n";
		$code .= '		'.$treatment."\n";
		$code .= '	}'."\n\n";

        preg_match('/'.$start.'(.*)\{\{ end_if \}\}/Us', $this->infos['tpl'], $match);
        $this->infos['tpl'] = str_replace($match[0], '\'.$this->condition'.$name_condition.'().\'', $this->infos['tpl']);
        $this->infos['class_cache'] .= $code;

        unset($this->infos['condition'][ $level_condition ]);
        $this->infos['level']['condition']--;
	}
}